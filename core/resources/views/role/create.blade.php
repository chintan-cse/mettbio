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
                </span> Create New Role </h3>
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
			<form id="createrole_form" name="createroleform" enctype="multipart/form-data" role="form">
			@csrf
            <div class="row">
              <div class="col-lg-12">
						  <div class="card-body">
							<div class="row">
								<div class="col-sm-12">
								<label  for="stylecat_select" class="field-label"> Role Name<span class="validrequire"> *</span></label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="role_name" placeholder="Role Name" required>
                                        </div>											
								</div>									
							</div>
						  </div>
						  <!-- /.card-body -->
              </div>
            </div>
			<div class="row">
              <div class="col-lg-12">
						  <div class="card-body">
							<h3 class="page-title">Role Permissions</h3>	
							<div class="row">
								@foreach($all_permissions as $single_permission) 
									@if($single_permission->parent_id == 0)										
										
										<div class="col-lg-6 col-sm-12 col-12 brdr-r">
											<div class="field-label">{{ $single_permission->name }}</div> 
											<div class="switch"><!----></div>
										<div class="row">
										@foreach($all_permissions as $sub_single_permission) 
											@if($single_permission->id == $sub_single_permission->parent_id)
											<div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:8px">
												<div class="form-group">
													<div class="switch" style="float:left; margin-right:5px;">
														<label>
														@php $checked = ""; @endphp
														
														<input name="permission" 
															id="{{ $sub_single_permission->id }}" 
															type="checkbox" 
															value="{{ $sub_single_permission->id }}" {{ $checked ?? '' }}>
														<span class="lever switch-col-blue"></span></label></div>
													<div class="demo-switch-title" style="font-size:14px;">{{ $sub_single_permission->name }}</div> 														
												</div>
											</div>
											@endif
										@endforeach		
										</div>	
										</div>				
									
									@endif
								@endforeach
							</div> 
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0 pt-3">
								<button id="createrole" type="submit" class="btn btn-gradient-primary btn-sm">Add</button>
							</div>
						  </div>
						  <!-- /.card-body -->
              </div>
            </div>
			</form>
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

$('#createrole_form input[type="checkbox"]').on('change',function(e){	
	perms_toogle = [
					{"8": ["9","10","47"]}, 
					{"11": ["12","13","48"]},
					{"17": ["18", "19", "27"]},
					{"20": ["21", "22", "35"]},
					{"36": ["37", "38", "46"]},
					{"23": ["24", "25"]},
					{"40": ["41", "42", "43"]},
					{"29": ["30", "31", "32"]},
				];
	this_perm_id = $(this).val();
	if(this.checked) {
		$.each(perms_toogle, function(key,value)
		{
			$.each(value, function(k, perms_arr){
				if(perms_arr.includes(this_perm_id)){
						$('#'+k).prop('checked', true);						
				}
			});
		});
	}
	else{
		$.each(perms_toogle, function(key,value)
		{
			$.each(value, function(k, perms_arr){
				if(this_perm_id == k) {
					$.each(perms_arr, function(m,n){
						if($('#' + n).is(":checked")) {
							$('#'+this_perm_id).prop('checked', true);
						}
					});
				}
			});
		});
	}
});

$('#createrole_form').on('submit', function(event){
	
	var new_permission = [];
    $.each($("input[name='permission']:checked"), function(){
		new_permission.push($(this).val());
    });
	
	$('#load').show();
	$('#createrole').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();
    var formData = new FormData($(this)[0]);
	formData.append('new_permission', new_permission);
    $.ajax({
        url: "{{ route('role.store') }}",
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
				// $('#createrole_form').trigger("reset");
				$('#load').hide();
				$('#createrole').show();
				
            }else{
				$('.alert-success').show();
                $('.alert-success').append('<p>'+result.success+'</p>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#createrole_form').trigger("reset");
				$('#load').hide();
				$('#createrole').show();
				setTimeout(function(){ 
					var redirect_url = '{{ route("role.index") }}';
					window.location.href = redirect_url;
				 }, 1000);	
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
			//$('#createrole_form').trigger("reset");
            $("html, body").animate({ scrollTop: 0 }, "slow");
			location.reload();
			$('#load').hide();
			$('#createrole').show();
        }
    });

});
</script>
@endsection
