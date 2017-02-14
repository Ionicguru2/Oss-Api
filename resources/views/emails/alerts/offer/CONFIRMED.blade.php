@extends('emails/master')
@section('content')
<span style="font-family:arial,helvetica neue,helvetica,sans-serif">
	<span style="font-size:27px">
		<span style="color:#9dc347">
			Hello {{ $user->get_name() }}
		</span>
	</span>
</span>

<p style="line-height: 200%; color: black;">
	<span style="font-family:arial,helvetica neue,helvetica,sans-serif">
		<span style="font-size:14px">
			You have confirmed the acceptance of your offer on {{ $offer->product->title }}
		</span>
	</span>
</p>
@endsection