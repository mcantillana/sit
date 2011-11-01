$(function(){
	
	//$('#datepicker').datepicker({inline: true});

	initMenu();
	$('.info_div').click(function() {$(this).fadeOut('slow')});
	//$("#dialog").dialog({ buttons: { "Ok": function() { $(this).dialog("close"); } } });
	//$('#tabs').tabs();

	$("#tabledata").resizable({ maxWidth: 940 });
	//$.plot($("#placeholder"), [ [[0, 0], [1, 10]]], { yaxis: { max: 10 }, grid: { color: "#000", borderWidth:1} });
});
	



 function initMenu() {
  $('#menu ul').hide();
  $('#menu ul:first').show();
  $('#menu li a').click(
  function() {
  var checkElement = $(this).next();
  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
  return false;
  }
  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
  $('#menu ul:visible').slideUp('normal');
  checkElement.slideDown('normal');
  return false;
  }
  }
  );
  }				
