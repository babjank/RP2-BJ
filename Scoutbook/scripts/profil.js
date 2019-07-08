$(document).ready(function()
{
	/*
	Skripta koja se uključuje u profil_index.php i patrol_index.php. 
	Ona reagira na događaj ulaska miša u područje slike koja korisnika obavještava o tome da ima nepročitanih
	poruka od korisnika čiji profil gleda ili odgovarajućeg korisnika u odjeljku "Patrola".
	Prilikom pojave opisanog događaja, javlja se dialog koji korisniku pojašnjava da se radi o tome da ima
	nepročitanih poruka.
	*/
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