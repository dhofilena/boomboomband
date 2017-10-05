<?php

class CPlaybackBeatMask
{
    public function __construct($beatNumber)
    {
        $this->m_BeatNumber = (int)$beatNumber;
    }
    
    public function MeetBeatNumber($beatNumber)
    {
        if ($beatNumber == $this->m_BeatNumber)
        {
            return TRUE;
        }
        
        return FALSE;
    }
    
    private $m_BeatNumber;
}

?>
