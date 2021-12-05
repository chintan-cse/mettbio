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
                </span> Role Permissions : {{ $role->role_name }}</h3>
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
														@if( in_array($sub_single_permission->id, $role_permissions) ) 
															@php $checked = "checked"; @endphp
														@endif
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
								<button id="saverole" type="submit" class="btn btn-gradient-success mr-2 btn-sm">Save</button>
								<a class="btn btn-gradient-danger btn-sm" href="{{ route('role.index') }}">Back</a>
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
	
	$('#load').show();
	$('#saverole').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
   event.preventDefault();
    var formData = new FormData();
	formData.append('id', {{ $role->id }})
	formData.append('new_permission', new_permission);
    $.ajax({
        url: "{{ route('role.permission') }}",
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
			$('.alert-danger').show();
			$('.alert-danger').append('<p>'+data.responseJSON.message+'</p>');	
			if ((data.responseJSON.errors)) {
				$.each(data.responseJSON.errors, function(key, value){    
                  	$('.alert-danger').append('<p>'+value+'</p>');					
				});
			}
			//$('#saverole_form').trigger("reset");
			location.reload();
            $("html, body").animate({ scrollTop: 0 }, "slow");
			$('#load').hide();
			$('#saverole').show();
        }
    });

});

$('#saverole_form input[type="checkbox"]').on('change',function(e){	
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
</script>
@endsection
