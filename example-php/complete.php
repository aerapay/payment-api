<?php

	$API_ID = 'YOUR_APP_ID';
	$API_SECRET = 'YOUR_APP_SECRET';

	$API_URL = 'https://payment2test.aerapay.com';

	// Create body
	$request_body = array(
		'token' => $_POST['token']
	);

	$API_SIGNATURE = base64_encode(hash('sha256', json_encode($request_body, JSON_UNESCAPED_SLASHES) . $API_SECRET, true));

	// Get cURL resource
	$ch = curl_init();

	// Set url
	curl_setopt($ch, CURLOPT_URL, $API_URL . '/complete');

	// Set method
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

	// Set options
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// Set headers
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"API_ID: " . $API_ID,
			"API_SIGNATURE: " . $API_SIGNATURE,
			"Content-Type: application/json",
		]
	);

	$body = json_encode($request_body);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

	$resp = json_decode(curl_exec($ch));

	if(!$resp) {
		die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
	}
	curl_close($ch);

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Aerapay Payment Example</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- Leave those next 4 lines if you care about users using IE8 -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<style type="text/css">
		body {
			padding-top: 50px;
		}

		.starter-template {
			padding: 40px 15px;
		}
	</style>
</head>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Aerapay Payment Example</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container">

		<div class="starter-template">
			<pre><?php echo json_encode($resp, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
		</div>

	</div>
	<!-- /.container -->

	<!-- Including Bootstrap JS (with its jQuery dependency) so that dynamic components work -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>