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
                </span> Test Certification </h3>
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
					<div class="card">
						<div class="card-body">												
							<div class="row">
							<div class="col-sm-8 col-12">
								<div class="form-group">											
									<div class="select2-purple">
									<label class="field-label">Select Sample<span class="validrequire"> *</span></label>
										<select id="testcert_sample_id" class="form-control select2" name="testcert_sample_id" style="width: 100%;" required>
											<option value="" selected="selected">Select Sample</option>
											@if (isset($sample))
												@foreach ($sample as $value)
													<option value="{{ $value->id }}">{{ $value->sampleid }}</option>
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
            </div>
			
			<div class="row ">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div id="datewisevalues"></div>
						</div>
					</div>
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

$('#testcert_sample_id').on('change', function(event){
	var sampleid = $(this).val();
	if(!sampleid || sampleid == "") {
		alert('Select Sample first!');
		return false;
	}
	$('#load').show();
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();
    $.ajax({
		type: 'GET',
        url: "{{ route('testcertification.afterselectsample') }}",
        data: {sampleid:sampleid},
        success: function(result)
        {
            if ((result.errors)) {
				$.each(result.errors, function(key, value){
                  	$('.alert-danger').show();
                  	$('.alert-danger').append('<p>'+value+'</p>');					
                });
				$("html, body").animate({ scrollTop: 0 }, "slow");
				// $('#generatetestcert_form').trigger("reset");
				$('#load').hide();
				$('#generatetest').show();
            }else{
				$("#datewisevalues" ).empty();
				$('#datewisevalues').html(result);
				$('#load').hide();
				$('#generatetest').show();
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
				// $('#createtesttype_form').trigger("reset");
				$("html, body").animate({ scrollTop: 0 }, "slow");
				$('#load').hide();
				// location.reload();
				$('#generatetest').show();
        	}
		}
    });

});
</script>
@endsection