@php

$user_permissions = Session::get('user_permissions');	

$namedRoute = Route::currentRouteName(); 
$module_nm = explode(".", $namedRoute)[0];
$module_create = $module_nm . ".create";
$module_delete = $module_nm . ".destroy";

@endphp
<div class="card">
    <div class="card=body">
        <div class="row head-btn-cs">
            <div class="col-lg-8 col-md-8 col-sm-8 col-12"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 p-0">
                    <div class="row">
						@if(in_array($module_create, $user_permissions[0]) && in_array($module_delete, $user_permissions[0]))
							<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1">
								@if(in_array($module_create, $user_permissions[0]))
								<a href="{{ route($module_create) }}" class="btn btn-block btn-sm btn-gradient-success col-12">Add New</a>
								@endif
							</div>	
							<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1">
								@if(in_array($module_delete, $user_permissions[0]))
								<button type="button" id="multiplerequestdelete" class="btn  btn-sm btn-block btn-gradient-danger col-12">Enable/Disable</button>
								@endif
							</div>
						@elseif(in_array($module_create, $user_permissions[0]))
							<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1">
								<a href="{{ route($module_create) }}" class="btn btn-block btn-sm btn-gradient-success col-12">Add New</a>
							</div>	
						@elseif(in_array($module_delete, $user_permissions[0]))	
							<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-12 text-right mb-1">
								<button type="button" id="multiplerequestdelete" class="btn  btn-sm btn-block btn-gradient-danger col-12">Enable/Disable</button>
							</div>	
						@endif	
                </div>
        </div>
    </div>	
</div>