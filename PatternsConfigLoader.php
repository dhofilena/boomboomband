<?php

class CPatternsConfigLoader
{
    public function __construct($xmlFileName)
    {        
        $xmlReader = new XMLReader();
        $xmlReader->open($xmlFileName);

        while($xmlReader->read())
        {
            if ($xmlReader->nodeType == XMLReader::ELEMENT)
            {
                $patternFileName = "";
                if ($xmlReader->name == "Pattern" && $xmlReader->hasAttributes)
                {
                    $patternInfo = array();
                    while($xmlReader->moveToNextAttribute())
                    {
                        if ($xmlReader->name == "name")
                        {
                            $patternFileName = strtolower($xmlReader->value);
                        }
                        else
                        {
                            $patternInfo[$xmlReader->name] = $xmlReader->value;
                        }
                    }
                    
                    $this->m_PatternsArray[$patternFileName] = $patternInfo;
                }
            }
        }
        
        $xmlReader->close();
    }
    
    public function InitPattern(&$pattern)
    {
        $patternFileName = strtolower($pattern->GetFileName());
        $pattern->InitWeightAndMasks($this->m_PatternsArray[$patternFileName]);
    }
    
    private $m_PatternsArray = array();
}

?>
