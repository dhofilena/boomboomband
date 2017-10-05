<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        include "Main.php";
        
        $fileName = "chord-progression.txt";
        
        $fp = fopen($fileName, "rb");
        if ($fp == FALSE)
        {
            die("File " . $fileName . " can't be open.");
        }
        $data = fread($fp, filesize($fileName));
        fclose($fp);
        
        $mp3FileName = "";
        ProcessMIDI($data, "SOFTSWNG", 120, array(), $mp3FileName);
          
        ?>
    </body>
</html>
