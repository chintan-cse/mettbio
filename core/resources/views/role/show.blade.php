<div class="row">
    <div class="col-md-12 h4"> Role: {{ $role->role_name }} </div>    
</div>
<div class="row role-popup">
    @foreach($all_permissions as $single_permission) 
        @if($single_permission->parent_id == 0)										
            
        <div class="col-lg-6  col-sm-12 col-12 brdr-r">
                <div class="field-label">{{ $single_permission->name }}</div> 
                <div class="switch"><!----></div>
            	<div class="row">
            @foreach($all_permissions as $sub_single_permission) 
                @if($single_permission->id == $sub_single_permission->parent_id)
                <div class="col-lg-3 col-md-3 col-sm-12 col-12" style="margin-top:8px">
                    <div class="form-group">
                        <div class="switch" style="float:left; margin-right:5px;">
                            <label>
                            @if( in_array($sub_single_permission->id, $role_permissions) ) 
                                <i class="fa fa-check" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-times" aria-hidden="true"></i>
                            @endif
                           
                            
                            </label></div>
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