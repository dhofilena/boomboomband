<?php

include "Chord.php";
include "PatternsConfigLoader.php";

define ("DefaultTicksPerQuarter", 960);
define ("WeightAlwaysSetting", 9);

class CKey
{
    public $Root;
    public $Type;
    public $BeatsCount;
}

class CChordProgression
{
    public function LoadFromString($progression)
    {               
        $this->ParseKeys($progression);
    }
    
    public function GetBeatsCount()
    {
        $beatsCount = 0;
        $keysCount = count($this->m_Keys);
        for ($i = 0; $i < $keysCount; ++$i)
        {
            $key = $this->m_Keys[$i];
            $beatsCount += $key->BeatsCount;
        }
        
        return $beatsCount;
    }
    
    public function ProcessInstrument($styleName, $instrumentName, 
            $volume, $tempo, $countInPattern, $startOfChorus, 
            $endOfChorus, $repeatNumber, $endOfSong, $instrumentPatch)
    {      
        $resultMIDI = null;
        
        $dirName = "Patterns" . DIRECTORY_SEPARATOR . $styleName . 
                   DIRECTORY_SEPARATOR . $instrumentName;
        if (file_exists($dirName))
        {
            $dir = opendir($dirName);
            $patterns = array();
            
            $configLoader = new CPatternsConfigLoader($dirName . DIRECTORY_SEPARATOR . "Patterns.xml");

            while (false !== ($filename = readdir($dir)))
            {
                if (IsMIDIFile($filename))
                {
                    $pattern = new CMidiPattern();
                    $pattern->LoadFromFile($dirName . DIRECTORY_SEPARATOR . $filename, $styleName);

                    if ($pattern->GetInstrumentName() == $instrumentName)
                    {           
                        $configLoader->InitPattern($pattern);
                        $patterns[] = $pattern;
                    }
                }
            }

            if (count($patterns) == 0)
            {
                die("There aren't any patterns for instrument: " . $instrumentName);
            }
            
            $editedPatterns = array();

            if ($instrumentName != Drum)
            {
                $editedPatterns = $this->ProcessNonDrumInstrument($patterns, 
                        $styleName, $startOfChorus, $endOfChorus, $repeatNumber, $endOfSong);
                
                $this->RepeatChorus($startOfChorus, $endOfChorus, $repeatNumber, 
                        $editedPatterns);
                
                $emptyPattern = new CEmptyMidiPattern($countInPattern->GetBeatsCount());
                array_unshift($editedPatterns, $emptyPattern);
            }
            else
            {
                $editedPatterns = $this->ProcessDrumInstrument($patterns, $endOfSong);
                
                $this->RepeatChorus($startOfChorus, $endOfChorus, $repeatNumber, 
                        $editedPatterns);
                
                array_unshift($editedPatterns, $countInPattern);
            }
            
            $resultMIDI = $this->ConcatenatePatternsToOne($editedPatterns);
        }
        
        if ($resultMIDI != null)
        {                
            $resultMIDI->ChangeVolume($volume);
            $resultMIDI->ChangeTempo($tempo);
            if ($instrumentPatch != -1)
            {
                $resultMIDI->ChangeInstrument($instrumentPatch);
            }
        }
        
        return $resultMIDI;
    }
    
    private function ProcessNonDrumInstrument($patterns, $styleName, 
            $startOfChorus, $endOfChorus, $repeatNumber, $endOfSong)
    {
        $barNumber = 1;
        $editedPatterns = array();
        $keysCount = count($this->m_Keys);
        for ($i = 0; $i < $keysCount; ++$i)
        {
            $key = $this->m_Keys[$i];
            $nextKey = 0;
            if ($i != count($this->m_Keys) - 1)
            {
                $nextKey = $this->m_Keys[$i + 1];
            }
            
            $beatsCount = $key->BeatsCount;
            $foundBeatsCount = 0;
            while ($foundBeatsCount < $key->BeatsCount)
            {
                $found = FALSE;
                $appropriatePatterns = array();
                
                while (!$found && $beatsCount >= 1)
                {
                    if ($beatsCount == 8)
                    {
                        if (($repeatNumber > 1 &&
                            (($barNumber == $startOfChorus - 1) ||
                            ($barNumber == $endOfChorus))) ||
                            ($barNumber == $endOfSong))
                        {
                            $beatsCount /= 2;
                            continue;
                        }
                    }
                    
                    $substyle = $this->GetRandomSubstyle();
                    
                    foreach ($patterns as $pattern)
                    {                           
                        $patternBeatsCount = $pattern->GetBeatsCount() + 
                                $pattern->GetBeatsOfSilenceAtTheEnd();
                        if ($patternBeatsCount == $beatsCount &&
                            $pattern->MeetBarNumberByMask(round($barNumber)) &&
                            $pattern->MeetBeatNumberByMask($foundBeatsCount) &&
                            $pattern->MeetChordByMasks($key, $nextKey, $key->BeatsCount, $this->m_Keys) &&
                            $pattern->MeetSubstyle($substyle))
                        {
                            $appropriatePatterns[] = $pattern;
                            $found = TRUE;
                        }
                    }
                    unset($pattern);

                    if ($found)
                    {
                        $editedPattern = 
                                clone $this->GetRandomPatternUsingWeight($appropriatePatterns);

                        $this->ProcessPattern($key, $styleName, $editedPattern);
                        $editedPatterns[] = $editedPattern;
                        
                        $silenceBeats = $editedPattern->GetBeatsOfSilenceAtTheEnd();
                        if ($silenceBeats != 0)
                        {
                            $editedPatterns[] = new CEmptyMidiPattern($silenceBeats);
                        }
                    }
                    else
                    {
                        $beatsCount /= 2;
                    }
                }
                
                if (!$found)
                {
                    $editedPatterns[] = new CEmptyMidiPattern($beatsCount);
                }
                $foundBeatsCount += $beatsCount;
                $barNumber += $beatsCount / 4;
                
                if ($barNumber == $endOfSong + 1)
                {
                    break;
                }
            }
        }
        unset($key);
        
        return $editedPatterns;
    }
    
    private function ProcessDrumInstrument($patterns, $endOfSong)
    {
        $barsCount = 0;
        foreach ($this->m_Keys as $key)
        {
            $barsCount += $key->BeatsCount / 4;
        }
        unset($key);
        
        if ($barsCount > $endOfSong)
        {
            $barsCount = $endOfSong;
        }

        for ($i = 0; $i < $barsCount; ++$i)
        {
            $appropriatePatterns = array();
            $substyle = $this->GetRandomSubstyle();
            
            foreach ($patterns as $pattern)
            {
                if ($pattern->GetBeatsCount() != 4)
                {
                    die("Drum patterns should always have 4 beats.");
                }
                if ($pattern->MeetBarNumberByMask($i + 1) &&
                    $pattern->MeetSubstyle($substyle))
                {
                    $appropriatePatterns[] = $pattern;
                }
            }
            unset($pattern);

            $editedPatterns[] = 
               clone $this->GetRandomPatternUsingWeight($appropriatePatterns);
        }
                
        return $editedPatterns;
    }
    
    private function RepeatChorus($startOfChorus, $endOfChorus, $repeatNumber, 
            &$patterns)
    {
        $barNumber = 1;
        $chorusPatterns = array();
        
        $insertPos = 0;
        foreach ($patterns as $pattern)
        {
            if ($barNumber >= $startOfChorus && $barNumber < $endOfChorus + 1)
            {
                $chorusPatterns[] = clone $pattern;
            }
            $barNumber += $pattern->GetBeatsCount() / 4;
            $insertPos++;
            if ($barNumber == $endOfChorus + 1)
            {
                break;
            }
        }
        unset($pattern);

        for ($i = 0; $i < $repeatNumber - 1; ++$i)
        {
            array_splice($patterns, $insertPos + i * count($chorusPatterns), 0, $chorusPatterns);
        }
    }

    public function RepeatLastChordToTheEnd($endOfSong)
    {        
        $keysCount = count($this->m_Keys);
        if ($this->m_Keys[$keysCount - 1]->BeatsCount == 2)
        {
            $keysForFilling[] = clone $this->m_Keys[$keysCount - 2];
            $keysForFilling[] = clone $this->m_Keys[$keysCount - 1];
        }
        else
        {
            $newKey = clone $this->m_Keys[$keysCount - 1];
            if ($newKey->BeatsCount == 8)
            {
                $newKey->BeatsCount = 4;
            }
            $keysForFilling[] = $newKey;
        }
        
        $emptyBarsCount = $endOfSong - $this->GetBeatsCount() / 4;
        for ($i = 0; $i < $emptyBarsCount; ++$i)
        {
            array_splice($this->m_Keys, count($this->m_Keys), 0, $keysForFilling);
        }
    }
    
    private function GetRandomSubstyle()
    {
        $substyleNumber = rand(0, 1);
        if ($substyleNumber == 0)
        {
            return "A";
        }
        else
        {
            return "B";
        }
    }
    
    private function GetRandomPatternUsingWeight($patterns)
    {   
        $patternsWithAlways = array();
        foreach ($patterns as $pattern)
        {
            if ($pattern->GetWeight() == WeightAlwaysSetting)
            {
                $patternsWithAlways[] = $pattern;
            }
        }
        unset($pattern);
        if (count($patternsWithAlways) > 0)
        {
            $index = rand(0, count($patternsWithAlways) - 1);
            return $patternsWithAlways[$index];
        }
        
        $this->SortPatternsByWeight($patterns);
        
        $weightsSum = 0;
        foreach ($patterns as $pattern)
        {
            $weightsSum += $pattern->GetWeight();
        }
        unset($pattern);
        
        $value = FloatRand(0, 1);
        
        foreach ($patterns as $pattern)
        {
            $value -= ($pattern->GetWeight() / $weightsSum);
            if ($value <= 0)
            {
                return $pattern;
            }
        }
        unset($pattern);
    }
    
    private function SortPatternsByWeight(&$patterns)
    {
        $patternsCount = count($patterns);
        for ($i = 1; $i < $patternsCount; ++$i)
        {
            $key = $patterns[$i];
            $j = $i - 1;
            while ($j >= 1 and $patterns[$j]->GetWeight() > $key->GetWeight())
            {
                $patterns[$j + 1] = $patterns[$j];
                $j--;
            }
            $patterns[$j + 1] = $key;
        }
    }
    
    private function ProcessPattern($key, $styleName, &$pattern)
    {        
        $notesAndChords = $this->SplitToIndependentNotesAndChords($pattern);
            
        $transposedNotes = $this->TransposeByKeyAndTransposeCode($notesAndChords, 
                $key, $pattern);
        $pattern->UpdateOriginalNotes($transposedNotes);
    }
    
    private function ConcatenatePatternsToOne($patterns)
    {       
        $resultEvents = array();
        
        $ticksOfEmpty = 0;
        foreach ($patterns as $pattern)
        {
            if (get_class($pattern) != "CEmptyMidiPattern")
            {
                $ticksPerQuarter = BinaryToInt($pattern->GetTicksPerQuarter());

                foreach ($pattern->GetEvents() as $event)
                {
                    $found = FALSE;
                    if (get_class($event) == "CMetaEvent")
                    {
                        foreach($resultEvents as $resEvent)
                        {
                            if ($event->Type == $resEvent->Type &&
                                $event->Length == $resEvent->Length &&
                                $event->DeltaTime == 0)
                            {
                                if ($event->Data == $resEvent->Data)
                                {
                                    $found = TRUE;
                                    break;
                                }
                                else if ($event->Type == 0x51)//Set Tempo Event
                                {
                                    $found = TRUE;
                                    break;
                                }
                            }
                        }
                        unset($resEvent);
                    }
                    
                    if (!$found)
                    {
                        $newEvent = clone $event;
                        $this->RecalculateDeltaTime($newEvent, $ticksPerQuarter);

                        if ($ticksOfEmpty != 0)
                        {
                            if (get_class($newEvent) == "CNote")
                            {
                                $newEvent->DeltaTime += $ticksOfEmpty;
                                $ticksOfEmpty = 0;
                            }
                        }

                        $resultEvents[] = $newEvent;
                    }
                }
            }
            else
            {
                $ticksOfEmpty += $pattern->GetBeatsCount() * DefaultTicksPerQuarter;
            }
        }
        $resultPattern = new CMidiPattern();
        
        $resultPattern->SetTicksPerQuarter(DefaultTicksPerQuarter);
        $resultPattern->SetEvents($resultEvents);
        
        return $resultPattern;
    }
    
    private function RecalculateDeltaTime(&$event, $oldTicksPerQuarter)
    {
        $event->DeltaTime = ($event->DeltaTime 
                            * (DefaultTicksPerQuarter / $oldTicksPerQuarter));
    }
    
    private function SplitToIndependentNotesAndChords($pattern)
    {
        $splittedArr = array();
        
        $chordNotes = array();
        $events = $pattern->GetEvents();
        
        $wasNoteC = FALSE;
        $wasNoteE = FALSE;
        $wasNoteG = FALSE;
        $wasNoteBb = FALSE;
        
        foreach ($events as $event)
        {
            if (get_class($event) == "CNote")
            {
                $chordNotes[] = $event;
                
                if (IsNoteC($event))
                {
                    $wasNoteC = TRUE;
                }
                else if (IsNoteE($event))
                {
                    $wasNoteE = TRUE;
                }
                else if (IsNoteG($event))
                {
                    $wasNoteG = TRUE;
                }
                else if (IsNoteBb($event))
                {
                    $wasNoteBb = TRUE;
                }   
                else
                {
                    foreach ($chordNotes as $note)
                    {
                        $splittedArr[] = clone $note;
                    }
                    unset($note);

                    unset($chordNotes);
                    $chordNotes = array();
                    
                    $wasNoteC = FALSE;
                    $wasNoteE = FALSE;
                    $wasNoteG = FALSE;
                    $wasNoteBb = FALSE;
                }
            }
        }
        unset($event);
        
        if (($wasNoteC && ($wasNoteE || $wasNoteG || $wasNoteBb)) ||
            ($wasNoteE && ($wasNoteG || $wasNoteBb)) ||
            ($wasNoteG && $wasNoteBb))
        {
            $chord = new CChord($chordNotes, $pattern->GetInstrumentName());
            $splittedArr[] = $chord;
        }
        else
        {
            foreach ($chordNotes as $note)
            {
                $splittedArr[] = clone $note;
            }
            unset($note);
        }
        
        return $splittedArr;
    }

    private function TransposeByKeyAndTransposeCode($notesAndChords, 
            $key, $pattern)
    {        
        $transposedNotes = array();
        
        $notesAndChordCount = count($notesAndChords);
        if ($notesAndChordCount != 0)
        {
            $semiTones = $key->Root;
            
            for ($index = 0; $index < $notesAndChordCount; ++$index)
            {
                $element = $notesAndChords[$index];
                if (get_class($element) == "CChord")
                {
                    $transposedChordNotes = $element->Transpose($semiTones, $key->Type);

                    foreach($transposedChordNotes as $note)
                    {
                        $transposedNotes[] = $note;
                    }
                    unset($note);
                }
                else if (get_class($element) == "CNote")
                {
                    $newNote = clone $element;
                    $newNote->Note += $semiTones;
                    if ($pattern->GetInstrumentName() != Bass)
                    {
                        $this->FixOctave($element, $newNote);
                    }
                    else
                    {
                        $originalRoot = $element;
                        if (!IsNoteC($element))
                        {
                            for ($i = $index - 1; $i >= 0; --$i)
                            {
                                if (get_class($notesAndChords[$i]) == "CNote" &&
                                    IsNoteC($notesAndChords[$i]))
                                {
                                    $originalRoot = $notesAndChords[$i];
                                    break;
                                }
                            }
                        }
                        $originalRootOctave = floor($originalRoot->Note / NotesInOctaveCount);
                        FixBassOctave($originalRootOctave, $newNote);
                    }
                    
                    $transposedNotes[] = $newNote;
                }
            }
        }
        
        return $transposedNotes;
    }
    
    private function FixOctave($originalNote, &$transposedNote)
    {
        if ($originalNote->Note < $transposedNote->Note)
        {
            $delta = $transposedNote->Note - $originalNote->Note;
            if ($delta >= $originalNote->Note - ($transposedNote->Note - NotesInOctaveCount))
            {
                $transposedNote->Note -= NotesInOctaveCount;
            }
        }
        else
        {
            $delta = $originalNote->Note - $transposedNote->Note;
            if ($delta > ($transposedNote->Note + NotesInOctaveCount) - $originalNote->Note)
            {
                $transposedNote->Note += NotesInOctaveCount;
            }
        }
    }
    
     private function ParseKeys($data)
    {
        $pieces = explode(",", $data);
        
        $barNumber = 1;
        foreach ($pieces as $piece)
        {
            $beats = explode("^", $piece);
            
            if (count($beats) > 0 && $beats[0] == $piece)//1 Chord per bar (4 beats)
            {              
                $key = new CKey();
                $this->ParseKeyNameAndType($piece, $key, $barNumber);
                
                $foundPrevious = FALSE;
                if (count($this->m_Keys) > 0)
                {
                    $previousKey = $this->m_Keys[count($this->m_Keys) - 1];
                    if ($previousKey->Root == $key->Root &&
                        $previousKey->Type == $key->Type &&
                        $previousKey->BeatsCount == 4) //2 Bars per 1 Chord (8 beats)
                    {
                        $previousKey->BeatsCount *= 2;
                        $foundPrevious = TRUE;
                    }
                }
                
                if (!$foundPrevious)
                {
                    $key->BeatsCount = 4;
                    $this->m_Keys[] = $key;
                }
            }
            else if (count($beats) == 2) //2 Chords per bar (2 Chords * 2 beats)
            {
                for ($i = 0; $i < count($beats); ++$i)
                {
                    $key = new CKey();
                    $key->BeatsCount = 2;
                    $this->ParseKeyNameAndType($beats[$i], $key, $barNumber);
                    $this->m_Keys[] = $key;
                }
            }
            $barNumber++;
        }
        unset($piece);
    }
    
    private function GetRootsArray()
    {
        $rootsArray = array("A#" => 10, "Bb" => 10,
                            "Ab" => 8,  "G#" => 8,
                            "C#" => 1,  "Db" => 1,
                            "D#" => 3,  "Eb" => 3,
                            "F#" => 6,  "Gb" => 6,
                            "A"  => 9,
                            "B"  => 11,
                            "C"  => 0,
                            "D"  => 2,
                            "E"  => 4,
                            "F"  => 5,
                            "G"  => 7);
        
        return $rootsArray;
    }
    
    private function ParseKeyNameAndType($piece, &$key, $barNumber)
    {
        $rootsArray = $this->GetRootsArray();
        
        $found = FALSE;
        foreach ($rootsArray as $name => $code)
        {
            if (stripos($piece, $name) === 0)
            {
                $found = TRUE;

                $key->Root = $code;
                $key->Type = substr_replace($piece, "", 0, strlen($name));
                
                if (!$this->CheckType($key->Type))
                {
                    die("Chord type \"" . $key->Type . "\" is wrong in bar " . $barNumber);
                }
                
                break;
            }
        }
        unset($name);
        unset($code);

        if (!$found)
        {
            die("Chord name \"" . $piece . "\" is wrong in bar " . $barNumber);
        }
    }
    
    private function CheckType($chordsType)
    {
        switch (strtolower($chordsType))
        {
            case "7":
            case "maj":
            case "2":
            case "maj7":
            case "maj9":
            case "6":
            case "69":
            case "m":
            case "m7":
            case "m6":
            case "m9":
            case "m/maj7":
            case "m7b5":
            case "dim":
            case "9":
            case "13":
            case "7b9":
            case "sus":
            case "7sus":
            case "5b":
            case "aug":
            case "maj9#11":
            case "maj13#11":
            case "maj13":
            case "+":
            case "maj7#5":
            case "maug":
            case "m11":
            case "m13":
            case "m#5":
            case "m7#5":
            case "m69":
            case "maj7lyd":
            case "maj7b5":
            case "m9b5":
            case "5":
            case "7+":
            case "9+":
            case "13+":
            case "7b13":
            case "7#11":
            case "13#11":
            case "7#11b13":
            case "9b13":
            case "9#11":
            case "9#11b13":
            case "13b9":
            case "7b9b13":
            case "13b9#11":
            case "7b9#11b13":
            case "7#9":
            case "13#9":
            case "7#9b13":
            case "7#9#11b13":
            case "7b5":
            case "13b5":
            case "7b5b13":
            case "9b5":
            case "9b5b13":
            case "7b5b9":
            case "7alt":
            case "9sus":
            case "9susb13":
            case "9sus#11":
            case "":
            {
                return true;
            }
            default:
            {
                return false;
            }
        }
    }
    
    private $m_Keys;
}

?>
