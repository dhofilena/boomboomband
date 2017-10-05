<?php

include "MidiPattern.php";
include "Utils.php";
include "MidiPatternsMerger.php";
include "ChordProgression.php";

/*  Input parameters:
 *  $styleName - String with name of the style
 *  Output parameters: 
 *  $instrumentPatchesArray - Array with instruments patches values
 *  like "Strings" => 49, "Piano" => 20, etc.
 *  $instrumentVolumesArray - Array with instruments volumes values
 *  like "Strings" => 0, "Piano" => 64, etc.
*/  
function GetInstrumentInfoForStyle($styleName, &$instrumentPatchesArray, &$instrumentVolumesArray)
{
    $instrumentsArray = array(Bass, Drum, Guitar, Piano, Strings);
    
    foreach ($instrumentsArray as $instrumentName)
    {        
        $dirName = "Patterns" . DIRECTORY_SEPARATOR . $styleName . 
                   DIRECTORY_SEPARATOR . $instrumentName;
        if (file_exists($dirName))
        {
            $dir = opendir($dirName);
            while (false !== ($filename = readdir($dir)))
            {
                if (IsMIDIFile($filename))
                {
                    $pattern = new CMidiPattern();
                    $pattern->LoadFromFile($dirName . DIRECTORY_SEPARATOR . $filename, $styleName);

                    if ($pattern->GetInstrumentName() == $instrumentName)
                    {
                        $instrumentPatchesArray[$instrumentName] = $pattern->GetInstrumentPatch();
                        $instrumentVolumesArray[$instrumentName] = $pattern->GetVolume();
                        break;
                    }
                }
            }
        }
    }
}

/*  Input parameters:
 *  $progression - String of chords, separated by , and ^
 *  $styleName - String with name of the style
 *  $tempo - Integer value of Tempo
 *  $instrumentsVolumes - Array of strings with names of instruments and 
 *      their volumes. Can contain values: Piano, Guitar, Drum, Bass, Strings.
 *  $transpose - String value contains root for transposition.
 *  $startOfChorus - Integer, start bar of Chorus.
 *  $endOfChorus - Integer value of end bar of chorus.
 *  $repeatNumber - Integer value of Repeat Number.
 *  $endOfSong - Integer value of end song bar number.
 *  $instrumentPatchesArray - Array with instruments patches values
 *      like "Strings" => 49, "Piano" => 20, etc.
 *  $commonVolume - Float value of the volume for all song (range is 0 < $commonVolume < 10)
 *  Output parameters: 
 *  $mp3FileName - String with name of the resultant *.MP3 file.
 *  $songDuration - Duration of the song in milliseconds (without Count In).
 *  $countInDuration - Duration of the Count In in milliseconds.
*/      
function ProcessMIDI($progression, $styleName, $tempo, $instrumentsVolumes, 
        $transpose, $startOfChorus, $endOfChorus, $repeatNumber, $endOfSong,
        $instrumentPatchesArray, $commonVolume,
        &$resultFileNameWithoutExt, &$songDuration, &$countInDuration)
{                 
    if ($progression == "")
    {
        die("Chord progression is empty.");
    }
    
    if ($startOfChorus >= $endOfChorus)
    {
        die("Start of Chorus has to be less than End of Chorus.");
    }
    
    if ($endOfChorus > $endOfSong)
    {
        die("End of Chorus can't be more than End of Song.");
    }
    
    $chordProgression = new CChordProgression();
    $chordProgression->LoadFromString($progression);
    
    if ($chordProgression->GetBeatsCount() / 4 < $endOfSong)
    {
        $chordProgression->RepeatLastChordToTheEnd($endOfSong);
    }

    $instrumentsArray = array(Bass, Drum, Guitar, Piano, Strings);
    $readyPatterns = array();
    
    $countInFileName = "Patterns" . DIRECTORY_SEPARATOR . "Count in.MID";
    if (file_exists($countInFileName))
    {
        $countInPattern = new CMidiPattern();
        $countInPattern->LoadFromFile($countInFileName, $styleName);
    }
    
    foreach ($instrumentsArray as $instrumentName)
    {
        $instrumentVolume = $instrumentsVolumes[$instrumentName];
        $instrumentPatch = -1;
        if (count($instrumentPatchesArray) != 0)
        {
            $instrumentPatch = $instrumentPatchesArray[$instrumentName];
        }                
        
        $result = $chordProgression->ProcessInstrument($styleName, 
            $instrumentName, $instrumentVolume, $tempo, $countInPattern, 
            $startOfChorus, $endOfChorus, $repeatNumber, $endOfSong, $instrumentPatch);
        
        if ($result)
        {
            $readyPatterns[] = $result;
        }
    }

    $resultsDirName = "Results";
    if (!file_exists($resultsDirName))
    {
        mkdir($resultsDirName);
    }
    $resultFileName = GenerateUniqueFileName($resultsDirName, ".mid");
        
    $merger = new CMidiPatternsMerger();
    $merger->MergeInstrumentPatternsToFile($resultFileName, $readyPatterns);
    
    $millisecsPerBeat  = 60000 / $tempo;
    $songDuration = $millisecsPerBeat * $chordProgression->GetBeatsCount();
    $countInDuration = $millisecsPerBeat * $countInPattern->GetBeatsCount();
    
    ConvertMIDIToMP3($resultFileName, $commonVolume);
    //CleanUpIntermediateFiles($resultFileName);
    
    $resultFileNameWithoutExt = $resultFileName;
}

function CleanUpMp3($mp3FileName)
{
    unlink($mp3FileName);
}

function CleanUpIntermediateFiles($resultFileName)
{    
    unlink($resultFileName);
    unlink($resultFileName . ".". wav);
}

?>
