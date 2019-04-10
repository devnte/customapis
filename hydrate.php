<?php
$clientID = array('cliid' => '');
$channel = $_GET["channel"];
function file_get_contents_curl($url) {
$ch = curl_init();

curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
curl_setopt($ch, CURLOPT_HTTPHEADER, $clientID);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
if ($channel == null){
    echo ("Please be sure to include a valid channel name.");
}
else{
    $url = 'https://api.twitch.tv/kraken/streams/'.$channel.'?client_id=';
    $url .= $clientID['cliid'];
    $apiCALL = json_decode(@file_get_contents_curl($url), true);
    if($apiCALL['stream'] == null){
        echo ("The stream is not currently live! Be sure to drink at least 4 ounces of water per hour in the meantime!");
    }
    else{
        // $follower = $apiCALL[‘follows’][‘0’][‘user’][‘name’];
        $starttime = $apiCALL['stream']['created_at'];
        $convertedstarttime = strtotime($starttime);
        $currtime = time();
        $seconds = 3600;
        echo ("The uptime for the stream is " . gmdate("H:i:s", $currtime - $convertedstarttime) . 
        " meaning you should have consumed at least " .(4* floor(($currtime-$convertedstarttime) / $seconds)). " ounces of water");
    }
}
?>