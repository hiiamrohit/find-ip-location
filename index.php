<?php
/*
* Author: Rohit Kumar
* Website: iamrohit.in
* Version: 0.0.1
* Date: 23-06-2016
* App Name: Find IP Location
* Description: Simple and fast online program to find ip address details.
*/
function ipInfo($ip) {
	if(isset($ip)) {
      $data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
	   if($data['geoplugin_status'] == '200') {
	   	return $data;
	   } else {
	   	echo "Bad request!, Error code is ".$data['geoplugin_status']; 
	   }
	} else {
		echo "IP is not set!"; 
	}
}

if(isset($_REQUEST['ip'])) {
	$data = ipInfo($_REQUEST['ip']);
  $uIp = $_REQUEST['ip'];
} else {
	$data = ipInfo($_SERVER['REMOTE_ADDR']);
   $uIp = $_SERVER['REMOTE_ADDR'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Find IP Address Location</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style>
  body {
    font-family: Helvetica,Arial,sans-serif;
    font-size: 14px;
    line-height: 22px;
    text-align: center;
}
  </style>
</head>
<body>
<div>

<h1>Find IP Address Location</h1>
<p>Simple and fast online program to find ip address details. </p>
<form action="">
<div>
		<p>Enter IP Address</p>
		<p><input name="ip" required="required" value="<?= $uIp ?>" /></p>
		
		<p><input type="submit" value="Submit" id="qr-gn"></p>
</div>
</form>

<br/>

<div id="ipinfo" style="width:30%; text-align center; margin:0 auto;">
<table border=1; width=400>
<tr><td><b>IP Address</b></td><td><?= $data['geoplugin_request'] ?></td></tr>
<tr><td><b>City</b></td><td><?= $data['geoplugin_city'] ?></td></tr>
<tr><td><b>State</b></td><td><?= $data['geoplugin_region'] ?></td></tr>
<tr><td><b>Country Code</b></td><td><?= $data['geoplugin_countryCode'] ?></td></tr>
<tr><td><b>Country</b></td><td><?= $data['geoplugin_countryName'] ?></td></tr>
<tr><td><b>Currency Code</b></td><td><?= $data['geoplugin_currencyCode'] ?></td></tr>
<tr><td><b>Currency Symbol</b></td><td><?= $data['geoplugin_currencySymbol'] ?></td></tr>
<tr><td><b>Latitude</b></td><td><?= $data['geoplugin_latitude'] ?></td></tr>
<tr><td><b>Longitude</b></td><td><?= $data['geoplugin_longitude'] ?></td></tr>

</table>
<h3>Location on Map</h3>
<div id="googleMap" style="width:400px;height:300px;"></div>
<p>Created by <a href="http://www.iamrohit.in">Rohit Kumar</a></p>
</div>




<script
src="http://maps.googleapis.com/maps/api/js">
</script>

<script>
var myCenter=new google.maps.LatLng("<?= $data['geoplugin_latitude'] ?>","<?= $data['geoplugin_longitude'] ?>");
var marker;

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:6,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  animation:google.maps.Animation.BOUNCE
  });

marker.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</body>
</html>

