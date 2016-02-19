<?php

	$API_ID = 'YOUR_APP_ID';
	$API_SECRET = 'YOUR_APP_SECRET';

	$API_URL = 'https://payment2test.aerapay.com';

	// Create body
	$request_body = array(
		'redirect' => 'http://localhost/aerapay-payment-php/index.php',
		'merchant' => array(
			'name' => 'Example Merchant',
			'website' => 'http://www.merchant.example',
			'email' => 'support@merchant.example',
			'image' => 'https://app.aerapay.com/img/g1.jpg'
		),
		'order' => array(
			'shipping' => '5.20',
			'total' => '25.16',
			'currency' => 'USD',
			'items' => array(
				array(
					'id' => 'B003AM87PU',
					'name' => 'Celestron 21036 PowerSeeker 70AZ Telescope',
					'amount' => '2.00',
					'quantity' => '2'
				),
				array(
					'id' => 'B00JL2TURM',
					'name' => 'Konjac Sponge - Activated Charcoal',
					'amount' => '2.03',
					'quantity' => '2'
				),
				array(
					'id' => 'B00V4PX9XK',
					'name' => 'Premium Blackhead & Blemish Remover Kit',
					'amount' => '5.95',
					'quantity' => '2'
				)
			)
		),
		'attachment' => array(
			'user_id' => '1234',
			'order_id' => '2345'
		)
	);

	$API_SIGNATURE = base64_encode(hash('sha256', json_encode($request_body, JSON_UNESCAPED_SLASHES) . $API_SECRET, true));

	// Get cURL resource
	$ch = curl_init();

	// Set url
	curl_setopt($ch, CURLOPT_URL, $API_URL . '/checkout');

	// Set method
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

	// Set options
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Set headers
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"API_ID: " . $API_ID,
			"API_SIGNATURE: " . $API_SIGNATURE,
			"Content-Type: application/json",
		)
	);

	$body = json_encode($request_body);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

	$resp = curl_exec($ch);

	if(!$resp) {
		die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
	} else {

		$token = json_decode($resp)->token;

		$url = $API_URL . "/?token=" . $token;
		header("Location: " . $url);
	}

	curl_close($ch);

?>
