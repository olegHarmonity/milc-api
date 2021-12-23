 @extends('mail.default') @section('content')
<p>
	@component('mail::message') @isset($verificationCode) Hello {{$name}},
	<br />
	<br /> <br> Thank you for creating an account with MILC Platform. Don't
	forget to complete your registration! <br>
	<br /> Please click on the link below or copy it into the address bar
	of your browser to confirm your email address: <br>
	<br /> <a href="{{ $verificationUrl }}">Confirm my email address </a> <br />
	@endisset {{-- Action Button --}} @isset($actionText)

	@component('mail::button', ['url' => $actionUrl]) {{ $actionText }}
	@endcomponent @endisset {{-- Salutation --}} @lang('Regards'), <br> The
	MILC Team @endcomponent
</p>
@endsection


