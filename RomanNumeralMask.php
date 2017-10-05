<?php

define ("NoteC", 0);
define ("NoteD", 2);
define ("NoteE", 4);
define ("NoteF", 5);
define ("NoteG", 7);
define ("NoteA", 9);
define ("NoteB", 11);

class CTonalityChord
{
    public function __construct($root, $type)
    {
        $this->Root = $root;
        $this->Type = $type;
    }
    
    public $Root;
    public $Type;
}

class CRomanNumeralMask
{
    public function __construct($romanNumber)
    {
        $this->m_RomanNumber = $this->ConvertRomanNumberToNumber($romanNumber);
        $this->BuildTonalities();
    }
    
    public function MeetChord($chord, $progression)
    {
        if ($this->m_RomanNumber == 0)
        {
            return TRUE;
        }
        
        $tonality = $this->DetermineTonality($progression);
        if ($tonality)
        {
            $romanNumberChord = $tonality[$this->m_RomanNumber - 1];
            
            if ($chord->Root == $romanNumberChord->Root &&
                (($chord->Type == $romanNumberChord->Type) ||
                ($chord->Type == "" && $romanNumberChord->Type == "maj") ||
                ($chord->Type == "maj" && $romanNumberChord->Type == "")))
             {
                 return TRUE;
             }
        }
        
        return FALSE;
    }
    
    private function BuildTonalities()
    {
        $tonalityC = array(new CTonalityChord(NoteC, ""), new CTonalityChord(NoteD, "m"),
                           new CTonalityChord(NoteE, "m"), new CTonalityChord(NoteF, ""),
                           new CTonalityChord(NoteG, "7"), new CTonalityChord(NoteA, "m"),
                           new CTonalityChord(NoteB, "m7b5"));
        $this->m_Tonalities[] = $tonalityC;
        
        $diffArray = array();
        $diffArray[] = NoteD - NoteC;
        $diffArray[] = NoteE - NoteC;
        $diffArray[] = NoteF - NoteC;
        $diffArray[] = NoteG - NoteC;
        $diffArray[] = NoteA - NoteC;
        $diffArray[] = NoteB - NoteC;
        
        foreach ($diffArray as $diff)
        {
            $tonality = array();
            foreach ($tonalityC as $chord)
            {
                $newChord = clone $chord;
                $newChord->Root += $diff;
                $tonality[] = $newChord;
            }
            $this->m_Tonalities[] = $tonality;
        }
    }
    
    private function DetermineTonality($progression)
    {
        $progressionCount = count($progression);
        foreach ($this->m_Tonalities as $tonality)
        {
            $counter = 0;
            foreach ($progression as $key)
            {
                foreach ($tonality as $tonalityChord)
                {
                    if ($key->Root == $tonalityChord->Root &&
                       (($key->Type == $tonalityChord->Type) ||
                       ($key->Type == "" && $tonalityChord->Type == "maj") ||
                       ($key->Type == "maj" && $tonalityChord->Type == "")))
                    {
                        ++$counter;
                    }
                }
            }
            if ($counter == $progressionCount)
            {
                return $tonality;
            }
        }
        return null;
    }
    
    private function ConvertRomanNumberToNumber($romanNumber)
    {
        switch ($romanNumber)
        {
            case "0":
            {
                return 0;
            }
            case "I":
            {
                return 1;
            }
            case "II":
            {
                return 2;
            }
            case "III":
            {
                return 3;
            }
            case "IV":
            {
                return 4;
            }
            case "V":
            {
                return 5;
            }
            case "VI":
            {
                return 6;
            }
            case "VII":
            {
                return 7;
            }
            default:
            {
                die("Roman Numbers can be in the range I - VII or 0 (Usual setting)");
            }
        }
    }
    
    public $m_RomanNumber;
    public $m_Tonalities = array();
}

?>
