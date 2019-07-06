$(document).ready(function()
{
	var username2;
	var instanse = false;
	var state = 0;
	var mes;
	var file;

	$(".posaljiPoruku").on("click", function(event)
	{
		var chatDiv = $("<div id='chat'>");
		chatDiv.append("<h2>Chat</h2>");
		chatDiv.append("<div id='chatWrap'><div id='chatArea'></div></div>")
			   .append("<form id='sendMessageArea'><p>Tvoja poruka: </p><textarea id='sendie' maxLength='100'></textarea></form>");
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
		
		$("#sendie").keyup(function(event)
		{
			if (event.keyCode == 13) {
				var text = $(this).val();
				var maxLength = $(this).attr("maxLength");
				var length = text.length;
				
				if (length <= maxLength + 1) {
					chat.send(text, username2);
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
		this.send = sendChat; // poziva se kada je poruka poslana. Šalje ju serveru.
		this.getState = getStateOfChat; // provjerava koliko linija tekstualna datoteka ima.
	}
	
	function getStateOfChat()
	{
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
					if (data.text) {
						for (var i = 0 ; i < data.text.length ; ++i) {
							$("#chatArea").append($("<br>" + data.text[i] + "<br>"));
						}
					}
					document.getElementById("chatArea").scrollTop = document.getElementById("chatArea").scrollHeight;
					instanse = false;
					state = data.state;
				}
			});
		} else {
			setTimeout(updateChat, 1500);
		}
	}
	
	function sendChat(message) 
	{
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