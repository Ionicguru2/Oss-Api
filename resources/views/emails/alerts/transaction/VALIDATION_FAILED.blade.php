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
			<p>This offer was denied because it did not pass 3rd Party validation on the product {{ $transaction->product->title }} ( Transaction no: {{ $transaction->id }}).</p>
		</span>
	</span>
</p>
@endsection