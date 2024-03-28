<?php
$handle = curl_init();
$json_data = json_encode(['external_id' => 'woocommerce-xendit-9514']);
$secret_api_key = 'xnd_development_t0uhxiocFZnQL4HJp88HynG3j0W7koZxYfFnER3PXh5kGEhQPtnMBUJBkqKy0UxC:';
curl_setopt_array($handle, array(
	CURLOPT_URL => 'https://api.xendit.co/credit_card_charges/65d60bf31b8dd50017fef1e0/auth_reversal',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_POSTFIELDS => $json_data,
	CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		'Authorization: Basic ' . base64_encode($secret_api_key),
	),
));

$result = curl_exec($handle);
// $tmp = json_decode($result,true);
print_r($result);
curl_close($handle);