<?php
$amount = $_GET["amount"];
$known = $_GET["known"];
$wanted = $_GET["wanted"];
$clientID = array('cliid' => '');
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
$url = 'https://api.exchangeratesapi.io/latest';
$apiCALL = json_decode(@file_get_contents_curl($url), true);
$rates = $apiCALL['rates'];

if($amount == null){
    echo('Please provide a valid variables for the command in the form "!convert amount currency-known currency-wanted"');
}
else if($known == null){
    echo('Please provide a valid variables for the command in the form "!convert amount currency-known currency-wanted"');
}
else if($wanted == null){
    echo('Please provide a valid variables for the command in the form "!convert amount currency-known currency-wanted"');
}

else if(array_key_exists($known, $rates) == FALSE){
    echo('Your known currency variable does not appear to be compatible. Please check https://www.ecb.europa.eu/stats/policy_and_exchange_rates/euro_reference_exchange_rates/html/index.en.html for compatible currency variables.');
}
else if(array_key_exists($wanted, $rates)==  FALSE){
    echo('Your desired currency variable does not appear to be compatible. Please check https://www.ecb.europa.eu/stats/policy_and_exchange_rates/euro_reference_exchange_rates/html/index.en.html for compatible currency variables.');
}
else{
    $convrate = $rates[$wanted] / $rates[$known];
    $result = $amount * $convrate;
    echo($amount ." " . $known . " is equivalent to ". $result . " " . $wanted);
}
?>