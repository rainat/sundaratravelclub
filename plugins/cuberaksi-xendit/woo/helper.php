<?php

function get_current_usd()
{
	$exchange_api_key = 'b6d4ff39d3923d206b7d68cde424a705';
	$exchange_api_url = "http://api.exchangeratesapi.io/v1/latest?access_key=$exchange_api_key&symbols=IDR,USD";

	$response = wp_remote_get($exchange_api_url);
	if (is_array($response) && !is_wp_error($response)) {


		$body    = json_decode($response['body'], true); // use the content

		if ($body['success']) {

			return $body['rates']['IDR'] / $body['rates']['USD'];
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

function CUBERAKSI_XENDIT_USD_IDR()
{
	 return get_current_usd();

	$usd_this_day = get_option('_cuberaksi_usd_today');

	if ((!is_today(json_decode($usd_this_day,true)['date'])) || (!$usd_this_day))
	 {
		$idr = get_current_usd();
		if ($idr) {
			update_option('_cuberaksi_usd_today', json_encode(['idr' => $idr, 'date' => new DateTime()]));
			return $idr;
		}
	}

	return 1;
}
