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
			var objave = data.objave;

			for (var i = 0 ; i < objave.length ; ++i) {
				var div = $("<div>");
				div.append("<h2>" + objave[i].naslov + "</h2>");
				div.append("<span class='autor'>Autor: " + objave[i].autor.charAt(0).toUpperCase() +
				objave[i].autor.slice(1) + "</span><br>");
				div.append("<span class='datum'>" + objave[i].datum + "</span><br>");
				div.append(objave[i].sadrzaj);
				$("#newsArea").append(div);
			}
		}
	});
});