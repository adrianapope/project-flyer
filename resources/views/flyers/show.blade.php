@extends('layout')

@section('content')

	<div class="row">
		<div class="col-md-3">
			<h1>{!! $flyer->street !!}</h1>
			<h2>{!! $flyer->price !!}</h2>

		<hr>

		<div class="description">
			{!! nl2br($flyer->description) !!}
		</div>
	</div>

	<div class="col-md-9">
		@foreach ($flyer->photos as $photo)
			<img src="/{{ $photo->path }}" alt="house">
		@endforeach
	</div>

	<hr>

	<h2>Add Your Photos</h2>

	{{-- <form id="addPhotosForm" action="/{{ $flyer->zip }}/{{ $flyer->street }}/photos" method="POST" class="dropzone"> --}}
	{{-- uses laravel's route() function to reference a "named route" called store_photo_path and then we just have to send through the zip code and the street. since we have lots of attributes we'll put each one on its line. --}}
	<form id="addPhotosForm"
		action="{{ route('store_photo_path', [$flyer->zip, $flyer->street]) }}"
		method="POST"
		class="dropzone">
		{{ csrf_field() }}
	</form>
@stop

@section('scripts.footer')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.js"></script>
	<script>
		Dropzone.options.addPhotosForm = {
			paramName: 'photo',
			maxFilesize: 3,
			acceptedFiles: '.jpg, .jpeg, .png, .bmp',
		};
	</script>
@stop