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
                  <i class="mdi mdi-microsoft"></i>
                </span> Update Company </h3>             			            
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
						<form id="editcompany_form" name="editcompanyform" enctype="multipart/form-data" role="form">
						@csrf
						<div class="card">
						  <div class="card-body">
							<div class="row">
                                <div class="col-sm-6">
								<label class="field-label">Company Id<span class="validrequire"> *</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="companyid" class="form-control floatdigit" name="company_id" placeholder="Company Id *" value="{{ $company->company_id }}" required>
                                    </div>
								</div>
								<div class="col-sm-6">
								<label class="field-label">Company Name<span class="validrequire"> *</span></label>
                                    <div class="input-group mb-3">
                                    
                                        <input type="text" id="companyname" class="form-control" name="company_name" placeholder="Company Name *" value="{{ $company->company_name }}" required>
                                    </div>
								</div>								
							</div>
							<script>
							function validateMaxLength()
							{	
								var text = $(this).val();
								$(this).val(text.substr(0, 100)); 						
							}
							$('#companyid').keypress(validateMaxLength);
							$('#companyname').keypress(validateMaxLength);
							</script>

							<div class="row">								
								<div class="col-sm-6 col-12">
								<label class="field-label">Email</label>
										<div class="input-group mb-3">
										  <div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-envelope"></i></span>
										  </div>
										  <input type="email" class="form-control" name="email" placeholder="Email " value="{{ $company->email }}" >
										</div>
                                </div>

                                <div class="col-sm-6 col-12">
								<label class="field-label">Discount (%)<span class="validrequire"> </span></label>
									<!--<div class="input-group mb-3">-->
										<div class="form-group">
											<input  type="text" autocomplete="off" name="discount" class="form-control floatdigit" placeholder="Discount (%)" value="{{ number_format($company->discount, 2) }}">
										</div>
									<!--</div> -->
								</div>								
							</div>
							
							<!-- <div class="row">
								<div class="col-sm-6 col-12">
								<label class="field-label">Phone Number<span class="validrequire"> </span></label>
									<div class="form-group">
										<input  type="text" autocomplete="off" name="phone" placeholder="Phone Number" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
									</div>
								</div>								
							</div> -->
							

							<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
								<button id="editcompany" type="submit" class="btn btn-gradient-primary btn-sm">Update</button>
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

$('#editcompany_form').on('submit', function(event){
	$('#load').show();
	$('#editcompany').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();    
    var formData = new FormData($(this)[0]);
    formData.append('_method', 'PUT');
    $.ajax({
        url: "{{ route('company.update', $company->id) }}",
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
				$('#editcompany').show();
            }else{
				$('.alert-success').show();
                $('.alert-success').append('<p>'+result.success+'</p>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#load').hide();
				$('#editcompany').show();
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
				// $('#createcompany_form').trigger("reset");
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#load').hide();
				location.reload();
				$('#editcompany').show();
        	}
		}
    });

});
</script>
@endsection
