<?php

function debug($data) {
    die('<pre>' . print_r($data,true) . '</pre>');
}

function getIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    return ($ip == "::1") ? "" : $ip;
}
header("Content-Type: application/xml");

// Proxy$opts = array('http' => array('proxy'=> 'tcp://127.0.0.1:8080', 'request_fulluri'=> true));
//$context = stream_context_create($opts);


$response = file_get_contents('http://freegeoip.net/xml/'.getIP());

debug($response);