<?php
error_reporting(0);
 include "Main.php";
class Datacon{
	
		public function setProcessMIDI($chords_string,$style,$tempo,$instruments,$transpose, $startOfChorus, $endOfChorus, $repeatNumber, $endOfSong, $instrumentPatchesArray)
		{
			/*$fileName = "chord-progression.txt";
			
			$fp = fopen($fileName, "rb");
			if ($fp == FALSE)
			{
				die("File " . $fileName . " can't be open.");
			}
			$data = fread($fp, filesize($fileName));
			fclose($fp);
			*/
			$mp3FileName = "";
			$fileDuration = "";
			$countInDuration = "";
                        
                        //Temporary. Shouls be changed.
                        //$instrumentPatchesArray = array();
                        //
                        
                        $response = ProcessMIDI($chords_string, $style, $tempo, $instruments,
                                $transpose, $startOfChorus, $endOfChorus, $repeatNumber, $endOfSong, 
                                $instrumentPatchesArray, 1.0,
                                $mp3FileName,$fileDuration,$countInDuration);
			$return =array();
			$return['mp3FileName']	=	$mp3FileName;
			$return['response']	=	$response;
			$return['fileDuration']	=	$fileDuration;
			$return['countInDuration']	=	$countInDuration;
			return $return;
		}
	} 

		if(isset($_POST['action'])){
		   $func = $_POST['action'];
		   if($func == 'processMIDI')
			 {
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
                                
				$instrument = array('Drum' => $hdrumps ,'Bass' => $hbass , 'Piano' => $hpiano , 'Guitar' => $hguitar , 'Strings' => $hstrings);
				//return $instrument;
				
				$instrumentPatchesArray = array('Drum' => $drum_patches ,'Bass' => $bass_patches , 'Piano' => $piano_patches , 'Guitar' => $guitar_patches , 'Strings' => $string_patches);
				
				if(!empty($_POST['chords1'])){
						$chords = array();
						$count_chords1 = count($_POST['chords1']);
						$count_chords2 = count($_POST['chords2']);
						for($i=0;$i < $count_chords1 ;$i++){
							if((trim($_POST['chords1'][$i]) =='') && (trim($_POST['chords2'][$i])=='')){
								continue;
							}
							else if((trim($_POST['chords1'][$i])=='') || (trim($_POST['chords2'][$i])=='')){
								if(trim($_POST['chords1'][$i]) !=''){
									$chords[$i] = trim($_POST['chords1'][$i]);
								}
								if(trim($_POST['chords2'][$i]) !=''){
									$chords[$i] = trim($_POST['chords2'][$i]);
								}
							}else{
                                                            $ss = $_POST['chords2'][$i];
								$chords[$i] = trim($_POST['chords1'][$i]) .'^'. trim($_POST['chords2'][$i]);
							}
						}
					$chords_string = implode(',', $chords);
					
				}
				//echo $chords_string;
                                
				$dataCons	=	new Datacon();
				$mp3response  = $dataCons->setProcessMIDI($chords_string, $style, $tempo, $instrument,$transpose, $startOfChorus, $endOfChorus, $repeatNumber, $endOfSong, $instrumentPatchesArray);
				//print_r($mp3response);
				$json	=	array();
				$mp3src		=	 $mp3response['mp3FileName'];
				$json['duration']	=	 $mp3response['fileDuration'];
				$json['countInDuration']	=	 $mp3response['countInDuration'];
				$browser= $_SERVER['HTTP_USER_AGENT'] ;
				if(strpos(strtolower($browser),'firefox'))
                                        {
                                                $json['mp3src']	 =	 $mp3src.'.ogg';
                                        }
                                else{
                                                        $json['mp3src']	  =	 $mp3src.'.mp3';
                                        }
			}
			
			echo json_encode($json);
			
		}
	
        
// testing for error
        
//
//		   $func = 'processMIDI';
//		   if($func == 'processMIDI')
//			 {
//                 $tempo ='120';
//				$style = 'SOFTSWNG';
//							//USERDEFIND PATCHES
//							$drum_patches = 0;
//							$bass_patches = 32;
//							$piano_patches = 0;
//							$guitar_patches = 0;
//							$string_patches = 0;
//							
//							// USER DEFINED VOLUMES
//							$hdrumps = 52;
//							$hbass = 62;
//							$hpiano = 62;
//							$hguitar = 62;
//							$hstrings = 62;
//                                //updated
//                                $transpose = 'C';
//                                $startOfChorus = 1;
//                                $endOfChorus = 4;
//                                $repeatNumber = 1;
//                                $endOfSong = 4;
//                                
//				$instrument = array('Drum' => $hdrumps ,'Bass' => $hbass , 'Piano' => $hpiano , 'Guitar' => $hguitar , 'Strings' => $hstrings);
//				
//				
//				$instrumentPatchesArray = array('Drum' => $drum_patches ,'Bass' => $bass_patches , 'Piano' => $piano_patches , 'Guitar' => $guitar_patches , 'Strings' => $string_patches);
//				
////				if(!empty($_POST['chords1'])){
////						$chords = array();
////						$count_chords1 = count($_POST['chords1']);
////						$count_chords2 = count($_POST['chords2']);
////						for($i=0;$i < $count_chords1 ;$i++){
////							if((trim($_POST['chords1'][$i]) =='') && (trim($_POST['chords2'][$i])=='')){
////								continue;
////							}
////							else if((trim($_POST['chords1'][$i])=='') || (trim($_POST['chords2'][$i])=='')){
////								if(trim($_POST['chords1'][$i]) !=''){
////									$chords[$i] = trim($_POST['chords1'][$i]);
////								}
////								if(trim($_POST['chords2'][$i]) !=''){
////									$chords[$i] = trim($_POST['chords2'][$i]);
////								}
////							}else{
////                                                            $ss = $_POST['chords2'][$i];
////								$chords[$i] = trim($_POST['chords1'][$i]) .'^'. trim($_POST['chords2'][$i]);
////							}
////						}
////					$chords_string = implode(',', $chords);
////					
////				}
//				//echo $chords_string;
//                                $chords_string='C';
//				$dataCons	=	new Datacon();
//				$mp3response  = $dataCons->setProcessMIDI($chords_string, $style, $tempo, $instrument,$transpose, $startOfChorus, $endOfChorus, $repeatNumber, $endOfSong, $instrumentPatchesArray);
//				//print_r($mp3response);
//				$json	=	array();
//				$mp3src		=	 $mp3response['mp3FileName'];
//				$json['duration']	=	 $mp3response['fileDuration'];
//				$json['countInDuration']	=	 $mp3response['countInDuration'];
//				$browser= $_SERVER['HTTP_USER_AGENT'] ;
//				if(strpos(strtolower($browser),'firefox'))
//                                        {
//                                                $json['mp3src']	 =	 $mp3src.'.ogg';
//                                        }
//                                else{
//                                                        $json['mp3src']	  =	 $mp3src.'.wav';
//                                        }
//			}
//			
//			echo json_encode($json);
//			
//		
	
                
// end testing for error        
        
		if(isset($_POST['music_style_name']) && $_POST['music_style_name'] == 'action'){
			$style_name	= $_POST['style_name'];
			$ptach_response;
                        $volumes = array();//Temporary! 
						$result	=	array();
			GetInstrumentInfoForStyle($style_name,$ptach_response,$volumes);
				$result	['volumes']			=	$volumes;	
				$result	['ptach_response']	= $ptach_response;	
			// print_r($ptach_response);
			echo json_encode($result);
		}	
?>

