@extends('layouts.app')

@section('content')

<style>
.searchfilter #roleslist-table_filter {
    float: left;
    margin-left: 0px !important;
}
.text-wrap{
    white-space:normal;
}
.width-200{
    width:200px !important;
}
</style>
	<!-- Main content -->
<section class="main-content-section style-8">
	<!-- Main content -->
    <section class="content">
	  <div class="main-panel">
          <div class="content-wrapper">            
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-directions menu-icon"></i>
                </span> Roles </h3>
				<nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                   <span class="">
				   <a href="{{route('home')}}"><i class="mdi mdi-home"></i></a><span><i class="mdi mdi-arrow-right"></i> Role</span> 
                  </li>
                </ul>
              </nav>
            </div>
			@if ($message = Session::get('success'))
				<div class="alert alert-success">
					<p>{{ $message }}</p>
				</div>
			@endif

			@if ($message = Session::get('error'))
				<div class="alert alert-danger">
					<p>{{ $message }}</p>
				</div>
			@endif

			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
			@endif

			<div class="card">
				<div class="card=body">
			<div class="row head-btn-cs">
				<div class="col-lg-8 col-md-8 col-sm-8 col-12"></div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-12 p-0">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1"></div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1">
						<a href="{{ route('role.create') }}" class="btn btn-block btn-sm btn-gradient-success col-12">Add New</a>
					</div>	
					<!--<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1">
						<button type="button" id="multiplerequestdelete" class="btn  btn-sm btn-block btn-gradient-danger col-12"> Delete</button>
					</div>	-->
				</div>
					
				</div>
					</div>	
			</div>



            <div class="row">
              <div class="col-lg-12">
					<table id="roleslist-table" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <!--<th>
                                    <div class="form-check form-check-info">
                                    <label class="form-check-label">
                                            <input type="checkbox"  class="form-check-input"  name="select_all" value="1" id="example-request-select-all"><i class="input-helper"></i><i class="example-request-select-all input-helper"></i></label>
                                    </div>
                                </th>-->
                                <!-- <th><div class="icheck-primary d-inline"><input type="checkbox" name="select_all" value="1" id="example-request-select-all"></div></th> -->
                                <th class="width-200">Role Name</th>
								<th>Assign Permission</th>									
                                <th>Action</th>
                                <th>Status</th>
                            </tr>
                        </thead>         
					</table>
              </div>
            </div>
			
          </div>        
        </div>
    </section>
</section>
    <!-- /.content -->
	<!-- Modal -->
	<div id="myModal" class="modal users-modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->

		<div class="modal-content">
        <div class="page-header">
		<h5 class="modal-title req-popup-title">Role Permissions</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        </div>
		
		  <div class="modal-body popp-up-scroll style-scroll">
				<div id="showdetails"></div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-gradient-danger btn-sm" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>

<script>

$.ajaxSetup({
headers: {
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$(document).on( "click",'.clickname', function() {
	$('#load').show();
	var dataid = $(this).attr('data-id');
	var url = '{{ route("role.show", ":id") }}';
	url = url.replace(':id', dataid);
	// $('#load').show();
	event.preventDefault();
	$.ajax({
		url: url,
		type: 'GET',
		data:{dataid:dataid},
		success: function(result)
		{
			$('#showdetails').html(result);
			$('#load').hide();
		},
		error: function(data)
		{
			$('.alert-danger').show();
			$('.alert-danger').append('<p>Something went wrong. Try again !!</p>');	
				// $('#visit_form').trigger("reset");
				location.reload();
				$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#load').hide();
		}
	});
});


//multiple records delete starts
$('#example-request-select-all').on('click',function(){
		$(".recordselect").prop('checked', $(this).prop('checked'));
	});
	
	$(document).on('click', '#multiplerequestdelete', function(){
        var id = [];
        // if(confirm("Are you sure you want to Delete this requests?"))
        // {
			$("#load").show();
			$('.recordselect:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0)
            {
				if(confirm("Are you sure you want to Delete this Role?"))
				{
					$.ajax({
						url:"{{ route('ajaxdata.massroledelete')}}",
						method:"get",
						data:{id:id},
						datatype: 'JSON',
						success:function(data)
						{
							location.reload();
						},
						error : function (jqXHR, textStatus, error) {
							location.reload();
						},
					});
				}            
            }
            else
            {
                alert("Please select at least one Glass");
				$("#load").hide();
            }
        // }
    });
//multiple records delete ends


$("#roleslist-table").DataTable({
		dom: "<'row m-2'<'col-sm-6 col-12 p-0 searchfilter'f><'col-sm-6 col-12 p-0'p>>r",
		processing: true,
		language: {processing: "<img style='width:100px; height:100px;position:fixed;top:50%;left:50%;transform: translate(-50%,-50%);' src='{{ asset('images/ajax-loader.gif') }}'/>"},
		serverSide: true,
		ajax:{
		   url: "{{ route('role.index') }}",
		   error : function (jqXHR, textStatus, error) {
				if (jqXHR && jqXHR.status == 401) {
				  location.reload();
				}else if(jqXHR && jqXHR.status == 419) {
					location.reload();
				}else{
					location.reload();
				}
			},
		},
		columns:[
			// {
				// data: 'id',
				// name: 'id',
				// render: function(data, type, full, meta){
					// // return "<input type='checkbox' value='"+data+"' class='recordselect' name='checked[]'>";
					// return '<div class="form-check form-check-info"> <label  class="form-check-label" for="example-request-select_'+data+'"><input type="checkbox"  class="recordselect"  name="checked[]" value='+data+' id="example-request-select_'+data+'"> <i class="input-helper"></i> </label> </div>';
				// },
				// orderable: false
			// },
			{
				data: 'role_name',
				name: 'role_name'
			},
			{
				data: 'role_permission',
				name: 'role_permission',
				orderable: false
			},			
			{
				data: 'action',
				name: 'action',
				orderable: false
			},
			{
				data: 'status',
				name: 'status',
				orderable: false
			}
		],
		columnDefs: [
			{
				className:"responsivetoggle nofilter", "targets":[0]
			},
			{
				render: function (data, type, full, meta) {
					return "<div class='text-wrap width-200'>" + data + "</div>";
				},
				targets: 1
			}
		],
		responsive: true,
		fnDrawCallback: function() {
			$('.toggleitem').bootstrapToggle();
			$('.toggleitem').change(function() {				
				var dataid= $(this).data('id');	
				
				var url = '{{ route("role.destroy", ":id") }}';
				url = url.replace(':id', dataid);
				
				var formData = new FormData();
    			formData.append('_method', 'DELETE');
			

				$.ajax({
				  url: url,
				  method: 'POST',
				  data: formData,
				  dataType:'JSON',
				  contentType: false,
				  cache: false,
				  processData: false,
				  success:function(data)
				  {
					  if(data.success) {						  
						alert(data.success);
					  }
				  },
				  error : function (jqXHR, textStatus, error) {
					if (jqXHR && jqXHR.status == 401) {
					  location.reload();
					}else if(jqXHR && jqXHR.status == 419) {
						location.reload();
					}else{
						location.reload();
					}
				  },
				});
			 });
		},
});

$("#roleslist-table").on('click', '.responsivetoggle', function(){
	$(this).closest('tr').next().find(".child .toggleitem").bootstrapToggle();
	$(this).closest('tr').next().find(".child .toggleitem").change(function() {				
				var dataid= $(this).data('id');	
				
				var url = '{{ route("role.destroy", ":id") }}';
				url = url.replace(':id', dataid);
				
				var formData = new FormData();
    			formData.append('_method', 'DELETE');
			

				$.ajax({
				  url: url,
				  method: 'POST',
				  data: formData,
				  dataType:'JSON',
				  contentType: false,
				  cache: false,
				  processData: false,
				  success:function(data)
				  {
					  if(data.success) {						  
						alert(data.success);
					  }
				  },
				  error : function (jqXHR, textStatus, error) {
					if (jqXHR && jqXHR.status == 401) {
					  location.reload();
					}else if(jqXHR && jqXHR.status == 419) {
						location.reload();
					}else{
						location.reload();
					}
				  },
				});
			 });
});
</script>
    
@endsection
