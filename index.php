<?php

function getIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    return ($ip == "::1") ? "" : $ip;
}



$opts = array('http' => array('proxy' => 'www-cache:3128', "request_fulluri" => true));
$context = stream_context_create($opts);

$location = simplexml_load_string(file_get_contents('http://freegeoip.net/xml/'.getIP(), false, $context)) ;

$weather_api = 'http://www.infoclimat.fr/public-api/gfs/xml?_ll='.$location->Latitude.','.$location->Longitude.'&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2';

$weather = simplexml_load_string(file_get_contents($weather_api, false, $context)) or die('Unable to load weather API') ;
$bikes = simplexml_load_string(file_get_contents('http://www.velostanlib.fr/service/carto', false, $context)) or die('Unable to load bikes API');



# MERGING XML FILES

$XML = new SimpleXMLElement('<application></application>');

$node = $XML->addChild('user');
$node->addAttribute('latitude',$location->Latitude);
$node->addAttribute('longitude',$location->Longitude);

$node = $XML->addChild('weather');

foreach ($weather->echeance as $echeance) {
    $child = $node->addChild('day');
    foreach( $echeance->attributes() as $key => $value ) {
        $child->addAttribute($key, $value);
        foreach ($echeance->temperature->level as $temperature) {
            $greatChild = $child->addChild('temperature', $temperature[0]);
            foreach ($temperature->attributes() as $key2 => $value2) {
                $greatChild->addAttribute($key2, $value2);
            }
        }
    }
}

$node = $XML->addChild('velostan');

foreach ($bikes->markers->marker as $marker) {
    $child = $node->addChild('marker');
    foreach( $marker->attributes() as $key => $value ) {
        $child->addAttribute( $key, $value );
    }

    $station = simplexml_load_string(file_get_contents('http://www.velostanlib.fr/service/stationdetails/nancy/'.$marker['number'], false, $context)) or die('Unable to load bikes API');
    $child = $child->addChild('station');
    $child->addAttribute('available', $station->available);
    $child->addAttribute('free', $station->free);
    $child->addAttribute('total', $station->total);
}


# START XSLT
$xslt = new XSLTProcessor();

# IMPORT STYLESHEET
$XSL = new DOMDocument();
$XSL->load('style.xsl');
$xslt->importStylesheet( $XSL );

#PRINT
print $xslt->transformToXML( $XML );
