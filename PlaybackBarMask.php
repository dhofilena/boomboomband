<?php

class CPlaybackBarMask
{
    public function __construct($settingNumber)
    {
        $this->m_SettingNumber = $settingNumber;
    }
    
    public function MeetBarNumber($barNumber)
    {
        switch ($this->m_SettingNumber)
        {
            //Usual setting
            case "0":
            {
                return TRUE;
            }
            case "bar 1 of 4":
            {
                // Pattern played at odd # bars only (1,3,5,7,9,...)
                if ($barNumber % 2 == 1)
                {
                    return TRUE;
                }
                break;
            }
            case "bar 2 of 4":
            {
                // Pattern played at even bars only (2,4,6,8,10...)
                if ($barNumber % 2 == 0)
                {
                    return TRUE;
                }
                break;
            }
            case "bar 3 of 4":
            {
                // Pattern played on 3rd of 4 bar (3,7,11,15..)
                if ($barNumber % 4 == 3)
                {
                    return TRUE;
                }
                break;
            }
            case "bar 4 of 4":
            {
                // Pattern played on 4th of 4 (4,8,12,16,20...)
                if ($barNumber % 4 == 0)
                {
                    return TRUE;
                }
                break;
            }
            case "bar 5 of 8":
            {
                // Pattern played on 5th of 8 (5,13,21...)
                if ($barNumber % 8 == 5)
                {
                    return TRUE;
                }
                break;
            }
            case "bar 6 of 8":
            {
                // Pattern played on 6th of 8 (6,14,22...)
                if ($barNumber % 8 == 6)
                {
                    return TRUE;
                }
                break;
            }
            case "bar 7 of 8":
            {
                // Pattern played on 7th of 8 (7,15,23...)
                if ($barNumber % 8 == 7)
                {
                    return TRUE;
                }
                break;
            }
            case "bar 8 of 8":
            {
                // Pattern played on 8th of 8 (8,16,24...)
                if ($barNumber % 8 == 0)
                {
                    return TRUE;
                }
                break;
            }
            case "pre fill":
            {
                return TRUE;
            }
            case "fill":
            {
                return TRUE;
            }
            case "post fill":
            {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    private $m_SettingNumber;
}

?>
