<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<h1>Information about order no. {{$order->order_number}}</h1>
	
	<h2>Product and rights information</h2>
	<br> Product title: {{ $order->rights_bundle->product->title }}
	<br> Product runtime: {{ $order->rights_bundle->product->runtime }} seconds
	<h3>Rights information:</h3>
	@foreach ($order->rights_bundle->bundle_rights_information as $index => $rightsInfo)
		<br>{{$index + 1}}:
		<br>Title: {{$rightsInfo->title}}
    	<br>Available from date: {{ $rightsInfo->available_from_date }}
    	<br>Expiry date: {{ $rightsInfo->expiry_date }}
    	<br>Available rights:
    	@foreach ($rightsInfo->available_rights as  $availRights)
    		{{$availRights.name}}
    		 @if( !$loop->last)
        	,
        	@endif
    	@endforeach
    	<br>Territories:
    	@foreach ($rightsInfo->territories as  $territory)
    		@foreach ($territory as  $territoryName)
    		{{$territoryName}}
    		 @if( !$loop->last)
        	,
        	@endif
    		@endforeach
    	@endforeach
    	
		<br>Description: {{$rightsInfo->long_description}}
	@endforeach
	
	<h2>Seller information</h2>
	<br> Contact email: {{ $order->rights_bundle->seller()->email }}
	<br> Organisation name: {{ $order->rights_bundle->seller()->organisation_name }}
	<br> Organisation type: {{ $order->rights_bundle->seller()->organisation_type->name }}
	<br> Organisation phone: {{ $order->rights_bundle->seller()->organisation_phone }}
	<br> Organisation address: {{ $order->rights_bundle->seller()->organisation_address }}
	<br> Organisation registration number: {{$order->rights_bundle->seller()->organisation_registration_number }}
	<br>
	<br>
	
	<h2>Buyer information</h2>
	<br> Contact email: {{ $order->contact_email }}
	<br> Delivery email: {{ $order->delivery_email }}
	<br> Organisation name: {{ $order->organisation_name }}
	<br> Organisation type: {{ $order->organisation_type }}
	<br> Organisation email: {{ $order->organisation_email }}
	<br> Organisation phone: {{ $order->organisation_phone }}
	<br> Organisation address: {{ $order->organisation_address }}
	<br> Organisation registration number: {{$order->organisation_registration_number }}
	<br>
	<br>
	
	<h2>Billing information</h2>
	<br>First name: {{ $order->billing_first_name }}
	<br>Last name: {{ $order->billing_last_name }}
	<br>Email: {{ $order->billing_email }}
	<br>Address: {{ $order->billing_address }}
	
	<h2>Payment information</h2>
	
	<br>Price: {{ $order->price->value }} {{ $order->price->currency }}
	<br>VAT ({{$order->vat_percentage->value}}%): {{ $order->vat->value }} {{ $order->vat->currency }}
	<br>Total: {{ $order->total->value }} {{ $order->total->currency }}
	<br>Transaction ID: {{ $order->transaction_id }}
	<br>Payment method: {{ $order->payment_method }}
	<br>
	<br>
	
	<h2>Dates of status changes</h2>
	<br>Contract accepted: {{ $order->contract_accepted_at }}
	<br>Payment started: {{ $order->payment_started_at }}
	<br>Paid: {{ $order->paid_at }}
	<br>Assets sent: {{ $order->assets_sent_at }}
	<br>Assets received: {{ $order->assets_received_at }}
	<br>Completed: {{ $order->completed_at }}
</body>
</html>