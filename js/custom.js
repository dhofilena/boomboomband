$(document).ready(function(){

//=================================== slider ===================================// 	
$( ".sliderbar" ).slider();


//=================================== Spinner Number Input ===================================// 	
$( ".spinNumber" ).spinner();

//=================================== Select box===================================// 	
$(".selectbox").selectbox();


//=================================== adjustment Hieght of soundsettings panel ===================================// 	
	var windowHeight = $(window).height();
	$(".soundsettings").height(windowHeight-85);
	
//=================================== Select Soundtrack Type alert loadded ===================================// 	
	$("#Soundtracktype").change(function(){
		sType = $("#Soundtracktype").val();
		alert(sType + ' Loaded Succesfully!!!');
	});
});