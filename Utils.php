<?php

function IsMIDIFile($file)
{
    return preg_match('/^[^.^:^?^\-][^:^?]*\.(?i)' . 
            '(mid|midi)' . '$/', $file);
}

function ConvertMIDIToMP3($midiFileName, $commonVolume)
{
    $linuxCommand = 'sh midi2mp3.sh ' . $midiFileName . ' ' . $commonVolume;
    $output = shell_exec($linuxCommand);
    if ($output == NULL)
    {
        die("Convertion MIDI to MP3 failed.");
    }
}

function BinaryToInt($binary)
{
    $packed = "";
    $binaryLength = count($binary);
    for ($i = 0; $i < $binaryLength; $i++)
    {
        $hex = dechex($binary[$i]);
        if (strlen($hex) == 1)
        {
            $hex = "0" . $hex;
        }
        $packed .= $hex;
    }
    
    return hexdec($packed);
}

function IntToBinary(&$binary, $binaryLength, $intValue)
{
    for ($i = 0; $i < $binaryLength - 1; ++$i)
    {
        $div = pow(0x100, $binaryLength - $i - 1);
        $binary[$i] = (int) floor($intValue / $div);
        $intValue = $intValue % $div;
    }
    $binary[$binaryLength - 1] = $intValue;
}

function FloatRand($fMin, $fMax)
{
    $f = rand() / getrandmax();
    return $fMin + $f * ($fMax - $fMin);
}

function GenerateUniqueFileName($path, $extension)
{
    $path = $path ? $path . DIRECTORY_SEPARATOR : '';

    do 
    {
        $name = uniqid();
        $file = $path . $name . $extension;
    } 
    while (file_exists($file));

    return $file;
}

?>
