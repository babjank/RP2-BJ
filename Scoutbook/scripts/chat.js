$(document).ready(function()
{
	var username1, username2;
	var instanse = false;
	var state = 0;
	var mes;
	var file;

	// Upit pomoću kojega dohvaćamo korisničko ime trenutno ulogiranog korisnika
	$.ajax(
	{
		url: "scoutbook.php?rt=ajax/username",
		data: {},
		type: "GET",
		dataType: "json",
		success: function(data)
		{
			username1 = data.username;
		}
	});

	// Reagiramo na klik na element s klasom "posaljiPoruku" - prikazujemo odjeljak koji omogućuje razgovor s danim korisnikom
	$(".posaljiPoruku").on("click", function(event)
	{
		$("body").append("<hr id='chatHr'>");
		var chatDiv = $("<div id='chat'>");
		chatDiv.append("<h1>CHAT</h1>");
		chatDiv.append("<div id='chatArea'></div>")
			   .append("<form id='sendMessageArea'><p>Tvoja poruka: </p><textarea id='sendie' maxLength='100' rows='10' cols='50'></textarea></form>");
		$("body").append(chatDiv);
		
		username2 = $(this).parent().prop("id");
		
		var chat = new Chat();
	
		chat.getState();
		chat.update()
		
		$("#sendie").keydown(function(event)
		{
			var key = event.which;
			
			if (key >= 33) {
				var maxLength = $(this).attr("maxLength");
				var length = this.value.length;
			
				if (length >= maxLength) {
					event.preventDefault();
				}
			}
		});
		
		// Poruka se šalje nakon što pritisnemo i otpustimo tipku Return/Enter
		$("#sendie").keyup(function(event)
		{
			if (event.keyCode == 13) {
				var text = $(this).val();
				var maxLength = $(this).attr("maxLength");
				var length = text.length;
				
				if (length <= maxLength + 1) {
					chat.send(text);
					$(this).val(""); 
				} else {
					$(this).val(text.substring(0, maxLength));
				}
			}
		});
		
		setInterval(chat.update, 1000);
	});
	
	function Chat()
	{
		this.update = updateChat; // updateChat provjerava postoje li novi zapisi u tekstualnoj datoteci
								  // na serveru. Ako postoje, dodaje ih u chat.
		this.send = sendChat; // Poziva se kada je poruka poslana. Šalje ju serveru.
		this.getState = getStateOfChat; // Stvara novu datoteku ako je potrebno
	}
	
	function getStateOfChat()
	{
		// Dohvaćamo trenutno stanje razgovora (otvara se nova datoteka za pohranjivanje razgovora ako već ne postoji)
		if (!instanse) {
			instanse = true;
			$.ajax(
			{
				url: "scoutbook.php?rt=ajax/chat",
				data: {"function": "getState", "username2": username2, "file": file},
				type: "GET",
				dataType: "json",
				success: function(data)
				{
					state = data.state;
					instanse = false;
				}
			});
		}
	}
	
	function updateChat()
	{
		// Provjeravamo ima li novih poruka - ako da, ispisujemo ih na stranicu
		if (!instanse)
		{
			instanse = true;
			$.ajax(
			{
				url: "scoutbook.php?rt=ajax/chat",
				data: {"function": "update", "state": state, "username2": username2, "file": file},
				type: "GET",
				dataType: "json",
				success: function(data)
				{
					if (data.state <= state) {
						instanse = false;
						return;
					}
					if (data.text) {
						for (var i = 0 ; i < data.text.length ; ++i) {
							$("#chatArea").append($("<br>" + data.text[i] + "<hr><br>"));
						}
					}
					document.getElementById("chatArea").scrollTop = document.getElementById("chatArea").scrollHeight;
					instanse = false;
					state = data.state;
					$.ajax(
					{
						url: "scoutbook.php?rt=ajax/updateProcitano",
						data: {"username1": username1, "username2": username2, "state": state},
						type: "GET",
						dataType: "json",
						success: function(data)
						{
						}
					});
				}
			});
		} else {
			setTimeout(updateChat, 1500);
		}
	}
	
	function sendChat(message) 
	{
		// Kontaktiramo PHP datoteku da pohrani novu poruku te osvježavamo chat
		updateChat();
		$.ajax(
		{
			url: "scoutbook.php?rt=ajax/chat",
			data: {"function": "send", "message": message, "username2": username2, "file": file},
			type: "GET",
			dataType: "json",
			success: function(data)
			{
				updateChat();
			}
		});
	}
});