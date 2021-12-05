<?php

namespace App\Http\Controllers;
use App\Menu;
use App\Permission;;
use App\Role;
use DB;
use Auth;
use Session;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\GlassHelper;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
			return datatables()->of(Role::all())
					->addColumn('role_name', function($data){
                        $role_name = '<a class="clickname" href="#"  id="anchor_'.$data->id.'" data-id="'.$data->id.'" data-toggle="modal" data-target="#myModal">'.$data->role_name.'</a>';
                        return $role_name;
                    })
                    ->addColumn('role_permission' ,function($data){
                        if($data->id == 1){
                            return '<i class="mdi mdi-key" data-toggle="tooltip" data-placement="top" title="No Permission"></i>';
                        }
                        $permission_link = '<a class="align-items-center" href="'.Route('role.edit', $data->id).'"  id="anchor_'.$data->id.'" data-id="'.$data->id.'"><i class="fas fa-key" data-toggle="tooltip" data-placement="top" title="Permssions"></i></a>';
                        return $permission_link;
                    })
					->addColumn('action', function($data){
                        /*$button = '<div class="row action-btn-cs">
										<div class="col-md-2 col-6 text-center">
											<a class="btn btn-gradient-info btn-rounded btn-icon" href="'.Route('role.editrole', $data->id).'"><i class="mdi mdi-border-color" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
										</div>
										<div class="col-md-2 col-6 text-center">
											<form action="'.Route('role.destroy', $data->id).'" method="POST">';
						$button .= csrf_field();
						$button .= '<input type="hidden" name="_method" value="DELETE">';
						$button .= 	'<button type="submit" onclick="return confirm(';
						$button .= 	'\'Are you sure to delete this Role ?\'';
									
						$button .= 	')" class="btn btn-gradient-danger btn-rounded btn-sm btn-icon"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Remove"></i> </button>
											</form>
										</div>									
									</div>';
                        return $button;*/
                        if($data->id < 5){
                            return '<i class="mdi mdi-key" data-toggle="tooltip" data-placement="top" title="No Permission"></i>';
                        }
                        $button = '<div class="row action-btn-cs">
										<div class="col-md-2 col-6 text-center">
											<a class="btn btn-gradient-info btn-rounded btn-icon" href="'.Route('role.editrole', $data->id).'"><i class="mdi mdi-border-color" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                        </div>
                                    </div>';
                        return $button;
                        
                    })
                    ->addColumn('status', function($data){
                        if($data->id < 5){
                            return '<i class="mdi mdi-key" data-toggle="tooltip" data-placement="top" title="No Permission"></i>';
                        }
                        $status = '<div class="toggle-btn-cs"><input type="checkbox" name="toggle" class="toggleitem" data-id="'.$data->id.'" data-toggle="toggle" data-off="Disable" data-on="Enable"';
						$status .= $data->status ? 'checked' : '';
                        $status .= '></div>';
                        return $status;
                    })
                    ->rawColumns(['role_name', 'role_permission', 'action', 'status'])
                    ->make(true);
        }        
        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$all_permissions = Menu::select('id','name','parent_id')->where('id','!=',3)->orderBy('parent_id','asc')->get();/*Menu::all();*/
        return view('role.create', compact('all_permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
            // 'role_name' => 'required|unique:roles,role_name' 
        // ]);
		
		$rules = [
			'role_name' => 'required|unique:roles,role_name',
			'new_permission' => 'required'
		];
		
		$customMessages = [
			'role_name.required' => 'Role Name Required',
			'role_name.unique' => 'Role name has already been taken',
			'new_permission.required' => 'Atleast One Permission Required',
		];
		
		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		
		if($request->has('new_permission') && $request->new_permission == "") {
		   $result = [
						"error" => "Atleast One Permission Required."
					];
			return response()->json(['errors'=>$result]);
		}

        try{
            $role = new Role();            
            $role->role_name = $request->role_name;
            $role->status = 1;
			if($role->save()){
				DB::beginTransaction();
				Permission::where('role_id','=',$role->id)->delete();
				
				$role_id = $role->id;
				$menus = explode(",", $request->new_permission);        
				// inserting permission to the permission table 
					foreach($menus as $menu_id) {               
						$menu_per = new Permission;
						$menu_per->role_id = $role_id ;
						$menu_per->menu_id = $menu_id;
						$menu_per->save();
					}
						
				DB::commit();

				Session::forget('user_permissions');
				//$permissions = $this->GetPermissionFromRoleId(Auth::user()->role_id);
				//$user_permissions = $this->GetPermissionFromRoleId(1);    
				
				$user_permissions = GlassHelper::GetPermissionFromRoleId(1);
				Session::push('user_permissions', $user_permissions);
               return response()->json(['success'=>'Role with assigned permissions created successfully', 'role_id'=>$role->id]);				
			}else{
				$result = [
						"error" => "Role Entry Failed!"
					];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			// catch code			
			$result = [
						"error" => "Role Entry Failed!"
					];
			return response()->json(['errors'=>$result]);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            
            $role = Role::find($id);        
            $all_permissions = Menu::select('id','name','parent_id')->orderBy('parent_id','asc')->get();/*Menu::all();*/
            $role_permissions = Permission::where('role_id','=',$id)->pluck('menu_id')->toArray();        
            return view('role.show', compact('role', 'all_permissions', 'role_permissions'));  

        }catch(\Exception $e){
            return redirect()->back()->with("error","Role not found !");
        }
    }


    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);        
        $all_permissions = Menu::select('id','name','parent_id')->where('id','!=',3)->orderBy('parent_id','asc')->get();/*Menu::all();*/

        $role_permissions = Permission::where('role_id','=',$id)->pluck('menu_id')->toArray();        


        return view('role.edit', compact('role', 'all_permissions', 'role_permissions'));
    }

    public function editrole($id)
    {
        $role = Role::find($id);        
        return view('role.editrole', compact('role'));
    }

    public function permission(Request $request){
       
       //dd($request->new_permission); exit;
	   $rules = [
			'new_permission' => 'required'
		];
		
		$customMessages = [
			'new_permission.required' => 'Atleast One Permission Required',
		];
		
		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
	   
		if($request->has('new_permission') && $request->new_permission == "") {
		   $result = [
						"error" => "Atleast One Permission Required."
					];
			return response()->json(['errors'=>$result]);
		}

        try{
        
            DB::beginTransaction();
            Permission::where('role_id','=',$request->id)->delete();
            
            $role_id = $request->id;
            $menus = explode(",", $request->new_permission);        
            // inserting permission to the permission table 
                foreach($menus as $menu_id) {               
                    $menu_per = new Permission;
                    $menu_per->role_id = $role_id ;
                    $menu_per->menu_id = $menu_id;
                    $menu_per->save();
                }
                    
            DB::commit();

            Session::forget('user_permissions');
            //$permissions = $this->GetPermissionFromRoleId(Auth::user()->role_id);
            //$user_permissions = $this->GetPermissionFromRoleId(1);    
            
            $user_permissions = GlassHelper::GetPermissionFromRoleId(1);
            Session::push('user_permissions', $user_permissions);

            return response()->json(['success'=>'New Permission Given']);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return response()->json(['error'=>'Something Went Wrong !']);
        }
 
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required'
        ]);
		
		try{
            $role = Role::findOrFail($id);
            $role->role_name = $request->role_name;
            if($role->update()){
                return response()->json(['success'=>'Role updated successfully']);                
            }else{
                $result = [
                    "error" => "Role Update Failed!"
                ];
                return response()->json(['errors'=>$result]);
            }
        }catch(\Exception $e){
            $result = [
                "error" => "Role Update Failed!"
            ];
            return response()->json(['errors'=>$result]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        try{     
            $role = Role::find($id);
            $role->status = !$role->status;
		    if($role->save()){
                if($role->status)
                {
                    return response()->json(['success'=>'Role Enabled successfully']);
                }
                else{
                    return response()->json(['success'=>'Role Disabled successfully']);
                }
            }            
        }
        catch(\Exception $e){
            $result = [
                "error" => "Update Failed!"
            ];
            return response()->json(['errors'=>$result]);
        }
    }

    public function getrolesfromCompanyId(Request $request){ 
        $data = [];
        if( $request->company_id == 1 && Auth::user()->role == 1){
			$roles = Role::select('id', 'role_name')->where('status', '=', 1)->get();
		}elseif( $request->company_id == 1  && Auth::user()->role == 2){
            $roles = Role::select('id', 'role_name')->where('status', '=', 1)->where('id', '>', 1)->get();
        }elseif( $request->company_id == 1){
            $roles = Role::select('id', 'role_name')->where('status', '=', 1)->where('id', '>', 2)->get();
        }
        else{
            $roles = Role::select('id', 'role_name')->find([3, 4]);
        }
        foreach($roles as $role){
            $data[$role->id] = $role->role_name;
        }
        return response()->json($data);

    }
}
