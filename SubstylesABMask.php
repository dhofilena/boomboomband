<?php

class CSubstylesABMask
{
    public function __construct($substyle)
    {
        // Can be such masks:
        // A and B
        $this->m_Substyle = $substyle;
    }
    
    public function MeetSubstyle($substyle)
    {
        if ($this->m_Substyle == 0 || 
            $this->m_Substyle == $substyle)
        {
            return TRUE;
        }
        
        return FALSE;
    }
   
    public $m_Substyle;
}

?>