@component('mail::message') {{-- Greeting --}} @if (! empty($greeting))
# {{ $greeting }} @else # @lang('Hello!') @endif

@isset($verificationCode) Dear Sir/Madam,
<br>
Thank you for creating an account with MILC Platform. Don't forget to
complete your registration!
<br>
Please click on the link below or copy it into the address bar of your
browser to confirm your email address:
<br>

<a href="{{ $verificationUrl }}">Confirm my email
	address </a>

<br />
@endisset {{-- Action Button --}} @isset($actionText)

@component('mail::button', ['url' => $actionUrl]) {{ $actionText }}
@endcomponent @endisset {{-- Salutation --}} @lang('Regards'),
<br>
{{ config('app.name') }} @endcomponent
