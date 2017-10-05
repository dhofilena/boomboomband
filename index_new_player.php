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
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.selectbox.css">
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen"/>

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

<!--audio start-->
	<script type="text/javascript" src="http://localhost:8080/player/inc/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="http://localhost:8080/player/inc/jquery.mb.miniPlayer.js"></script>
   
     

    <script type="text/javascript">

        $(function(){

            if (self.location.href == top.location.href){
                $("body").css({font:"normal 13px/16px 'trebuchet MS', verdana, sans-serif"});
                var logo=$("<a href='http://pupunzi.com'><img id='logo' border='0' src='http://pupunzi.com/images/logo.png' alt='mb.ideas.repository' style='display:none;'></a>").css({position:"absolute", top:10, left:10});
                $(".wrapper").prepend(logo);
                $("#logo").fadeIn();
            }

            if(isAndroidDefault){
                alert("Sorry, your browser does not support this implementation of the player. It will be used the standard HTML5 audio player instead")
            }

            $(".audio").mb_miniPlayer({
                width:240,
                inLine:false,
                id3:true
            });

        });

    </script>

<!--audio end-->

<!--[if IE 7]>
<script type="text/javascript">
    $(document).ready(function(){
    	$(".selectbox").selectbox("detach");
		alert("Please upgrade your browser for best performance");
	});
 </script>
 <![endif]-->
 
 <script type="text/javascript">
  $(document).ready(function(){
	
	 $("#drumps").slider({
	  min: 1,
	  max: 127,
	  value: 52,
	  step: 2,
	  slide: function(event, ui) {
	  $("#hdrumps").val(ui.value);
	  
	  
	  }
	});
	
	$("#bass").slider({
	  min: 1,
	  max: 127,
	  value: 62,
	  step: 2,
	  slide: function(event, ui) {
	  $("#hbass").val(ui.value);
	  
	  }
	});
	
	$("#piano").slider({
	  min: 1,
	  max: 127,
	  value: 62,
	  step: 2,
	  slide: function(event, ui) {
	  $("#hpiano").val(ui.value);
	  
	  }
	});
	
	$("#guitar").slider({
	  min: 1,
	  max: 127,
	  value: 62,
	  step: 2,
	  slide: function(event, ui) {
	  $("#hguitar").val(ui.value);
	  
	  }
	});
	
	$("#strings").slider({
	  min: 1,
	  max: 127,
	  value: 62,
	  step: 2,
	  slide: function(event, ui) {
	  $("#hstrings").val(ui.value);
	  
	  }
	});
	
	
	/*submit composition form*/
	$('#play_music').click(function(){
		var url = 'datacon.php';
		var data  = 'tempo='+$('#music_tempo').val()+'&style='+$('#music_style').val()+'&hdrumps='+$('#hdrumps').val()+'&hbass='+$('#hbass').val()+'&hpiano='+$('#hpiano').val()+'&hguitar='+$('#hguitar').val()+'&hstrings='+$('#hstrings').val()+'&action=processMIDI';
		data += '&'+$('#chords_form').serialize();
		//alert(data);
		doAjaxCall(url,data,false,function(html){
					try {
						var responseData		= $.parseJSON(html);
						//console.log(responseData);
						//alert(responseData.mp3src);
						var mp3src			=	responseData.mp3src;
						var duration		=	responseData.duration;
						var countInDuration	=	responseData.countInDuration;
						var audio_core	= $('#audio_core').attr('src',mp3src)[0];
						audio_core.play() // <- play the song!!!
						var Speed	=	calculateTempo($('#music_tempo').val());   
						setTimeout(function(){makeFocusOnChords(Speed)},Speed); 
						} catch (e) {
						alert(html);
						}
		});
	});
	
	$('.topChords ul.Chords li input[type="text"]').focus(function(){
		$('.topChords ul.Chords li').removeClass('highlight');
		$(this).closest('li').addClass('highlight');
	});
	
	
});

	function calculateTempo(currentTempo){
			var tempo	=	120/currentTempo;
			
			return tempo * 2000;
	}
	function makeFocusOnChords(Speed){
			$('.topChords ul.Chords .highlight').removeClass('highlight');
			$('.topChords ul.Chords input[type="text"]:first').closest('li').addClass('highlight');
			
			var interval	=	setInterval(function(){
				
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
			
		$("#stop_music").off('click').on('click',function() {
			
		  clearInterval(interval);
			audio_core.pause();
		});
	
	}
	

 </script>
</head>

<body>
<div class="TopWrapper">
	<div class="TopMenus clearfix gradient">
    	<div class="logo"><a href="#">New Rock Band</a></div>
    	<ul  class="clearfix">
        	<li class="active"><a href="index.html">Main</a></li>
            <li><a href="editor.html">Editor</a></li>
        </ul>
    </div>
	<form name="composition" id="music_composition" action="" onsubmit="return false;">	
	<div class="MusicContainer">
    <div class="MusicEditor clearfix" >
    	<div class="control">
        	<span class="label"><label>Tempo :</label></span>
            <span class="field"><input type="text" class="spinNumber" name="tempo" value="120" id="music_tempo"></span>
       </div>

    	<div class="control">
        	<span class="label"><label>Transpose :</label></span>
            <span class="field">
            	<select class="selectbox"  id="" name="transpose">
            		<option value="C" selected> C</option>
            		<option value="Db">Db</option>
            		<option value="Eb">Eb</option>
            		<option value="E">E</option>
            		<option value="F">F</option>
            		<option value="Gb">Gb</option>
            		<option value="G">G</option>
            		<option value="Ab">Ab</option>
            		<option value="A">A</option>
            		<option value="Bb">Bb</option>
            		<option value="B">B</option>
                </select>
           	</span>
       </div>
       
       <div class="control">
        	<span class="label"><label>Style :</label></span>
            <span class="field">
            	<select class="selectbox"  id="music_style" name="style">
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
            <span class="field"><input type="text" class="spinNumber" value="1" name="start_of_chorus"></span>
       </div>

       <div class="control">
        	<span class="label"><label>End of Chorus :</label></span>
            <span class="field"><input type="text" class="spinNumber" value="4" name="end_of_chorus"></span>
       </div>

		<div class="control">
        	<span class="label"><label>Repeat Number :</label></span>
            <span class="field"><input type="text" class="spinNumber" value="1"  name="repeat_number"></span>
       </div>

		<div class="control">
        	<span class="label"><label>End of Song:</label></span>
            <span class="field"><input type="text" class="spinNumber" value="4" name="end_of_song"></span>
       </div>
       
		<div class="control">
        	<span class="btn"><button value="" id="play_music">Play</button></span>
        	<span class="btn"><button value="" id="stop_music">Stop</button></span>
       </div>
		<div class="control">
					  <a id="m2" class="audio {skin:'orange', ogg:'', showTime:false}" href="http://www.miaowmusic.com/mp3/Miaow-02-Hidden.mp3">miaowmusic - Hidden (ogg/mp3)</a>
				
				
				<!--	<object id='audio_core' class="audio-node" data="music.mp3" type="application/x-mplayer2"><param  id='audio_core1' class="audio-node" name="filename" value="music.mp3"></object>-->
		</div>
	</div>
	
    <ul class="settings clearfix">
    	<li>
        	<div class="col">
	            <span class="btn"><button value="">SAVE</button></span>
    	    	<span class="btn"><button value="">LOAD</button></span>
   	   		</div>

        </li>
        <li>
        	 <div class="col">
            	<select class="selectbox"  id="" name="">
            	  <option value="ACOUSTIC BASS">ACOUSTIC BASS </option>
            	  <option value="SLAP BASS 1">SLAP BASS 1</option>
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
            	<select class="selectbox"  id="" name="">
            	  <option value="ACOUSTIC BASS">ACOUSTIC BASS </option>
            	  <option value="SLAP BASS 1">SLAP BASS 1</option>
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
            	<select class="selectbox"  id="" name="">
            	  <option value="ACOUSTIC GRAND">ACOUSTIC GRAND</option>
            	  <option value="BRIGHT ACOUSTIC">BRIGHT ACOUSTIC</option>
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
            	<select class="selectbox"  id="" name="">
            	  <option value="NYLON STRING GUITAR">NYLON STRING GUITAR</option>
            	  <option value="STEEL STRING GUITAR">STEEL STRING GUITAR</option>
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
            	<select class="selectbox"  id="" name="">
            	  <option value="VIOLIN">VIOLIN</option>
            	  <option value="VIOLA">VIOLA</option>
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
                    <li><input type="text" name="chords1[]"></li>
                    <li><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>02</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>03</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>04</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>05</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>06</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>07</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>08</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>09</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li"> 
                    <li>10</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li" >
                    <li>11</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>12</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>13</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>14</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>15</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>16</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>17</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>18</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>19</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>20</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>21</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>22</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>23</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>24</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>25</li>
                     <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>26</li>
                   <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>27</li>
                     <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>28</li>
                   <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>29</li>
                     <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>30</li>
                     <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>31</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>32</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>33</li>
                     <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>34</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>35</li>
                     <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>36</li>
                  <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>37</li>
                   <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>38</li>
                   <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>39</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
            <li class="parent-li">
                <ul class="sub-li">
                    <li>40</li>
                    <li class=""><input type="text" name="chords1[]"></li>
                    <li class=""><input type="text" name="chords2[]"></li>
                </ul>
            </li>
        </ul>
   	</div>
    
    
    </form>
    <div class="Ad">
    <img src="images/Program_overview.jpg"></div>
</div>

</body>

</html>