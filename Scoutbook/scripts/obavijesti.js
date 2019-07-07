$(document).ready(function()
{	
	$.ajax(
	{
		url: "scoutbook.php?rt=ajax/news",
		data: {},
		type: "GET",
		dataType: "json",
		success: function(data)
		{
			var objave = data.objave, i;

			for (i = 0 ; i < objave.length ; ++i) {
				var div = $("<div id='objava" + objave[i].id + "'>");
				div.append("<h2>" + objave[i].naslov + "</h2>");
				div.append("<span class='autor'>Autor: " + objave[i].autor.charAt(0).toUpperCase() +
				objave[i].autor.slice(1) + "</span><br>");
				div.append("<span class='datum'>" + objave[i].datum + "</span><br>");
				div.append(objave[i].sadrzaj);
				
				div.append("<br><span class='prikaziKomentare' id='prikaziKom" + objave[i].id + 
							"'>Prikaži komentare!</span>");
				div.append("<br><span class='dodajKomentare' id='dodajKom" + objave[i].id + 
							"'>Dodaj komentar!</span>");
				div.append("<hr>");
				$("#newsArea").append(div);
			}
			
			$.ajax(
			{
				url: "scoutbook.php?rt=ajax/sviKomentari",
				data: {},
				type: "GET",
				dataType: "json",
				success: function(data)
				{
					var komentari = data.komentari;
					for (var i = 0 ; i < komentari.length ; ++i)
						$("#prikaziKom" + komentari[i].id).append(" (" + komentari[i].komentari.length + ")");
				}
			});
		}
	});
	
	$("body").on("click", ".prikaziKomentare", function(event)
	{
		id = $(this).prop("id").substring(10)
		$.ajax(
		{
			url: "scoutbook.php?rt=ajax/komentari",
			data: {id_obavijest: $(this).prop("id").substring(10)},
			type: "GET",
			dataType: "json",
			success: function(data)
			{
				var komentari = data.komentari;
				if (komentari.length > 0) {
					var div = $("<div id='komentari" + id + "'>");
					for (var i = 0 ; i < komentari.length ; ++i) {
						div.append(komentari[i].autor.charAt(0).toUpperCase() +
									komentari[i].autor.slice(1));
						div.append("<br>" + komentari[i].datum);
						div.append("<br>" + komentari[i].sadrzaj + "<br>");
						$("#objava" + id).append(div);
					} 
				}
			}
		});
	});
	
	$("body").on("click", ".dodajKomentare", function(event)
	{
		var id = $(this).prop("id").substring(8);
		var div = $("<div id='formaKomentari" + id + "'>");
		var form = $("<form method='post' action='scoutbook.php?rt=troop/objaviKomentar&id_obavijest=" 
					+ id + "'></form>");
		form.append("<textarea name='komArea" + id + "' rows='3' cols='30'></textarea>");
		form.append("<br><button class='objaviKom' id='btn" + id + "'>Objavi!</button>");
		div.append(form);
		$("#objava" + id).append(div);
	});
	
	/*$("body").on("click", ".objaviKom", function(event)
	{
		var id = $(this).prop("id").substring(3);
		var sadrzaj = $("#komArea" + id).val();
		$.ajax(
		{
			url: "scoutbook.php?rt=ajax/objaviKomentar",
			data: {id_obavijest: id, sadrzaj: sadrzaj},
			type: "GET",
			dataType: "json",
			success: function(data)
			{
				
			}
		});
	});*/
});