<?php

class CMidiPatternsMerger
{
    public function MergeInstrumentPatternsToFile($fileName, $patterns)
    {
        $this->m_FileHandle = fopen($fileName, 'wb');
        
        if ($this->m_FileHandle == FALSE)
        {
            die("File " . $fileName . "couldn't be created.");
        }

        $this->WriteHeader($patterns);
        $this->WriteFirstTrack($patterns);
        
        foreach ($patterns as $pattern)
        {
            $this->FixChannel($pattern);
            $this->WritePatternAsTrack($pattern);
        }
        unset($pattern);
        
        fclose($this->m_FileHandle);
    }
    
    private function FixChannel(&$pattern)
    {
        $newChannel = -1;
        foreach ($pattern->GetEvents() as $event)
        {
            if (get_class($event) != "CMetaEvent")
            {
                if ($newChannel == -1)
                {
                    foreach ($this->m_busyChannels as $channel)
                    {
                        if ($event->Channel == $channel)
                        {
                            $newChannel = $this->GetFreeChannel();
                            $event->Channel = $newChannel;
                            $this->m_busyChannels[] = $newChannel;
                            break;
                        }
                    }
                    unset($channel);
                    if ($newChannel == -1)
                    {
                        $this->m_busyChannels[] = $event->Channel;
                        $newChannel = $event->Channel;
                    }
                }
                else
                {
                    $event->Channel = $newChannel;
                }
            }
        }
        unset($event);
    }
    
    private function GetFreeChannel()
    {
        for ($channel = 1; $channel <= 16; $channel++)
        {
            $isFree = TRUE;
            foreach ($this->m_busyChannels as $busyChannel)
            {
                if ($channel == $busyChannel)
                {
                    $isFree = FALSE;
                    break;
                }
            }
            unset($busyChannel);
            
            if ($isFree && $channel != DrumChannel)
            {
                return $channel;
            }
        }
        
        return 0;
    }
    
    private function WriteHeader($patterns)
    {
        $midiFormat = 1;
        $tracksCount = count($patterns) + 1;
        
        $ticksPQ = $patterns[0]->GetTicksPerQuarter();

        $tracksCountBinary = null;
        IntToBinary($tracksCountBinary, 2, $tracksCount);        
        $header = pack("C*", 0x4D, 0x54, 0x68, 0x64, 
                             0x00, 0x00, 0x00, 0x06,
                             0x00, $midiFormat,
                             $tracksCountBinary[0], $tracksCountBinary[1],
                             $ticksPQ[0], $ticksPQ[1]);

        fwrite($this->m_FileHandle, $header);
    }
    
    private function WriteStartOfTrack($lengthOfTrack)
    {
        $lengthOfTrackBinary = null;
        IntToBinary($lengthOfTrackBinary, 4, $lengthOfTrack);
        $header = pack("C*", 0x4D, 0x54, 0x72, 0x6B,
                             $lengthOfTrackBinary[0], 
                             $lengthOfTrackBinary[1],
                             $lengthOfTrackBinary[2],
                             $lengthOfTrackBinary[3]);

        fwrite($this->m_FileHandle, $header);
    }
    
    private function WriteEndOfTrack()
    {       
        $header = pack("C*", 0x00, 0xFF, 0x2F, 0x00);
        fwrite($this->m_FileHandle, $header);
    }
    
    private function PickMetaEventsToPlaceInFirstTrack($events)
    {
        foreach ($events as $event)
        {
            if (get_class($event) == "CMetaEvent")
            {
                if (($event->Type == 0x00) || //Sequence Number Event
                    ($event->Type == 0x02) || //CopyRight Event
                    ($event->Type == 0x06) || //Marker Event
                    ($event->Type == 0x07) || //Cue Point Event
                    ($event->Type == 0x51) || //SetTempo Event
                    ($event->Type == 0x58) || //Time Signature
                    ($event->Type == 0x59) || //Key Signature
                    ($event->Type == 0x54)    //SMPTE Offset Event
                    )
                {
                    $metaEvents[] = $event;
                }                         
            }
        }
        unset($events);
        
        return $metaEvents;
    }
    
    private function WriteMetaEvent(&$array, $event)
    {
        $this->WriteVariableLenValue($array, $event->DeltaTime);
        $array[] = 0xFF;
        $array[] = $event->Type;

        $this->WriteVariableLenValue($array, $event->Length);

        $array = array_merge($array, $event->Data);
    }
    
    private function WriteFirstTrack($patterns)
    {
        $metaEvents = array();
        foreach ($patterns as $pattern)
        {
            $events = $this->PickMetaEventsToPlaceInFirstTrack($pattern->GetEvents());
            if ($events)
            {
                foreach($events as $event)
                {
                    $found = FALSE;
                    foreach($metaEvents as $metaEvent)
                    {
                        if ($event->Type == $metaEvent->Type &&
                            $event->Length == $metaEvent->Length &&
                            $event->Data == $metaEvent->Data)
                        {
                            $found = TRUE;
                            break;
                        }
                    }
                    unset($metaEvent);
                    if (!$found)
                    {
                        $metaEvents[] = $event;
                    }
                }
                unset($event);
            }
        }
        unset($pattern);
        
        $trackDataArray = null;
        foreach ($metaEvents as $event)
        {            
            $this->WriteMetaEvent($trackDataArray, $event);
        }
        unset($event);
        
        $trackData = call_user_func_array("pack", array_merge(array("C*"), $trackDataArray));
             
        $this->WriteStartOfTrack(count($trackDataArray) + 4);
        fwrite($this->m_FileHandle, $trackData);        
        $this->WriteEndOfTrack();
    }
    
    private function WritePatternAsTrack($pattern)
    {         
        $trackDataArray = array();
        $this->m_LastEventWithStatusByte = null;
        
        $events = $pattern->GetEvents();
        foreach ($events as $event)
        {
            if (get_class($event) == "CMetaEvent")
            {
                if (($event->Type != 0x00) &&//Sequence Number Event
                    ($event->Type != 0x02) && //CopyRight Event
                    ($event->Type != 0x06) && //Marker Event
                    ($event->Type != 0x07) && //Cue Point Event
                    ($event->Type != 0x51) && //SetTempo Event
                    ($event->Type != 0x58) && //Time Signature
                    ($event->Type != 0x59) && //Key Signature
                    ($event->Type != 0x54)    //SMPTE Offset Event
                    )
                {
                    $this->WriteMetaEvent($trackDataArray, $event);
                }
                $this->m_LastEventWithStatusByte = null;
            }
            else if (get_class($event) == "CMainEvent")
            {
                $this->WriteVariableLenValue($trackDataArray, $event->DeltaTime);
                
                if ($this->m_LastEventWithStatusByte == null ||
                    get_class($this->m_LastEventWithStatusByte) != "CMainEvent" ||
                    $this->m_LastEventWithStatusByte->Type != $event->Type ||
                    $this->m_LastEventWithStatusByte->Channel != $event->Channel)
                {
                    $trackDataArray[] = $event->Type + $event->Channel - 1;
                    $this->m_LastEventWithStatusByte = $event;
                }
                
                $trackDataArray = array_merge($trackDataArray, $event->Data);
            }
            else if (get_class($event) == "CNote")
            {
                $this->WriteVariableLenValue($trackDataArray, $event->DeltaTime);
                if ($event->Start)
                {
                    if ($this->m_LastEventWithStatusByte == null ||
                        get_class($this->m_LastEventWithStatusByte) != "CNote" ||
                        $this->m_LastEventWithStatusByte->Channel != $event->Channel)
                    {
                        $trackDataArray[] = 0x90 + $event->Channel - 1;
                        $this->m_LastEventWithStatusByte = $event;
                    }
                }
                else
                {
                    if ($this->m_LastEventWithStatusByte == null ||
                        get_class($this->m_LastEventWithStatusByte) != "CNote" ||
                        $this->m_LastEventWithStatusByte->Channel != $event->Channel ||
                        $event->Velocity != 0)
                    {
                        $trackDataArray[] = 0x80 + $event->Channel - 1;
                        $this->m_LastEventWithStatusByte = $event;
                    }
                }
                $trackDataArray[] = $event->Note;
                $trackDataArray[] = $event->Velocity;
            }
            else if (get_class($event) == "C0AEvent")
            {
                $this->WriteVariableLenValue($trackDataArray, $event->DeltaTime);
                
                $trackDataArray[] = $event->Type;
                $trackDataArray = array_merge($trackDataArray, $event->Data);
                $this->m_LastEventWithStatusByte = null;
            }
        }
        unset($event);
        
        $trackData = call_user_func_array("pack", array_merge(array("C*"), $trackDataArray));
             
        $this->WriteStartOfTrack(count($trackDataArray) + 4);
        fwrite($this->m_FileHandle, $trackData);
        $this->WriteEndOfTrack();
    }
    
    private function WriteVariableLenValue(&$binary, $value)
    {
        $tmp = $value & 0x7f;
        while (($value >>= 7) > 0)
        {
            $tmp <<= 8;
            $tmp |= 0x80;
            $tmp += ($value & 0x7f);
        }
        while (TRUE)
        {
            $binary[] = $tmp;
            if ($tmp & 0x80)
            {
                $tmp >>= 8;
            }
            else
            {
                break;
            }
        }
    }
    
    private $m_FileHandle;
    private $m_LastEventWithStatusByte;
    private $m_busyChannels = array();
}

?>