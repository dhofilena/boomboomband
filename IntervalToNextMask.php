<?php

define ("NotesInOctaveCount", 12);

class CIntervalToNextMask
{
    public function __construct($interval)
    {
        // $interval can be such masks:
        // same root; up 7th; up 6th; up 5th; up 4th; up 3rd; up 2nd;
        // any interval; down 2nd; down 3rd; down 4th; down 5th; down 6th; down 7th;
        $this->m_IntervalToNext = $interval;
    }
    
    public function MeetChord($chord, $nextChord)
    {
        if ($nextChord == null)
        {
            return TRUE;
        }
        
        switch ($this->m_IntervalToNext)
        {
            case "same root":
            {
                if ($nextChord->Root == $chord->Root)
                {
                    return TRUE;
                }
                break;
            }
            case "up 7th":
            {
                $semitones = $this->GetSemitonesUp($chord, $nextChord);
                if ($semitones == 10 || $semitones == 11)
                {
                    return TRUE;
                }
                break;
            }
            case "up 6th":
            {
                $semitones = $this->GetSemitonesUp($chord, $nextChord);
                if ($semitones == 8 || $semitones == 9)
                {
                    return TRUE;
                }
                break;
            }
            case "up 5th":
            {
                $semitones = $this->GetSemitonesUp($chord, $nextChord);
                if ($semitones == 6 || $semitones == 7)
                {
                    return TRUE;
                }
                break;
            }
            case "up 4th":
            {
                $semitones = $this->GetSemitonesUp($chord, $nextChord);
                if ($semitones == 5)
                {
                    return TRUE;
                }
                break;
            }
            case "up 3rd":
            {
                $semitones = $this->GetSemitonesUp($chord, $nextChord);
                if ($semitones == 3 || $semitones == 4)
                {
                    return TRUE;
                }
                break;
            }
            case "up 2nd":
            {
                $semitones = $this->GetSemitonesUp($chord, $nextChord);
                if ($semitones == 1 || $semitones == 2)
                {
                    return TRUE;
                }
                break;
            }
            case "any interval":
            {
                return TRUE;
            }
            case "down 7th":
            {
                $semitones = $this->GetSemitonesDown($chord, $nextChord);
                if ($semitones == 10 || $semitones == 11)
                {
                    return TRUE;
                }
                break;
            }
            case "down 6th":
            {
                $semitones = $this->GetSemitonesDown($chord, $nextChord);
                if ($semitones == 8 || $semitones == 9)
                {
                    return TRUE;
                }
                break;
            }
            case "down 5th":
            {
                $semitones = $this->GetSemitonesDown($chord, $nextChord);
                if ($semitones == 6 || $semitones == 7)
                {
                    return TRUE;
                }
                break;
            }
            case "down 4th":
            {
                $semitones = $this->GetSemitonesDown($chord, $nextChord);
                if ($semitones == 5)
                {
                    return TRUE;
                }
                break;
            }
            case "down 3rd":
            {
                $semitones = $this->GetSemitonesDown($chord, $nextChord);
                if ($semitones == 3 || $semitones == 4)
                {
                    return TRUE;
                }
                break;
            }
            case "down 2nd":
            {
                $semitones = $this->GetSemitonesDown($chord, $nextChord);
                if ($semitones == 1 || $semitones == 2)
                {
                    return TRUE;
                }
                break;
            }
            default:
            {
                die("Unsupported Next Interval Mask.");
            }
        }
        
        return FALSE;
    }
    
    private function GetSemitonesUp($chord, $nextChord)
    {
        $semitones = $nextChord->Root - $chord->Root;
        if ($semitones < 0)
        {
            $semitones += NotesInOctaveCount;
        }
        
        return $semitones;
    }
    
    private function GetSemitonesDown($chord, $nextChord)
    {
        $semitones = $chord->Root - $nextChord->Root;
        if ($semitones < 0)
        {
            $semitones += NotesInOctaveCount;
        }
        
        return $semitones;
    }
    
    private $m_IntervalToNext;
}

?>