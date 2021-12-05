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
                </span> Add Company </h3>             			            
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
						<form id="createcompany_form" name="createcompanyform" enctype="multipart/form-data" role="form">
						@csrf
						<div class="card">
						  <div class="card-body">
							<div class="row">
                                <div class="col-sm-6">
								<label class="field-label">Company Id<span class="validrequire"> *</span></label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="companyid" class="form-control floatdigit" name="company_id" placeholder="Company Id *" required maxlength="6">
                                    </div>
								</div>
								<div class="col-sm-6">
								<label class="field-label">Company Name<span class="validrequire"> *</span></label>
                                    <div class="input-group mb-3">
                                    
                                        <input type="text" id="companyname" class="form-control" name="company_name" placeholder="Company Name *" required maxlength="50">
                                    </div>
								</div>								
							</div>
							<script>
							function validateMaxLengthCI()
							{	
								var text = $(this).val();
								$(this).val(text.substr(0, 6)); 						
							}
							function validateMaxLengthCN()
							{	
								var text = $(this).val();
								$(this).val(text.substr(0, 50)); 						
							}
							$('#companyid').keypress(validateMaxLengthCI);
							$('#companyname').keypress(validateMaxLengthCN);
							</script>

							<div class="row">								
								<div class="col-sm-6 col-12">
								<label class="field-label">Email</label>
										<div class="input-group mb-3">
										  <div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-envelope"></i></span>
										  </div>
										  <input type="email" class="form-control" name="email" placeholder="Email">
										</div>
                                </div>

                                <div class="col-sm-6 col-12">
								<label class="field-label">Discount (%)<span class="validrequire"> </span></label>
									<!--<div class="input-group mb-3">-->
										<div class="form-group">
											<input  type="text" autocomplete="off" name="discount" class="form-control floatdigit" placeholder="Discount (%)" value="0"  maxlength="5">
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
								<button id="createcompany" type="submit" class="btn btn-gradient-primary btn-sm">Add</button>
								<button id="createcompanyreset" type="button" class="btn btn-gradient-info btn-sm">Reset</button>
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
$("input[name='discount']").on('keyup', function(e){
	if(parseFloat(this.value)>100)
	{
		value = this.value;
		this.value = value.substr(0,value.length-1);
	}
});

$('#createcompanyreset').on('click', function () {
	$('#createcompany_form').trigger("reset");
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#createcompany_form').on('submit', function(event){
	$('#load').show();
	$('#createcompany').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: "{{ route('company.store') }}",
        type: 'POST',
		dataType:'JSON',
		contentType: false,
		cache: false,
		processData: false,
        data: new FormData(this),
        success: function(result)
        {
            if ((result.errors)) {
				$.each(result.errors, function(key, value){
                  	$('.alert-danger').show();
                  	$('.alert-danger').append('<p>'+value+'</p>');					
                });
				$("html, body").animate({ scrollTop: 0 }, "slow");
				// $('#createcompany_form').trigger("reset");
				$('#load').hide();
				$('#createcompany').show();
            }else{
				$('.alert-success').show();
                $('.alert-success').append('<p>'+result.success+'</p>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#createcompany_form').trigger("reset");
				$('#load').hide();
				$('#createcompany').show();
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
				$('#createcompany').show();
        	}
		}
    });

});
</script>
@endsection
