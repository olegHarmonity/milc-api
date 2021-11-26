@component('mail::message')
{{-- Greeting --}}
 
@isset($name)
Hello {{ $name }}! <br/><br/>
@else
Hello! <br/><br/>
@endisset

@isset($message)
{!! $message !!}
@endisset

{{-- Action Button --}}
@isset($actionText)

@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent
@endisset


{{-- Salutation --}}

@lang('Regards'),<br>
The MILC Team 

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
