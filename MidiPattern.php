<?php

include "PlaybackBarMask.php";
include "PlaybackBeatMask.php";
include "RomanNumeralMask.php";
include "ChordTypesMask.php";
include "IntervalToNextMask.php";
include "ChordDurationMask.php";
include "SubstylesABMask.php";

define ("FormatStartByte", 9);
define ("TracksCountStartByte", 11);
define ("TicksPQStartByte", 13);
define ("TicksPQLength", 2);
define ("HeaderLength", 14);
define ("TrackLengthBytesCount", 4);
define ("DrumChannel", 10);
define ("ElectricBassFinger", 0x21);
define ("ElectricGuitarClean", 0x1B);
define ("AcousticGuitarNylon", 0x18);
define ("AcousticGuitarSteel", 0x19);
define ("ElectricGuitarMuted", 0x1C);
define ("AcousticGrandPiano", 0x00);
define ("ElectricPiano1", 0x04);
define ("ElectricPiano2", 0x05);
define ("Clav", 0x07);
define ("StringEnsemble1", 0x30);
define ("StringEnsemble2", 0x31);
define ("SynthStrings1", 0x32);
define ("RockOrgan", 0x12);
define ("AcousticBass", 0x20);
define ("SlapBass1", 0x24);
define ("SlapBass2", 0x25);
define ("FretlessBass", 0x23);
define ("Trumpet", 0x38);
define ("TenorSax", 0x42);
define ("Bass", "Bass");
define ("Piano", "Piano");
define ("Guitar", "Guitar");
define ("Drum", "Drum");
define ("Strings", "Strings");
define ("VolumeController", 7);
define ("MicrosecondsPerMinute", 60000000);

class CNote
{
    public $DeltaTime;
    public $Channel;
    public $Note;
    public $Velocity;
    public $Start;
}

class CMainEvent
{
    public $DeltaTime;
    public $Type;
    public $Channel;
    public $Length;
    public $Data;
}

class CMetaEvent
{
    public $DeltaTime;
    public $Type;
    public $Length;
    public $Data;
}

class C0AEvent
{
    public $DeltaTime;
    public $Type;
    public $Length;
    public $Data;
}

class CEmptyMidiPattern
{
    public function __construct($beatsCount)
    {
        $this->m_BeatsCount = $beatsCount;
    }
    
    public function GetBeatsCount()
    {
        return $this->m_BeatsCount;
    }
    
    private $m_BeatsCount;
}

class CMidiPattern
{
    public function __clone()
    {
        $eventsCount = count($this->m_Events);
        for ($i = 0; $i < $eventsCount; ++$i)
        {
            $this->m_Events[$i] = clone $this->m_Events[$i];
        }
    }
    
    public function LoadFromFile($fileName, $styleName)
    {
        $fp = fopen("$fileName", "rb");
        if ($fp == FALSE)
        {
            die("File " . $fileName . " can't be open.");
        }
        $contents = fread($fp, filesize($fileName));
        fclose($fp);
        
        $binaryData = unpack("C*", $contents);
        
        $this->Parse($binaryData);
        
        $this->m_FileName = basename($fileName);
        if (!$this->IsDrumPattern())
        {
            $this->m_BeatsCount = (int)$this->m_FileName[1];
        }
        else
        {
            $this->m_BeatsCount = $this->CalculateRealBeatsCount();
        }
        $this->m_SilenceBeatsCount = $this->m_BeatsCount - $this->CalculateRealBeatsCount();
        $this->m_StyleName = $styleName;
        $this->m_InstrumentName = $this->FindInstrumentName();  
    }
    
    public function InitWeightAndMasks($arrayInfo)
    {
        if (!is_array($arrayInfo))
        {
            die("Pattern must be inited with the array of weight and masks.");
        }
        
        $this->m_Weight = (int)$arrayInfo["Weight"];
        $this->m_PlaybackBarMask = new CPlaybackBarMask($arrayInfo["PlaybackBarMask"]);
        $this->m_PlaybackBeatMask = new CPlaybackBeatMask($arrayInfo["PlaybackBeatMask"]);
        $this->m_RomanNumeralMask = new CRomanNumeralMask($arrayInfo["RonamNumeralMask"]);
        $this->m_ChordTypesMask = new CChordTypesMask($arrayInfo["ChordTypesMask"]);
        $this->m_IntervalToNextMask = new CIntervalToNextMask($arrayInfo["IntervalToNextMask"]);
        $this->m_ChordDurationMask = new CChordDurationMask($arrayInfo["ChordDurationMask"]);
        $this->m_SubstylesABMask = new CSubstylesABMask($arrayInfo["SubstylesABMask"]);
    }
    
    public function GetFileName()
    {
        return $this->m_FileName;
    }
    
    public function GetWeight()
    {
        return $this->m_Weight;
    }
    
    public function MeetBarNumberByMask($barNumber)
    {
        if ($this->m_PlaybackBarMask != null)
        {
            return $this->m_PlaybackBarMask->MeetBarNumber($barNumber);
        }
        
        return TRUE;
    }
    
    public function MeetBeatNumberByMask($beatNumber)
    {
        if ($this->m_PlaybackBeatMask != null)
        {
            return $this->m_PlaybackBeatMask->MeetBeatNumber($beatNumber);
        }
        
        return TRUE;
    }
    
    public function MeetChordByMasks($chord, $nextChord, $duration, $progression)
    {
        if ($this->m_RomanNumeralMask != null)
        {
            if (!$this->m_RomanNumeralMask->MeetChord($chord, $progression))
            {
                return FALSE;
            }
        }
        
        if ($this->m_ChordTypesMask != null)
        {
            if (!$this->m_ChordTypesMask->MeetChord($chord))
            {
                return FALSE;
            }
        }
        
        if ($this->m_IntervalToNextMask != null)
        {
            if (!$this->m_IntervalToNextMask->MeetChord($chord, $nextChord))
            {
                return FALSE;
            }
        }
        
        if ($this->m_ChordDurationMask != null)
        {
            if (!$this->m_ChordDurationMask->MeetChordDuration($duration))
            {
                return FALSE;
            }
        }
        
        return TRUE;
    }

    public function MeetSubstyle($substyle)
    {
        if ($this->m_SubstylesABMask != null)
        {
            return $this->m_SubstylesABMask->MeetSubstyle($substyle);
        }
        
        return TRUE;
    }
    
    public function GetEvents()
    {
        return $this->m_Events;
    }
    
    public function SetEvents($events)
    {
        $this->m_Events = $events;
    }
    
    public function UpdateOriginalNotes($notes)
    {
        $i = 0;
        foreach ($this->m_Events as $event)
        {              
            if (get_class($event) == "CNote")
            {
                $event->Note = $notes[$i]->Note;
                ++$i;
            }
        }
        unset($event);
    }
    
    public function GetBeatsCount()
    {
        return $this->m_BeatsCount;
    }
    
    public function GetBeatsOfSilenceAtTheEnd()
    {        
        return $this->m_SilenceBeatsCount;
    }
    
    public function GetTempo()
    {
        foreach ($this->m_Events as $event)
        {              
            if (get_class($event) == "CMetaEvent")
            {
                if ($event->Type == 0x51) //Set Tempo Meta Event
                {
                    return MicrosecondsPerMinute / BinaryToInt($event->Data);//BPM
                }
            }
        }
    }
    
    public function ChangeTempo($tempoBPM)
    {
        $found = FALSE;
        foreach ($this->m_Events as $event)
        {
            if (get_class($event) == "CMetaEvent")
            {
                if ($event->Type == 0x51) //Set Tempo Meta Event
                {
                    $tempoMicroSecsPerBeat = MicrosecondsPerMinute / $tempoBPM;
                    
                    IntToBinary($event->Data, $event->Length, $tempoMicroSecsPerBeat);
                    $found = TRUE;
                    break;
                }
            }
        }
        if (!found)
        {
            die ("There isn't Set Tempo Event in pattern.");
        }
    }
    
    public function GetTicksPerQuarter()
    {
        return $this->m_TicksPerQuarter;
    }
    
    public function SetTicksPerQuarter($ticksPQ)
    {
        IntToBinary($this->m_TicksPerQuarter, 2, $ticksPQ);
    }
    
    public function GetInstrumentName()
    {
        return $this->m_InstrumentName;
    }
    
    public function GetInstrumentPatch()
    {
        $programNumber = 0;
        foreach ($this->m_Events as $event)
        {
            if (get_class($event) == "CMainEvent")
            {
                if ($event->Type == 0xC0)
                {
                    $programNumber = $event->Data[0];
                    break;
                }
            }
        }
        
        return $programNumber;
    }
    
    public function ChangeInstrument($instrumentPatch)
    {
        foreach ($this->m_Events as $event)
        {
            if (get_class($event) == "CMainEvent")
            {
                if ($event->Type == 0xC0)
                {
                    $event->Data[0] = $instrumentPatch;
                }
            }
        }
    }
    
    public function GetVolume()
    {
        $volume = 127;
        foreach ($this->m_Events as $event)
        {
            if (get_class($event) == "CMainEvent")
            {
                if ($event->Type == 0xB0)
                {
                    if ($event->Data[0] == VolumeController)
                    {
                        $volume = $event->Data[1];
                        break;
                    }
                }
            }
        }
        
        return $volume;
    }

    public function ChangeVolume($volume)
    {
        $channel = 0;
        for ($i = 0; $i < count($this->m_Events); ++$i)
        {
            $event = $this->m_Events[$i];
            if (get_class($event) == "CMainEvent")
            {
                $channel = $event->Channel;
                if ($event->Type == 0xB0)
                {
                    if ($event->Data[0] == VolumeController)
                    {
                        $event->Data[1] = $volume;
                    }
                }
            }
        }
        
        $newVolumeEvent = new CMainEvent();
        $newVolumeEvent->Channel = $channel;
        $newVolumeEvent->Type = 0xB0;
        $newVolumeEvent->Length = 2;
        $newVolumeEvent->DeltaTime = 0;
        $newVolumeEvent->Data[0] = VolumeController;
        $newVolumeEvent->Data[1] = $volume;
        
        array_unshift($this->m_Events, $newVolumeEvent);
    }
    
    public function CalculateRealBeatsCount()
    {
        $lengthInTicks = 0;
        foreach ($this->m_Events as $event)
        {
            $lengthInTicks += $event->DeltaTime;
        }
        unset($event);
        
        return $lengthInTicks / BinaryToInt($this->m_TicksPerQuarter);
    }
    
    private function FindInstrumentName()
    {
        if ($this->IsDrumPattern())
        {
            return Drum;
        }
        else
        {
            $programNumber = -1;
            foreach ($this->m_Events as $event)
            {
                if (get_class($event) == "CMainEvent")
                {
                    if ($event->Type == 0xC0)
                    {
                        $programNumber = $event->Data[0];
                        break;
                    }
                }
            }
            
            if ($programNumber == ElectricBassFinger ||
                $programNumber == AcousticBass ||
                $programNumber == SlapBass1 ||
                $programNumber == SlapBass2 ||
                $programNumber == FretlessBass)
            {
                return Bass;
            }
            if ($programNumber == ElectricGuitarClean ||
                $programNumber == AcousticGuitarNylon ||
                $programNumber == Trumpet ||
                $programNumber == Clav ||
                $programNumber == AcousticGuitarSteel ||
                $programNumber == ElectricGuitarMuted ||
                ($programNumber == RockOrgan && 
                 $this->m_StyleName == "BLZ128"))
            {
                return Guitar;
            }
            if ($programNumber == AcousticGrandPiano ||
                ($programNumber == ElectricPiano1 && 
                 $this->m_StyleName != "JAZQUINT" && 
                 $this->m_StyleName != "BLZ128") ||
                $programNumber == ElectricPiano2)
            {
                return Piano;
            }
            if ($programNumber == StringEnsemble1 ||
                $programNumber == StringEnsemble2 ||
                ($programNumber == ElectricPiano1  && 
                 $this->m_StyleName == "JAZQUINT") ||
                ($programNumber == ElectricPiano1  && 
                 $this->m_StyleName == "BLZ128") ||
                $programNumber == TenorSax ||
                $programNumber == SynthStrings1 ||
                ($programNumber == RockOrgan &&
                ($this->m_StyleName == "MEDROCK2" || 
                 $this->m_StyleName == "BLUSHF_2")))
            {
                return Strings;
            }
        }
        return "";
    }
    
    private function IsDrumPattern()
    {
        foreach ($this->m_Events as $event)
        {             
            if (get_class($event) == "CNote" && $event->Channel == DrumChannel)
            {
                return TRUE;
            }
        }
        unset($event);
        
        return FALSE;
    }
    
    private function Parse($binaryData)
    {
        $this->m_ProgramNumber = -1;
        $formatArr = array_slice($binaryData, FormatStartByte - 1, 2);     
        $format = BinaryToInt($formatArr);
        
        if ($format != 0 && $format != 1)
        {
            die("Error! Format isn't supported.");
        }
        
        $tracksCountArr = array_slice($binaryData, TracksCountStartByte - 1, 2);
        
        $tracksCount = BinaryToInt($tracksCountArr);
         
        if ($tracksCount == 0)
        {
            die("Error! Tracks count is incorrect.");
        }
        
        $this->m_TicksPerQuarter = array_slice($binaryData, 
               TicksPQStartByte - 1, TicksPQLength);
        
        $MTrkRecord = array(0x4D, 0x54, 0x72, 0x6B);
        
        $lengthOfTrack = 0;
        for ($trackIndex = 1; $trackIndex <= $tracksCount; ++$trackIndex)
        {
            $arr = array_slice($binaryData, HeaderLength, 4);
            if ($arr !== $MTrkRecord)
            {
                die("Error! Track record is absent.");
            }

            $trackLengthArr = array_slice($binaryData, 
                    HeaderLength + count($MTrkRecord), TrackLengthBytesCount);

            $trackDataStart = HeaderLength + $lengthOfTrack + 
                 (count($MTrkRecord) + TrackLengthBytesCount) * $trackIndex + 1;
            
            $lengthOfTrack = BinaryToInt($trackLengthArr);

            $i = $trackDataStart;

            while ($i <= $trackDataStart + $lengthOfTrack)
            {
                //Delta Time variable length value
                $this->m_CurrentDeltaTime = $this->ReadVariableLenValue($binaryData, $i);

                //Meta Events
                if ($binaryData[$i] == 0xFF)
                {
                    ++$i;
                    if ($binaryData[$i] != 0x2F) //Not end of track
                    {
                        $this->ParseMetaEvent($binaryData, $i);
                    }
                    $this->m_LastStatusByte = 0;
                }
                //Main Events
                else if ($binaryData[$i] >= 0x80 && $binaryData[$i] <= 0xEF)
                {
                    $this->m_LastStatusByte = $binaryData[$i];
                    ++$i;
                    $this->ParseMainEvent($this->m_LastStatusByte, $binaryData, $i);
                }
                //Some strange event 0x0A 0x54 0x00 0x58 0x28 0x00 0x5D 0x00
                else if ($binaryData[$i] == 0x0A)
                {
                    $event = new C0AEvent();
                    $event->DeltaTime = $this->m_CurrentDeltaTime;
                    $event->Type = $binaryData[$i];
                    ++$i;
                    $event->Length = 7;
                    for ($j = 0; $j < $event->Length; ++$j)
                    {
                        $event->Data[] = $binaryData[$i];
                        ++$i;
                    }
                    
                    $this->m_Events[] = $event;
                }
                else //Running Status
                {
                    if ($this->m_LastStatusByte != 0)
                    {
                        $this->ParseMainEvent($this->m_LastStatusByte, $binaryData, $i);
                    }
                }
            }
        }
    }
    
    private function ParseMainEvent($statusByte, $binaryData, &$curr)
    {                
        //Note Off
        if ($statusByte >= 0x80 && $statusByte <= 0x8F)
        {
            $note = new CNote();
            $note->Start = FALSE;
            $note->Channel = $statusByte - 0x80 + 1;
            $note->DeltaTime = $this->m_CurrentDeltaTime;
            $note->Note = $binaryData[$curr];
            ++$curr;
            $note->Velocity = $binaryData[$curr];
            ++$curr;
            
            $this->m_Events[] = $note;
        }
        //Note On
        else if ($statusByte >= 0x90 && $statusByte <= 0x9F)
        {
            $note = new CNote();
            $note->Start = TRUE;
            $note->Channel = $statusByte - 0x90 + 1;
            $note->DeltaTime = $this->m_CurrentDeltaTime;
            $note->Note = $binaryData[$curr];
            ++$curr;
            $note->Velocity = $binaryData[$curr];
            ++$curr;
            
            if ($note->Velocity == 0)
            {
                $note->Start = FALSE;
            }
            
            $this->m_Events[] = $note;
        }
        //Polyphonic Key Pressure
        else if ($statusByte >= 0xA0 && $statusByte <= 0xAF)
        {
            $event = new CMainEvent();
            $event->DeltaTime = $this->m_CurrentDeltaTime;
            $event->Type = 0xA0;
            $event->Channel = $statusByte - $event->Type + 1;
            $event->Length = 2;
            $event->Data[] = $binaryData[$curr];
            ++$curr;
            $event->Data[] = $binaryData[$curr];
            ++$curr;
            
            $this->m_Events[] = $event;
        }
        //Control Change Event
        else if ($statusByte >= 0xB0 && $statusByte <= 0xBF)
        {
            $event = new CMainEvent();
            $event->DeltaTime = $this->m_CurrentDeltaTime;
            $event->Type = 0xB0;
            $event->Channel = $statusByte - $event->Type + 1;
            $event->Length = 2;
            $event->Data[] = $binaryData[$curr];
            ++$curr;
            $event->Data[] = $binaryData[$curr];
            ++$curr;
            
            $this->m_Events[] = $event;
        }
        //Program Change Event
        else if ($statusByte >= 0xC0 && $statusByte <= 0xCF)
        {
            $event = new CMainEvent();
            $event->DeltaTime = $this->m_CurrentDeltaTime;
            $event->Type = 0xC0;
            $event->Channel = $statusByte - $event->Type + 1;
            $event->Length = 1;
            $event->Data[] = $binaryData[$curr];
            ++$curr;
            
            $this->m_Events[] = $event;
        }
        //Channel Pressure
        else if ($statusByte >= 0xD0 && $statusByte <= 0xDF)
        {
            $event = new CMainEvent();
            $event->DeltaTime = $this->m_CurrentDeltaTime;
            $event->Type = 0xD0;
            $event->Channel = $statusByte - $event->Type + 1;
            $event->Length = 1;
            $event->Data[] = $binaryData[$curr];
            ++$curr;
            
            $this->m_Events[] = $event;
        }
        //Pitch Wheel Change
        else if ($statusByte >= 0xE0 && $statusByte <= 0xEF)
        {
            $event = new CMainEvent();
            $event->DeltaTime = $this->m_CurrentDeltaTime;
            $event->Type = 0xE0;
            $event->Channel = $statusByte - $event->Type + 1;
            $event->Length = 2;
            $event->Data[] = $binaryData[$curr];
            ++$curr;
            $event->Data[] = $binaryData[$curr];
            ++$curr;
            
            $this->m_Events[] = $event;
        }
    }
    
    private function ParseMetaEvent($binaryData, &$curr)
    {
        $metaEvent = new CMetaEvent();
        $metaEvent->DeltaTime = $this->m_CurrentDeltaTime;
        $metaEvent->Type = $binaryData[$curr];
        ++$curr;
        $metaEvent->Length = $this->ReadVariableLenValue($binaryData, $curr);
        $metaEvent->Data = array_slice($binaryData, $curr - 1, $metaEvent->Length);
        
        $this->m_Events[] = $metaEvent;
        
        $curr += $metaEvent->Length;
    }
    
    private function ReadVariableLenValue($binary, &$curr)
    {
        $value = $binary[$curr];
        ++$curr;
        if ($value & 0x80)
        {
            $value &= 0x7f;
            do
            {
                $c = $binary[$curr];
                $value = ($value << 7) + ($c & 0x7f);
                ++$curr;
            }
            while ($c & 0x80);
        }
        return $value;
    }
    
    private $m_TicksPerQuarter = array();
    private $m_CurrentDeltaTime;
    private $m_LastStatusByte;
    private $m_Events = array();
    private $m_Weight;
    private $m_RomanNumeralMask;
    private $m_ChordTypesMask;
    private $m_PlaybackBarMask;
    private $m_PlaybackBeatMask;
    private $m_IntervalToNextMask;
    private $m_ChordDurationMask;
    private $m_SubstylesABMask;
    private $m_FileName;
    private $m_BeatsCount;
    private $m_SilenceBeatsCount;
    private $m_StyleName;
}
?>