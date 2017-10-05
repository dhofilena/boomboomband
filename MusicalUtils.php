<?php

define ("NotesInOctaveCount", 12);
define ("NoteC", 0);
define ("NoteE", 4);
define ("NoteG", 7);
define ("NoteBb", 10);

function IsNoteC($note)
{
    if (($note->Note % NotesInOctaveCount) == NoteC)
    {
        return TRUE;
    }
    return FALSE;
}

function IsNoteE($note)
{
    if (($note->Note % NotesInOctaveCount) == NoteE)
    {
        return TRUE;
    }
    return FALSE;
}

function IsNoteG($note)
{
    if (($note->Note % NotesInOctaveCount) == NoteG)
    {
        return TRUE;
    }
    return FALSE;
}

function IsNoteBb($note)
{
    if (($note->Note % NotesInOctaveCount) == NoteBb)
    {
        return TRUE;
    }
    return FALSE;
}

function FixBassOctave($originalRootOctave, &$transposedNote)
{
    $lowerE = ($originalRootOctave - 1) * NotesInOctaveCount + NoteE;
    $higherE = $originalRootOctave * NotesInOctaveCount + NoteE;

    while ($transposedNote->Note <= $lowerE)
    {
        $transposedNote->Note += NotesInOctaveCount;
    }
    
    $bottomThreshold = 0x24; //C in 2nd octave

    while ($transposedNote->Note > $higherE && 
           $transposedNote->Note - NotesInOctaveCount >= $bottomThreshold)
    {
        $transposedNote->Note -= NotesInOctaveCount;
    }
}

?>
