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
                </span> Add User </h3>
              <!--<nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <a class="btn btn-gradient-primary btn-sm" href="{{ route('users.index') }}"> Back</a>
                  </li>
                </ul>
              </nav>-->				            
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
						<form id="createuser_form" name="createuserform" enctype="multipart/form-data" role="form">
						@csrf
						<div class="card">
						  <div class="card-body">												
							<div class="row">
								<div class="col-sm-4 col-12">
								<label class="field-label">First Name<span class="validrequire"> *</span></label>
									<div class="input-group mb-3">
										<input type="text" id="userfirstname" class="form-control" name="user_firstname" placeholder="First Name *">
								</div>
								</div>
								<div class="col-sm-4 col-12">
								<label class="field-label">Last Name<span class="validrequire"> *</span></label>
									<div class="input-group mb-3">
										<input type="text" id="userlastname" class="form-control" name="user_lastname" placeholder="Last Name *">
									</div>
								</div>
								<div class="col-sm-4 col-12">
									<label class="field-label">Email<span class="validrequire"> *</span></label>
										<div class="input-group mb-3">
										  <div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-envelope"></i></span>
										  </div>
										  <input type="email" class="form-control" name="user_email" placeholder="Email *">
										</div>
									</div>								
							</div>
							<!-- <div class="row">
									
							</div> -->
							
							<div class="row">
									<div class="col-sm-6 col-12">
									<label class="field-label">Password<span class="validrequire"> *</span></label>
										<div class="input-group mb-3">
										  	<input type="password" name="user_password" class="form-control" placeholder="Password*"><br/>
										  	<input type="button" class="btn btn-gradient-primary btn-sm" value="Generate" onClick="generate();" tabindex="2">
										  	<div class="col-lg-12 p-0">
												<div class="form-check form-check-success">
													<label class="form-check-label">
														<input type="checkbox" class="form-check-input"  id='check' name="showpassword" onChange="showpass();">Show password <i class="input-helper"></i><i class="input-helper"></i>
													</label>
												</div>
											</div>
										</div>
									</div>	
									<div class="col-sm-6 col-12">
										<label class="field-label">Phone Number<span class="validrequire"> </span></label>
										<div class="form-group">
											<input  type="text" autocomplete="off" name="user_number" placeholder="Phone Number" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
										</div>
									</div>								
							</div>
							<div class="row">
								<!--<div class="col-lg-2 col-12">
								<label class="field-label">Discount (%)<span class="validrequire"> </span></label>
									<div class="input-group mb-3">
										<div class="form-group">
										
									
											<input  type="text" autocomplete="off" name="user_discount" class="form-control floatdigit" placeholder="Discount (%)">
										</div>
									</div>
								</div>-->
								
																
							</div>
							<div class="row">
								
								<div class="col-lg-12 col-12">
								<label class="field-label">Address<span class="validrequire"> </span></label>
									<div class="form-group">
										
									
										<textarea class="form-control" rows="4" name="address"  placeholder="Address..."></textarea>
									</div>
								</div>
								<div class="col-sm-3 col-12">
								<label class="field-label">City<span class="validrequire"> </span></label>
									<div class="input-group mb-3">
									
										<input type="text" id="city" class="form-control" name="user_city" placeholder="City">
									</div>
								</div>
								<div class="col-sm-3 col-12">
								<label class="field-label">State<span class="validrequire"> </span></label>
									<div class="input-group mb-3">
										<input type="text" id="state" class="form-control" name="user_state" placeholder="State">
									</div>
								</div>
								<div class="col-sm-3 col-12">
								<label class="field-label">Country<span class="validrequire"> </span></label>
									<div class="input-group mb-3">
										<input type="text" id="country" class="form-control" name="user_country" placeholder="Country">
									</div>
								</div>
								<div class="col-sm-3 col-12">
								<label class="field-label">Zipcode<span class="validrequire"></span></label>
									<div class="input-group mb-3">
										<input type="text" id="zip" class="form-control" name="user_zip" placeholder="Zipcode">
									</div>
								</div>	
								
								@auth
								@if(Auth::user()->role != 3 && Auth::user()->role != 4)
								<div class="col-sm-6">
									<div class="form-group">
									<label class="field-label">Company Name<span class="validrequire"> *</span></label>
										<select id="company_select" class="form-control select2" name="user_name" >
											<option value="" selected="selected">Select Company</option>
											@if (isset($company))
												@foreach ($company as $value)
													<option value="{{ $value->id }}">{{ $value->company_name }}</option>
													@endforeach
											@endif
										</select>
									</div>			
								</div>								
								<div class="col-sm-6">
									<div class="form-group">
									<label class="field-label">Role<span class="validrequire"> *</span></label>
										<select id="role_select" class="form-control select2" name="role" >
											<option value="" selected="selected">Select Role</option>
											<?php /*
											@if (isset($role))
												@foreach ($role as $value)
													<option value="{{ $value->id }}">{{ $value->role_name }}</option>
													@endforeach
											@endif */ ?>
										</select>
									</div>			
								</div>	
								@endif	
								@endauth						
							</div>
							
							

							<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
								<button id="createuser" type="submit" class="btn btn-gradient-primary btn-sm">Add</button>
								<button id="createuserreset" type="button" class="btn btn-gradient-info btn-sm">Reset</button>
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
function showpass(){
    	document.createuserform.elements['showpassword'].checked ? document.createuserform.elements['user_password'].setAttribute("type", "text") : document.createuserform.elements['user_password'].setAttribute("type", "password");
    };
function randomPassword(length) {
    var charsonly = "abcdefghijklmnopqrstuvwxyz";
	var capcharsonly = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var numcharsonly = "1234567890";
	var specialcharsonly = "!@#$%^&*()-+<>";
    var pass = "";
    for (var x = 0; x < 4; x++) {
        var i = Math.floor(Math.random() * charsonly.length);
        pass += charsonly.charAt(i);
    }
	for (var x = 0; x < 4; x++) {
        var i = Math.floor(Math.random() * capcharsonly.length);
        pass += capcharsonly.charAt(i);
    }
	for (var x = 0; x < 3; x++) {
        var i = Math.floor(Math.random() * numcharsonly.length);
        pass += numcharsonly.charAt(i);
    }
	for (var x = 0; x < 4; x++) {
        var i = Math.floor(Math.random() * specialcharsonly.length);
        pass += specialcharsonly.charAt(i);
    }
    return pass;
}

function generate() {
    createuserform.user_password.value = randomPassword(10);
}

$('#createuserreset').on('click', function () {
	$('#createuser_form').trigger("reset");
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#company_select').on('change', function(){
	
	company_id = $('#company_select').val();
	$.ajax({
        url: "{{ route('getrolebycompanyid') }}",
        type: 'GET',
		dataType:'JSON',
		data:{company_id:company_id},
		success: function(result){
			$('#role_select').html("<option value='' selected='selected'>Select Role</option>");
			$.each(result, function (key, value){					
				$('#role_select').append('<option value='+key+'>'+ value +'</option>');
			});
		},
		
	});


});
$('#createuser_form').on('submit', function(event){
	$('#load').show();
	$('#createuser').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();
    var formData = new FormData($(this)[0]);
	formData.append('company_id', $('#company_select').val());
	formData.append('company_name',$('#company_select option:selected').text());
    $.ajax({
        url: "{{ route('users.store') }}",
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
				// $('#createuser_form').trigger("reset");
				$('#load').hide();
				$('#createuser').show();
            }else{
				$('.alert-success').show();
                $('.alert-success').append('<p>'+result.success+'</p>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#createuser_form').trigger("reset");
				showpass();
				$('#load').hide();
				$('#createuser').show();
			}
        },
        error: function(data)
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
				// $('#createuser_form').trigger("reset");
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#load').hide();
				location.reload();
				$('#createuser').show();
        	}
		}
    });

});
</script>
@endsection
