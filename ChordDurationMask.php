<?php

class CChordDurationMask
{
    public function __construct($chordDuration)
    {
        // Can be such masks:
        // 1, 2, 4, 8 (beats)
        $this->m_ChordDuration = (int)$chordDuration;
    }
    
    public function MeetChordDuration($chordDuration)
    {
        if ($this->m_ChordDuration == 0 || 
            $this->m_ChordDuration == $chordDuration)
        {
            return TRUE;
        }
        
        return FALSE;
    }
   
    public $m_ChordDuration;
}

?>