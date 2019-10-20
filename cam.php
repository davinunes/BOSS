<!DOCTYPE html>
<html>
<body>
<p id="demo">Clique no bot�o para obter sua localiza��o:</p>
<button onclick="getLocation()">Clique aqui</button>
<div id="mapholder"></div>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
var x=document.getElementById("demo");
function getLocation()
  {
  if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition,showError);
    }
  else{x.innerHTML="Geolocaliza��o n�o � suportada nesse browser.";}
  }
 
function showPosition(position)
  {
  lat=position.coords.latitude;
  lon=position.coords.longitude;
  latlon=new google.maps.LatLng(lat, lon)
  mapholder=document.getElementById('mapholder')
  mapholder.style.height='250px';
  mapholder.style.width='500px';
 
  var myOptions={
  center:latlon,zoom:14,
  mapTypeId:google.maps.MapTypeId.ROADMAP,
  mapTypeControl:false,
  navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
  };
  var map=new google.maps.Map(document.getElementById("mapholder"),myOptions);
  var marker=new google.maps.Marker({position:latlon,map:map,title:"Voc� est� Aqui!"});
  }
 
function showError(error)
  {
  switch(error.code)
    {
    case error.PERMISSION_DENIED:
      x.innerHTML="Usu�rio rejeitou a solicita��o de Geolocaliza��o."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML="Localiza��o indispon�vel."
      break;
    case error.TIMEOUT:
      x.innerHTML="O tempo da requisi��o expirou."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML="Algum erro desconhecido aconteceu."
      break;
    }
  }
</script>
</body>
</html>


Read more: http://www.linhadecodigo.com.br/artigo/3653/usando-geolocalizacao-com-html5.aspx#ixzz5zhxBsuaf