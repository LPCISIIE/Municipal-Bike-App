<?php
//header("Content-Type: application/xml");

function debug($data) {
    die('<pre>' . print_r($data,true) . '</pre>');
}

function getIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    return ($ip == "::1") ? "" : $ip;
}




// Proxy$opts = array('http' => array('proxy'=> 'tcp://127.0.0.1:8080', 'request_fulluri'=> true));
//$context = stream_context_create($opts);

$location = simplexml_load_string(file_get_contents('http://freegeoip.net/xml/'.getIP())) ;
$weather_api = 'http://www.infoclimat.fr/public-api/gfs/xml?_ll='.$location->Latitude.','.$location->Longitude.'&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2';
$weather = simplexml_load_string(file_get_contents($weather_api)) ;
//echo $weather->echeance->asXML();

# LOAD XML FILE
$XML = $weather->echeance;


# START XSLT
$xslt = new XSLTProcessor();

# IMPORT STYLESHEET 1
$XSL = new DOMDocument();
$XSL->load('style.xsl');
$xslt->importStylesheet( $XSL );

#PRINT
print $xslt->transformToXML( $XML );


echo "

<script>


	var mymap = L.map('mapid').setView([$location->Latitude, $location->Longitude], 13);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoieGNob3BpbiIsImEiOiJjaXluMXg0cTAwMDBwM3VwZnN0Y2ZxM3JmIn0.Hfr7AY-5aNpongUyCXdOUg', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, ' +
			'<a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
			'Imagery © <a href=\"http://mapbox.com\">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap)


</script>";
