$(document).ready(function()
{
	navDecoration();

	$(".nav").on("click", function(event)
	{
		sessionStorage.setItem("aktivan", $(this).prop("id"));
		navDecoration();
	});
	
	function navDecoration()
	{
		var elements = $(".nav");
		for (var i = 0 ; i < elements.length ; ++i) {
			if (sessionStorage.getItem("aktivan") === elements.eq(i).prop("id"))
				elements.eq(i).css("text-decoration", "underline");
			else
				elements.eq(i).css("text-decoration", "none");
		}
	};
});