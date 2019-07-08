$(document).ready(function()
{
	var komPrikazani = false, dodajKom = false;
	// Upit pomoću kojega dohvaćamo sve obavijesti trenutno zapisane u bazi podataka
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
				var div = $("<div class='objava' id='objava" + objave[i].id + "'>");
				div.append("<h2 class='naslov'>" + objave[i].naslov + "</h2>");
				div.append("<span class='autor'>Autor: <a href='scoutbook.php?rt=profil&username=" 
				+ objave[i].autor + "'>" + objave[i].autor.charAt(0).toUpperCase() +
				objave[i].autor.slice(1) + "</a></span>");
				div.append("<span class='datum'>" + objave[i].datum + "</span>");
				div.append("<div class='komSadrzajArea'>" + objave[i].sadrzaj + "</div>");
				div.append("<span class='prikaziKomentare' id='prikaziKom" + objave[i].id + 
							"'>Prikaži komentare!</span>");
				div.append("<span class='specChar'> &bull; </span><span class='dodajKomentare' id='dodajKom" 
							+ objave[i].id + "'>Dodaj komentar!</span>");
				div.append("<div id='prikazani" + objave[i].id + "'>");
				div.append("<div id='dodavanjeKom" + objave[i].id + "'>");
				$("#newsArea").prepend(div);
			}
			
			// Upit pomoću kojega doznajemo koliko komentara ima na pojedinoj obavijesti - za svaku obavijest zapisujemo broj komentara u zagrade unutar span elementa s IDjem "prikaziKom"
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
	
	/* Prilikom klika na element klase "prikaziKomentare", na stranicu postavljamo sve komentare 
	odgovarajuće obavijesti. Dodajemo ih u div element s odgovarajućim IDjem.
	Naime, za svaku obavijest postoji div element s IDjem nastalim konkatenacijom riječi "prikazani" i
	ID-a dane obavijesti.
	*/
	$("body").on("click", ".prikaziKomentare", function(event)
	{
		id = $(this).prop("id").substring(10);
		$("#prikazani" + id).html("");
		if (!komPrikazani) {
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
						var div = $("<div class='komentarIt' id='komentari" + id + "'>");
						for (var i = 0 ; i < komentari.length ; ++i) {
							var span = $("<span class='autorDatum'></span>");
							span.append("<a href='scoutbook.php?rt=profil&username=" + komentari[i].autor 
							+ "'>" + komentari[i].autor.charAt(0).toUpperCase() +
									komentari[i].autor.slice(1) + "</a>");
							span.append(" (" + komentari[i].datum + ")");
							div.append(span);
							div.append("<br>" + komentari[i].sadrzaj + "<br>");
							div.append("<hr>");
							$("#prikazani" + id).append(div);
						} 
					}
				}
			});
			komPrikazani = true;
		} else {
			komPrikazani = false;
		}
	});
	
	/* Prilikom klika na element klase "dodajKomentare", na stranicu postavljamo formu pomoću koje trenutno
	ulogirani korisnik može dodavati nove komentare na odgovarajuću objavu. 
	Dodajemo je u div element s odgovarajućim IDjem.
	Naime, za svaku obavijest postoji div element s IDjem nastalim konkatenacijom riječi "dodavanjeKom" i
	ID-a dane obavijesti.
	Prilikom klika na gumb unutar forme (s tekstom "Objavi!"), podaci se šalju PHP datoteci koja potom pokreće
	njihovo spremanje u bazu podataka.
	*/
	$("body").on("click", ".dodajKomentare", function(event)
	{
		var id = $(this).prop("id").substring(8);
		$("#dodavanjeKom" + id).html("");
		if (!dodajKom) {
			var div = $("<div id='formaKomentari" + id + "'>");
			var form = $("<form method='post' action='scoutbook.php?rt=troop/objaviKomentar&id_obavijest=" 
					+ id + "'></form>");
			form.append("<textarea name='komArea" + id + "' rows='3' cols='50'></textarea>");
			form.append("<br><button class='objaviKom' id='btn" + id + "'>Objavi!</button>");
			div.append(form);
			$("#dodavanjeKom" + id).append(div);
			dodajKom = true;
		} else {
			dodajKom = false;
		}
	});
});