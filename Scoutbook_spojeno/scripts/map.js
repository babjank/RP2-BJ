$( document ).ready( function()
{
  koordinate();
} );

function koordinate()
{
  $.ajax(
  {
      url: "scoutbook.php?rt=ajax/map",
      type: "GET",
      data:
      {
      },
      dataType: "json",
      success: function( data )
      {
        if( typeof( data.error ) === "undefined" )
        {
          console.log('sucess');
          lociraj( data );
        }
        else console.log( data.error );
      },
      error: function( error )
      {
        console.log( "error = " + error );
      }
  } );
}


function lociraj( data )
{
    var lokacija = $( "#lokacija" );
    lokacija.html( "<h5>Lociram...</h5>" );

    var sir = Number(data.sirina);
    var duz = Number(data.duzina);
    lokacija.html( "<h5>Lokacija je: </h5>" );

    var openLayerMap = new ol.Map(
    {
        target: 'mapa', // id elementa gdje će se nacrtati mapa
        layers: // koje slojeve ćemo prikazati na mapi
        [
            new ol.layer.Tile( { source: new ol.source.OSM() } )
        ],
        view: new ol.View(
        {
            center: ol.proj.fromLonLat( [duz, sir] ), // zemljopisne koord. centra mape
            zoom: 15
        })
    } );

}
