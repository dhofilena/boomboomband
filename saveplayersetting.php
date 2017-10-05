<?php
error_reporting(1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST['action'])) {
    $funct = $_POST['action'];
    if ($funct == 'export_setting') {
       // return 'inside';
        $tempo = $_POST['tempo'];
        
        $style = $_POST['style'];
        //USERDEFIND PATCHES
        $drum_patches = $_POST['drum_patches'];
        $bass_patches = $_POST['bass_patches'];
        $piano_patches = $_POST['piano_patches'];
        $guitar_patches = $_POST['guitar_patches'];
        $string_patches = $_POST['string_patches'];

        // USER DEFINED VOLUMES
        $hdrumps = $_POST['hdrumps'];
        $hbass = $_POST['hbass'];
        $hpiano = $_POST['hpiano'];
        $hguitar = $_POST['hguitar'];
        $hstrings = $_POST['hstrings'];
        //updated
        $transpose = $_POST["transpose"];
        $startOfChorus = $_POST["start_of_chorus"];
        $endOfChorus = $_POST["end_of_chorus"];
        $repeatNumber = $_POST["repeat_number"];
        $endOfSong = $_POST["end_of_song"];
       // var_dump($_POST['chrods1']);
       // var_dump(json_decode($_POST['chords1'], true));
//        if (!empty($_POST['chords1'])) {
//            $chords1 = array();
//            $chords2 = array();
//            $count_chords1 = count($_POST['chords1']);
//            $count_chords2 = count($_POST['chords2']);
//            $count_chords = 0;
//            if ($count_chords2 > $count_chords1) {
//                $count_chords = $count_chords2;
//            } else {
//                $count_chords = $count_chords1;
//            }
//            $i = 0;
//            $j = 0;
//            $cnt = 0;
//            while ($cnt < $count_chords) {
//                if ((trim($_POST['chords1'][$cnt]) == '') && (trim($_POST['chords2'][$cnt]) == '')) {
//                    continue;
//                } else if ((trim($_POST['chords1'][$cnt]) == '') || (trim($_POST['chords2'][$cnt]) == '')) {
//                    if (trim($_POST['chords1'][$cnt]) != '') {
//                        $chords1[$i] = trim($_POST['chords1'][$cnt]);
//                        $i++;
//                    }
//                    if (trim($_POST['chords2'][$cnt]) != '') {
//                        $chords2[$j] = trim($_POST['chords2'][$cnt]);
//                        $j++;
//                    }
//                } else {
//
//                    $chords1[$i] = trim($_POST['chords1'][$cnt]);
//                    $chords2[$j] = trim($_POST['chords2'][$cnt]);
//                    $i++;
//                    $j++;
//                }
//                $cnt++;
//            }
//            $chords_string1 = implode(',', $chords1);
//            $chords_string2 = implode(',', $chords2);
//            $chords_string1=$_POST['chords1'];
//        }
//      
        $chords_string1=$_POST['chrods1'];
        $chords_string2=$_POST['chrods2'];
        $posts=array();
          $posts[] = array('tempo' => "$tempo", 'style' => "$style", 'drum_patches' => "$drum_patches", 'bass_patches' => "$bass_patches",
            'piano_patches' => "$piano_patches", 'guitar_patches' => "$guitar_patches", 'string_patches' => "$string_patches",
            'hdrumps' => "$hdrumps", 'hbass' => "$hbass", 'hpiano' => "$hpiano", 'hguitar' => "$hguitar",
            'hstrings' => "$hstrings", 'transpose' => "$transpose", 'start_of_chorus' => "$startOfChorus",
            'end_of_chorus' => "$endOfChorus", 'repeat_number' => "$repeatNumber", 'end_of_song' => "$endOfSong",
            'chords_string1' => "$chords_string1", 'chords_string2' => "$chords_string2");
          
       
        
        try {
            $fname = time();
            $response['player_setting'] = $posts;
            
            $fp = fopen('player_settings/' . $fname . '.json', 'w');
            fwrite($fp, json_encode($response));
            fclose($fp);
            //header("Location: player_settings/".$fname.".json");
            echo $fname.'.json';
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
}else{
    echo 'no data send';
}