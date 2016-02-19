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
			<?php
				if ($_GET && $_GET["result"]) {
					$result = json_decode(base64_decode($_GET["result"]));

			?>
			<pre><?php echo json_encode($result, JSON_PRETTY_PRINT); ?></pre>
			<form action="complete.php" method="POST">
				<button type="submit" class="btn btn-default">Complete</button>
				<input type="hidden" value="<?php echo $result->token ?>" name="token" />
			</form>
			<?php
				}
			?>
		</div>

		<form action="checkout.php" method="POST" id="testForm">
			<button type="submit" class="btn btn-default">To Checkout Page</button>
		</form>

	</div>
	<!-- /.container -->

	<!-- Including Bootstrap JS (with its jQuery dependency) so that dynamic components work -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>