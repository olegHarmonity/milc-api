<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Fonts -->
<link
	href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
	rel="stylesheet">

<style>
body {
	font-family: 'Nunito', sans-serif;
}
</style>
</head>
<body>
	<form action="{{ url('pay',['id' => 1]) }}" method="post">
		<input type="text" name="amount" /> {{ csrf_field() }} <input
			type="submit" name="submit" value="Pay Now">
	</form>
</body>
</html>