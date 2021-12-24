<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Email template</title>
<link href='https://fonts.googleapis.com/css?family=Poppins'
	rel='stylesheet'>
<style>
* {
	font-family: 'Poppins';
	font-style: normal;
}

body {
	background-color: #191C21;
	text-align: center;
	padding-top: 125px;
	padding-bottom: 118px;
}

h2 {
	color: #FFFFFF;
	font-size: 36px;
	line-height: 54px;
	font-weight: 600;
	margin-top: 84px;
	margin-bottom: 34px;
}

.text-one {
	color: #E5E5E5;
	font-size: 16px;
	line-height: 24px;
	font-weight: 400;
	margin-bottom: 34px;
	margin-left: auto;
	margin-right: auto;
	max-width: 498px;
}

.text-two {
	color: #E5E5E5;
	font-size: 16px;
	line-height: 24px;
	font-weight: 400;
	margin-bottom: 80px;
	margin-left: auto;
	margin-right: auto;
	max-width: 498px;
}

.follow-us {
	font-size: 16px;
	line-height: 24px;
	font-weight: 600;
	color: #FFFFFF;
	margin-bottom: 18px;
}

.img-box {
	display: flex;
	margin-left: auto;
	margin-right: auto;
	max-width: 180px;
	justify-content: space-between;
}
</style>
</head>
<body>
	<div>
		<img src="{{ asset('storage/app_images/milc.png') }}" alt="Logo" />
		@if(isset($name))
			<h2>Hello {{$name}}</h2>
		@else
			<h2>Hello</h2>
		@endif
		<p class="text-one">@if(isset($message))  {!! $message !!} @endif</p>
		<p class="text-two">@if(isset($message1)) {!! $message1 !!} @endif
		  
		</p>
		</p>
		<p class="follow-us">Follow us on</p>
		<div class="img-box">
			<img src="{{ asset('storage/app_images/facebook.png') }}"
				alt="Facebook" /> 
			<img src="{{ asset('storage/app_images/twitter.png') }}" 
				alt="Twitter" />
			<img src="{{ asset('storage/app_images/youtube.png') }}"
				alt="Youtube" />
		</div>
	</div>
</body>
</html>