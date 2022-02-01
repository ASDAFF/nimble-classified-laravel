<?php
// update
function updateCurl($url,$method){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($ch, CURLOPT_PUT, true );
    curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3");   // who am i3

    if($method == "get")
        curl_setopt($ch, CURLOPT_HTTPGET, true );
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $filecontents=curl_exec($ch);
    curl_close($ch);
    return $filecontents;
}
