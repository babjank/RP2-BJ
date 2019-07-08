$(document).ready(function()
{
	/*
	Skripta pomoću koje reagiramo na događaje vezane uz elemente liste unutar navigacije u headeru.
	Prilikom klika na neki od elemenata, mijenja se podatak o trenutno aktivnom odjeljku.
	Element liste (koji predstavlja trenutni aktivni odjeljak) dobiva klasu "current", dok svim ostalima
	oduzimamo klasu "current". Pomoću CSS-a mijenjamo izgled elemenata s klasom "current".
	*/
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
				elements.eq(i).parent().addClass("current");
			else
				elements.eq(i).parent().removeClass("current");
		}
	};
});