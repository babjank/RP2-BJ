$(document).ready(function()
{
	$("#odred").css("text-decoration", "underline");
	sessionStorage.setItem("aktivan", $(this).prop("id"));
});