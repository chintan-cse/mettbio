@extends('layouts.app')

@section('content')

<style>
.searchfilter #requestlist-table_filter {
    float: left;
    margin-left: 0px !important;
}
</style>
	<!-- Main content -->
<section class="main-content-section style-8">
	<!-- Main content -->
    <section class="content">
	  <div class="main-panel">
          <div class="content-wrapper">

		  <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-account"></i>
                </span> Sample assign to User List </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                   <span class="">
						<a href="{{route('home')}}"><i class="mdi mdi-home"></i></a></span><span><i class="mdi mdi-arrow-right"></i> Sample Assignment</span> 
                  </li>
                </ul>
              </nav>
            </div>
			<!-- <div class="row mb-2">
				<div class="col-md-9">
					<h3></h3>
				</div>
				<div class="col-md-3 text-right">
					<span class="page-title-icon bg-gradient-primary text-white mr-2">
						<a href="{{route('home')}}"><i class="mdi mdi-home"></i></a></span><span>> Users</span>
				</div>									
			</div> -->
			@if ($message = Session::get('success'))
			<div class="row">
				<div class="col-lg-8 col-12"></div>
				<div class="col-lg-4 col-12">
				<div class="alert alert-success">
					<p>{{ $message }}</p>
				</div>
				</div>
					</div>


			@endif

			@if ($message = Session::get('error'))
			<div class="row">
				<div class="col-lg-8 col-12"></div>
				<div class="col-lg-4 col-12">
				<div class="alert alert-danger">
					<p>{{ $message }}</p>
					</div>
				</div>
				</div>


			@endif

			@if ($errors->any())
			
				<div class="alert alert-danger">
					<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
			

			@endif
			
			<!--@include('layouts.internalmenu')-->
            <div class="row">
              <div class="col-lg-12">
					<table id="sampleassignlist-table" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
							<thead>
								<tr>
									<th>Sample ID</th>
									<th>Assign To</th>
									<th>Change To</th>
									<th>change</th>
								</tr>
							</thead>         
					</table>
              </div>
			</div>
				</div>
			</div>
          </div>        
        </div>
    </section>
</section>
    <!-- /.content -->
	<!-- Modal -->
	<div id="myModal" class="modal fade users-modal" role="dialog">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->

		<div class="modal-content">
			
        <div class="page-header">
		<h5 class="modal-title req-popup-title">Sample Detail</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        </div>
		<div class="modal-body">

		
		  <div class="modal-body popp-up-scroll style-scroll">
				<div id="showdetails"></div>
		  </div>
		 
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-gradient-danger btn-sm" data-dismiss="modal">Close</button>
		  </div>
</div>
	  </div>
	</div>

<script>

$.ajaxSetup({
headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$(document).on( "click",'.clickname', function() {
	$('#load').show();
	var dataid = $(this).attr('data-id');
	var url = '{{ route("sample.show", ":id") }}';
	url = url.replace(':id', dataid);
	// $('#load').show();
	event.preventDefault();
	$.ajax({
		url: url,
		type: 'GET',
		data:{dataid:dataid},
		success: function(result)
		{
			$('#showdetails').html(result);
			$('#load').hide();
		},
		error: function(data)
		{
			$('.alert-danger').show();
			$('.alert-danger').append('<p>Something went wrong. Try again !!</p>');	
				// $('#visit_form').trigger("reset");
				location.reload();
				$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#load').hide();
		}
	});
});

//multiple records delete ends
$("#sampleassignlist-table").DataTable({
		dom: "<'row m-2'<'col-sm-6 col-12 p-0 searchfilter'f><'col-sm-6 col-12 p-0'p>>r",
		processing: true,
		language: {processing: "<img style='width:100px; height:100px;position:fixed;top:50%;left:50%;transform: translate(-50%,-50%);' src='{{ asset('images/ajax-loader.gif') }}'/>"},
		serverSide: true,
		ajax:{
		   url: "{{ route('sampleassignment.index') }}",
		   error : function (jqXHR, textStatus, error) {
				if (jqXHR && jqXHR.status == 401) {
				  location.reload();
				}else if(jqXHR && jqXHR.status == 419) {
					location.reload();
				}else{
					// location.reload();
				}
			},
		},
		columns:[
			{
				data: 'sampleid',
				name: 'sampleid',
				orderable: false
			},
			{
				data: 'assignto',
				name: 'assignto',
				orderable: false
			},
			{
				data: 'changeto',
				name: 'changeto',
				orderable: false
			},
			{
				data: 'change',
				name: 'change',
				orderable: false
			},
		],
		responsive: true,
});

$(document).on( "click",'.changeuser', function() {
	$('#load').show();
	var sampleid = $(this).attr('data-sampleid');
	var userid = $('#user_select_'+sampleid).val();
	if(!userid || userid == '') {		
		$('#load').hide();
		alert('Select User to assign Sample!!');
		return false;
	}
	var url = '{{ route("sampleassignment.change") }}';
	// $('#load').show();
	event.preventDefault();
	$.ajax({
		url: url,
		type: 'POST',
		data:{sampleid:sampleid,userid:userid},
		success: function(result)
		{
			$('#alreadyassign_'+sampleid).html(result.username);
			$('#load').hide();
		},
		error: function(data)
		{
			$('.alert-danger').show();
			$('.alert-danger').append('<p>Something went wrong. Try again !!</p>');	
				// $('#visit_form').trigger("reset");
				// location.reload();
				$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#load').hide();
		}
	});
});
</script>
@endsection
