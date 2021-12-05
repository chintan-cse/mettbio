<form id="generatetestcert_form" name="generatetestcert" enctype="multipart/form-data" role="form">
						@csrf
					<input type="hidden" name="testcert_sample_id" value="{{$sample->id}}">
					<div class="card">
						<div class="card-body">
							<div class="card p-2 pt-3" id="addbeforeimagebox">
								<div class="row datebox-title" >
									<div class="col-lg-10 col-12"> <label>Upload Sample Image before Testing </label>( <span class="upload-format">Please upload Image in JPG,PNG format only with max 5MB size.</span>)</div>
									<div class="col-lg-2 col-12"> <label>  </label> </div>
								</div>
								<div class="row dateaddbox">
									<div class="col-lg-4 col-sm-4 col-12">  
										<div class="form-group">
											<div class="input-group">
												<div class="custom-file">
													<div class="button-wrap">
														<input type="file" value="sampleimage_beforetesting_0"  name="sampleimage_beforetesting[]" id="sampleimage_beforetesting_0" data-index = "0" onchange="previewFile(this,0);"> 
														<label for="sampleimage_beforetesting_0"></label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-sm-4 col-12">
										<img id="imagepreview_0" src="#" alt="Image Preview" style="width: 200px;height: 200px;"/>
									</div>
									<div class="col-lg-4 col-sm-4 col-12"><span class="btn btn-success addbeforeimage"  data-toggle="tooltip" data-placement="top" title="Add More"><i class="fas fa-plus"></i></span> </div>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
								<button id="generatetest" type="submit" class="btn btn-gradient-primary btn-sm">Start Testing</button>
								<button id="generatetestreset" type="button" class="btn btn-gradient-info btn-sm">Reset</button>
							</div>
						</div>
					</div>
					</form>
<script>
var row=1;
function previewFile(input,index){
	var file = $("#sampleimage_beforetesting_"+index).get(0).files[0];	
    if(file){
		var reader = new FileReader();
		reader.onload = function(){
			$('#imagepreview_'+index).attr("src", reader.result);
        }
		reader.readAsDataURL(file);
    }
}

$(document).on("click", ".addbeforeimage", function () {
	var new_row = '<div class="row dateaddbox"><div class="col-lg-4 col-sm-4 col-12"> <div class="form-group"><div class="input-group"><div class="custom-file"><div class="button-wrap"><input type="file" value="sampleimage_beforetesting_'+row+'" name="sampleimage_beforetesting[]" id="sampleimage_beforetesting_'+row+'" data-index="'+row+'" onchange="previewFile(this,'+row+');"> <label for="sampleimage_beforetesting_'+row+'"></label></div></div></div></div></div><div class="col-lg-4 col-sm-4 col-12"><img id="imagepreview_'+row+'" src="#" alt="Image Preview" style="width: 200px;height: 200px;"/></div><div class="col-lg-4 col-sm-4 col-12"><span class="delete-row btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Remove"><i class="fas fa-trash-alt"></i></span> </div></div>';

	$('#addbeforeimagebox').append(new_row);
	row++;
	return false;
});
$(document).on("click", ".delete-row", function () {
	if(row>1) {
		$(this).closest('.dateaddbox').remove();
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

$('#generatetestcert_form').on('submit', function(event){
	$('#load').show();
	$('#generatetest').hide();	
	$(".alert-danger").hide();
	$(".alert-success").hide();
	$(".alert-danger").empty();
	$(".alert-success").empty();
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: "{{ route('testcertification.generatetest') }}",
        type: 'POST',
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
			alert(error);
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