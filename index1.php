<!DOCTYPE html>
<html>
<!--[if IE 8]>         <html class="no-js ie ie8"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie ie9"> <![endif]-->
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="keywords" content="" />
<meta content="" http-equiv="description"/>
<meta name="author" content="" />
<title>Band</title>
<link rel="shortcut icon" href="../images/favicon.ico" />

<link rel="stylesheet" type="text/css" href="css/jquery.selectbox.css">

<link rel="stylesheet" type="text/css" href="css/style.css" media="screen"/>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<style>
.jp-gui {
	position:relative;
	padding:0px 0px 0px 20px;
	width:225px;
	top:12px;
}
.jp-gui.jp-no-volume {
	width:432px;
}
.jp-gui ul {
	margin:0;
	padding:0;
}
.jp-gui ul li {
	position:relative;
	float:left;
	list-style:none;
	margin:2px;
	padding:4px 0;
	cursor:pointer;
}
.jp-gui ul li a {
	margin:0 4px;
}
.jp-gui li.jp-repeat,
.jp-gui li.jp-repeat-off {
	margin-left:344px;
}
.jp-gui li.jp-mute,
.jp-gui li.jp-unmute {
	margin-left:20px;
}
.jp-gui li.jp-volume-max {
	margin-left:120px;
}
li.jp-pause,
li.jp-repeat-off,
li.jp-unmute,
.jp-no-solution {
	display:none;
}
.jp-progress-slider {
	position: absolute;
top: 10px;
left: 100px;
width: 134px;
padding: 0px;
height: 4px;
}
.jp-progress-slider .ui-slider-handle {
	cursor:pointer;
}
.jp-volume-slider {
	position:absolute;
	top:31px;
	left:508px;
	width:100px;
	height:.4em;
}
.jp-volume-slider .ui-slider-handle {
	height:.8em;
	width:.8em;
	cursor:pointer;
}
.jp-gui.jp-no-volume .jp-volume-slider {
	display:none;
}
.jp-current-time,
.jp-duration {
	position:absolute;
	top:42px;
	font-size:0.8em;
	cursor:default;
}
.jp-current-time {
	left:100px;
}
.jp-duration {
	right:30px;
}
.jp-gui.jp-no-volume .jp-duration {
	right:70px;
}
.jp-clearboth {
	clear:both;
}
.player .ui-slider .ui-slider-handle {
position: absolute;
z-index: 2;
width: 0.8em;
height: 0.8em;
cursor: default;
display: none;
}
.player .jp-progress-slider {
position: absolute;
top: 12px;
left: 70px;
width: 134px;
padding: 0px;
height: 4px;
}
.player .jp-gui {
position: relative;
padding: 0px 0px 0px 20px;
width: 238px;
top: 12px;
}
.ui-progressbar {
    position: relative;
}
.progress-label {
  position: absolute;
  left: 24%;
  top: 4px;
  font-weight: bold;
  text-shadow: 1px 1px 0 #fff;
}
.overlay {
position:fixed;
    left:0;
    right:0;
    top:0;
    bottom:0;
    
   
 z-index:9;
background-color:#000;
background:rgba(0, 0, 0, 0.5);

    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
    filter: alpha(opacity=50);
}
.loading {
    position:absolute;
    top:35%;
    left:40%;
    width: 25%;
    height: 10px;
    z-index:10;
    /*background:url(../../images/loader.gif) no-repeat center center;*/
}
.loadingDiv {
    
    
    display:none;
    
    

}
</style>

<!--[if lt IE 9]>
         <script src="js/html5shiv.js"></script>
<![endif]-->

<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="css/ie7.css" media="screen"/>
<![endif]-->


<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="css/ie8.css" media="screen"/>
<![endif]-->

<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]--> 

 
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.selectbox-0.2.min.js"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/core.js"></script>
<script type="text/javascript" src="js/jquery.jplayer.min.js"></script>




<!--[if IE 7]>
<script type="text/javascript">
    $(document).ready(function(){
    	$(".selectbox").selectbox("detach");
		alert("Please upgrade your browser for best performance");
	});
 </script>
 <![endif]-->
 
 <script type="text/javascript">
  var times = 1;
  var progressBarValue = 0;
  var songKeys	=	new Array(); 
		songKeys[1]	=	'C';
		songKeys[2]	=	'Db';
		songKeys[3]	=	'D';
		songKeys[4]	=	'Eb';
		songKeys[5]	=	'E';
		songKeys[6]	=	'F';
		songKeys[7]	=	'Gb';
		songKeys[8]	=	'G';
		songKeys[9]	=	'Ab';
		songKeys[10] =	'A';
		songKeys[11]=	'Bb';
		songKeys[12]=	'B';
  $(document).ready(function(){
	
	
	var selectData	='';
        var steps = 0;
	
		for(var s = 1; s < songKeys.length; s++){
			selectData +='<option value="'+s+'">'+songKeys[s]+'</option>';
		}
		
	$('#transpose').html(selectData).promise().done(function(){
		//$('.transpose').selectbox();
		var StaticSelectFlag	=	1;
		$('#transpose').off('change').on('change',function(){
				if(confirm("Are you sure you want to change Key of the song")){
					var arrayIndex		=	$(this).val();
					var replaceIndex	=	parseInt(StaticSelectFlag) + parseInt(arrayIndex);
					replaceIndex		=	parseInt(replaceIndex);
					
					var replaceText		= 	songKeys[replaceIndex];
					
					if(parseInt(StaticSelectFlag) < arrayIndex){
						steps			=	parseInt(arrayIndex) - parseInt(StaticSelectFlag);
						StaticSelectFlag	=	parseInt(arrayIndex);	
					}else{
                                                steps	=	parseInt((parseInt(songKeys.length) - 1) - parseInt(StaticSelectFlag)) + parseInt(arrayIndex);
						StaticSelectFlag	=	parseInt(arrayIndex);	
					}
					
					chords1(steps);
					chords2(steps);
					
			}else{
				StaticSelectFlag	=	parseInt($(this).val());
                                steps = StaticSelectFlag;
				//alert(StaticSelectFlag);
			}
			$('#SongKey').val(songKeys[$(this).val()]);	
		})
	});
	
	 $("#drumps").slider({
	  min: 1,
	  max: 127,
	  value: 127,
	  step: 2,
	  slide: function(event, ui) {
	  $("#hdrumps").val(ui.value);
	  
	  
	  }
	});
	
	$("#bass").slider({
	  min: 0,
	  max: 127,
	  value: 107,
	  step: 1,
	  slide: function(event, ui) {
	  $("#hbass").val(ui.value);
	  
	  }
	});
	
	$("#piano").slider({
	  min: 0,
	  max: 127,
	  value: 127,
	  step: 1,
	  slide: function(event, ui) {
	  $("#hpiano").val(ui.value);
	  
	  }
	});
	


	$("#guitar").slider({
	  min: 0,
	  max: 127,
	  value: 127,
	  step: 1,
	  slide: function(event, ui) {
	  $("#hguitar").val(ui.value);
	  
	  }
	});
	
	$("#strings").slider({
	  min: 0,
	  max: 127,
	  value: 127,
	  step: 1,
	  slide: function(event, ui) {
	  $("#hstrings").val(ui.value);
	  
	  }
	});
	
	
	/*submit composition form*/
	var duration = '';
	var countInDuration = '';
	$('#play_music').click(function(){
		var refrence	=		$(this);
		refrence.text('Wait');
                //progressBarValue = 0;
                progressStart();
		$('.topChords  ul.Chords li').removeClass('highlight');
		var url = 'datacon.php';
		
		var data  = 'bass_patches='+$('#bass_sytle').val()+'&piano_patches='+$('#piano_sytle').val()+'&guitar_patches='+$('#guitar_style').val()+'&string_patches='+$('#string_sytle').val()+'&drum_patches='+$('#drum_sytle').val()+'&tempo='+$('#music_tempo').val()+'&style='+$('#music_style').val()+'&hdrumps='+$('#hdrumps').val()+'&hbass='+$('#hbass').val()+'&hpiano='+$('#hpiano').val()+'&hguitar='+$('#hguitar').val()+'&hstrings='+$('#hstrings').val()+"&transpose="+ $("#SongKey").val() + "&start_of_chorus=" + $("#start_of_chorus").val() + "&end_of_chorus=" + $("#end_of_chorus").val() + "&repeat_number=" + $("#repeat_number").val() + "&end_of_song=" + $("#end_of_song").val() +'&action=processMIDI';
                //alert(data);
		data += '&'+$('#chords_form').serialize();
		data += '&'+$('#music_composition').serialize();
                //console.log(data);
		doAjaxCall(url,data,false,function(html){
					try {
							var responseData		= $.parseJSON(html);
							var mp3src			=	responseData.mp3src;
							 duration			=	responseData.duration;
							 countInDuration	=	responseData.countInDuration;
							 //$("#jquery_jplayer_1").jPlayer( "clearMedia" );
                                                         console.log(responseData);
                                                        alert(mp3src);
							$("#jquery_jplayer_1").jPlayer( "destroy" );
							updatePlayer(mp3src);
							$('.topChords ul.Chords .highlight').removeClass('highlight');
							// <- play the song!!!
							
							setTimeout(function(){refrence.text('Play');},1);
                                                        progressStop();
							
						} catch (e) {
							alert(html);
							//alert(e);
							
							//$("#jquery_jplayer_1").jPlayer("stop");
							//var mp3src	=	'http://www.jplayer.org/audio/mp3/Miaow-07-Bubble.mp3';
							//updatePlayer(mp3src);
							refrence.text('Play');
                                                        //progressLabel.text( "Error!" );
                                                        progressStop();
						}
			});
		});
	
            $('.topChords ul.Chords li input[type="text"]').focus(function(){ 
                    $('.topChords ul.Chords li').removeClass('highlight');
                    $(this).closest('li').addClass('highlight');
            });
            
				$("#stop_music").on('click',function() {
                    	$("#jquery_jplayer_1").jPlayer("stop");
				});
                $(".ui-icon-triangle-1-s").click(function(){
                    //$(".spinNumber").change(function(){
                    $(".spinNumber").each(function(){
                        try{
                            //var parents = $(this).parents("span");
                            if( parseInt($(this).val()) < 1){
                                $(this).select();
                                $(this).val("1");
                            }
                        }catch(e){
                            alert(e);
                        }
                    });
                });
                $(".spinNumber").change(function(){
                    $(".spinNumber").each(function(){
                        try{
                            //var parents = $(this).parents("span");
                            if( parseInt($(this).val()) < 1){
                                $(this).select();
                                $(this).val("1");
                            }
                        }catch(e){
                            alert(e);
                        }
                    });
                });
            
			$('#music_style').change(function(){
				var style_name	=	$(this).val();
				//$('option', this).removeAttr("selected");
				//alert(style_name);
				var data	=	'music_style_name=action&style_name='+style_name;
				var url		=	'datacon.php';
					doAjaxCall(url,data,false,function(html){
					try{
						
						var responseData		= $.parseJSON(html);
					//	alert(responseData.ptach_response.Bass);
						if(typeof responseData.ptach_response.Bass != 'undefined'){
							 var Bass	=	responseData.ptach_response.Bass;
								$('#bass_sytle').selectbox('detach');
								 $('#bass_sytle').val(Bass);
							//	 $('#bass_sytle').selectbox('attach');
								// $( "#bass" ).slider( "value", Bass );
						}
						if(typeof responseData.volumes.Bass != 'undefined'){
								var Bass	=	responseData.volumes.Bass;
								$( "#bass" ).slider( "value", Bass );
								$( "#hbass" ).val( Bass );
						}
						if(typeof responseData.ptach_response.Drum != 'undefined'){
							var Drum	=	responseData.ptach_response.Drum;
							
								//$('#drum_sytle').selectbox('detach');
								//$('#drum_sytle').val(Drum);
							//	$('#drum_sytle').selectbox('attach');
						}
						if(typeof responseData.volumes.Drum != 'undefined'){
								var Drum	=	responseData.volumes.Drum;
								$( "#drumps" ).slider( "value", Drum );
								$( "#hdrumps" ).val( Drum );
						}
						if(typeof responseData.ptach_response.Guitar != 'undefined'){
							var Guitar	=	responseData.ptach_response.Guitar;
							
								$('#guitar_style').selectbox('detach');
								$('#guitar_style').val(Guitar);
							//	$('#guitar_style').selectbox('attach');
						}
						if(typeof responseData.volumes.Guitar != 'undefined'){
								var Guitar	=	responseData.volumes.Guitar;
								$( "#guitar" ).slider( "value", Guitar );
								$( "#hguitar" ).val( Guitar );
						}
						if(typeof responseData.ptach_response.Piano != 'undefined'){
							var Piano	=	responseData.ptach_response.Piano;
								
								$('#piano_sytle').selectbox('detach');
								$('#piano_sytle').val(Piano);
							//	$('#piano_sytle').selectbox('attach');
						}
						
						if(typeof responseData.volumes.Piano != 'undefined'){
								var Piano	=	responseData.volumes.Piano;
								$( "#piano" ).slider( "value", Piano );
								$( "#hpiano" ).val( Piano );
						}
						if(typeof responseData.ptach_response.Strings != 'undefined'){
							var Strings	=	responseData.ptach_response.Strings;
								$('#string_sytle').selectbox('detach');
								$('#string_sytle').val(Strings);
							//	$('#string_sytle').selectbox('attach');
						}
						
						if(typeof responseData.volumes.Strings != 'undefined'){
								var Strings	=	responseData.volumes.Strings;
								$( "#strings" ).slider( "value", Strings );
								$( "#hstrings" ).val( Strings );
						}
						
					}
					catch(e){
						alert(e);
					}
				});
			});
	});
	
	function chords1(steps){
            console.log( "Steps " +  steps);
            $('#chords_form input.chords1').each(function(){
                    var inputValOrg	=	$(this).val();
                    var refrenceInput	=	$(this);
                    if(inputValOrg != ''){
                            var inputVal	=	inputValOrg.substr(0,1).toUpperCase() + inputValOrg.substr(1,1).toLowerCase();
                            var inputValONE	=	inputValOrg.substr(0,1).toUpperCase();
                            //console.log("Input val " + inputVal);
                            //console.log("Input val One " + inputValONE);
                            var index = $.inArray(inputVal,songKeys);
                            //console.log("index in songKeys is " + index);
                            if(index !== -1){
                            //alert($.inArray(inputVal,songKeys) !== -1);
                                var currentIndex	=	index;
                                var stepIndex	=	parseInt(currentIndex) + parseInt(steps);
                                //console.log( "Current Index " + currentIndex + " Step Index" + stepIndex );
                                //	alert('Double stepIndex '+stepIndex);
                                if(parseInt(stepIndex) >= songKeys.length){
                                    //alert('enter for modification');
                                    stepIndex	=	parseInt(stepIndex) - songKeys.length +1;
                                    if(stepIndex == '' || stepIndex==null || stepIndex== 1){
                                        stepIndex	=	1;
                                    }
                                    //alert('Double stepIndex after change more than index= ' + stepIndex);
                                }
                                //alert('Go for step Index '+ stepIndex)
                                refrenceInput.val(songKeys[stepIndex]+inputValOrg.substr(2,200));
                            }else if($.inArray(inputValONE,songKeys) !== -1){
                                    // it means array doen't have that perticular value....
                                    
                                    //alert($.inArray(inputValONE,songKeys) !== +1);
                                    var currentIndex            =	$.inArray(inputValONE,songKeys);
                                    var stepIndex		=	parseInt(currentIndex) + parseInt(steps);
                                    //console.log( "Current Index " + currentIndex + " Step Index" + stepIndex );
                            //	alert('one stepIndex '+stepIndex);
                                    if(parseInt(stepIndex) >= songKeys.length){
                                //	alert('enter for modification one');
                                        stepIndex	=	parseInt(stepIndex)	-	songKeys.length +1;
                                        if(stepIndex =='' || stepIndex==null){
                                            stepIndex	=	1;
                                        }
                            //	alert('one stepIndex after change more than index= ' + stepIndex);
                                    }
                                    if(currentIndex !== -1){
                                        refrenceInput.val(songKeys[stepIndex]+inputValOrg.substr(1,200));
                                    }
                            }

                    }	
            }); 
			}
	function chords2(steps){
				$('#chords_form input.chords2').each(function(){
					var inputValOrg	=	$(this).val();
					var refrenceInput	=	$(this);
					if(inputValOrg != ''){
						var inputVal	=	inputValOrg.substr(0,1).toUpperCase() + inputValOrg.substr(1,1).toLowerCase();
						var inputValONE	=	inputValOrg.substr(0,1).toUpperCase();
                                                console.log("Input val " + inputVal);
                                                console.log("Input val One " + inputValONE);
						if($.inArray(inputVal,songKeys) !== -1){
						//alert($.inArray(inputVal,songKeys) !== -1);
                                                    var currentIndex	=	$.inArray(inputVal,songKeys);
                                                    var stepIndex		=	parseInt(currentIndex) + parseInt(steps);
                                                    //	alert('Double stepIndex '+stepIndex);
                                                            if(parseInt(stepIndex) >= songKeys.length){
                                                                //alert('enter for modification');
                                                                stepIndex	=	parseInt(stepIndex) - songKeys.length +1;
                                                                if(stepIndex =='' || stepIndex==null){
                                                                    stepIndex	=	1;
                                                                }
                                                                //alert('Double stepIndex after change more than index= ' + stepIndex);
                                                            }
                                                            //alert('Go for step Index '+ stepIndex)
                                                            refrenceInput.val(songKeys[stepIndex]+inputValOrg.substr(2,200));
                                            }else if($.inArray(inputValONE,songKeys) !== -1){
                                            //alert($.inArray(inputValONE,songKeys) !== +1);
                                                    var currentIndex	=	$.inArray(inputValONE,songKeys);
                                                    var stepIndex		=	parseInt(currentIndex) + parseInt(steps);
                                                    console.log( "Current Index " + currentIndex + " Step Index" + stepIndex );
                                            //	alert('one stepIndex '+stepIndex);
                                                    if(parseInt(stepIndex) >= songKeys.length){
                                            //	alert('enter for modification one');
                                                    stepIndex	=	parseInt(stepIndex)	-	songKeys.length +1;
                                                        if(stepIndex =='' || stepIndex==null){
                                                            stepIndex	=	1;
                                                        }
                                            //	alert('one stepIndex after change more than index= ' + stepIndex);
                                                    }
                                                    if(currentIndex !== -1){
                                                        refrenceInput.val(songKeys[stepIndex]+inputValOrg.substr(1,200));
                                                    }
                                            }
						
					}	
				}); 
			}
	
	function calculateTempo(currentTempo){
			var tempo	=	120/currentTempo;
			return tempo * 1000;
	}
	function makeFocusOnChords(Speed){
			$('.topChords ul.Chords .highlight').removeClass('highlight');
			$('.topChords ul.Chords input[type="text"]:first').closest('li').addClass('highlight');
			
			 interval	=	setInterval(function(){
				
				var oldHightlight = $(".topChords ul.Chords .highlight");
				
				if(oldHightlight.next("li").length > 0)
				{
					oldHightlight.next("li").find('input[type="text"]').closest('li').addClass('highlight');
					oldHightlight.removeClass('highlight');
				}
				else
				{
					oldHightlight.removeClass('highlight');
					oldHightlight.closest('.parent-li').next('li').find('input[type="text"]:first') .closest('li').addClass('highlight');
				}
			},Speed); 
			
		
	
	}
	function ClearAllChords(){
		clearInterval(interval);
	}

 </script>
<script type="text/javascript">
	$(document).ready(function(){
		//updatePlayer('http://www.jplayer.org/audio/mp3/Miaow-07-Bubble.mp3');
	})
	var nmberPlayed=1;
function updatePlayer(guid){
	
	var myPlayer = $("#jquery_jplayer_1"),
		myPlayerData,
		fixFlash_mp4, // Flag: The m4a and m4v Flash player gives some old currentTime values when changed.
		fixFlash_mp4_id, // Timeout ID used with fixFlash_mp4
		ignore_timeupdate, // Flag used with fixFlash_mp4
		options = {
			ready: function (event) {
				//alert('hello');
				// Setup the player with media.
				$(this).jPlayer("setMedia", {
					mp3: guid,
					oga: guid
				});
				$(this).jPlayer("play",0);
			},
			timeupdate: function(event) {
				if(!ignore_timeupdate) {
					myControl.progress.slider("value", event.jPlayer.status.currentPercentAbsolute);
				}
			},
			swfPath: "js",
			supplied: "mp3, oga",
			cssSelectorAncestor: "#jp_container_1",
			wmode: "window",
			keyEnabled: true,
			ended : function(){
				repeat_number = $('#repeat_number').val();
				if(repeat_number > 1){
					if(repeat_number	>	nmberPlayed){
					$("#jquery_jplayer_1").jPlayer("play",0);
					nmberPlayed++;
					}else{
					
					}
				
				}
			}
			
		},
		myControl = {
			progress: $(options.cssSelectorAncestor + " .jp-progress-slider"),
			volume: $(options.cssSelectorAncestor + " .jp-volume-slider")
		};

	// Instance jPlayer
	myPlayer.jPlayer(options);

	// A pointer to the jPlayer data object
	myPlayerData = myPlayer.data("jPlayer");

	// Define hover states of the buttons
	$('.jp-gui ul li').hover(
		function() { $(this).addClass('ui-state-hover'); },
		function() { $(this).removeClass('ui-state-hover'); }
	);

	// Create the progress slider control
	myControl.progress.slider({
		animate: "fast",
		max: 100,
		range: "min",
		step: 0.1,
		value : 0,
		slide: function(event, ui) {
			var sp = myPlayerData.status.seekPercent;
			if(sp > 0) {
				// Apply a fix to mp4 formats when the Flash is used.
				if(fixFlash_mp4) {
					ignore_timeupdate = true;
					clearTimeout(fixFlash_mp4_id);
					fixFlash_mp4_id = setTimeout(function() {
						ignore_timeupdate = false;
					},1000);
				}
				// Move the play-head to the value and factor in the seek percent.
				myPlayer.jPlayer("playHead", ui.value * (100 / sp));
			} else {
				// Create a timeout to reset this slider to zero.
				setTimeout(function() {
					myControl.progress.slider("value", 0);
				}, 0);
			}
		}
	});

	// Create the volume slider control
	myControl.volume.slider({
		animate: "fast",
		max: 1,
		range: "min",
		step: 0.01,
		value : $.jPlayer.prototype.options.volume,
		slide: function(event, ui) {
			myPlayer.jPlayer("option", "muted", false);
			myPlayer.jPlayer("option", "volume", ui.value);
		}
	});

}

</script>
</head>

<body>

<div class="TopWrapper">
	<div class="TopMenus clearfix gradient">
    	<div class="logo"><a href="#"><img src="images/bbb.png" alt="loading.." /></a></div>
    	<ul  class="clearfix">
        	<li class="active"><a href="index.html">Main</a></li>
            <li style="display: none;"><a href="editor.html">Editor</a></li>
        </ul>
    </div>
	<form name="composition" id="music_composition" action="" onsubmit="return false;">	
		<input type="hidden" id="SongKey" name="SongKey" value="C">
	<div class="MusicContainer">
    <div class="MusicEditor clearfix" >
    	<div class="control">
        	<span class="label"><label>Tempo :</label></span>
            <span class="field"><input type="text" class="spinNumber" name="tempo" value="120" id="music_tempo"></span>
       </div>

    	<div class="control">
        	<span class="label"><label>Key of the song :</label></span>
            <span class="field">
            	<select class="transpose"  id="transpose" name="transpose">
            	
                </select>
           	</span>
       </div>
       
       <div class="control">
        	<span style="width:50px" class="label"><label>Style :</label></span>
            <span class="field">
            	<select style="width:200px" id="music_style" name="style">
            	 <option value="SOFTSWNG">Jazz Swing Trio</option>
					<option value="BREEZIN">Funky Fusion</option>
					<option value="TOASTY">Soft Jazz</option>
					<option value="LITEROK2">Pop Rock</option>
					<option value="MEDROCK2">Straight Rock</option>
					<option value="JAZQUINT">Jazz Band</option>
					<option value="BLZ128">Blues Band</option>
					<option value="FUNK1">Funk Rock</option>
            		<option value="BLUSHF_2">Blues Shuffle</option>
					<option value="POPBALAD">Ballad Time</option>
                </select>
           	</span>
       </div>
       
       <div class="control">
        	<span class="label"><label>Start of Chorus :</label></span>
            <span class="field"><input type="text" class="spinNumber" value="1" id="start_of_chorus" name="start_of_chorus"></span>
       </div>

       <div class="control">
        	<span class="label"><label>End of Chorus :</label></span>
                <span class="field"><input type="text" class="spinNumber" value="4" id="end_of_chorus" name="end_of_chorus"></span>
       </div>

		<div class="control">
        	<span class="label"><label>Repeat Number :</label></span>
            <span class="field"><input type="text" class="spinNumber" value="1"  id='repeat_number' name="repeat_number"></span>
       </div>

		<div class="control">
        	<span class="label"><label>End of Song:</label></span>
                <span class="field"><input type="text" class="spinNumber" value="4" name="end_of_song" id="end_of_song"></span>
       </div>
       
		<div class="control">
        	<span class="btn"><button value="" id="play_music">Play</button></span>
        	<span class="btn"><button value="" id="stop_music">Stop</button></span>
       </div>
	   <div class="control player">
				<div id="jquery_jplayer_1" class="jp-jplayer"></div>

		<div id="jp_container_1">
			<div class="jp-gui ui-widget ui-widget-content ui-corner-all">
				<ul>
					<li class="jp-play ui-state-default ui-corner-all"><a href="javascript:;" class="jp-play ui-icon ui-icon-play" tabindex="1" title="play">play</a></li>
					<li class="jp-pause ui-state-default ui-corner-all"><a href="javascript:;" class="jp-pause ui-icon ui-icon-pause" tabindex="1" title="pause">pause</a></li>
				</ul>
				<div class="jp-progress-slider"></div>
				<div class="jp-clearboth"></div>
			</div>
				
			</div>
		</div>
		<? /*<div class="control">
					 <audio  src="Hydrate-Kenny_Beltrey.ogg"  controls="controls"  id='audio_core' class="audio-node" >
					   Your browser does not support HTML5 audio.
					</audio> 
				<!--	<object id='audio_core' class="audio-node" data="music.mp3" type="application/x-mplayer2"><param  id='audio_core1' class="audio-node" name="filename" value="music.mp3"></object>-->
		</div> */ ?>
	</div>
	
    <ul class="settings clearfix">
    	<li>
        	<div class="col">
	            <span class="btn" style="display: none"><button value="">SAVE</button></span>
    	    	<span class="btn" style="display: none"><button value="">LOAD</button></span>
   	   		</div>

        </li>
        <li>
        	 <div class="col">
            	<select class="wid"  id="drum_sytle" name="drum_patches">
				<option value="0">Standard Drum Kit</option>
            	  
    	       </select>
       	  	</div>
        	<div class="col text-center">
	            <p>Drums</p>
            </div>
        	<div class="col">
				<div id="drumps" class="sliderbar"></div>
            </div>
        </li>
        <li>          
            <div class="col">
            	<select class="wid"  id="bass_sytle" name="bass_patches">
            	 
            	  <option value="0">Acoustic Grand Piano </option>
            	  <option value="1">Bright Acoustic Piano </option>
            	  <option value="2">Electric Grand Piano</option>
            	  <option value="3">Honky-tonk Piano</option>
            	  <option value="4">Electric Piano 1</option>
            	  <option value="5">Electric Piano 2 </option>
            	  <option value="6">Harpsichord </option>
            	  <option value="7">Clav</option>
            	  <option value="8">Celesta</option>
            	  <option value="9">Glockenspiel </option>
            	  <option value="10">Music Box</option>
            	  <option value="11">Vibraphone</option>
            	  <option value="12">Marimba </option>
            	  <option value="13">Xylophone </option>
            	  <option value="14">Tubular Bells </option>
            	  <option value="15">Dulcimer</option>
            	  <option value="16">Drawbar Organ</option>
            	  <option value="17">Percuss. Organ </option>
            	  <option value="18">Rock Organ</option>
            	  <option value="19">Church Organ</option>
            	  <option value="20">Reed Organ</option>
            	  <option value="21">Accordion</option>
            	  <option value="22">Harmonica </option>
            	  <option value="23">Tango Accordion </option>
            	  <option value="24">Acoustic Guitar (nylon) </option>
            	  <option value="25">Acoustic Guitar (steel) </option>
            	  <option value="26">Electric Guitar (jazz) </option>
            	  <option value="27">Electric Guitar (clean) </option>
            	  <option value="28">Electric Guitar (muted) </option>
            	  <option value="29">Overdriven Guitar </option>
            	  <option value="30">Distortion Guitar</option>
            	  <option  value="31">Guitar Harmonics </option>
            	  <option selected="selected" value="32">Acoustic Bass</option>
            	  <option value="33">Electric Bass (finger)</option>
            	  <option value="34">Electric Bass (pick) </option>
            	  <option value="35">Fretless Bass </option>
            	  <option value="36">Slap Bass 1 </option>
            	  <option value="37">Slap Bass 2 </option>
            	  <option value="38">Synth Bass 1</option>
            	  <option value="39">Synth Bass 2 </option>
            	  <option value="34">Violin </option>
            	  <option value="41">Viola </option>
            	  <option value="42">Cello </option>
            	  <option value="43">Contrabass</option>
            	  <option value="44">Tremolo Strings</option>
            	  <option value="45">Pizzicato Strings</option>
            	  <option value="46">Orchestral Harp</option>
            	  <option value="47">Timpani</option>
            	  <option value="48">String Ensemble 1</option>
            	  <option value="49">String Ensemble 2</option>
            	  <option value="50">Synth Strings 1</option>
            	  <option value="51">Synth Strings 2</option>
            	  <option value="52">Choir Aahs</option>
            	  <option value="53">Voice Oohs </option>
            	  <option value="54">Synth Voice</option>
            	  <option value="55">Orchestra Hit</option>
            	  <option value="56">Trumpet</option>
            	  <option value="57">Trombone</option>
            	  <option value="58">Tuba</option>
            	  <option value="59">Muted Trumpet</option>
            	  <option value="60">French Horn</option>
            	  <option value="61">Brass Section</option>
            	  <option value="62">Synth Brass 1</option>
            	  <option value="63">Synth Brass 2</option>
            	  <option value="64">Soprano Sax</option>
            	  <option value="65">Alto Sax</option>
            	  <option value="66">Tenor Sax</option>
            	  <option value="67">Baritone Sax</option>
            	  <option value="68">Oboe</option>
            	  <option value="69">English Horn</option>
            	  <option value="70">Bassoon</option>
            	  <option value="71">Clarinet</option>
            	  <option value="72">Piccolo</option>
            	  <option value="73">Flute</option>
            	  <option value="74">Recorder</option>
            	  <option value="75">Pan Flute</option>
            	  <option value="76">Blown Bottle</option>
            	  <option value="77">Shakuhachi</option>
            	  <option value="78">Whistle</option>
            	  <option value="79">Ocarina</option>
            	  <option value="80">Lead 1 (square)</option>
            	  <option value="81">Lead 2 (sawtooth)</option>
            	  <option value="82">Lead 3 (calliope)</option>
            	  <option value="83">Lead 4 (chiff)</option>
            	  <option value="84">Lead 5 (charang)</option>
            	  <option value="85">Lead 6 (voice)</option>
            	  <option value="86">Lead 7 (fifths) </option>
            	  <option value="87">Lead 8 (bass + lead)</option>
            	  <option value="88">Pad 1 (new age)</option>
            	  <option value="89">Pad 2 (warm)</option>
            	  <option value="90">Pad 3 (polysynth)</option>
            	  <option value="91">Pad 4 (choir)</option>
            	  <option value="92">Pad 5 (bowed)</option>
            	  <option value="93">Pad 6 (metallic)</option>
            	  <option value="94">Pad 7 (halo)</option>
            	  <option value="95">Pad 8 (sweep)</option>
            	  <option value="96">FX 1 (rain)</option>
            	  <option value="97">FX 2 (soundtrack)</option>
            	  <option value="98">FX 3 (crystal)</option>
            	  <option value="99">FX 4 (atmosphere)</option>
            	  <option value="100">FX 5 (brightness)</option>
            	  <option value="101">FX 6 (goblins) </option>
            	  <option value="102">FX 7 (echoes)</option>
            	  <option value="103">FX 8 (sci-fi)</option>
            	  <option value="104">Sitar </option>
            	  <option value="105">Banjo </option>
            	  <option value="106">Shamisen</option>
            	  <option value="107">Koto</option>
            	  <option value="108">Kalimba</option>
            	  <option value="109">Bagpipe</option>
            	  <option value="110">Fiddle</option>
            	  <option value="111">Shanai</option>
            	  <option value="112">Tinkle Bell</option>
            	  <option value="113">Agogo</option>
            	  <option value="114">Steel Drums</option>
            	  <option value="115">Woodblock</option>
            	  <option value="116">Taiko Drum</option>
            	  <option value="117">Melodic Tom</option>
            	  <option value="118">Synth Drum</option>
            	  <option value="119">Reverse Cymbal</option>
            	  <option value="120">Guitar Fret Noise</option>
				  <option value="121">Breath Noise</option>
				  <option value="122">Seashore</option>
				  <option value="123">Bird Tweet</option>
				  <option value="124">Telephone Ring</option>
				  <option value="125">Helicopter</option>
				  <option value="126">Applause</option>
				  <option value="127">Gunshot</option>


            	 
            	 
    	       </select>
       	  	</div>
			<div class="col text-center">
	            <p>Bass</p>
            </div>
        	<div class="col">
				<div id="bass" class="sliderbar"></div>
            </div>
        </li>
        <li>
             <div class="col">
            	<select class="wid"  id="piano_sytle" name="piano_patches">
            	 
            	  <option value="0">Acoustic Grand Piano </option>
            	  <option value="1">Bright Acoustic Piano </option>
            	  <option value="2">Electric Grand Piano</option>
            	  <option value="3">Honky-tonk Piano</option>
            	  <option value="4">Electric Piano 1</option>
            	  <option value="5">Electric Piano 2 </option>
            	  <option value="6">Harpsichord </option>
            	  <option value="7">Clav</option>
            	  <option value="8">Celesta</option>
            	  <option value="9">Glockenspiel </option>
            	  <option value="10">Music Box</option>
            	  <option value="11">Vibraphone</option>
            	  <option value="12">Marimba </option>
            	  <option value="13">Xylophone </option>
            	  <option value="14">Tubular Bells </option>
            	  <option value="15">Dulcimer</option>
            	  <option value="16">Drawbar Organ</option>
            	  <option value="17">Percuss. Organ </option>
            	  <option value="18">Rock Organ</option>
            	  <option value="19">Church Organ</option>
            	  <option value="20">Reed Organ</option>
            	  <option value="21">Accordion</option>
            	  <option value="22">Harmonica </option>
            	  <option value="23">Tango Accordion </option>
            	  <option value="24">Acoustic Guitar (nylon) </option>
            	  <option value="25">Acoustic Guitar (steel) </option>
            	  <option value="26">Electric Guitar (jazz) </option>
            	  <option value="27">Electric Guitar (clean) </option>
            	  <option value="28">Electric Guitar (muted) </option>
            	  <option value="29">Overdriven Guitar </option>
            	  <option value="30">Distortion Guitar</option>
            	  <option  value="31">Guitar Harmonics </option>
            	  <option value="32">Acoustic Bass</option>
            	  <option value="33">Electric Bass (finger)</option>
            	  <option value="34">Electric Bass (pick) </option>
            	  <option value="35">Fretless Bass </option>
            	  <option value="36">Slap Bass 1 </option>
            	  <option value="37">Slap Bass 2 </option>
            	  <option value="38">Synth Bass 1</option>
            	  <option value="39">Synth Bass 2 </option>
            	  <option value="34">Violin </option>
            	  <option value="41">Viola </option>
            	  <option value="42">Cello </option>
            	  <option value="43">Contrabass</option>
            	  <option value="44">Tremolo Strings</option>
            	  <option value="45">Pizzicato Strings</option>
            	  <option value="46">Orchestral Harp</option>
            	  <option value="47">Timpani</option>
            	  <option value="48">String Ensemble 1</option>
            	  <option value="49">String Ensemble 2</option>
            	  <option value="50">Synth Strings 1</option>
            	  <option value="51">Synth Strings 2</option>
            	  <option value="52">Choir Aahs</option>
            	  <option value="53">Voice Oohs </option>
            	  <option value="54">Synth Voice</option>
            	  <option value="55">Orchestra Hit</option>
            	  <option value="56">Trumpet</option>
            	  <option value="57">Trombone</option>
            	  <option value="58">Tuba</option>
            	  <option value="59">Muted Trumpet</option>
            	  <option value="60">French Horn</option>
            	  <option value="61">Brass Section</option>
            	  <option value="62">Synth Brass 1</option>
            	  <option value="63">Synth Brass 2</option>
            	  <option value="64">Soprano Sax</option>
            	  <option value="65">Alto Sax</option>
            	  <option value="66">Tenor Sax</option>
            	  <option value="67">Baritone Sax</option>
            	  <option value="68">Oboe</option>
            	  <option value="69">English Horn</option>
            	  <option value="70">Bassoon</option>
            	  <option value="71">Clarinet</option>
            	  <option value="72">Piccolo</option>
            	  <option value="73">Flute</option>
            	  <option value="74">Recorder</option>
            	  <option value="75">Pan Flute</option>
            	  <option value="76">Blown Bottle</option>
            	  <option value="77">Shakuhachi</option>
            	  <option value="78">Whistle</option>
            	  <option value="79">Ocarina</option>
            	  <option value="80">Lead 1 (square)</option>
            	  <option value="81">Lead 2 (sawtooth)</option>
            	  <option value="82">Lead 3 (calliope)</option>
            	  <option value="83">Lead 4 (chiff)</option>
            	  <option value="84">Lead 5 (charang)</option>
            	  <option value="85">Lead 6 (voice)</option>
            	  <option value="86">Lead 7 (fifths) </option>
            	  <option value="87">Lead 8 (bass + lead)</option>
            	  <option value="88">Pad 1 (new age)</option>
            	  <option value="89">Pad 2 (warm)</option>
            	  <option value="90">Pad 3 (polysynth)</option>
            	  <option value="91">Pad 4 (choir)</option>
            	  <option value="92">Pad 5 (bowed)</option>
            	  <option value="93">Pad 6 (metallic)</option>
            	  <option value="94">Pad 7 (halo)</option>
            	  <option value="95">Pad 8 (sweep)</option>
            	  <option value="96">FX 1 (rain)</option>
            	  <option value="97">FX 2 (soundtrack)</option>
            	  <option value="98">FX 3 (crystal)</option>
            	  <option value="99">FX 4 (atmosphere)</option>
            	  <option value="100">FX 5 (brightness)</option>
            	  <option value="101">FX 6 (goblins) </option>
            	  <option value="102">FX 7 (echoes)</option>
            	  <option value="103">FX 8 (sci-fi)</option>
            	  <option value="104">Sitar </option>
            	  <option value="105">Banjo </option>
            	  <option value="106">Shamisen</option>
            	  <option value="107">Koto</option>
            	  <option value="108">Kalimba</option>
            	  <option value="109">Bagpipe</option>
            	  <option value="110">Fiddle</option>
            	  <option value="111">Shanai</option>
            	  <option value="112">Tinkle Bell</option>
            	  <option value="113">Agogo</option>
            	  <option value="114">Steel Drums</option>
            	  <option value="115">Woodblock</option>
            	  <option value="116">Taiko Drum</option>
            	  <option value="117">Melodic Tom</option>
            	  <option value="118">Synth Drum</option>
            	  <option value="119">Reverse Cymbal</option>
            	  <option value="120">Guitar Fret Noise</option>
				  <option value="121">Breath Noise</option>
				  <option value="122">Seashore</option>
				  <option value="123">Bird Tweet</option>
				  <option value="124">Telephone Ring</option>
				  <option value="125">Helicopter</option>
				  <option value="126">Applause</option>
				  <option value="127">Gunshot</option>


            	 

            	 
            	  </select>
           	</div>
            <div class="col text-center">
	            <p>Piano</p>
            </div>
        	<div class="col">
				<div id="piano" class="sliderbar"></div>
            </div>
        </li>
        <li>
             <div class="col">
            	<select class="wid"   id="guitar_style" name="guitar_patches">
            	 
					<option value="0">Acoustic Grand Piano </option>
            	  <option value="1">Bright Acoustic Piano </option>
            	  <option value="2">Electric Grand Piano</option>
            	  <option value="3">Honky-tonk Piano</option>
            	  <option value="4">Electric Piano 1</option>
            	  <option value="5">Electric Piano 2 </option>
            	  <option value="6">Harpsichord </option>
            	  <option value="7">Clav</option>
            	  <option value="8">Celesta</option>
            	  <option value="9">Glockenspiel </option>
            	  <option value="10">Music Box</option>
            	  <option value="11">Vibraphone</option>
            	  <option value="12">Marimba </option>
            	  <option value="13">Xylophone </option>
            	  <option value="14">Tubular Bells </option>
            	  <option value="15">Dulcimer</option>
            	  <option value="16">Drawbar Organ</option>
            	  <option value="17">Percuss. Organ </option>
            	  <option value="18">Rock Organ</option>
            	  <option value="19">Church Organ</option>
            	  <option value="20">Reed Organ</option>
            	  <option value="21">Accordion</option>
            	  <option value="22">Harmonica </option>
            	  <option value="23">Tango Accordion </option>
            	  <option value="24">Acoustic Guitar (nylon) </option>
            	  <option value="25">Acoustic Guitar (steel) </option>
            	  <option value="26">Electric Guitar (jazz) </option>
            	  <option value="27">Electric Guitar (clean) </option>
            	  <option value="28">Electric Guitar (muted) </option>
            	  <option value="29">Overdriven Guitar </option>
            	  <option value="30">Distortion Guitar</option>
            	  <option  value="31">Guitar Harmonics </option>
            	  <option value="32">Acoustic Bass</option>
            	  <option value="33">Electric Bass (finger)</option>
            	  <option value="34">Electric Bass (pick) </option>
            	  <option value="35">Fretless Bass </option>
            	  <option value="36">Slap Bass 1 </option>
            	  <option value="37">Slap Bass 2 </option>
            	  <option value="38">Synth Bass 1</option>
            	  <option value="39">Synth Bass 2 </option>
            	  <option value="34">Violin </option>
            	  <option value="41">Viola </option>
            	  <option value="42">Cello </option>
            	  <option value="43">Contrabass</option>
            	  <option value="44">Tremolo Strings</option>
            	  <option value="45">Pizzicato Strings</option>
            	  <option value="46">Orchestral Harp</option>
            	  <option value="47">Timpani</option>
            	  <option value="48">String Ensemble 1</option>
            	  <option value="49">String Ensemble 2</option>
            	  <option value="50">Synth Strings 1</option>
            	  <option value="51">Synth Strings 2</option>
            	  <option value="52">Choir Aahs</option>
            	  <option value="53">Voice Oohs </option>
            	  <option value="54">Synth Voice</option>
            	  <option value="55">Orchestra Hit</option>
            	  <option value="56">Trumpet</option>
            	  <option value="57">Trombone</option>
            	  <option value="58">Tuba</option>
            	  <option value="59">Muted Trumpet</option>
            	  <option value="60">French Horn</option>
            	  <option value="61">Brass Section</option>
            	  <option value="62">Synth Brass 1</option>
            	  <option value="63">Synth Brass 2</option>
            	  <option value="64">Soprano Sax</option>
            	  <option value="65">Alto Sax</option>
            	  <option value="66">Tenor Sax</option>
            	  <option value="67">Baritone Sax</option>
            	  <option value="68">Oboe</option>
            	  <option value="69">English Horn</option>
            	  <option value="70">Bassoon</option>
            	  <option value="71">Clarinet</option>
            	  <option value="72">Piccolo</option>
            	  <option value="73">Flute</option>
            	  <option value="74">Recorder</option>
            	  <option value="75">Pan Flute</option>
            	  <option value="76">Blown Bottle</option>
            	  <option value="77">Shakuhachi</option>
            	  <option value="78">Whistle</option>
            	  <option value="79">Ocarina</option>
            	  <option value="80">Lead 1 (square)</option>
            	  <option value="81">Lead 2 (sawtooth)</option>
            	  <option value="82">Lead 3 (calliope)</option>
            	  <option value="83">Lead 4 (chiff)</option>
            	  <option value="84">Lead 5 (charang)</option>
            	  <option value="85">Lead 6 (voice)</option>
            	  <option value="86">Lead 7 (fifths) </option>
            	  <option value="87">Lead 8 (bass + lead)</option>
            	  <option value="88">Pad 1 (new age)</option>
            	  <option value="89">Pad 2 (warm)</option>
            	  <option value="90">Pad 3 (polysynth)</option>
            	  <option value="91">Pad 4 (choir)</option>
            	  <option value="92">Pad 5 (bowed)</option>
            	  <option value="93">Pad 6 (metallic)</option>
            	  <option value="94">Pad 7 (halo)</option>
            	  <option value="95">Pad 8 (sweep)</option>
            	  <option value="96">FX 1 (rain)</option>
            	  <option value="97">FX 2 (soundtrack)</option>
            	  <option value="98">FX 3 (crystal)</option>
            	  <option value="99">FX 4 (atmosphere)</option>
            	  <option value="100">FX 5 (brightness)</option>
            	  <option value="101">FX 6 (goblins) </option>
            	  <option value="102">FX 7 (echoes)</option>
            	  <option value="103">FX 8 (sci-fi)</option>
            	  <option value="104">Sitar </option>
            	  <option value="105">Banjo </option>
            	  <option value="106">Shamisen</option>
            	  <option value="107">Koto</option>
            	  <option value="108">Kalimba</option>
            	  <option value="109">Bagpipe</option>
            	  <option value="110">Fiddle</option>
            	  <option value="111">Shanai</option>
            	  <option value="112">Tinkle Bell</option>
            	  <option value="113">Agogo</option>
            	  <option value="114">Steel Drums</option>
            	  <option value="115">Woodblock</option>
            	  <option value="116">Taiko Drum</option>
            	  <option value="117">Melodic Tom</option>
            	  <option value="118">Synth Drum</option>
            	  <option value="119">Reverse Cymbal</option>
            	  <option value="120">Guitar Fret Noise</option>
				  <option value="121">Breath Noise</option>
				  <option value="122">Seashore</option>
				  <option value="123">Bird Tweet</option>
				  <option value="124">Telephone Ring</option>
				  <option value="125">Helicopter</option>
				  <option value="126">Applause</option>
				  <option value="127">Gunshot</option>


            	 
            	 
            	 </select>
           	</div>
        	<div class="col text-center">
	            <p>Guitar</p>
            </div>
        	<div class="col">
				<div id="guitar" class="sliderbar"></div>
            </div>
        </li>
        <li>
             <span class="col">
            	<select class="wid"  id="string_sytle" name="string_patches">
            	  <option value="0">Acoustic Grand Piano </option>
            	  <option value="1">Bright Acoustic Piano </option>
            	  <option value="2">Electric Grand Piano</option>
            	  <option value="3">Honky-tonk Piano</option>
            	  <option value="4">Electric Piano 1</option>
            	  <option value="5">Electric Piano 2 </option>
            	  <option value="6">Harpsichord </option>
            	  <option value="7">Clav</option>
            	  <option value="8">Celesta</option>
            	  <option value="9">Glockenspiel </option>
            	  <option value="10">Music Box</option>
            	  <option value="11">Vibraphone</option>
            	  <option value="12">Marimba </option>
            	  <option value="13">Xylophone </option>
            	  <option value="14">Tubular Bells </option>
            	  <option value="15">Dulcimer</option>
            	  <option value="16">Drawbar Organ</option>
            	  <option value="17">Percuss. Organ </option>
            	  <option value="18">Rock Organ</option>
            	  <option value="19">Church Organ</option>
            	  <option value="20">Reed Organ</option>
            	  <option value="21">Accordion</option>
            	  <option value="22">Harmonica </option>
            	  <option value="23">Tango Accordion </option>
            	  <option value="24">Acoustic Guitar (nylon) </option>
            	  <option value="25">Acoustic Guitar (steel) </option>
            	  <option value="26">Electric Guitar (jazz) </option>
            	  <option value="27">Electric Guitar (clean) </option>
            	  <option value="28">Electric Guitar (muted) </option>
            	  <option value="29">Overdriven Guitar </option>
            	  <option value="30">Distortion Guitar</option>
            	  <option  value="31">Guitar Harmonics </option>
            	  <option  value="32">Acoustic Bass</option>
            	  <option value="33">Electric Bass (finger)</option>
            	  <option value="34">Electric Bass (pick) </option>
            	  <option value="35">Fretless Bass </option>
            	  <option value="36">Slap Bass 1 </option>
            	  <option value="37">Slap Bass 2 </option>
            	  <option value="38">Synth Bass 1</option>
            	  <option value="39">Synth Bass 2 </option>
            	  <option value="34">Violin </option>
            	  <option value="41">Viola </option>
            	  <option value="42">Cello </option>
            	  <option value="43">Contrabass</option>
            	  <option value="44">Tremolo Strings</option>
            	  <option value="45">Pizzicato Strings</option>
            	  <option value="46">Orchestral Harp</option>
            	  <option value="47">Timpani</option>
            	  <option value="48">String Ensemble 1</option>
            	  <option value="49">String Ensemble 2</option>
            	  <option value="50">Synth Strings 1</option>
            	  <option value="51">Synth Strings 2</option>
            	  <option value="52">Choir Aahs</option>
            	  <option value="53">Voice Oohs </option>
            	  <option value="54">Synth Voice</option>
            	  <option value="55">Orchestra Hit</option>
            	  <option value="56">Trumpet</option>
            	  <option value="57">Trombone</option>
            	  <option value="58">Tuba</option>
            	  <option value="59">Muted Trumpet</option>
            	  <option value="60">French Horn</option>
            	  <option value="61">Brass Section</option>
            	  <option value="62">Synth Brass 1</option>
            	  <option value="63">Synth Brass 2</option>
            	  <option value="64">Soprano Sax</option>
            	  <option value="65">Alto Sax</option>
            	  <option value="66">Tenor Sax</option>
            	  <option value="67">Baritone Sax</option>
            	  <option value="68">Oboe</option>
            	  <option value="69">English Horn</option>
            	  <option value="70">Bassoon</option>
            	  <option value="71">Clarinet</option>
            	  <option value="72">Piccolo</option>
            	  <option value="73">Flute</option>
            	  <option value="74">Recorder</option>
            	  <option value="75">Pan Flute</option>
            	  <option value="76">Blown Bottle</option>
            	  <option value="77">Shakuhachi</option>
            	  <option value="78">Whistle</option>
            	  <option value="79">Ocarina</option>
            	  <option value="80">Lead 1 (square)</option>
            	  <option value="81">Lead 2 (sawtooth)</option>
            	  <option value="82">Lead 3 (calliope)</option>
            	  <option value="83">Lead 4 (chiff)</option>
            	  <option value="84">Lead 5 (charang)</option>
            	  <option value="85">Lead 6 (voice)</option>
            	  <option value="86">Lead 7 (fifths) </option>
            	  <option value="87">Lead 8 (bass + lead)</option>
            	  <option value="88">Pad 1 (new age)</option>
            	  <option value="89">Pad 2 (warm)</option>
            	  <option value="90">Pad 3 (polysynth)</option>
            	  <option value="91">Pad 4 (choir)</option>
            	  <option value="92">Pad 5 (bowed)</option>
            	  <option value="93">Pad 6 (metallic)</option>
            	  <option value="94">Pad 7 (halo)</option>
            	  <option value="95">Pad 8 (sweep)</option>
            	  <option value="96">FX 1 (rain)</option>
            	  <option value="97">FX 2 (soundtrack)</option>
            	  <option value="98">FX 3 (crystal)</option>
            	  <option value="99">FX 4 (atmosphere)</option>
            	  <option value="100">FX 5 (brightness)</option>
            	  <option value="101">FX 6 (goblins) </option>
            	  <option value="102">FX 7 (echoes)</option>
            	  <option value="103">FX 8 (sci-fi)</option>
            	  <option value="104">Sitar </option>
            	  <option value="105">Banjo </option>
            	  <option value="106">Shamisen</option>
            	  <option value="107">Koto</option>
            	  <option value="108">Kalimba</option>
            	  <option value="109">Bagpipe</option>
            	  <option value="110">Fiddle</option>
            	  <option value="111">Shanai</option>
            	  <option value="112">Tinkle Bell</option>
            	  <option value="113">Agogo</option>
            	  <option value="114">Steel Drums</option>
            	  <option value="115">Woodblock</option>
            	  <option value="116">Taiko Drum</option>
            	  <option value="117">Melodic Tom</option>
            	  <option value="118">Synth Drum</option>
            	  <option value="119">Reverse Cymbal</option>
            	  <option value="120">Guitar Fret Noise</option>
				  <option value="121">Breath Noise</option>
				  <option value="122">Seashore</option>
				  <option value="123">Bird Tweet</option>
				  <option value="124">Telephone Ring</option>
				  <option value="125">Helicopter</option>
				  <option value="126">Applause</option>
				  <option value="127">Gunshot</option>


            	 

                </select>
           	</span>
			<div class="col text-center">
	            <p>Strings</p>
            </div>
        	<div class="col">
				<div id="strings" class="sliderbar"></div>
            </div>
        </li>
	   </ul>

	   <input type="hidden" value="52" id="hdrumps" name="hdrumps"/>
	   <input type="hidden" value="62" id="hbass" name="hbass"/>
	   <input type="hidden" value="62" id="hpiano"  name="hpiano"/>
	   <input type="hidden" value="62" id="hguitar" name="hguitar"/>
	   <input type="hidden" value="62" id="hstrings" name="hstrings" />
	   
    </div>
	
	</form>
	<form action="" onsubmit="return false" name="chords_form" id="chords_form">
    <div class="topChords ">
        <ul class="inline Chords clearfix">
            <li class="parent-li">
                <ul class="sub-li">
                    <li>01</li>
                    <li><input type="text" class="chords1" name="chords1[]"></li>
                    <li><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>02</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>03</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>04</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>05</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>06</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>07</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>08</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>09</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li"> 
                    <li>10</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li" >
                    <li>11</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>12</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>13</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>14</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>15</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>16</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>17</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>18</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>19</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>20</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>21</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>22</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>23</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>24</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>25</li>
                     <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>26</li>
                   <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>27</li>
                     <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>28</li>
                   <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>29</li>
                     <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>30</li>
                     <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>31</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>32</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>33</li>
                     <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>34</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>35</li>
                     <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>36</li>
                  <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>37</li>
                   <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>38</li>
                   <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>39</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>40</li>
                    <li class=""><input type="text" class="chords1" name="chords1[]"></li>
                    <li class=""><input type="text" class="chords2" name="chords2[]"></li>
                </ul>
            </li>
        </ul>
   	</div>
    
    
    </form>
    <div class="Ad">
	<iframe src="http://www.boomboomband.com/app-banner-1/" ></iframe>
   </div>
</div>
    <script>
        // document.getElementById('audio_core').addEventListener('ended', function(){
            // //alert(parseInt($("#repeat_number").val()));
            // //alert(times < parseInt($("#repeat_number").val()));
            // if(times < parseInt($("#repeat_number").val())){
                // this.currentTime = 0;
                // this.play();
                // times++;
            // }else{
                // this.pause();
                // times = 1;
            // }
        // }, false);
	
    </script>
    <div class="loadingDiv">
        <div class="overlay">
            
        </div>
<div class="loading">
                <div id="progressbar"><div class="progress-label" style="top:8px;">Loading Sound File...</div></div>
            </div>
    </div>
    <script>
    var progressbar = $( "#progressbar" ),
      progressLabel = $( ".progress-label" );
  $(function() {
    progressbar.progressbar({
      value: false,
      /*change: function() {
        progressLabel.text( progressbar.progressbar( "value" ) + "%" );
      },
      complete: function() {
        progressLabel.text( "Complete!" );
      }*/
    });
  });
    function progressStart() {
        $(".loadingDiv").show();
         /*var val = progressBarValue + 1;
         progressBarValue ++;
         progressbar.progressbar( "value", val );
         progressLabel.text( "Loading Sound File."  + val + "%" )
         //alert($("#play_music").text());
         if($("#play_music").text() == "Play"){
             progressStop();
             val = 100;
         }
         if ( val < 50 ) {
            setTimeout( progressStart, 100 );
         }else if ( val < 80 ) {
            setTimeout( progressStart, 200 );
         }else if(val < 99){
             setTimeout( progressStart, 300 );
         }
        /*var val = progressbar.progressbar( "value" ) || 0;
        progressbar.progressbar( "value", val + 1 );
        if ( val < 99 ) {
            setTimeout( progressStart, 100 );
        }*/
    }
    function progressStop(){
        //progressbar.progressbar( "value", 100 );
        $(".loadingDiv").hide();
    }
  </script>
</body>
<script type="text/javascript" src="http://jplayer.org/js/prettify/prettify-jPlayer.js"></script>

</html>