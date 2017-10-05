<!DOCTYPE html>
<html>
<!--[if IE 8]>         <html class="no-js ie ie8"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie ie9"> <![endif]-->

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="keywords" content="" />
    <meta content="" http-equiv="description" />
    <meta name="author" content="" />
    <title>Band</title>
    <link rel="shortcut icon" href="../images/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="css/jquery.selectbox.css">

    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <style>
        .jp-gui {
            position: relative;
            padding: 0px 0px 0px 20px;
            width: 225px;
            top: 12px;
        }
        .jp-gui.jp-no-volume {
            width: 432px;
        }
        .jp-gui ul {
            margin: 0;
            padding: 0;
        }
        .jp-gui ul li {
            position: relative;
            float: left;
            list-style: none;
            margin: 2px;
            padding: 4px 0;
            cursor: pointer;
        }
        .jp-gui ul li a {
            margin: 0 4px;
        }
        .jp-gui li.jp-repeat,
        .jp-gui li.jp-repeat-off {
            margin-left: 344px;
        }
        .jp-gui li.jp-mute,
        .jp-gui li.jp-unmute {
            margin-left: 20px;
        }
        .jp-gui li.jp-volume-max {
            margin-left: 120px;
        }
        li.jp-pause,
        li.jp-repeat-off,
        li.jp-unmute,
        .jp-no-solution {
            display: none;
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
            cursor: pointer;
        }
        .jp-volume-slider {
            position: absolute;
            top: 31px;
            left: 508px;
            width: 100px;
            height: .4em;
        }
        .jp-volume-slider .ui-slider-handle {
            height: .8em;
            width: .8em;
            cursor: pointer;
        }
        .jp-gui.jp-no-volume .jp-volume-slider {
            display: none;
        }
        .jp-current-time,
        .jp-duration {
            position: absolute;
            top: 42px;
            font-size: 0.8em;
            cursor: default;
        }
        .jp-current-time {
            left: 100px;
        }
        .jp-duration {
            right: 30px;
        }
        .jp-gui.jp-no-volume .jp-duration {
            right: 70px;
        }
        .jp-clearboth {
            clear: both;
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
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 9;
            background-color: #000;
            background: rgba(0, 0, 0, 0.5);
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
            filter: alpha(opacity=50);
        }
        .loading {
            position: absolute;
            top: 35%;
            left: 40%;
            width: 25%;
            height: 10px;
            z-index: 10;
            /*background:url(../../images/loader.gif) no-repeat center center;*/
        }
        .loadingDiv {
            display: none;
        }
        .upload_btn .label {
            width: 100px !important;
        }
        .file-upload {
            position: relative;
            margin: 10px;
            background: #FFFFFF;
            padding: 7px 22px;
            text-align: center;
            width: 120px;
            color: #000;
            border: 1px solid #A6C9E2;
            font-size: 13px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            overflow: hidden;
        }
        .file-upload input.file-input {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            left: 0;
            width: 120px;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
		.bbb-save-as-cover{
position: fixed;
    z-index: 99999;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: white;
    filter: alpha(opacity=0);
    opacity: 0.5;
}
.bbb-save-as{
    background: #FFF;
    border: 10px solid #333;
    border: 10px solid rgba(0,0,0,.7);
    border-radius: 8px;
    box-shadow: 0 3px 3px rgba(0,0,0,.3);
    -webkit-background-clip: padding;
    -moz-background-clip: padding;
    background-clip: padding-box;
	    position: fixed;
    z-index: 99999;
    top: 100px;
    left: 50%;
    width: 550px;
    margin-left: -275px;
    opacity: 1;
}
.bbb-save-as-prompt{
}
.bbb-save-as-dialog{
    padding: 25px;
}
.bbb-save-as-dialog p{
	    margin: 0 0 20px;
		color: #000;
    text-align: center;
}
.bbb-save-as-form{
}
.bbb-save-as-text{  
 margin-bottom: 15px; 
    width: 100%;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    font-size: 100%;
border: 1px solid #CCC;
    padding: 10px;
    border-radius: 4px;
}
.bbb-save-as-buttons{
	text-align:center;
}
.bbb-save-as-buttons .btn{
	    margin: 0px 5px;
}
.bbb-save-as-buttons .btn.saveas button{}
.bbb-save-as-buttons .btn.cancel button{}
.MusicEditor .saveas_song{
    vertical-align: bottom;
}
.MusicEditor #downloadify{
        padding: 0px 115px;
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
    <script type="text/javascript" src="js/jquery.jplayer.inspector.js"></script>
    <script type="text/javascript" src="js/filedownload.js"></script>
    <!--<script type="text/javascript" src="js/jquery.media.event.inspector.js"></script>-->

 <script type="text/javascript" src="js/swfobject.js"></script>
  <script type="text/javascript" src="js/downloadify.min.js"></script>


    <!--[if IE 7]>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".selectbox").selectbox("detach");
                        alert("Please upgrade your browser for best performance");
                });
         </script>
         <![endif]-->

    <script type="text/javascript">
        
        $(function() {
            CallBoomBoomBandFunctions();
            $("#start_new_music").on("click", function() {
                ResetValueOfTopBlock();
				ResetValueOfChordDDL();
				ResetValueOfChordSlider();
				$("#chords_form li").removeClass("highlight");
				$("#chords_form input[type=text]").val("");
			});
        });

        function ResetValueOfTopBlock() {
            $("#SongKey").val("C");
            $("#music_tempo").val("120");
            $("#music_style").val("SOFTSWNG");
            $("#start_of_chorus").val("1");
            $("#end_of_chorus").val("4");
            $("#repeat_number").val("1");
            $("#end_of_song").val("4");
        }

        function ResetValueOfChordSlider() {
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

            $("#commanvolume").slider({
                min: 0,
                max: 10,
                value: 3,
                step: 0.5,
                slide: function(event, ui) {
                    $("#hcommanvolume").val(ui.value);

                }
            });
        }

        function ResetValueOfChordDDL() {
            $("#drum_sytle").val("0");
            $("#bass_sytle").val("32");
            $("#piano_sytle").val("0");
            $("#guitar_style").val("0");
            $("#string_sytle").val("0");
        }

		function ExportMusic(refrence,isSaveAs){
                refrence.text('Saving');
                //progressBarValue = 0;
                progressStart();
                var url = 'saveplayersetting.php';
                var data = 'bass_patches=' + $('#bass_sytle').val() + '&piano_patches=' + $('#piano_sytle').val() + '&guitar_patches=' + $('#guitar_style').val() + '&string_patches=' + $('#string_sytle').val() + '&drum_patches=' + $('#drum_sytle').val() + '&tempo=' + $('#music_tempo').val() + '&style=' + $('#music_style').val() + '&hdrumps=' + $('#hdrumps').val() + '&hbass=' + $('#hbass').val() + '&hpiano=' + $('#hpiano').val() + '&hguitar=' + $('#hguitar').val() + '&hstrings=' + $('#hstrings').val() + "&transpose=" + $("#SongKey").val() + "&start_of_chorus=" + $("#start_of_chorus").val() + "&end_of_chorus=" + $("#end_of_chorus").val() + "&repeat_number=" + $("#repeat_number").val() + "&end_of_song=" + $("#end_of_song").val() + '&action=export_setting';
                //console.log(data);
                var chrod1_values = $('input[name="chords1[]"]').map(function() {
                    return this.value
                }).get();
                var chrod2_values = $('input[name="chords2[]"]').map(function() {
                    return this.value
                }).get();
                console.log(chrod1_values);
                data += '&chrods1=' + chrod1_values;
                data += '&chrods2=' + chrod2_values;
                // console.log(data);
                //  alert(document.domain); 
                doAjaxCall(url, data, false, function(html) {
                    try {
					if(isSaveAs){
						var downloadName=html;
						downloadName=downloadName.substring(0,downloadName.lastIndexOf('.'));
						var responseData = html;
						
						var _popupHTML='<div id="bbb-save-as-block"><div class="bbb-save-as-cover"></div>';
						_popupHTML+='<section class="bbb-save-as bbb-save-as-prompt"><div class="bbb-save-as-dialog">';
						_popupHTML+='<p>Please Enter File Name</p>';
						_popupHTML+='<div class="bbb-save-as-form"><div><input type="text" value="'+downloadName+'" class="bbb-save-as-text" id="bbb-save-as-text"></div></div>';
						_popupHTML+='<div class="bbb-save-as-buttons"><span class="btn saveas"><button value="" id="ExportMusicSaveAs">Save as</button></span><span class="btn cancel"><button value="" id="ExportMusicSaveAsCancel">Cancel</button></span></div>';
						_popupHTML+='</div></section></div>';
						
						$("body").append(_popupHTML);
						$("#ExportMusicSaveAsCancel").click(function(){
							$("#bbb-save-as-block").remove();
						});
						$("#ExportMusicSaveAs").click(function(){
							downloadName=$("#bbb-save-as-text").val();
							if(downloadName.trim().length<=0){
								downloadName=html.substring(0,html.lastIndexOf('.'));
							}
							downloadName=downloadName+".json";
							console.log(downloadName);
							var btn = document.createElement("a");
							btn.href = 'http://' + document.domain + '/bbb/tatyana/player_settings/' + responseData;
							btn.target = '_blank';
							btn.download = downloadName;
							btn.click();
							$("#bbb-save-as-block").remove();							
						});
					}else{
							var downloadName=html;
							var responseData = html;
							var btn = document.createElement("a");
							btn.href = 'http://' + document.domain + '/bbb/tatyana/player_settings/' + responseData;
							btn.target = '_blank';
							btn.download = downloadName;
							btn.click();
					}
                        progressStop();
						if(isSaveAs)
							refrence.text('Save as Song');
						else
							refrence.text('Save Song');
                    } catch (e) {
                        console.log(e);
                        refrence.text('Export Settings');
                        //progressLabel.text( "Error!" );
                        progressStop();
                    }


                });
            }
            

        function CallBoomBoomBandFunctions() {
            var Speed = '';
            var duration = '';
            var countInDuration = '';
            var movehighlight = '';
            var startInter = '';
            var onlyfirst = 1;
            var times = 1;
            var progressBarValue = 0;
            var songKeys = new Array();
            songKeys[1] = 'C';
            songKeys[2] = 'Db';
            songKeys[3] = 'D';
            songKeys[4] = 'Eb';
            songKeys[5] = 'E';
            songKeys[6] = 'F';
            songKeys[7] = 'Gb';
            songKeys[8] = 'G';
            songKeys[9] = 'Ab';
            songKeys[10] = 'A';
            songKeys[11] = 'Bb';
            songKeys[12] = 'B';

            ResetValueOfTopBlock();
            ResetValueOfChordDDL();
            ResetValueOfChordSlider();
            $("#chords_form li").removeClass("highlight");
            $("#chords_form input[type=text]").val("");

            //$("#audio_in_page_source_inspector").mediaEventInspector({mediaElement:document.getElementById("jp_audio_0")});
			
            var selectData = '';
            var steps = 0;

            for (var s = 1; s < songKeys.length; s++) {
                selectData += '<option value="' + s + '">' + songKeys[s] + '</option>';
            }

            $('#transpose').html(selectData).promise().done(function() {
                //$('.transpose').selectbox();
                var StaticSelectFlag = 1;
                $('#transpose').off('change').on('change', function() {
                    if (confirm("Are you sure you want to change Key of the song")) {
                        var arrayIndex = $(this).val();
                        var replaceIndex = parseInt(StaticSelectFlag) + parseInt(arrayIndex);
                        replaceIndex = parseInt(replaceIndex);

                        var replaceText = songKeys[replaceIndex];

                        if (parseInt(StaticSelectFlag) < arrayIndex) {
                            steps = parseInt(arrayIndex) - parseInt(StaticSelectFlag);
                            StaticSelectFlag = parseInt(arrayIndex);
                        } else {
                            steps = parseInt((parseInt(songKeys.length) - 1) - parseInt(StaticSelectFlag)) + parseInt(arrayIndex);
                            StaticSelectFlag = parseInt(arrayIndex);
                        }

                        chords1(steps);
                        chords2(steps);

                    } else {
                        StaticSelectFlag = parseInt($(this).val());
                        steps = StaticSelectFlag;
                        //alert(StaticSelectFlag);
                    }
                    $('#SongKey').val(songKeys[$(this).val()]);
                })
            });

            var obj = {
                a: 123,
                b: "4 5 6"
            };
            var data = "text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(obj));
            //export player settings
			
			$("#export_music_as").click(function(){
                var refrence = $(this);
				ExportMusic(refrence,true);
			});
			
            $('#export_music').click(function() {
                var refrence = $(this);
				ExportMusic(refrence,false);
			});
			
			//end of export player settings

            /*submit composition form*/

            $('#play_music').click(function() {
                var refrence = $(this);
                refrence.text('Wait');
                //progressBarValue = 0;
                progressStart();
                
                $('.topChords  ul.Chords li').removeClass('highlight');
                var song_data = $('#music_style').val() + " => " + " Select 1: "+$("#drum_sytle").val()+ " Select 2 : " + $("#bass_sytle").val() + " Select 3 : " + $("#piano_sytle").val() + " Select 4 : " + $("#guitar_style").val() + " Select 5  : " + $("#string_sytle").val() + " Drums: "+ $("#hdrumps").val() + " Bass: " + $("#hbass").val() + " Piano " + $("#hpiano").val() + " Guitar " + $("#hguitar").val() + " Strings " + $("#hstrings").val() ;
                var data = 'song_data='+song_data ;
                doAjaxCall('create_style.php', data , false, function(html) {
                    
                });
               
                
                var url = 'datacon.php';

                var data = 'bass_patches=' + $('#bass_sytle').val() + '&piano_patches=' + $('#piano_sytle').val() + '&guitar_patches=' + $('#guitar_style').val() + '&string_patches=' + $('#string_sytle').val() + '&drum_patches=' + $('#drum_sytle').val() + '&tempo=' + $('#music_tempo').val() + '&style=' + $('#music_style').val() + '&hdrumps=' + $('#hdrumps').val() + '&hbass=' + $('#hbass').val() + '&hpiano=' + $('#hpiano').val() + '&hguitar=' + $('#hguitar').val() + '&hstrings=' + $('#hstrings').val() + "&transpose=" + $("#SongKey").val() + "&start_of_chorus=" + $("#start_of_chorus").val() + "&end_of_chorus=" + $("#end_of_chorus").val() + "&repeat_number=" + $("#repeat_number").val() + "&end_of_song=" + $("#end_of_song").val() + '&action=processMIDI';
                console.log(data);
                data += '&' + $('#chords_form').serialize();
                data += '&' + $('#music_composition').serialize();
                //console.log(data);
                doAjaxCall(url, data, false, function(html) {
                    try {
                        console.log(html);
                        var responseData = $.parseJSON(html);
                        //console.log(responseData);
                        var mp3src = responseData.mp3src;
                        duration = parseInt(responseData.duration);
                        countInDuration = parseInt(responseData.countInDuration);
                        //$("#jquery_jplayer_1").jPlayer( "clearMedia" );
                        countInDuration = countInDuration;
                        console.log("countInDuration:" + countInDuration);
                        console.log("duration:" + duration);
                        console.log(mp3src);
                        $("#jquery_jplayer_1").jPlayer("destroy");
                        repeat_number = $('#repeat_number').val();
                        console.log("repeat_number:" + repeat_number);
                        if (repeat_number > 1) {
                            duration = duration * repeat_number;
                        }
                        nmberToPlay = parseInt((duration / repeat_number) + (countInDuration));
                        nmberPlayed = parseInt(duration / repeat_number);
                        $('.topChords ul.Chords .highlight').removeClass('highlight');
                        updatePlayer(mp3src, function() {

                            setTimeout(function() {
                                refrence.text('Play');
                            }, 1);
                            progressStop();

                            Speed = parseInt(calculateTempo($('#music_tempo').val()));
                            console.log("speed: " + Speed);
                            movehighlight = parseInt(countInDuration + Speed);
                            console.log("movehighlight:" + movehighlight);



                        });


                    } catch (e) {
                        alert(e.message);
                        refrence.text('Play');
                        //progressLabel.text( "Error!" );
                        progressStop();
                    }
                });
            });

            $('.topChords ul.Chords li input[type="text"]').focus(function() {
                $('.topChords ul.Chords li').removeClass('highlight');
                $(this).closest('li').addClass('highlight');
            });

            $("#stop_music").on('click', function() {
                $("#jquery_jplayer_1").jPlayer("stop");
                $('.topChords ul.Chords li').removeClass('highlight');
                $('.topChords ul.Chords .highlight').addClass('highlight');
            });
          
			$(".ui-icon-triangle-1-s").click(function() {
                //$(".spinNumber").change(function(){
                $(".spinNumber").each(function() {
                    try {
                        //var parents = $(this).parents("span");
                        if (parseInt($(this).val()) < 1) {
                            $(this).select();
                            $(this).val("1");
                        }
                    } catch (e) {
                        alert(e);
                    }
                });
            });
       
			$(".spinNumber").change(function() {
                $(".spinNumber").each(function() {
                    try {
                        //var parents = $(this).parents("span");
                        if (parseInt($(this).val()) < 1) {
                            $(this).select();
                            $(this).val("1");
                        }
                    } catch (e) {
                        alert(e);
                    }
                });
            });

            $('#music_style').change(function() {
                var style_name = $(this).val();
                //$('option', this).removeAttr("selected");
                //alert(style_name);
                var data = 'music_style_name=action&style_name=' + style_name;
                var url = 'datacon.php';
                doAjaxCall(url, data, false, function(html) {
                    try {

                        var responseData = $.parseJSON(html);
                        console.log(responseData);
                        //	alert(responseData.ptach_response.Bass);
                        if (typeof responseData.ptach_response.Bass != 'undefined') {
                            var Bass = responseData.ptach_response.Bass;
                            $('#bass_sytle').selectbox('detach');
                            $('#bass_sytle').val(Bass);
                            //	 $('#bass_sytle').selectbox('attach');
                            // $( "#bass" ).slider( "value", Bass );
                        }
                        if (typeof responseData.volumes.Bass != 'undefined') {
                            var Bass = responseData.volumes.Bass;
                            $("#bass").slider("value", Bass);
                            $("#hbass").val(Bass);
                        }
                        if (typeof responseData.ptach_response.Drum != 'undefined') {
                            var Drum = responseData.ptach_response.Drum;

                            //$('#drum_sytle').selectbox('detach');
                            //$('#drum_sytle').val(Drum);
                            //	$('#drum_sytle').selectbox('attach');
                        }
                        if (typeof responseData.volumes.Drum != 'undefined') {
                            var Drum = responseData.volumes.Drum;
                            $("#drumps").slider("value", Drum);
                            $("#hdrumps").val(Drum);
                        }
                        if (typeof responseData.ptach_response.Guitar != 'undefined') {
                            var Guitar = responseData.ptach_response.Guitar;

                            $('#guitar_style').selectbox('detach');
                            $('#guitar_style').val(Guitar);
                            //	$('#guitar_style').selectbox('attach');
                        }
                        if (typeof responseData.volumes.Guitar != 'undefined') {
                            var Guitar = responseData.volumes.Guitar;
                            $("#guitar").slider("value", Guitar);
                            $("#hguitar").val(Guitar);
                        }
                        if (typeof responseData.ptach_response.Piano != 'undefined') {
                            var Piano = responseData.ptach_response.Piano;

                            $('#piano_sytle').selectbox('detach');
                            $('#piano_sytle').val(Piano);
                            //	$('#piano_sytle').selectbox('attach');
                        }

                        if (typeof responseData.volumes.Piano != 'undefined') {
                            var Piano = responseData.volumes.Piano;
                            $("#piano").slider("value", Piano);
                            $("#hpiano").val(Piano);
                        }
                        if (typeof responseData.ptach_response.Strings != 'undefined') {
                            var Strings = responseData.ptach_response.Strings;
                            $('#string_sytle').selectbox('detach');
                            $('#string_sytle').val(Strings);
                            //	$('#string_sytle').selectbox('attach');
                        }

                        if (typeof responseData.volumes.Strings != 'undefined') {
                            var Strings = responseData.volumes.Strings;
                            $("#strings").slider("value", Strings);
                            $("#hstrings").val(Strings);
                        }

                    } catch (e) {
                        alert(e);
                    }
                });
            });

            function chords1(steps) {
                console.log("Steps " + steps);
                $('#chords_form input.chords1').each(function() {
                    var inputValOrg = $(this).val();
                    var refrenceInput = $(this);
                    if (inputValOrg != '') {
                        var inputVal = inputValOrg.substr(0, 1).toUpperCase() + inputValOrg.substr(1, 1).toLowerCase();
                        var inputValONE = inputValOrg.substr(0, 1).toUpperCase();
                        //console.log("Input val " + inputVal);
                        //console.log("Input val One " + inputValONE);
                        var index = $.inArray(inputVal, songKeys);
                        //console.log("index in songKeys is " + index);
                        if (index !== -1) {
                            //alert($.inArray(inputVal,songKeys) !== -1);
                            var currentIndex = index;
                            var stepIndex = parseInt(currentIndex) + parseInt(steps);
                            //console.log( "Current Index " + currentIndex + " Step Index" + stepIndex );
                            //	alert('Double stepIndex '+stepIndex);
                            if (parseInt(stepIndex) >= songKeys.length) {
                                //alert('enter for modification');
                                stepIndex = parseInt(stepIndex) - songKeys.length + 1;
                                if (stepIndex == '' || stepIndex == null || stepIndex == 1) {
                                    stepIndex = 1;
                                }
                                //alert('Double stepIndex after change more than index= ' + stepIndex);
                            }
                            //alert('Go for step Index '+ stepIndex)
                            refrenceInput.val(songKeys[stepIndex] + inputValOrg.substr(2, 200));
                        } else if ($.inArray(inputValONE, songKeys) !== -1) {
                            // it means array doen't have that perticular value....

                            //alert($.inArray(inputValONE,songKeys) !== +1);
                            var currentIndex = $.inArray(inputValONE, songKeys);
                            var stepIndex = parseInt(currentIndex) + parseInt(steps);
                            //console.log( "Current Index " + currentIndex + " Step Index" + stepIndex );
                            //	alert('one stepIndex '+stepIndex);
                            if (parseInt(stepIndex) >= songKeys.length) {
                                //	alert('enter for modification one');
                                stepIndex = parseInt(stepIndex) - songKeys.length + 1;
                                if (stepIndex == '' || stepIndex == null) {
                                    stepIndex = 1;
                                }
                                //	alert('one stepIndex after change more than index= ' + stepIndex);
                            }
                            if (currentIndex !== -1) {
                                refrenceInput.val(songKeys[stepIndex] + inputValOrg.substr(1, 200));
                            }
                        }

                    }
                });
            }

            function chords2(steps) {
                $('#chords_form input.chords2').each(function() {
                    var inputValOrg = $(this).val();
                    var refrenceInput = $(this);
                    if (inputValOrg != '') {
                        var inputVal = inputValOrg.substr(0, 1).toUpperCase() + inputValOrg.substr(1, 1).toLowerCase();
                        var inputValONE = inputValOrg.substr(0, 1).toUpperCase();
                        console.log("Input val " + inputVal);
                        console.log("Input val One " + inputValONE);
                        if ($.inArray(inputVal, songKeys) !== -1) {
                            //alert($.inArray(inputVal,songKeys) !== -1);
                            var currentIndex = $.inArray(inputVal, songKeys);
                            var stepIndex = parseInt(currentIndex) + parseInt(steps);
                            //	alert('Double stepIndex '+stepIndex);
                            if (parseInt(stepIndex) >= songKeys.length) {
                                //alert('enter for modification');
                                stepIndex = parseInt(stepIndex) - songKeys.length + 1;
                                if (stepIndex == '' || stepIndex == null) {
                                    stepIndex = 1;
                                }
                                //alert('Double stepIndex after change more than index= ' + stepIndex);
                            }
                            //alert('Go for step Index '+ stepIndex)
                            refrenceInput.val(songKeys[stepIndex] + inputValOrg.substr(2, 200));
                        } else if ($.inArray(inputValONE, songKeys) !== -1) {
                            //alert($.inArray(inputValONE,songKeys) !== +1);
                            var currentIndex = $.inArray(inputValONE, songKeys);
                            var stepIndex = parseInt(currentIndex) + parseInt(steps);
                            console.log("Current Index " + currentIndex + " Step Index" + stepIndex);
                            //	alert('one stepIndex '+stepIndex);
                            if (parseInt(stepIndex) >= songKeys.length) {
                                //	alert('enter for modification one');
                                stepIndex = parseInt(stepIndex) - songKeys.length + 1;
                                if (stepIndex == '' || stepIndex == null) {
                                    stepIndex = 1;
                                }
                                //	alert('one stepIndex after change more than index= ' + stepIndex);
                            }
                            if (currentIndex !== -1) {
                                refrenceInput.val(songKeys[stepIndex] + inputValOrg.substr(1, 200));
                            }
                        }

                    }
                });
            }

            function calculateTempo(currentTempo) {
                var tempo = 60000 / currentTempo;
                return (tempo * 4);
            }

            function makeFocusOnChords() {
                //        console.log("inside method");
                var curTime = parseInt(($("#jquery_jplayer_1").data("jPlayer").htmlElement.audio.currentTime) * 1000);
                var cInDuration = parseInt(countInDuration);
                var cDuration = parseInt(duration);
                //                                console.log("curTime:"+ curTime);
                if (curTime >= cInDuration) {

                    if (curTime < cInDuration + parseInt(Speed)) {
                        $('.topChords ul.Chords input[type="text"]:first').closest('div').addClass('highlight');

                    } else if ((curTime > movehighlight) && (parseInt(curTime) < parseInt(cInDuration + cDuration))) {
                        // for repeat sound case

                        if (repeat_number > 1) {

                            console.log("curTime=" + curTime + " nmberToPlay=" + nmberToPlay);
                            if (parseInt(curTime) >= parseInt(nmberToPlay) || parseInt(curTime + 55) >= parseInt(nmberToPlay)) {

                                $('.topChords ul.Chords div').removeClass('highlight');
                                //setTimeout(function(){makeFocusOnChords(Speed,duration)},countInDuration); 
                                $('.topChords ul.Chords input[type="text"]:first').closest('div').addClass('highlight');
                                nmberToPlay = nmberToPlay + nmberPlayed;
                            } else {
                                // end of repeat sound case
                                var oldHightlight = $(".topChords ul.Chords .highlight");
                                oldHightlight.closest(".parent-li").next("li").find('input[type="text"]').closest('div').addClass('highlight');
                                oldHightlight.removeClass('highlight');
                            }
                        } else {

                            var oldHightlight = $(".topChords ul.Chords .highlight");
                            oldHightlight.closest(".parent-li").next("li").find('input[type="text"]').closest('div').addClass('highlight');
                            oldHightlight.removeClass('highlight');
                        }
                        movehighlight = movehighlight + parseInt(Speed);
                    }

                }


                //        console.log("currentTime::-"+$("#jquery_jplayer_1").data("jPlayer").htmlElement.audio.currentTime);



            }

            function ClearAllChords() {
                clearInterval(startInter);
            }

            //updatePlayer('http://www.jplayer.org/audio/mp3/Miaow-07-Bubble.mp3');
            var nmberToPlay = 1;
			
            function updatePlayer(guid, callback) {
                var myPlayer = $("#jquery_jplayer_1"),
                    myPlayerData,
                    fixFlash_mp4, // Flag: The m4a and m4v Flash player gives some old currentTime values when changed.
                    fixFlash_mp4_id, // Timeout ID used with fixFlash_mp4
                    ignore_timeupdate, // Flag used with fixFlash_mp4
                    options = {
                        ready: function(event) {
                            //alert('hello');
                            // Setup the player with media.
                            $(this).jPlayer("setMedia", {
                                mp3: guid,
                                oga: guid
                            });
                            $(this).jPlayer("play", 0);
                            // $(this).jPlayer("load");
                            // $(this).jPlayer("play",0);
                        },
                        timeupdate: function(event) {

                            //                                console.log("timing:"+ event.jPlayer.status.currentTime);
                            var curTime1 = parseInt(event.jPlayer.status.currentTime * 1000);
                            var cInDuration1 = countInDuration;
                            var cDuration1 = duration;
                            dem = cInDuration1 + cDuration1;
                            // console.log("curTime1:-" + curTime1 + " cInDuration1+cDuration1:-" + dem);
                            if ((parseInt(curTime1) === parseInt(cInDuration1 + cDuration1))) {
                                ClearAllChords();

                            }
                            if (!ignore_timeupdate) {
                                //                                    console.log("sduration:"+event.jPlayer.status.duration)
                                //myControl.progress.slider("value", event.jPlayer.status.currentPercentAbsolute);
                            }
                        },
                        swfPath: "js",
                        supplied: "mp3, oga",
                        cssSelectorAncestor: "#jp_container_1",
                        wmode: "window",
                        preload: "auto",
                        keyEnabled: true,
                        ended: function() {



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

                //console.log("seekable"+myPlayer.seekable);
                // Define hover states of the buttons
                $('.jp-gui ul li').hover(
                    function() {
                        $(this).addClass('ui-state-hover');
                    },
                    function() {
                        $(this).removeClass('ui-state-hover');
                    }
                );

                // Create the progress slider control
                myControl.progress.slider({
                    animate: "fast",
                    max: 100,
                    range: "min",
                    step: 0.1,
                    value: 0,
                    slide: function(event, ui) {
                        var sp = myPlayerData.status.seekPercent;
                        if (sp > 0) {
                            // Apply a fix to mp4 formats when the Flash is used.
                            if (fixFlash_mp4) {
                                ignore_timeupdate = true;
                                clearTimeout(fixFlash_mp4_id);
                                fixFlash_mp4_id = setTimeout(function() {
                                    ignore_timeupdate = false;
                                }, 1000);
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
                    value: $.jPlayer.prototype.options.volume,
                    slide: function(event, ui) {
                        myPlayer.jPlayer("option", "muted", false);
                        myPlayer.jPlayer("option", "volume", ui.value);
                    }
                });
                //        console.log("currentTime1::-"+myPlayer.jPlayer.status);
                //        console.log("currentTime1::-"+myPlayer.status);

                //   myPlayer.jPlayer("play",0);
                //      startInter= setInterval(function(){  console.log("currentTime::-"+$("#jquery_jplayer_1").data("jPlayer").htmlElement.audio.currentTime)}, 50); 
                startInter = setInterval(makeFocusOnChords, 50);
                callback();
            }

            <!--file upload for settings-->
            // The event listener for the file upload
            document.getElementById('txtFileUpload').addEventListener('change', upload, false);

            // Method that checks that the browser supports the HTML5 File API
            function browserSupportFileUpload() {
                var isCompatible = false;
                if (window.File && window.FileReader && window.FileList && window.Blob) {
                    isCompatible = true;
                }
                return isCompatible;
            }

            // Method that reads and processes the selected file
            function upload(evt) {
                if (!browserSupportFileUpload()) {
                    alert('The File APIs are not fully supported in this browser!');
                } else {
                    var data = null;
                    try {
                        var file = evt.target.files[0];
                        var reader = new FileReader();
                        reader.readAsText(file);
                    } catch (err) {
                        alert('unable to upload file');
                    }
                    reader.onload = function(event) {
                        var csvData = event.target.result;
                        // console.log(csvData);
                        var data = $.parseJSON(csvData);
                        $('#txtFileUpload').val(null);
                        //                if (data && data.length > 0) {
                        //                  alert('Imported -' + data.length + '- rows successfully!');
                        //                } else {
                        //                    alert('No data to import!');
                        //                }
                        //console.log(data);

                        console.log(data['player_setting'][0].bass_patches);
                        var res_bass_patches = data['player_setting'][0].bass_patches;
                        console.log(res_bass_patches);
                        console.log($('select[name^="bass_patches"] option[value="' + res_bass_patches + '"]').size())
                        var res_chords_string1 = data['player_setting'][0].chords_string1;
                        var res_chords_string2 = data['player_setting'][0].chords_string2;
                        var res_end_of_chorus = data['player_setting'][0].end_of_chorus;
                        var res_end_of_song = data['player_setting'][0].end_of_song;
                        var res_drum_patches = data['player_setting'][0].drum_patches;
                        var res_guitar_patches = data['player_setting'][0].guitar_patches;
                        var res_hbass = data['player_setting'][0].hbass;
                        var res_hdrumps = data['player_setting'][0].hdrumps;
                        var res_hguitar = data['player_setting'][0].hguitar;
                        var res_hpiano = data['player_setting'][0].hpiano;
                        var res_hstrings = data['player_setting'][0].hstrings;
                        var res_piano_patches = data['player_setting'][0].piano_patches;
                        var res_repeat_number = data['player_setting'][0].repeat_number;
                        var res_start_of_chorus = data['player_setting'][0].start_of_chorus;
                        var res_string_patches = data['player_setting'][0].string_patches;
                        var res_style = data['player_setting'][0].style;
                        var res_tempo = data['player_setting'][0].tempo;
                        var res_transpose = data['player_setting'][0].transpose;
                        console.log(res_style);
                        $('#music_tempo').val(res_tempo);
                        $('#SongKey').val(res_transpose);
                        //                $('#music_style').val(res_transpose);
                        $('#start_of_chorus').val(res_start_of_chorus);
                        $('#end_of_chorus').val(res_end_of_chorus);
                        $('#repeat_number').val(res_repeat_number);
                        $('#end_of_song').val(res_end_of_song);
                        var trans_position = jQuery.inArray(res_transpose, songKeys);
                        $('select[name^="transpose"]').val(trans_position);
//                        $('select[name^="transpose"] option:selected').attr("selected", null);  
//                        $('select[name^="transpose"] option[value="' + trans_position + '"]').attr("selected", "selected");
                        
                        $('select[name^="style"]').val(res_style);
//                        $('select[name^="style"] option:selected').attr("selected", null);
//                        $('select[name^="style"] option[value="' + res_style + '"]').attr("selected", "selected");

                       // $('select[name^="bass_patches"] option:selected').attr("selected", null);
                        // $('select[name^="bass_patches"] option[value="'+res_bass_patches+'"]').attr("selected","selected");
                        $('select[name^="bass_patches"]').val(res_bass_patches)
                        
//                        $('select[name^="piano_patches"] option:selected').attr("selected", null);
//                        $('select[name^="piano_patches"] option[value="' + res_piano_patches + '"]').attr("selected", "selected");
                        
                        $('select[name^="piano_patches"]').val(res_piano_patches);
                        $('select[name^="guitar_patches"]').val(res_guitar_patches);
                        
//                        $('select[name^="guitar_patches"] option:selected').attr("selected", null);
//                        $('select[name^="guitar_patches"] option[value="' + res_guitar_patches + '"]').attr("selected", "selected");
                        
                        $('select[name^="string_patches"]').val(res_string_patches);
                        
//                        $('select[name^="string_patches"] option:selected').attr("selected", null);
//                        $('select[name^="string_patches"] option[value="' + res_string_patches + '"]').attr("selected", "selected");


                        $("#drumps").slider('value', res_hdrumps);
                        $("#bass").slider('value', res_hbass);
                        $("#piano").slider('value', res_hpiano);
                        $("#guitar").slider('value', res_hguitar);
                        $("#strings").slider('value', res_hstrings);

                        $('#hdrumps').val(res_hdrumps);
                        $('#hbass').val(res_hbass);
                        $('#hpiano').val(res_hpiano);
                        $('#hguitar').val(res_hguitar);
                        $('#hstrings').val(res_hstrings);

                        var string1_arr1 = res_chords_string1.split(",");
                        var string1_arr2 = res_chords_string2.split(",");
                        var ichrodnum = 1;
                        var ichrodnumcount = 0;
                        while (ichrodnum < 80) {
                            $('#ichrods' + ichrodnum).val(string1_arr1[ichrodnumcount]);
                            ichrodnum = ichrodnum + 2;
                            ichrodnumcount++;
                        }
                        var ichrodnum = 2;
                        var ichrodnumcount = 0;
                        while (ichrodnum < 81) {
                            $('#ichrods' + ichrodnum).val(string1_arr2[ichrodnumcount]);
                            ichrodnum = ichrodnum + 2;
                            ichrodnumcount++;
                        }

                        //                 $('#end_of_chorus').val(res_end_of_chorus);
                        //                 $('#end_of_chorus').val(res_end_of_chorus);
                        //                 $('#end_of_chorus').val(res_end_of_chorus);




                    };
                    reader.onerror = function() {
                        alert('Unable to read ' + file.fileName);
                    };
                }
            }

            <!--end file upload for settings-->
        }
    </script>
</head>

<body>

    <div class="TopWrapper">
        <div class="TopMenus clearfix gradient">
            <div class="logo">
                <a href="#"><img src="images/bbb.png" alt="loading.." />
                </a>
            </div>
            <ul class="clearfix">
                <li class="active"><a href="index.html">Main</a>
                </li>
                <li style="display: none;"><a href="editor.html">Editor</a>
                </li>
            </ul>
        </div>
        <form name="composition" id="music_composition" action="" onsubmit="return false;">
            <input type="hidden" id="SongKey" name="SongKey" value="C">
            <div class="MusicContainer">
                <div class="MusicEditor clearfix">
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
                                    <li class="jp-play ui-state-default ui-corner-all"><a href="javascript:;" class="jp-play ui-icon ui-icon-play" tabindex="1" title="play">play</a>
                                    </li>
                                    <li class="jp-pause ui-state-default ui-corner-all"><a href="javascript:;" class="jp-pause ui-icon ui-icon-pause" tabindex="1" title="pause">pause</a>
                                    </li>
                                </ul>
                                <div class="jp-progress-slider"></div>
                                <div class="jp-clearboth"></div>
                            </div>

                        </div>
                    </div>
                    <? /*<div class="control">
                    <audio src="Hydrate-Kenny_Beltrey.ogg" controls="controls" id='audio_core' class="audio-node">
                        Your browser does not support HTML5 audio.
                    </audio>
                    <!--	<object id='audio_core' class="audio-node" data="music.mp3" type="application/x-mplayer2"><param  id='audio_core1' class="audio-node" name="filename" value="music.mp3"></object>-->
                </div> */ ?>
                <div class="control saveas_song">
                    
					<span class="label"><label>&nbsp;</label></span>
                    <?/*<span class="btn"><button value="" id="export_music">Save Song</button></span>*/?>
					<span class="btn">
                                            <p id="downloadify">
				
                                            </p>
                                            <!--<button value="" id="export_music_as">Save as Song</button>-->
                                        </span>

                </div>
                <div class="control upload_btn">
                    <span class="label"><label>Load Song</label></span>
                    <span class="field">
   <span class="file-upload">
       <input type="file" name="File Upload" class="file-input" id="txtFileUpload" accept=".json" />Choose File
    </span>
                    </span>
                </div>
                <div class="control"><span class="label"><label>&nbsp;</label></span>
                    <span class="btn"><button value="" id="start_new_music">Start New Song</button></span>

                </div>
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
                        <select class="wid" id="drum_sytle" name="drum_patches">
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
                        <select class="wid" id="bass_sytle" name="bass_patches">

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
                            <option value="31">Guitar Harmonics </option>
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
                        <select class="wid" id="piano_sytle" name="piano_patches">

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
                            <option value="31">Guitar Harmonics </option>
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
                        <select class="wid" id="guitar_style" name="guitar_patches">

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
                            <option value="31">Guitar Harmonics </option>
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

            <input type="hidden" value="127" id="hdrumps" name="hdrumps" />
            <input type="hidden" value="107" id="hbass" name="hbass" />
            <input type="hidden" value="127" id="hpiano" name="hpiano" />
            <input type="hidden" value="127" id="hguitar" name="hguitar" />
            <input type="hidden" value="127" id="hstrings" name="hstrings" />

    </div>

    </form>
    <form action="" onsubmit="return false" name="chords_form" id="chords_form">
        <div class="topChords ">
            <ul class="inline Chords clearfix">
                <li class="parent-li">

                    <span>01</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods1" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods2" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>02</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods3" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods4" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>03</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods5" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods6" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>04</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods7" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods8" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>05</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods9" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods10" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>06</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods11" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods12" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>07</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods13" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods14" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>08</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods15" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods16" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>09</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods17" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods18" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>10</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods19" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods20" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>11</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods21" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods22" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>12</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods23" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods24" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>13</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods25" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods26" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>14</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods27" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods28" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>15</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods29" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods30" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>16</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods31" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods32" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>17</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods33" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods34" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">
                    <span>18</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods35" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods36" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>19</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods37" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods38" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>20</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods39" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods40" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>21</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods41" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods42" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>22</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods43" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods44" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>23</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods45" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods46" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>24</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods47" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods48" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>25</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods49" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods50" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>26</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods51" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods52" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>27</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods53" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods54" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>28</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods55" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods56" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>29</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods57" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods58" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>30</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods59" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods60" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>31</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods61" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods62" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>32</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods63" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods64" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>33</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods65" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods66" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>34</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods67" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods68" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>35</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods69" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods70" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>36</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods71" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods72" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>37</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods73" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods74" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>38</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods75" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods76" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>39</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods77" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods78" name="chords2[]">
                    </div>

                </li>
                <li class="parent-li">

                    <span>40</span>
                    <div class="">
                        <input type="text" class="chords1" id="ichrods79" name="chords1[]">
                        <input type="text" class="chords2" id="ichrods80" name="chords2[]">
                    </div>

                </li>
            </ul>
        </div>


    </form>
    <div class="Ad">
        <iframe src="http://www.boomboomband.com/app-banner-1/"></iframe>
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
            <div id="progressbar">
                <div class="progress-label" style="top:8px;">Loading Sound File...</div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
            Downloadify.create('downloadify',{
                    filename: function(){
                        var d = new Date();
                        var n = d.getTime();
                            return n+'.json';
                    },
                    data: function(){
                        var chrod1_values = $('input[name="chords1[]"]').map(function() {
                            return this.value
                        }).get();
                        var chrod2_values = $('input[name="chords2[]"]').map(function() {
                            return this.value
                        }).get();
                        var obj = {
                            tempo :$('#music_tempo').val() ,
                            style :  $('#music_style').val(),
                            drum_patches : $('#drum_sytle').val(),
                            bass_patches : $('#bass_sytle').val(),
                            piano_patches : $('#piano_sytle').val(),
                            guitar_patches : $('#guitar_style').val(),
                            string_patches : $('#string_sytle').val(),
                            hdrumps : $('#hdrumps').val() ,
                            hbass : $('#hbass').val() ,
                            hpiano : $('#hpiano').val(), 
                            hguitar : $('#hguitar').val(),
                            hstrings : $('#hstrings').val(),
                            transpose : $("#SongKey").val(),
                            start_of_chorus : $("#start_of_chorus").val(),
                            end_of_chorus : $("#end_of_chorus").val(),
                            repeat_number : $("#repeat_number").val(),
                            end_of_song : $("#end_of_song").val(),
                            chords_string1 : chrod1_values.toString(),
                            chords_string2 : chrod2_values.toString()
                        }
                        return JSON.stringify({ player_setting : [obj] });
                        
                    },
                    onComplete: function(){ 
                        //alert('Your File Has Been Saved!'); 
                    },
                    onCancel: function(){
//                        alert('You have cancelled the saving of this file.'); 
                    },
                    onError: function(){
//                        alert('You must put something in the File Contents or there will be nothing to save!'); 
                    },
                    transparent: false,
                    swf: 'media/downloadify.swf',
                    downloadImage: 'images/download.png',
                    width: 130,
                    height: 32,
                    transparent: true,
                    append: false
            });
    </script>
    <script>
        var progressbar = $("#progressbar"),
            progressLabel = $(".progress-label");
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

        function progressStop() {
            //progressbar.progressbar( "value", 100 );
            $(".loadingDiv").hide();
        }
    </script>
</body>
<script type="text/javascript" src="http://jplayer.org/js/prettify/prettify-jPlayer.js"></script>

</html>