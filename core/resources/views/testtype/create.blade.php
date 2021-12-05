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
                </span> Add Test Type Methods </h3>
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
						<form id="createtesttype_form" name="createtesttypem" enctype="multipart/form-data" role="form">
						@csrf
						<div class="card">
						  <div class="card-body">												
							<div class="row">
								<div class="col-sm-8 col-12">
									<label class="field-label">Type Name<span class="validrequire"> *</span></label>
									<div class="input-group mb-3">
										<input type="text" id="typename" class="form-control" name="testtypename" placeholder="Type Name *" required>
									</div>
								</div>							
							</div>
							
							<div class="card p-2 pt-3" id="addmethod">
								<div class="row datebox-title">
									<div class="col-lg-3 col-md-3 col-sm-3 col-12"> <label>Method Name </label></div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-12"> <label> Select Template </label> </div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-12"> <label> Exposure time </label> </div>
									<div class="col-lg-1 col-md-1 col-sm-1 col-12 p-0">  <label>Add new </label></div>
								</div>

								<div class="row dateaddbox">
									<div class="col-lg-12 col-sm-12 col-12">
										<div class="row">
											<div class="col-lg-3 col-sm-3 col-12">
												<div class="form-group">
											
														<div class="select2-purple">
															<input type="text" id="methodname" class="form-control" name="testtype[0][methodname]" placeholder="Method Name *" required>
														</div>
												</div>
											</div>								
											<div class="col-lg-3 col-sm-3 col-12">
												<div class="form-group">
													
														<div class="select2-purple">
															<select class="form-control select2"  name="testtype[0][templateid]" style="width: 100%;" id="templateid_0" required>
																<option value="" selected="selected">Select Template</option>
																@if (isset($templatelist))
																	@foreach ($templatelist as $value)
																		<option value="{{ $value->id }}">{{ $value->templatename }}</option>
																	@endforeach
																@endif
															</select>
														</div>
												</div>
											</div>									
											<div class="col-lg-3 col-sm-3 col-12">
												<div class="form-group">													
													<div class="select2-purple">
														<input type="text" id="exposuretime" class="form-control" name="testtype[0][exposuretime]" placeholder="Exposure Time">
													</div>
												</div>
											</div>
											<div class="col-lg-1 col-sm-4 col-12">
												<span class="btn btn-success add-method" id="add-method" data-toggle="tooltip" data-placement="top" title="Add More"><i class="fas fa-plus"></i></span> 
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-sm-12 col-12">
										<div class="card p-2 pt-3" id="addsubmethod_0">
											<div class="row datebox-title">
												<div class="col-lg-3 col-md-3 col-sm-3 col-12"> <label>Sub Method Name </label></div>
												<div class="col-lg-1 col-md-1 col-sm-1 col-12 p-0">  <span class="btn btn-success add-submethod" id="add-submethod" data-value="0" data-toggle="tooltip" data-placement="top" title="Add More"><i class="fas fa-plus"></i></span></div>
											</div>								
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
								<button id="createtype" type="submit" class="btn btn-gradient-primary btn-sm">Add</button>
								<button id="createtypereset" type="button" class="btn btn-gradient-info btn-sm">Reset</button>
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
var row=1;
var subrow=1;
$(document).on("click", ".add-method", function () {
	var new_row = '<div class="row dateaddbox"><div class="col-lg-12 col-sm-12 col-12"><div class="row"><div class="col-lg-3 col-sm-3 col-12"><div class="form-group"><div class="select2-purple"><input type="text" id="methodname" class="form-control" name="testtype['+row+'][methodname]" placeholder="Method Name *" required></div></div></div><div class="col-lg-3 col-sm-3 col-12"><div class="form-group"><div class="select2-purple"><select class="form-control select2" name="testtype['+row+'][templateid]" style="width: 100%;" id="templateid_0" required><option value="" selected="selected">Select Template</option>@if (isset($templatelist))@foreach ($templatelist as $value)<option value="{{$value->id}}">{{$value->templatename}}</option>@endforeach @endif</select></div></div></div><div class="col-lg-3 col-sm-3 col-12"><div class="form-group"><div class="select2-purple"><input type="text" id="exposuretime" class="form-control" name="testtype['+row+'][exposuretime]" placeholder="Exposure Time"></div></div></div><div class="col-lg-1 col-sm-4 col-12"><span class="delete-row btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Remove"><i class="fas fa-trash-alt"></i></span> </div></div></div><div class="col-lg-12 col-sm-12 col-12"><div class="card p-2 pt-3" id="addsubmethod_'+row+'"><div class="row datebox-title"><div class="col-lg-3 col-md-3 col-sm-3 col-12"> <label>Sub Method Name </label></div><div class="col-lg-1 col-md-1 col-sm-1 col-12 p-0"> <span class="btn btn-success add-submethod" id="add-submethod" data-value="'+row+'" data-toggle="tooltip" data-placement="top" title="Add More"><i class="fas fa-plus"></i></span></div></div></div></div></div>';

	$('#addmethod').append(new_row);
	$('.select2-'+row+'').select2();
	row++;
	return false;
});

$(document).on("click", ".delete-row", function () {
	//  alert("deleting row#"+row);
	if(row>1) {
		$(this).closest('.dateaddbox').remove();
	}
	return false;
});

$(document).on("click", ".add-submethod", function () {
	var appenddiv = $(this).data('value');
	var new_row = '<div class="row datesubaddbox"><div class="col-lg-3 col-sm-3 col-12">	<div class="form-group">		<div class="select2-purple">	<input type="text" id="submethodname" class="form-control" name="testtype['+appenddiv+'][method]['+subrow+'][submethodname]" placeholder="Sub Method Name *" required>	</div>	</div>	</div><div class="col-lg-1 col-sm-3 col-12 p-0">	<span class="delete-subrow btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Remove"><i class="fas fa-trash-alt"></i></span> 	</div></div>';

	$('#addsubmethod_'+appenddiv+'').append(new_row);
	subrow++;
	return false;
});

$(document).on("click", ".delete-subrow", function () {
	if(subrow>0) {
		$(this).closest('.datesubaddbox').remove();
	}
	return false;
});
$('#createuserreset').on('click', function () {
	$('#createuser_form').trigger("reset");
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#createtesttype_form').on('submit', function(event){
	$('#load').show();
	$('#createtype').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();
    var formData = new FormData($(this)[0]);
	formData.append('company_id', $('#company_select').val());
	formData.append('company_name',$('#company_select option:selected').text());
    $.ajax({
        url: "{{ route('testtype.store') }}",
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
				// $('#createtesttype_form').trigger("reset");
				$('#load').hide();
				$('#createtype').show();
            }else{
				$('.alert-success').show();
                $('.alert-success').append('<p>'+result.success+'</p>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#createtesttype_form').trigger("reset");
				$('#load').hide();
				$('#createtype').show();
			}
        },
        error: function(jqXHR, textStatus, error)
        {
			if (jqXHR && jqXHR.status == 401) {
				$('.alert-danger').show();
				$('.alert-danger').append('<p>Session Expired. Login again !!</p>');
				$('#load').hide();
				location.reload();
			}else if(jqXHR && jqXHR.status == 419) {
				$('.alert-danger').show();
				$('.alert-danger').append('<p>Session Expired. Login again !!</p>');
				$('#load').hide();
				location.reload();
			}else {
				$('.alert-danger').show();
				$('.alert-danger').append('<p>Session Expired. Login again !!</p>');
				// $('#createtesttype_form').trigger("reset");
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#load').hide();
				location.reload();
				$('#createtype').show();
        	}
		}
    });

});
</script>
@endsection
