@extends('layout')

@section('content')

	<div class="row">
		<div class="col-md-4">
			<h1>{!! $flyer->street !!}</h1>
			<h2>{!! $flyer->price !!}</h2>

		<hr>

		<div class="description">
			{!! nl2br($flyer->description) !!}
		</div>
	</div>

	{{-- line this up as a grid. i need to display these photos in rows.
	if we want each image to be col-md-2 then we need a row class wrapping
	every four images. with eloquent results, we can do chunk(4) which will
	essentially give you an array of items. and each array is equal to four
	photos. we will save that as set. and i can wrap that in a row. and say foreach set as $photo, display thumbnails. remember when you are in a row
	everything resets so everything is divisible by 12 again. so if we want four on a page and we are dealing with 12 columns then 1/4 of 12 is 3. so we display col-md-3. --}}
	<div class="col-md-8 gallery">
		@foreach ($flyer->photos->chunk(4) as $set)
			<div class="row">
				@foreach ($set as $photo)
					<div class="col-md-3 gallery_image">
						<img src="/{{ $photo->thumbnail_path }}" alt="house">
					</div>
				@endforeach
			</div>
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