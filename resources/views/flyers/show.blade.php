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

{{-- 			does the currently authenticated user own the given model? this only works because we made $user equal to Auth::user(). This can be used on any model as long as it has the user_id column we can perform that comparison. says if we have a user and that user owns the flyer, only in that case should we display the form.
 --}}
 			@if ($user && $user->owns($flyer))

				<hr>

				{{-- <form id="addPhotosForm" action="/{{ $flyer->zip }}/{{ $flyer->street }}/photos" method="POST" class="dropzone"> --}}
				{{-- uses laravel's route() function to reference a "named route" called store_photo_path and then we just have to send through the zip code and the street. since we have lots of attributes we'll put each one on its line. --}}
				<form id="addPhotosForm"
					action="{{ route('store_photo_path', [$flyer->zip, $flyer->street]) }}"
					method="POST"
					class="dropzone">
					{{ csrf_field() }}
				</form>
			@endif
		</div>
	</div>
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