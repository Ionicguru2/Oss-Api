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
			<p>A transaction is currently awaiting approval in the web admin: {{ $offer->product->title }} ( Transaction no: {{ $offer->transaction->id }}).</p>
		</span>
	</span>
</p>
@endsection