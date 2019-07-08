$(document).ready(function()
{	
	var brPatrola, patrole, vode;
	
	var opt = {
        autoOpen: false,
        modal: true,
        width: 300,
        height: 200,
        title: 'O patroli'
	};
	
	$.ajax(
	{
		url: "./scoutbook.php?rt=ajax",
		data: {},
		type: "GET",
		dataType: "json",
		success: function(data)
		{
			ctx = $("#cnv").get(0).getContext("2d");
			ctx.fillStyle = "rgb(255, 100, 100)";
			ctx.fillRect(300 - 100, 30, 200, 70);
			ctx.textAlign = "center";
			ctx.fillStyle = "black";
			ctx.font = "16px Didot";
			ctx.fillText("Odred izviđača Borongaj", 300, 65);
	
			var patrolaList = data.patrole;
			var velicinaOdred = 600 / patrolaList.length;
			brPatrola = patrolaList.length;
			patrole = patrolaList;
			vode = data.vode;
		
			colors = ["#FFBA7D", "#FFFF7D", "#D0FF7D", "#97FF7D", "#7DE6FF", "#7DB1FF", "#F37DFF"];
			for (var i = 0 ; i < patrolaList.length ; ++i) {
				ctx.beginPath();
				ctx.moveTo(200 + i * 200 / (patrolaList.length - 1), 100);
				ctx.lineTo(i * velicinaOdred + velicinaOdred / 2, 300);
				ctx.stroke();
				var r = 255 - (i + 1) * 20;
				var g = 100 + (i + 1) * 20;
				var b = 100 + (i + 1) * 20;
				ctx.fillStyle = colors[i];
				ctx.fillRect(i * velicinaOdred + velicinaOdred / 2 - 50, 300, 100, 70);
				ctx.fillStyle = "black";
				ctx.fillText(patrolaList[i].ime_patrole, i * velicinaOdred + velicinaOdred / 2, 335);
			}
			
			for (var i = 0 ; i < patrole.length ; ++i) {
				var div = $("<div style='display:none;' id='dialog" + i + "'>");
				div.append(patrole[i].ime_patrole + "<br>Vođa: " + vode[i].charAt(0).toUpperCase()
				+ vode[i].slice(1) + "<br>Razred: " + patrole[i].razred + ".<br>Stupanj znanja: ");
				var stupanj;
				if (patrole[i].stupanj_znanja === "zlatni")
					stupanj = "gold";
				else if (patrole[i].stupanj_znanja === "srebrni")
					stupanj = "silver";
				else stupanj = "bronze";
				div.append("<img src='data/" + stupanj + ".png' height='50' align='middle'>");
				div.append("<br><a href='scoutbook.php?rt=troop/patrol&ime_patrole=" 
							+ patrole[i].ime_patrole + "'>Popis članova</a>");
				$("body").append(div);
				
				$(function() {
  					$("#dialog" + i).dialog({
    					autoOpen : false, modal : true, show : "blind", hide : "blind"
  					});
  				});
			}
			
			/*for (var i = 0 ; i < patrole.length ; ++i) {
				$(function() {
  					$("#dialog" + i).dialog({
    					autoOpen : false, modal : true, show : "blind", hide : "blind"
  					});
  				});
  			}*/
		}
	});
	
	/*$("#cnv").on("click", function(event)
	{
		var rect = this.getBoundingClientRect();
		var x = event.clientX - rect.left, y = event.clientY - rect.top;
		var velicinaOdred = 600 / brPatrola;
		
		var index = -1;
		for (var i = 0 ; i < brPatrola ; ++i) {
			if (x >= i * velicinaOdred + velicinaOdred / 2 - 50 && 
				x <= i * velicinaOdred + velicinaOdred / 2 + 50) {
				index = i;
				break;	
			}
		}
		
		if (index !== -1) {
			alert(patrole[i].ime_patrole + "\nVođa: " + vode[i].charAt(0).toUpperCase() 
			+ vode[i].slice(1) + "\nRazred: " + patrole[i].razred + ".\nStupanj znanja: " 
			+ patrole[i].stupanj_znanja);
		}
	});*/
  	
  	$("#cnv").on("click", function() {
  		var rect = this.getBoundingClientRect();
		var x = event.clientX - rect.left, y = event.clientY - rect.top;
		var velicinaOdred = 600 / brPatrola;
		
		var index = -1;
		for (var i = 0 ; i < brPatrola ; ++i) {
			if (x >= i * velicinaOdred + velicinaOdred / 2 - 50 && 
				x <= i * velicinaOdred + velicinaOdred / 2 + 50 &&
				y >= 300 && y <= 370) {
				index = i;
				break;	
			}
		}
		
		if (index !== -1) {
			$("#dialog" + index).dialog(opt).dialog("open");
			return false;
		}
  	});	
});