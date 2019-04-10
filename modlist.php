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
if ($channel == null) {
    echo("Please provide a channel name!");
}
else{
    $message = "The moderators of the channel are: ";
    $getID = json_decode(@file_get_contents_curl("https://api.twitch.tv/kraken/channels/".$channel."?client_id=".$clientID['cliid']),true)['_id'];
    if ($getID == null) {
        echo("This channel does not appear to exist. Please try inputting an existing channel.");
    }
    else{
        $url = "https://api.twitch.tv/kraken/chat/".$getID."/mods?api_version=5&client_id=".$clientID['cliid'];
        $apiCALL = json_decode(@file_get_contents_curl($url), true);
        foreach($apiCALL['mods'] as $name){
            $message.=$name['user']['display_name'].', ';
        }
        print($message);
}
}
?>