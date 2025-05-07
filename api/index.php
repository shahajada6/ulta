<?php

function auth($token)
{

    error_reporting(0);
    $current_time = time();
    $new_time = strtotime('+12 hours', $current_time);

    $url = "http://iptvs4.ultapulta.com/stalker_portal/server/load.php?type=stb&action=get_profile&hd=1&ver=ImageDescription%3A%200.2.18-r14-pub-250%3B%20ImageDate%3A%20Fri%20Jan%2015%2015%3A20%3A44%20EET%202016%3B%20PORTAL%20version%3A%205.1.0%3B%20API%20Version%3A%20JS%20API%20version%3A%20328%3B%20STB%20API%20version%3A%20134%3B%20Player%20Engine%20version%3A%200x566&num_banks=2&sn=ea46a4034188caa27d142034e676444d&stb_type=MAG250&image_version=218&video_out=hdmi&device_id=4E0DD1AB59D0D6863AFDAB41D5FF8C537DE5F4E3EBDFC9219046D28664476232&device_id2=4E0DD1AB59D0D6863AFDAB41D5FF8C537DE5F4E3EBDFC9219046D28664476232&signature=&auth_second_step=1&hw_version=1.7-BD-00&not_valid_token=0&client_type=STB&hw_version_2=ea46a4034188caa27d142034e676444d&timestamp=" . $new_time . "&api_signature=263&metrics=%7B%22mac%22%3A%2200%3A1A%3A79%3A64%3AFA%3A0E%22%2C%22sn%22%3A%22ea46a4034188caa27d142034e676444d%22%2C%22model%22%3A%22MAG250%22%2C%22type%22%3A%22STB%22%2C%22uid%22%3A%22%22%2C%22random%22%3A%2267138998c61e37263729d509709a53d0%22%7D&JsHttpRequest=1-xml";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
        "Cookie: mac=00:1A:79:64:FA:0E; stb_lang=en; timezone=GMT",
        "Authorization: Bearer $token",
        "Referer: http://iptvs4.ultapulta.com/stalker_portal/c/",
        "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3",
        "X-User-Agent: Model: MAG250; Link: WiFi",
        "Referer: http://iptvs4.ultapulta.com/stalker_portal/c/",
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
}

function handShake($token)
{
    $id = $token;

    // $cid = $_GET['au'];
    error_reporting(0);

    $url = "http://iptvs4.ultapulta.com/stalker_portal/server/load.php?type=stb&action=handshake&token=" . $id . "&JsHttpRequest=1-xml";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
        "Cookie: mac=00:1A:79:64:FA:0E; stb_lang=en; timezone=GMT",
        "Referer: http://iptvs4.ultapulta.com/stalker_portal/c/",
        "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3",
        "X-User-Agent: Model: MAG250; Link: WiFi",
        "Referer: http://iptvs4.ultapulta.com/stalker_portal/c/",
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $resp = curl_exec($curl);
    //echo $resp;
    curl_close($curl);

    $zurl = json_decode($resp, true);
    $ourl = $zurl['js']['token'];
    return $ourl;

}


function getToken()
{
    // $id = $_GET['id'];

    // $cid = $_GET['au'];
    error_reporting(0);

    $url = "http://iptvs4.ultapulta.com/stalker_portal/server/load.php?type=stb&action=handshake&token=&JsHttpRequest=1-xml";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
        "Cookie: mac=00:1A:79:64:FA:0E; stb_lang=en; timezone=GMT",
        "Referer: http://iptvs4.ultapulta.com/stalker_portal/c/",
        "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3",
        "X-User-Agent: Model: MAG250; Link: WiFi",
        "Referer: http://hexa.sonyy.cc/stalker_portal/c/",
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    $resp = curl_exec($curl);
    //echo $resp;
    curl_close($curl);

    $zurl = json_decode($resp, true);
    return $zurl['js']['token'];
}

function genToken()
{
    $ourl = getToken();
    auth($ourl);
    return handShake($ourl);

}

function getCh($id)
{
    $token = genToken();
    $url = "http://iptvs4.ultapulta.com/stalker_portal/server/load.php?type=itv&action=create_link&cmd=ffrt%20http://localhost/ch/$id&series=&forced_storage=0&disable_ad=0&download=0&force_ch_link_check=0&JsHttpRequest=1-xml";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
       "Cookie: mac=00:1A:79:64:FA:0E; stb_lang=en; timezone=GMT",
        "Authorization: Bearer $token",
        "Referer: http://iptvs4.ultapulta.com/stalker_portal/c/",
        "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 250 Safari/533.3",
        "X-User-Agent: Model: MAG250; Link:",
        "Referer: http://iptvs4.ultapulta.com/stalker_portal/c/",
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    $resp = curl_exec($curl);
    // echo $resp;
    curl_close($curl);



    $zurl = json_decode($resp, true);
    $ourl = $zurl['js']['cmd'];
    return $ourl;
}

if (@$_GET['id'] != "") {
    $id = @$_GET['id'];
    $ourl = getCh($id);
    header('Location: ' . $ourl);
}

