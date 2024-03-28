<?php

function get_current_currency_to_idr($xendit = '')
{
	// delete_transient('currency_rate_');
	$curr_transient = get_transient('currency_rate_');
	if (false === ($curr_transient)) {
		// this code runs when there is no valid transient set
		$tmp = get_current_usd();
		if ($tmp) {
			set_transient('currency_rate_', json_encode($tmp), 3600 * 6);
			$curr_transient = json_encode($tmp);
		}
	}

	$base_currency = json_decode($curr_transient, true);
	// $base_currency = get_current_usd();
	// console_log($base_currency);

	$value = $base_currency['USD'];
	if (isset($_COOKIE['__currency__cb'])) {
		$value = $base_currency[$_COOKIE['__currency__cb']];
	}

	if ($xendit === 'xendit') {
		if (isset($_COOKIE['__currency__cb'])) {

			if ($_COOKIE['__currency__cb'] === 'USD')
				$value = $base_currency['IDR'];
			if ($_COOKIE['__currency__cb'] === 'IDR')
				$value = $base_currency['USD'];
		} else {
			$value = $base_currency['IDR'];
		}
	}
	return $value;
}

function get_current_usd()
{
	// return [
	// 			'USD' => 1,
				
	// 			'IDR' => 15700
	// 		];

	//account exhahange api free edition 
	//user dev.sundaratravel@gmail.com
	//pass dev.sundaratravel@gmail.com1234
	// $exchange_api_key = '4f6a30b958046690718d9bbf663f427c';
	// $exchange_api_url = "http://api.exchangeratesapi.io/v1/latest?access_key=$exchange_api_key&symbols=IDR,USD";
	$exchange_api_url='https://v6.exchangerate-api.com/v6/782ce3e525cc0522ed894b8a/pair/usd/idr';

	$response = wp_remote_get($exchange_api_url);
	if (is_array($response) && !is_wp_error($response)) {


		$body    = json_decode($response['body'], true); // use the content

		if ($body['result']==='success') {

			return [
				'USD' => 1,
				// 'THB' => $body['rates']['THB'] / $body['rates']['USD'],
				// 'IDR' => $body['rates']['IDR'] / $body['rates']['USD']
				'IDR' => $body['conversion_rate']

			];
		}


		return false;
	}
	return false;
}

function is_today($match_date)
{
	$date = new DateTime();
	$interval = $date->diff($match_date);

	if ($interval->days == 0) {

		return true;
	}

	return false;
}

function CUBERAKSI_SUNDARA_USD_IDR()
{
	return get_current_usd();

	// $usd_this_day = get_option('_cuberaksi_usd_today');

	// if ((!is_today(json_decode($usd_this_day, true)['date'])) || (!$usd_this_day)) {
	// 	$idr = get_current_usd();
	// 	if ($idr) {
	// 		update_option('_cuberaksi_usd_today', json_encode(['idr' => $idr, 'date' => new DateTime()]));
	// 		return $idr;
	// 	}
	// }

	// return 1;
}

function console_log($obj)
{
	$json = json_encode($obj);
	echo "<script>console.log($json)</script>";
}

// delete_transient('currency_rate_');