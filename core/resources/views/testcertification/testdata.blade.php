<h3>Test Entries List</h3>
<div class="col-md-12">
	@if(isset($sampletestdata))
		@foreach($sampletestdata as $data)
			<!-- Box Comment -->
            <div class="card card-widget collapsed-card">
              <div class="row card-header">
				<div class="col-md-4">
					<div class="user-block">
					  <span class="username"><a>Date: </a> {{date('d/m/Y',strtotime($data->datelist))}}</span>
					</div>
				</div>
                <div class="col-md-4">
					<div class="user-block">
					  <span class="username"><a>Observation Hours: </a>{{$data->observationhours}}</span>
					</div>
				</div>
                <div class="col-md-4">
					<div class="card-tools">
					  <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
						@if($data->filled)
							<i class="far fa-thumbs-up"></i>
						@else
							<i class="far fa-thumbs-down"></i>
						@endif
						</button>
					  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
					  </button>
					</div>
				</div>
              </div>
              <div class="card-body">
				<div class="row">
					<div class="col-lg-8 col-12"></div>
					<div class="col-lg-4 col-12">
						<div id="alertsuccess_{{$data->id}}" class="alert alert-success" style="display:none">
						</div>
					</div>	
				</div>	
				<div class="row">	
					<div class="col-lg-8 col-12"></div>
					<div class="col-lg-4 col-12">	
						<div id="alertdanger_{{$data->id}}" class="alert alert-danger" style="display:none">
						</div>
					</div>
				</div>
				<form class="testentry_form" data-rowindex="{{$data->id}}" name="testentry_form" enctype="multipart/form-data" role="form">
				<input type="hidden" name="entryrow" value="{{$data->id}}">
				<div class="row">
						<div class="col-sm-6 col-md-6 col-12">
							<label class="field-label">Fog<span class="validrequire"> *</span></label>
							<div class="input-group mb-3">
								<input type="text" id="fog_{{$data->id}}" class="form-control" name="fog" placeholder="Fog Value *" value="@if(isset($data->fogvalue) && $data->fogvalue != "") {{$data->fogvalue}} @endif" required>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-12">
							<label class="field-label">PH<span class="validrequire"> *</span></label>
							<div class="input-group mb-3">
								<input type="text" id="ph_{{$data->id}}" class="form-control" name="ph" placeholder="PH Value *" value="@if(isset($data->phvalue) && $data->phvalue != "") {{$data->phvalue}} @endif" required>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-12">
							<div class="form-group">											
								<div class="select2-purple">
									<label class="field-label">Select Rusting<span class="validrequire"> *</span></label>
									<select id="rusting_{{$data->id}}" class="form-control select2" name="rusting" style="width: 100%;" required>
										<option value="" selected="selected">Select Rusting</option>
										@if(isset($data->phvalue) && $data->phvalue != "") 
											@if($data->rust == 'yes') 
												<option value="yes" selected>Yes</option>
											@else
												<option value="yes">Yes</option>
											@endif
											
											@if($data->rust == 'no') 
												<option value="no" selected>No</option>
											@else
												<option value="no">No</option>
											@endif										
										@else
											<option value="yes">Yes</option>
											<option value="no">No</option>
										@endif
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-12">
							<label class="field-label">Interruption Time (Min)<span class="validrequire"> *</span></label>
							<div class="input-group mb-3">
								<input type="text" id="interruptiontime_{{$data->id}}" class="form-control" name="interruptiontime" placeholder="Time *" value="@if(isset($data->interruptiontime) && $data->interruptiontime != "") {{$data->interruptiontime}} @endif" required>
							</div>
						</div>
						<div class="col-sm-12 col-md-12 col-12">
							<label class="field-label">Remarks<span class="validrequire">*</span></label>
							<div class="input-group mb-3">
								<textarea class="form-control" name="remarks"  placeholder="Enter  Remarks...">@if(isset($data->remarks) && $data->remarks != "") {{$data->remarks}} @endif</textarea>
							</div>
						</div>
						<div class="col-sm-12 col-md-12 col-12">
							<label class="field-label">Upload Tested Images<span class="validrequire">*</span></label>
							<div class="input-group mb-3">
								<input class="fileupload" data-entryrow="{{$data->id}}" name="testedimages[]" type="file" multiple="multiple" />
							</div>
						</div>
						<div class="col-sm-12 col-md-12 col-12">
							<div id="dvPreview_{{$data->id}}"></div>
						</div>
						@if($loop->last)
							 <input name="lastentry" value='last' type="hidden" />
						@endif
						<button id="testentry_{{$loop->index}}" type="submit" class="btn btn-gradient-primary btn-sm">Update</button>
				</div>
				</form>
              </div>
            </div>
            <!-- /.card -->
		@endforeach
	@endif
</div>
<script language="javascript" type="text/javascript">
$(function () {
    $(".fileupload").change(function () {
		var rowid = $(this).attr('data-entryrow');
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $("#dvPreview_"+rowid);
            dvPreview.html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img />");
                        img.attr("style", "height:100px;width: 100px");
                        img.attr("src", e.target.result);
                        dvPreview.append(img);
                    }
                    reader.readAsDataURL(file[0]);
                } else {
                    alert(file[0].name + " is not a valid image file.");
                    dvPreview.html("");
                    return false;
                }
            });
        } else {
            alert("This browser does not support HTML5 FileReader.");
        }
    });
});
$('.testentry_form').on('submit', function(event){
	var index = $(this).data('rowindex');
	$('#load').show();
	$('#testentry_'+index).hide();
	$("#alertsuccess_"+index).hide();
	$("#alertdanger_"+index).hide();
	$("#alertsuccess_"+index).empty();
	$("#alertdanger_"+index).empty();
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: "{{ route('testcertification.testdataentry')}}",
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
					$("#alertdanger_"+index).show();
                  	$("#alertdanger_"+index).append('<p>'+value+'</p>');					
                });
				// $('#edittesttype_form').trigger("reset");
				$('#load').hide();
				$('#testentry_'+index).show();
            }else{
				$("#alertsuccess_"+index).show();
                $("#alertsuccess_"+index).append('<p>'+result.success+'</p>');
				$('#load').hide();
				$('#testentry_'+index).show();
			}
        },
		error: function(jqXHR, textStatus, error)
			{
				if (jqXHR && jqXHR.status == 401) {
						$("#alertdanger_"+index).show();
						$("#alertdanger_"+index).append('<p>Session Expired. Login again !!</p>');
						$('#load').hide();
						// location.reload();
				}else if(jqXHR && jqXHR.status == 419) {
						$("#alertdanger_"+index).show();
						$("#alertdanger_"+index).append('<p>Session Expired. Login again !!</p>');
						$('#load').hide();
						// location.reload();
				}else {
						$("#alertdanger_"+index).show();
						$("#alertdanger_"+index).append('<p>Session Expired. Login again !!</p>');	
						// $('#edittesttype_form').trigger("reset");
						$('#load').hide();
						// location.reload();
						$('#testentry_'+index).show();
				}
			},
    });
})
</script>