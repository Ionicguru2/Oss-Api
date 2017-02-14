@extends('emails/master')
@section('content')
<span style="font-family:arial,helvetica neue,helvetica,sans-serif">
	<span style="font-size:27px">
		<span style="color:#9dc347">
			Hello Administrator,
		</span>
	</span>
</span>

<p style="line-height: 200%; color: black;">
	<span style="font-family:arial,helvetica neue,helvetica,sans-serif">
		<span style="font-size:14px">
			<p>User {{ $offer->user->get_name() }} (ID: {{ $offer->user->identifier }}), has requested Third Party Validation on product {{ $offer->product->title }} ( Product no: {{ $offer->product->id }}, Transaction no: {{ $offer->transaction->id }}).</p>
		</span>
	</span>
</p>
@endsection