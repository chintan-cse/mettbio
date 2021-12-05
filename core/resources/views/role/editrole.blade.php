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
                <i class="mdi mdi-directions"></i>
                </span> Update Rolename</h3>
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
            <div class="row">
              <div class="col-lg-12">
						<form id="saverole_form" name="saveroleform" enctype="multipart/form-data" role="form">
						@csrf
						  <div class="card-body">														
							<div class="row">
                                <div class="col-sm-12 col-12">
                                    <label  for="stylecat_select" class="field-label">Role Name<span class="validrequire"> *</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="role_name" placeholder="Name" value="{{$role->role_name}}" required>
                                    </div>
								</div>
							</div> 
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
								<button id="saverole" type="submit" class="btn btn-gradient-success mr-2 btn-sm">Update</button>
							</div>
						  </div>
						  <!-- /.card-body -->						
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

$('#saverole_form').on('submit', function(event){

	var new_permission = [];
    $.each($("input[name='permission']:checked"), function(){
		new_permission.push($(this).val());
    });
	console.log(new_permission);
	
	$('#load').show();
	$('#saverole').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
   event.preventDefault();
   var formData = new FormData($(this)[0]);	
   formData.append('_method', 'PUT');
    $.ajax({
        url: "{{ route('role.update', $role->id) }}",
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
				// $('#saverole_form').trigger("reset");
				$('#load').hide();
				$('#saverole').show();
            }else{
				$('.alert-success').show();
                $('.alert-success').append('<p>'+result.success+'</p>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				//$('#saverole_form').trigger("reset");
				$('#load').hide();
				$('#saverole').show();
			}
        },
        error: function(data)
        {
			console.log(data.responseJSON);			
            $('.alert-danger').show();
			$('.alert-danger').append('<p>'+data.responseJSON.message+'</p>');	
			if ((data.responseJSON.errors)) {
				$.each(data.responseJSON.errors, function(key, value){    
                  	$('.alert-danger').append('<p>'+value+'</p>');					
				});
			}
			//$('#saverole_form').trigger("reset");
            $("html, body").animate({ scrollTop: 0 }, "slow");
			location.reload();
			$('#load').hide();
			$('#saverole').show();
        }
    });

});
</script>
@endsection
