<?php 

$url = "https://bitpay.com/api/rates";
$json = json_decode(file_get_contents($url));
$dollar = $btc = 0;

foreach ($json as $obj){
	if ($obj-> code == 'AUD')
		$btc = $obj -> rate;
}

echo '1 bitcoin = $'. $btc .' AUD <br>';
// echo '10 dollars = '. round($dollar*10,8).' BTC<br>';




