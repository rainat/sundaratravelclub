<?php

namespace Cuberaksi\Amelia\Service;



class Amelia_Data
{
	private $data_amelia;
	private $provider_service;

	public function __construct()
	{
		$this->data_amelia = array(
			'name' => '-',
			'description' => '-',
			'color' => '#1788FB',
			'price' => '0',
			'status' => 2,
			'categoryId' =>   '1',
			'minCapacity' => '1',
			'maxCapacity' => '1',
			'duration' => '1800',
			'timeBefore' => null,
			'timeAfter' => null,
			'bringingAnyone' => '1',
			'priority' => 1,
			'pictureFullPath' => null,
			'pictureThumbPath' => null,
			'position' => '1',
			'show' => '1',
			'aggregatedPrice' => '1',
			'settings' => '{"payments":{"paymentLinks":{"enabled":false,"changeBookingStatus":false,"redirectUrl":null},"onSite":false,"wc":{"productId":0},"payPal":{"enabled":false},"stripe":{"enabled":false},"mollie":{"enabled":false},"razorpay":{"enabled":false}},"general":{"minimumTimeRequirementPriorToBooking":null},"zoom":{"enabled":false},"lessonSpace":{"enabled":false},"activation":{"version":"6.7"}}',
			'recurringCycle' => 'disabled',
			'recurringSub' => 'future',
			'recurringPayment' => '0',
			'translations' => null,
			'depositPayment' => 1,
			'depositPerPerson' => '1',
			'deposit' => '0',
			'fullPayment' => '0',
			'mandatoryExtra' => '0',
			'minSelectedExtras' => null,
			'customPricing' => '{"enabled":false,"durations":{}}',
			'maxExtraPeople' => null,
			'limitPerCustomer' => '{"enabled":false,"numberOfApp":1,"timeFrame":"day","period":1,"from":"bookingDate"}'

		);
		$this->provider_service = array('customPricing' => '{"enabled":false,"durations":{}}',
			'userId' => '',
			'serviceId' => '',	
			'price'	=> '0',	
			'minCapacity' => '1',
			'maxCapacity' => '1',
			);
	}

	public function update_service($post_id, $data)
	{

		$this->data_amelia['name'] = isset($data['name']) ? $data['name'] : '';
		$this->data_amelia['description'] = isset($data['description']) ? $data['description']  : '';
		$this->data_amelia['price'] = isset($data['price']) ? $data['price'] : '';

		if (isset($data['product_id'])) 
		{
			$this->data_amelia['settings'] = '{"payments":{"paymentLinks":{"enabled":false,"changeBookingStatus":false,"redirectUrl":null},"onSite":false,"wc":{"productId":'. $data['product_id'] . '},"payPal":{"enabled":false},"stripe":{"enabled":false},"mollie":{"enabled":false},"razorpay":{"enabled":false}},"general":{"minimumTimeRequirementPriorToBooking":null},"zoom":{"enabled":false},"lessonSpace":{"enabled":false},"activation":{"version":"6.7"}}';
		}


		$this->update_table($post_id);
	}

	function update_table($post_id)
	{
		global $wpdb;

		$meta = get_post_meta($post_id,'_amelia_cuberaksi',true);
		$data_meta = [];
		

		if ($meta) {
			// exist service amelia cuberaksi
			$obj = json_decode($meta,true);
			$wpdb->update('wp_amelia_services', $this->data_amelia,['id' => $obj['service_id']]);

			$result = $wpdb->update("wp_amelia_providers_to_services", ['price' => $this->data_amelia['price']],['userId' => $this->get_employee(), 'serviceId' => $obj['service_id']]);

			$this->provider_service['price'] = $this->data_amelia['price'];

			$data_meta['product_id'] = $post_id;
			$data_meta['service_id'] = $obj['service_id'];
			$data_meta['price'] = $this->data_amelia['price'];

		} else
		{
			// doesn't exist service amelia cuberaksi			
			
			$wpdb->insert('wp_amelia_services', $this->data_amelia);
			$id = $wpdb->insert_id;

			$this->provider_service['userId'] = $this->get_employee();
			$this->provider_service['serviceId'] = $id;
			$this->provider_service['price'] = $this->data_amelia['price'];

			$wpdb->insert('wp_amelia_providers_to_services',$this->provider_service);

			$data_meta['product_id'] = $post_id;
			$data_meta['service_id'] = $id;
			$data_meta['price'] = $this->data_amelia['price'];
		}

		update_post_meta($post_id,'_amelia_cuberaksi',json_encode($data_meta));	

	}

	function get_employee()
	{
		global $wpdb;
		$result = $wpdb->get_results("SELECT * FROM  wp_amelia_users WHERE type = 'provider' ", ARRAY_A);
		if ($result) {
			return $result[0]['id'];
		}

		return false;
	}

}
