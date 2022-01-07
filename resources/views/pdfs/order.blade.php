<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order</title>
  <style>
    * {
      margin: 0;
      outline: 0;
      box-sizing: border-box;
    }
    body {
      background: #000;
      color: #fff;
      font-family: 'Poppins';
      font-size: 16px;
      padding: 125px 64px 89px 64px;
    }
    .text-center {
      text-align: center;
    }
    .right {
      float: right;
    }
    h1 {
      padding-top: 84px;
      font-size: 36px;
    }
    .info-box-second h3,
    .info-box {
      padding-left: 35px;
    }
    .info-box.rights > div,
    .info-box.rights > h4 {
      padding-left: 35px;
    }
    .info-box.rights > h4 {
      padding: 35px 0 35px 35px;
    }
    h3 {
      font-size: 24px;
      margin-bottom: 38px;
      margin-top: 53px;
    }
    .title {
      color: rgba(255, 255, 255, 0.8);
      font-weight: 500;
    }
    h3:after,
    h4:after,
    .title:after {
      content: ':';
      padding-left: 2px;
      padding-right: 10px;
    }
    .title,
    .description {
      font-size: 20px;
      line-height: 32.1px;
    }
    h1,
    h3,
    .description {
      font-weight: 600;
    }
    .info-box-second {
      display: inline-block;
      width: calc(50% - 8px);
    }
    .info-wrap {
      border: 1px solid rgba(198, 198, 198, .3);
      border-radius: 9px;
      padding: 20px;
    }
    footer {
      padding-top: 85px;
    }
    footer a {
      color: #630E17;
    }
  </style>
</head>
<body>
  <div class="text-center">
    <img src="{{ asset('storage/app_images/milc.png') }}" alt="Logo" />
  </div>
  <h1 class="text-center">Order no. {{$order->order_number}}</h1>
  <div class="info-box">
    <h3>Product and rights information</h3>
    <div>
      <span class="title">Product title</span>
      <span class="description">{{ $order->rights_bundle->product->title }}</span>
    </div>
    <div>
      <span class="title">Product runtime</span>
      <span class="description">{{ $order->rights_bundle->product->runtime }} seconds</span>
    </div>
  </div>
  
  <div class="info-box rights">
    <h3>Rights information</h3>
    
    @foreach ($order->rights_bundle->bundle_rights_information as $rightsInfo)
		<div>
	      <span class="title">Title</span>
	      <span class="description">{{$rightsInfo->title}}</span>
	    </div>
	    
	    <div>
	      <span class="title">Available from date</span>
	      <span class="description">{{ $rightsInfo->available_from_date }}</span>
	    </div>
	    
    	<div>
	      <span class="title">Expiry date</span>
	      <span class="description">{{ $rightsInfo->expiry_date }}</span>
	    </div>
	
	    <h4>Available rights</h4>
	   	<div>
	      <span class="title">Rights</span>
	      	<span class="description">
		    	@foreach ($rightsInfo->available_rights as  $availRights)
		    		{{$availRights.name}}
		    		 @if( !$loop->last)
		        	,
		        	@endif
		    	@endforeach
	    	</span>
	   	 </div>
	   	 
	   	 <div>
	      <span class="title">Territories</span>
	      	<span class="description">
		    	@foreach ($rightsInfo->territories as $territory)
		    		@foreach ($territory as $territoryName)
		    		{{$territoryName}}
		    		 @if( !$loop->last)
		        	,
		        	@endif
		    		@endforeach
		    	@endforeach
	    	</span>
	   	</div>
	   	
	   	 <div>
     		<span class="title">Description</span>
     		<span class="description">{{$rightsInfo->long_description}}</span>
	   	</div>
	@endforeach
    
  </div>
  
  <div class="bill-payment-info">
    <div class="info-box-second">
      <h3>Billing information</h3>
      <div class="info-wrap">
        <div>
          <span class="title">First name</span>
          <span class="description">{{ $order->billing_first_name }}</span>
        </div>
        <div>
          <span class="title">Last name</span>
          <span class="description">{{ $order->billing_last_name }}</span>
        </div>
        <div>
          <span class="title">Email</span>
          <span class="description">{{ $order->billing_email }}</span>
        </div>
        <div>
          <span class="title">Address</span>
          <span class="description">{{ $order->billing_address }}</span>
        </div>
      </div>
    </div>
    
    <div class="info-box-second right">
      <h3>Payment information</h3>
      <div class="info-wrap">
        <div>
          <span class="title">Price</span>
          <span class="description">{{ $order->price->value }} {{ $order->price->currency }}</span>
        </div>
        <div>
          <span class="title">VAT ({{$order->vat_percentage->value}}%)</span>
          <span class="description">{{ $order->vat->value }} {{ $order->vat->currency }}</span>
        </div>
        <div>
          <span class="title">Total</span>
          <span class="description">{{ $order->total->value }} {{ $order->total->currency }}</span>
        </div>
        <div>
          <span class="title">Transaction ID</span>
          <span class="description">{{ $order->transaction_id }}</span>
        </div>
        <div>
          <span class="title">Payment method</span>
          <span class="description">{{ $order->payment_method }}</span>
        </div>
      </div>
    </div>
  </div>
  
  <div class="info-box">
    <h3>Seller information</h3>
    <div>
      <span class="title">Contact email</span>
      <span class="description">{{ $order->seller->email }}</span>
    </div>
    <div>
      <span class="title">Organisation name</span>
      <span class="description">{{ $order->seller->organisation_name }}</span>
    </div>
    <div>
      <span class="title">Organisation type</span>
      <span class="description">{{ $order->seller->organisation_type->name }}</span>
    </div>
    <div>
      <span class="title">Organisation phone</span>
      <span class="description">{{ $order->seller->organisation_phone }}</span>
    </div>
    <div>
      <span class="title">Organisation address</span>
      <span class="description">{{ $order->seller->organisation_address }}</span>
    </div>
    <div>
      <span class="title">Registration number</span>
      <span class="description">{{$order->seller->organisation_registration_number }}</span>
    </div>
  </div>
	
  <div class="info-box">
    <h3>Buyer information</h3>
    <div>
      <span class="title">Contact email</span>
      <span class="description">{{ $order->contact_email }}</span>
    </div>
    <div>
      <span class="title">Organisation name</span>
      <span class="description">{{ $order->organisation_name }}</span>
    </div>
    <div>
      <span class="title">Organisation type</span>
      <span class="description">{{ $order->organisation_type }}</span>
    </div>
    <div>
      <span class="title">Organisation phone</span>
      <span class="description">{{ $order->organisation_phone }}</span>
    </div>
    <div>
      <span class="title">Organisation address</span>
      <span class="description">{{ $order->organisation_address }}</span>
    </div>
    <div>
      <span class="title">Registration number</span>
      <span class="description">{{$order->organisation_registration_number }}</span>
    </div>
  </div>
  <footer>
    <p class="text-center">Follow us on</p>
    <div class="social-logos text-center">
    	<div class="img-box">
      	<a href="https://www.facebook.com">facebook</a>
      	<a href="https://www.twitter.com">tweeter</a>
      	<a href="https://www.youtube.com">youtube</a>
		</div>
    </div>
    <div class="text-center">
      <a href="https://metaverse.milc.global">https://metaverse.milc.global</a>
    </div>
  </footer>
</body>
</html>