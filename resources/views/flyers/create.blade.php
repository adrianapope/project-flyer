@extends('layout')

@section('content')
<h1>Selling your home?</h1>

<div class="row">
	<div class="col-md-6">
		<form method="POST" action="/flyers" enctype="multipart/form-data">
			@include('flyers.form')

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
		</form>
	</div>
</div>
@stop