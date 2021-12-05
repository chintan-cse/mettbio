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
                </span> Update User </h3>
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
						<form id="edituser_form" name="createuserform" enctype="multipart/form-data" role="form">
						@csrf
						<div class="card">
						  <div class="card-body">
							<div class="row">
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>First Name : </label>
										<span>{{$userprofile->firstname}} </span>
									</div>
								</div>
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>Last Name : </label>
										<span>{{ $userprofile->lastname }}  </span>
									</div>
								</div>
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>Company name : </label>
										<span>{{$company->company_name}}</span>
									</div>
								</div>
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>Email : </label>								
										<span>{{$user->email}}</span>
									</div>
								</div>	
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>Phone Number : </label>
										<span>{{$userprofile->phone_number}}</span>
									</div>
								</div>								
							</div>
							<div class="row">
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>Role : </label>								
										<span>{{$role->role_name}}</span>
									</div>
								</div>								
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>City : </label>								
										<span>{{$userprofile->city}}</span>
									</div>
								</div>								
							</div>
							<div class="row">
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>State : </label>
										<span>{{$userprofile->state}}</span>
									</div>
								</div>
								<div class="col-lg-4 col-sm-12 col-12">
									<div class="input-group pop-label mb-3">
										<label>Country : </label>								
										<span>{{$userprofile->country}}</span>
									</div>
								</div>	
								<div class="col-lg-4 col-12">
									<div class="input-group pop-label mb-3">
											<label>Zipcode: </label>
											<span>{{$userprofile->zip}}</span>
									</div>
								</div>
								<div class="col-lg-12 col-12">
									<div class="input-group pop-label mb-3">
											<label>Address: </label>
											<span>{{$userprofile->address}}</span>
									</div>
								</div>							
							</div>
							<div class="row">
								
								<!--<div class="col-lg-4 col-12">
									<div class="input-group mb-3">
										<div class="form-group">
											<label class="field-label title-size">Discount (%)</label>
											<input type="text" autocomplete="off" name="user_discount" value="{{$userprofile->discount}}" class="form-control floatdigit" placeholder="Discount (%)">
										</div>
									</div>
								</div>	-->

								<div class="col-lg-4 col-sm-12 col-12">
								<label class="field-label  title-size">Password</label>
										<div class="input-group mb-3">
										  <input type="password" name="user_password" class="form-control" placeholder="Password"><br/>
										  <input type="button" class="btn btn-gradient-primary btn-sm" value="Generate" onClick="generate();" tabindex="2">
										  <div class="col-lg-12 p-0">
										  <div class="form-check form-check-success">
                              <label class="form-check-label">
                                <input type="checkbox" class="form-check-input"  id='check' name="showpassword" onChange="showpass();">Show password <i class="input-helper"></i><i class="input-helper"></i></label>
                            </div>
									</div>

							</div>
							<!-- <div class="row">
								
										</div> -->
									</div>									
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
								<button id="createuser" type="submit" class="btn btn-gradient-primary btn-sm">Update</button>
								<a class="btn btn-gradient-danger btn-sm" href="{{ route('users.index') }}" style="padding:8px 10px">Cancel</a>
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

// $('#createuserreset').on('click', function () {
	// $('#edituser_form').trigger("reset");
// });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#edituser_form').on('submit', function(event){
	var userid = {!! $user->id !!}
	$('#load').show();
	$('#createuser').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();
	var formData = new FormData($(this)[0]);
	formData.append('_method', 'PUT');
	var updateurl = '{{ route("users.update", ":id") }}';
	updateurl = updateurl.replace(':id', userid);
    $.ajax({
        url: updateurl,
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
				$('#load').hide();
				$('#createuser').show();
            }else{
				$('.alert-success').show();
                $('.alert-success').append('<p>'+result.success+'</p>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#load').hide();
				$('#createuser').show();
			}
        },
        error: function(data)
        {
            $('.alert-danger').show();
            $('.alert-danger').append('<p>Session Expired. Login again !!</p>');
            $("html, body").animate({ scrollTop: 0 }, "slow");
			$('#load').hide();
			location.reload();
			$('#createuser').show();
        }
    });

});
</script>
@endsection