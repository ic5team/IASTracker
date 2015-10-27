<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{Lang::get('email.passwordReminderSubject')}}</h2>

		<div>
			{{Lang::get('email.passwordReminderText', array('username' => $user, 'link' => URL::to('password/reset?token='.$token)))}}.<br/>
		</div>
	</body>
</html>
