@if (session()->has('flash_message'))
	<script type="text/javascript">
	    swal({
	      title: "{{ session('flash_message.title') }}",
	      text: "{{ session('flash_message.message') }}",
	      type: "info",
	      timer: 1700,
	      confirmButtonText: false
	   	});
 	</script>
@endif