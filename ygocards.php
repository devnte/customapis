<?php
$clientID = array('cliid' => '');
$card = $_GET["card"];
$card = substr($card,13);
$newcard = str_replace(' ','_',$card);
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
function identify($c){
    if ($c == null) {
        echo("Please provide a card name!");
    }
    else{
        $getID = json_decode(@file_get_contents_curl("https://db.ygoprodeck.com/api/v4/cardinfo.php?name=".$c),true);
        array_push($getID,'error');
        if (is_string($getID[0])) {
            throw new Exception('This card does not exist. Please choose a real card.');
        }
        else{
            $val = $getID[0][0];
            if(strpos($val["type"], "Monster")){
                echo($val["name"]." is a level ". $val["level"] ." ". $val["type"]." card with ". $val["atk"] . " attack points and " . $val["def"]." defense points. The card description is: ". $val["desc"]);
            }
            else{
                echo($val["name"]." is a ". $val["type"]."  card. The card description is: ". $val["desc"]);
            }
    }
    }
}
try{
    echo identify($newcard);
} catch (Exception $e) {
    echo "Error: ", $e->getMessage();
}
?>