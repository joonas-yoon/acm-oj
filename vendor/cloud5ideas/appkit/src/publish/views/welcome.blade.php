<html>
	<head>
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}

			.link {
				font-size: 18px;
			}

			.link a {
				color: #f4645f;
				text-decoration: none;
			}

			.link a:hover {
				color: #e74430;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">{{ config('appkit.app_name') }}</div>
				<div class="quote">{{ Inspiring::quote() }}</div>
				<div class="link"><a href="{{admin_url()}}">Login</a></div>
			</div>
		</div>
	</body>
</html>
