@extends('layouts.app')

@section('content')
<section class="main-content-section style-8">
	<!-- Main content -->
    <section class="content">
	  <div class="main-panel">
          <div class="content-wrapper">
            
            <div class="page-header">
				<h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-account"></i>
                </span> Edit Sample </h3>
			</div>
			<div class="row">
				<div class="col-lg-8 col-12"></div>
				<div class="col-lg-4 col-12">
			<div class="alert alert-success" style="display:none">
			</div>
			</div>	
				</div>	
				<div class="row">	
				<div class="col-lg-8 col-12"></div>
				<div class="col-lg-4 col-12">	
			<div class="alert alert-danger" style="display:none">
			</div>
				</div>
				</div>


            <div class="row ">
              <div class="col-lg-12">
						<form id="editsample_form" name="editsample" enctype="multipart/form-data" role="form">
						@csrf
						<div class="card">
						  <div class="card-body">												
							<div class="row">
								<div class="col-sm-8 col-12">
									<label class="field-label">NABL / Non NABL<span class="validrequire"> *</span></label>
									<div class="input-group mb-3">
										<label class="radio-inline">
											<input type="radio" id="nabl" name="nabl_value" value="nabl" 
												@if($sample->nabl_status) checked @endif
											>NABL
										</label>
										<label class="radio-inline">
											<input type="radio" id="nonnabl" name="nabl_value" value="nonnabl" @if(!$sample->nabl_status) checked @endif>Non NABL
										</label>
									</div>
								</div>							
							</div>
							
							<div class="card p-2 pt-3">
								<div class="row datebox-title">
									<div class="col-lg-3 col-md-3 col-sm-3 col-12"> <label>Select Test Type</label></div>
								</div>
								<div class="row dateaddbox">
									<div class="col-lg-12 col-sm-12 col-12">
										<div class="row">
											<div class="col-lg-3 col-sm-3 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<select id="testtype_select" class="form-control select2" name="testtype_id" style="width: 100%;" required>
															<option value="" selected="selected">Select Test Type</option>
															@if (isset($testtype))
																@foreach ($testtype as $value)
																	@if($sample->testtype_id == $value->id)
																		<option value="{{ $value->id }}" selected>{{ $value->typename }}</option>
																	@else
																		<option value="{{ $value->id }}">{{ $value->typename }}</option>
																	@endif
																@endforeach
															@endif
														</select>
													</div>
												</div>
											</div>								
											<div class="col-lg-3 col-sm-3 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<select id="testtypemethod_select" class="form-control select2" name="testtypemethod_id" style="width: 100%;" required>
															<option value="" selected="selected">Select Test Type Method</option>
															@if (isset($testtypemethod))
																@foreach ($testtypemethod as $value)
																	@if($sample->testtypemethod_id == $value->id)
																		<option value="{{ $value->id }}" selected>{{ $value->methodname }}</option>
																	@else
																		<option value="{{ $value->id }}">{{ $value->methodname }}</option>
																	@endif
																@endforeach
															@endif
														</select>
													</div>
												</div>
											</div>									
											<div class="col-lg-3 col-sm-3 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<select id="testtypesubmethod_select" class="form-control select2" name="testtypesubmethod_id" style="width: 100%;">
															<option value="" selected="selected">Select Test Type Sub Method</option>
															@if (isset($testtypesubmethod))
																@foreach ($testtypesubmethod as $value)
																	@if($sample->testtypesubmethod_id == $value->id)
																		<option value="{{ $value->id }}" selected>{{ $value->submethodname }}</option>
																	@else
																		<option value="{{ $value->id }}">{{ $value->submethodname }}</option>
																	@endif
																@endforeach
															@endif
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							
							<div class="card p-2 pt-3">
								<div class="row datebox-title">
									<div class="col-lg-3 col-md-3 col-sm-3 col-12"> <label>Client Details</label></div>
								</div>
								<div class="row dateaddbox">
									<div class="col-lg-12 col-sm-12 col-12">
										<div class="row">
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Client Name*</label>
														<input  type="text" autocomplete="off"  name="clientname" class="form-control" placeholder="Client Name" value="@if($sample->client_name != "") {{$sample->client_name}} @endif" required>
													</div>
												</div>
											</div>								
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Contact Number*</label>
														<input  type="text" autocomplete="off"  name="contactnumber" class="form-control floatdigit" placeholder="Contact Number" value="@if($sample->client_contact != "") {{$sample->client_contact}} @endif" required>
													</div>
												</div>
											</div>									
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Client Email*</label>
														<input  type="email" autocomplete="off"  name="clientemail" class="form-control" placeholder="Client Email" value="@if($sample->client_mail != "") {{$sample->client_mail}} @endif" required>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-8 col-sm-8 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Client Address*</label>
														<textarea class="form-control" name="clientaddress"  placeholder="Enter  Address..."required>@if($sample->client_address != "") {{$sample->client_address}} @endif
														</textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-8 col-sm-8 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Sub Vendor</label>
														<input  type="text" autocomplete="off"  name="subvendor" class="form-control" placeholder="Subvendor" value="@if($sample->client_subvendor != "") {{$sample->client_subvendor}} @endif">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="card p-2 pt-3">
								<div class="row datebox-title">
									<div class="col-lg-3 col-md-3 col-sm-3 col-12"> <label>Product Details</label></div>
								</div>
								<div class="row dateaddbox">
									<div class="col-lg-12 col-sm-12 col-12">
										<div class="row">
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Product Name*</label>
														<input  type="text" autocomplete="off"  name="productname" class="form-control" placeholder="Product Name" value="@if($sample->product_name != "") {{$sample->product_name}} @endif" required>
													</div>
												</div>
											</div>								
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Product Material*</label>
														<input  type="text" autocomplete="off"  name="productmaterial" class="form-control" placeholder="Product Material" value="@if($sample->product_material != "") {{$sample->product_material}} @endif" required>
													</div>
												</div>
											</div>									
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Product Type*</label>
														<input  type="text" autocomplete="off"  name="producttype" class="form-control" placeholder="Product Type" value="@if($sample->product_type != "") {{$sample->product_type}} @endif" required>
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Product BatchNo*</label>
														<input  type="text" autocomplete="off"  name="productbatchno" class="form-control" placeholder="Product Batch No" value="@if($sample->product_batchno != "") {{$sample->product_batchno}} @endif" required>
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Product HeatNo*</label>
														<input  type="text" autocomplete="off"  name="productheatno" class="form-control" placeholder="Product Heat No" value="@if($sample->product_heatno != "") {{$sample->product_heatno}} @endif" required>
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-sm-4 col-12">
												<div class="form-group">											
													<div class="select2-purple">
														<label>Product Client Name*</label>
														<input  type="text" autocomplete="off"  name="productclientname" class="form-control" placeholder="Product Client Name" value="@if($sample->product_clientname != "") {{$sample->product_clientname}} @endif" required>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card p-2 mb-3 mt-2 row">
								<div class="col-sm-8 col-12">
									<label class="field-label">Required Report Date<span class="validrequire"> *</span></label>
									<input  type="text" autocomplete="off" class="form-control float-right datepicker" id="reportdate" name="reportdate" value="@if($sample->required_report_date != "") {{date('d/m/yy',strtotime($sample->required_report_date))}} @endif" autocomplete="off" >
								</div>							
							</div>
							<div class="card p-2 mb-3 mt-2">
								<div class="row datebox-title">
									<div class="col-lg-12 col-12"> 
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="return_status"  class="cls_return_status" id="return_status" @if($sample->return_status != "") checked @endif>
											<label for="return_status">Return</label>
										</div>
									</div>
								</div>
								<div class="row dateaddbox" id="returnbox" @if($sample->return_status != "") style="display:block;" @else style="display:none;" @endif>
									
									<div class="col-lg-4 col-12">  
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="same_client_address"  class="same_client_address" id="same_client_address" @if($sample->return_same_client != "") checked @endif>
											<label for="same_client_address">Same As Client</label>
										</div>
									</div>
									<div class="col-lg-8 col-12">  
										<label>Address</label>
										<div class="input-group">
											<textarea class="form-control" name="returnaddress"  placeholder="Enter  Address...">@if($sample->return_client_address != "") {{$sample->return_client_address}} @endif</textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
								<button id="createsample" type="submit" class="btn btn-gradient-primary btn-sm">Add</button>
								<button id="createsamplereset" type="button" class="btn btn-gradient-info btn-sm">Reset</button>
							</div>

						  </div>
						  <!-- /.card-body -->
						
						</div>
						</form>
              </div>
            </div>
          </div>
        
        </div>

    </section>
</section>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#return_status').change(function() {
	if(this.checked) {
		$("#returnbox").css('display','inherit');
	}
	else{
		$("#returnbox").css('display','none');
	}
	
});


$('#testtype_select').change(function() {
	$('#load').show();
    $.ajax({
        type:"GET",
        url : "{{route('sample.gettypemethods')}}",
        data:{testtypeid:$(this).val()},
		datatype: 'JSON',
        success : function(response) {
            var select = $('#testtypemethod_select');
            var subselect = $('#testtypesubmethod_select');
			select.empty();
			subselect.empty();
			select.append($('<option value="" >Select Test Type Method</option>'));
			subselect.append($('<option value="" >Select Test Type Sub Method</option>'));
			$.each(response.testtypemethods, function(index, value) {          
				select.append(
						$('<option value="'+value.id+'">'+value.methodname+'</option>')
					);
			});
			$('#load').hide();
        },
        error: function() {
            alert('Error occured');
			$('#load').hide();
        }
    });
});

$('#testtypemethod_select').change(function() {
	$('#load').show();
    $.ajax({
        type:"GET",
        url : "{{route('sample.gettypesubmethods')}}",
        data:{testtypemethodid:$(this).val()},
		datatype: 'JSON',
        success : function(response) {
            var select = $('#testtypesubmethod_select');
			select.empty();
			select.append($('<option value="" >Select Test Type Sub Method</option>'));
			$.each(response.testtypesubmethods, function(index, value) {          
				select.append(
						$('<option value="'+value.id+'">'+value.submethodname+'</option>')
					);
			});
			$('#load').hide();
        },
        error: function() {
            alert('Error occured');
			$('#load').hide();
        }
    });
});

$('#editsample_form').on('submit', function(event){
	$('#load').show();
	$('#editoversize').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();
    var formData = new FormData($(this)[0]);
	formData.append('_method', 'PUT');
    $.ajax({
        url: "{{ route('sample.update',$sample->id) }}",
		type: 'POST',
		dataType:'JSON',
		contentType: false,
		cache: false,
		processData: false,
        data: formData,
        success: function(result)
        {
            if ((result.errors)) {
				$.each(result.errors, function(key, value){
                  	$('.alert-danger').show();
                  	$('.alert-danger').append('<p>'+value+'</p>');					
                });
				$("html, body").animate({ scrollTop: 0 }, "slow");
				// $('#editsample_form').trigger("reset");
				$('#load').hide();
				$('#editoversize').show();
            }else{
				$('.alert-success').show();
                $('.alert-success').append('<p>'+result.success+'</p>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$("#editoversize").prop('disabled', false);
				// window.location.href = "{{ route('sample.edit',$sample->id) }}";
				$('#load').hide();
				$('#editoversize').show();
			}
        },
		error: function(jqXHR, textStatus, error)
			{
				if (jqXHR && jqXHR.status == 401) {
						$('.alert-danger').show();
						$('.alert-danger').append('<p>Session Expired. Login again !!</p>');
						$('#load').hide();
						// location.reload();
				}else if(jqXHR && jqXHR.status == 419) {
						$('.alert-danger').show();
						$('.alert-danger').append('<p>Session Expired. Login again !!</p>');
						$('#load').hide();
						// location.reload();
				}else {
						$('.alert-danger').show();
						$('.alert-danger').append('<p>Session Expired. Login again !!</p>');	
						// $('#editsample_form').trigger("reset");
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('#load').hide();
						// location.reload();
						$('#editoversize').show();
				}
			},
    });

});
</script>
@endsection