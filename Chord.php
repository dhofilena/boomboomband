<?php

include "MusicalUtils.php";

define ("Interval3rd", 3);

class CChord
{
    public function __construct($originalNotes, $instrument)
    {
        $this->m_Instrument = $instrument;
        
        if (is_array($originalNotes))
        {
            foreach ($originalNotes as $note)
            {
                if (!IsNoteC($note) &&
                    !IsNoteE($note) &&
                    !IsNoteG($note) &&
                    !IsNoteBb($note))
                {
                    die("Chord must consist of notes C, E, G (,Bb).");
                }

                $this->m_OriginalNotes[] = clone $note;
            }
            unset($note);
            $this->m_OriginalNotesCount = count($this->m_OriginalNotes);
            
            $this->m_OriginalRootOctave = $this->FindOrignalRootOctave();
        }
        else
        {
            die("CChord class must be inited with array of notes.");
        }
    }
    
    public function Transpose($semiTones, $chordsType)
    {       
        $index = 0;
        foreach ($this->m_OriginalNotes as $note)
        {
            $this->m_TransposedNotes[$index] = clone $note;
            $this->m_TransposedNotes[$index]->Note += $semiTones;
            ++$index;
        }
        unset($note);
        
        $this->TransposeByType($chordsType);
        
        $index = 0;
        foreach ($this->m_TransposedNotes as $note)
        {
            if ($this->m_Instrument == Bass)
            {
                $this->FixBassOctave($note);
            }
            else
            {
                $this->FixOctave($this->m_OriginalNotes[$index], $note);
            }
            ++$index;
        }
        unset($note);
        
        if ($this->m_Instrument == Piano)
        {
            $this->FixPianoOctaves();
        }
        
        return $this->m_TransposedNotes;
    }
    
    private function TransposeByType($chordsType)
    {
        switch (strtolower($chordsType))
        {
            case "7":
            {
                break;
            }
            case "maj":
            {
                $this->Move7th(2);
                break;
            }
            case "2":
            {
                $this->MoveRoot(2);
                $this->Move7th(4);
                break;
            }
            case "maj7":
            {
                $this->Move7th(1);
                break;
            }
            case "maj9":
            {
                $this->MoveRoot(2);
                $this->Move7th(1);
                break;
            }
            case "6":
            {
                $this->Move7th(-1);
                break;
            }
            case "69":
            {
                $this->MoveRoot(2);
                $this->Move7th(-1);
                break;
            }
            case "m":
            {
                $this->Move3rd(-1);
                $this->Move7th(2);
                break;
            }
            case "m7":
            {
                $this->Move3rd(-1);
                break;
            }
            case "m6":
            {
                $this->Move3rd(-1);
                $this->Move7th(-1);
                break;
            }
            case "m9":
            {
                $this->MoveRoot(2);
                $this->Move3rd(-1);
                break;
            }
            case "m/maj7":
            {
                $this->Move3rd(-1);
                $this->Move7th(1);
                break;
            }
            case "m7b5":
            {
                $this->Move3rd(-1);
                $this->Move5th(-1);
                break;
            }
            case "dim":
            {
                $this->Move3rd(-1);
                $this->Move5th(-1);
                $this->Move7th(-1);
                break;
            }
            case "9":
            {
                $this->MoveRoot(2);
                break;
            }
            case "13":
            {
                $this->MoveRoot(2);
                $this->Move5th(2);
                break;
            }
            case "7b9":
            {
                $this->MoveRoot(1);
                break;
            }
            case "sus":
            {
                $this->Move3rd(1);
                $this->Move7th(2);
                break;
            }
            case "7sus":
            {
                $this->MoveRoot(2);
                $this->Move3rd(1);
                break;
            }
            case "5b":
            {
                $this->Move5th(-1);
                $this->Move7th(2);
                break;
            }
            case "aug":
            {
                $this->Move5th(1);
                $this->Move7th(2);
                break;
            }
            case "maj9#11":
            {
                $this->MoveRoot(2);
                $this->Move3rd(2);
                $this->Move7th(1);
                break;
            }
            case "maj13#11":
            {
                $this->MoveRoot(2);
                $this->Move3rd(2);
                $this->Move5th(2);
                $this->Move7th(1);
                break;
            }
            case "maj13":
            {
                $this->MoveRoot(2);
                $this->Move5th(2);
                $this->Move7th(1);
                break;
            }
            case "+":
            {
                $this->Move5th(1);
                $this->Move7th(2);
                break;
            }
            case "maj7#5":
            {
                $this->MoveRoot(2);
                $this->Move5th(1);
                $this->Move7th(1);
                break;
            }
            case "maug":
            {
                $this->Move3rd(-1);
                $this->Move5th(1);
                $this->Move7th(2);
                break;
            }
            case "m11":
            {
                $this->MoveRoot(2);
                $this->Move3rd(-1);
                $this->Move5th(-2);
                break;
            }
            case "m13":
            {
                $this->MoveRoot(2);
                $this->Move3rd(-1);
                $this->Move5th(2);
                break;
            }
            case "m#5":
            {
                $this->Move3rd(-1);
                $this->Move5th(1);
                $this->Move7th(2);
                break;
            }
            case "m7#5":
            {
                $this->Move3rd(-1);
                $this->Move5th(1);
                break;
            }
            case "m69":
            {
                $this->MoveRoot(2);
                $this->Move3rd(-1);
                $this->Move7th(-1);
                break;
            }
            case "maj7lyd":
            {
                $this->MoveRoot(2);
                $this->Move7th(1);
                break;
            }
            case "maj7b5":
            {
                $this->Move5th(-1);
                $this->Move7th(1);
                break;
            }
            case "m9b5":
            {
                $this->MoveRoot(2);
                $this->Move3rd(-1);
                $this->Move5th(-1);
                break;
            }
            case "5":
            {
                $this->Move7th(2);
                break;
            }
            case "7+":
            {
                $this->Move5th(1);
                break;
            }
            case "9+":
            {
                $this->MoveRoot(2);
                $this->Move5th(1);
                break;
            }
            case "13+":
            {
                $this->MoveRoot(2);
                $this->Move3rd(5);
                $this->Move5th(1);
                break;
            }
            case "7b13":
            {
                $this->MoveRoot(2);
                $this->Move5th(1);
                break;
            }
            case "7#11":
            {
                $this->MoveRoot(2);
                $this->Move5th(-1);
                break;
            }
            case "13#11":
            {
                $this->MoveRoot(2);
                $this->Move3rd(2);
                $this->Move5th(2);
                break;
            }
            case "7#11b13":
            {
                $this->MoveRoot(2);
                $this->Move3rd(2);
                $this->Move5th(1);
                break;
            }
            case "9b13":
            {
                $this->MoveRoot(2);
                $this->Move5th(1);
                break;
            }
            case "9#11":
            {
                $this->MoveRoot(2);
                $this->Move3rd(2);
                break;
            }
            case "9#11b13":
            {
                $this->MoveRoot(2);
                $this->Move3rd(2);
                $this->Move5th(1);
                break;
            }
            case "13b9":
            {
                $this->MoveRoot(1);
                $this->Move5th(2);
                break;
            }
            case "7b9b13":
            {
                $this->MoveRoot(1);
                $this->Move5th(1);
                break;
            }
            case "13b9#11":
            {
                $this->MoveRoot(1);
                $this->Move3rd(2);
                $this->Move5th(2);
                break;
            }
            case "7b9#11b13":
            {
                $this->MoveRoot(1);
                $this->Move3rd(2);
                $this->Move5th(1);
                break;
            }
            case "7#9":
            {
                $this->MoveRoot(3);
                break;
            }
            case "13#9":
            {
                $this->MoveRoot(3);
                $this->Move5th(2);
                break;
            }
            case "7#9b13":
            {
                $this->MoveRoot(3);
                $this->Move5th(1);
                break;
            }
            case "7#9#11b13":
            {
                $this->MoveRoot(3);
                $this->Move3rd(2);
                $this->Move5th(1);
                break;
            }
            case "7b5":
            {
                $this->Move5th(-1);
                break;
            }
            case "13b5":
            {
                $this->MoveRoot(9);
                $this->Move5th(-1);
                break;
            }
            case "7b5b13":
            {
                $this->MoveRoot(8);
                $this->Move5th(-1);
                break;
            }
            case "9b5":
            {
                $this->MoveRoot(2);
                $this->Move5th(-1);
                break;
            }
            case "9b5b13":
            {
                $this->MoveRoot(2);
                $this->Move3rd(4);
                $this->Move5th(-1);
                break;
            }
            case "7b5b9":
            {
                $this->MoveRoot(1);
                $this->Move5th(-1);
                break;
            }
            case "7alt":
            {
                $this->MoveRoot(3);
                $this->Move5th(1);
                break;
            }
            case "9sus":
            {
                $this->MoveRoot(2);
                $this->Move3rd(1);
                break;
            }
            case "9susb13":
            {
                $this->MoveRoot(2);
                $this->Move3rd(1);
                $this->Move5th(1);
                break;
            }
            case "9sus#11":
            {
                $this->MoveRoot(2);
                $this->Move3rd(1);
                $this->Move5th(-1);
                break;
            }
            case "":
            {
                $this->Move7th(2);
                break;
            }
            default:
            {
                die("Chord type \"" . $chordsType . "\" is wrong.");
            }
        }
    }
    
    private function MoveRoot($semiTones)
    {
        if ($this->m_Instrument != Bass)
        {
            for ($i = 0; $i < $this->m_OriginalNotesCount; ++$i)
            {
                if (IsNoteC($this->m_OriginalNotes[$i]))
                {
                    $this->m_TransposedNotes[$i]->Note += $semiTones;
                }
            }
        }
    }
    
    private function Move3rd($semiTones)
    {
        for ($i = 0; $i < $this->m_OriginalNotesCount; ++$i)
        {
            if (IsNoteE($this->m_OriginalNotes[$i]))
            {
                $this->m_TransposedNotes[$i]->Note += $semiTones;
            }
        }
    }
    
    private function Move5th($semiTones)
    {
        for ($i = 0; $i < $this->m_OriginalNotesCount; ++$i)
        {
            if (IsNoteG($this->m_OriginalNotes[$i]))
            {
                $this->m_TransposedNotes[$i]->Note += $semiTones;
            }
        }
    }
    
    private function Move7th($semiTones)
    {
        for ($i = 0; $i < $this->m_OriginalNotesCount; ++$i)
        {
            if (IsNoteBb($this->m_OriginalNotes[$i]))
            {
                $this->m_TransposedNotes[$i]->Note += $semiTones;
            }
        }
    }
    
    private function FixOctave($originalNote, &$transposedNote)
    {          
        $note = clone $originalNote;
        
        if ($this->m_Instrument == Piano)
        {
            $lowestPianoRoot = 0x30;
            while ($note->Note < $lowestPianoRoot)
            {
                $note->Note += NotesInOctaveCount;
            }

            $highestPianoRoot = 0x54;
            while ($note->Note > $highestPianoRoot)
            {
                $note->Note -= NotesInOctaveCount;
            }
        }
        
        $originalNoteOctave = floor($note->Note / NotesInOctaveCount);
        $transposedNoteOctave = floor($transposedNote->Note / NotesInOctaveCount);
        
        $transposedNote->Note += 
                ($originalNoteOctave - $transposedNoteOctave) * NotesInOctaveCount;
    }
    
    private function FixBassOctave(&$transposedNote)
    {
        FixBassOctave($this->m_OriginalRootOctave, $transposedNote);
    }
    
    private function FixPianoOctaves()
    {
        $index = 0;
        foreach ($this->m_TransposedNotes as $note)
        {
            $octave = floor($note->Note / NotesInOctaveCount);
            if ($octave == 4)
            {
                foreach ($this->m_TransposedNotes as $n)
                {
                    $oct = floor($n->Note / NotesInOctaveCount);
                    if ($oct == 4)
                    {
                        $diff = abs($note->Note - $n->Note);
                        if ($diff < Interval3rd && $diff != 0)
                        {
                            if (!IsNoteC($this->m_OriginalNotes[$index]))
                            {
                                $note->Note += NotesInOctaveCount;
                            }
                        }
                    }
                }
            }
            $index++;
        }
    }
    
    private function FindOrignalRootOctave()
    {
        $min = null;
        foreach ($this->m_OriginalNotes as $note)
        {
            if (IsNoteC($note))
            {
                if ($min == null)
                {
                    $min = $note;
                }
                else if ($note->Note < $min->Note)
                {
                    $min = $note;
                }
            }
        }
        unset($note);
        
        if ($min == null) //there isn't note C
        {
            foreach ($this->m_OriginalNotes as $note)
            {
                if ($min == null)
                {
                    $min = $note;
                }
                else if ($note->Note < $min->Note)
                {
                    $min = $note;
                }
            }
            unset($note);
        }
        
        return floor($min->Note / NotesInOctaveCount);
    }
    
    private $m_OriginalNotes;
    private $m_OriginalNotesCount;
    private $m_OriginalRootOctave;
    private $m_TransposedNotes;
    private $m_Instrument;
}

?>
