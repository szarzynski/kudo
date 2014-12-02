<html>
<head>
<meta charset="UTF-8">
</head>
<body>
	
	<h1>{{ lang.login.header }}</h1>
	{{ flash.error }}
	<form id="login" name="login" id="login" method="post">
		<input type="hidden" name="{{ csrf_key }}" value="{{ csrf_token }}">
		<input type="text" placeholder="{{ lang.login.username }}" class="form-control uname" name="username" value="{{ username }}">
		<input type="password" placeholder="{{ lang.login.password }}" class="form-control pword" name="password">
		<input type="submit" value="{{ lang.login.submit }}" class="btn btn-success btn-block" />

	</form>

</body>

</html>