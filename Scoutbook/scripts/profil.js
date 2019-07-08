$(document).ready(function()
{
	var div = $("<div style='display:none;' id='popup'>");
	div.append("Imate nepročitane poruke od ovog korisnika.");
	$("body").append(div);
	
	var opt = {
        autoOpen: false,
        modal: true,
        width: 400,
        height: 100,
        title: 'Nepročitane poruke!'
	};
	
	$(function() {
  		$("#popup").dialog({
    		autoOpen : false, modal : true, show : "blind", hide : "blind"
  		});
  	});
  				
	$("body").on("mouseenter", ".newMessageIcon", function(event)
	{
		$("#popup").dialog(opt).dialog("open");
	});
});