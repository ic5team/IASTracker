<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ Lang::get('email.welcomeTitle') }}</h2>
		<div>
			{{ Lang::get('email.activationText') }}{{ URL::to('account/activate?token='.$token) }}.<br/>
		</div>
	</body>
</html>
