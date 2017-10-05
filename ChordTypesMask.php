<?php

class CChordTypesMask
{
    public function __construct($chordTypesString)
    {
        // Can be such masks:
        // any; C; Cmaj7 C6 C; Cm; Cm7 Cm; Cm7b5; Cdim; Csus; C7sus Csus; C7 C9 C13; C7alt; C C7;
        $this->m_ChordTypesArray = explode(" ", $chordTypesString);
    }
    
    public function MeetChord($chord)
    {
        if (count($this->m_ChordTypesArray) == 0)
        {
            return TRUE;
        }
        
        foreach ($this->m_ChordTypesArray as $chordType)
        {
            if ($chordType == "C" . $chord->Type || $chordType == "any")
            {
                return TRUE;
            }
        }
        
        return FALSE;
    }
   
    public $m_ChordTypesArray = array();
}

?>