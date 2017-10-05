<?php
error_reporting(1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


        $tempo = $_POST['song_data'];
        $data =  "\n" . date('d-m-Y h:i:s') ."\n" . $tempo."\n";
       
        
        try {
            $fname = time();
            $fn = 'song_data.txt';
            $fp = fopen($fn, 'a+');
            $size = filesize($fn); 
            fwrite($fp, $data);
            $text = fread($fp, $size); 
            fclose($fp);
            //header("Location: player_settings/".$fname.".json");
            echo 'song_data.txt';
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
  
