<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\UserProfile;
use App\User;
use App\Company;
use App\Role;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Helpers\GlassHelper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		if(request()->ajax())
        {			
			$sql = "SELECT u.id, u.status, up.firstname as first_name, up.lastname as last_name, c.company_name as company_name, u.email FROM users as u , user_profile as up, company as c WHERE u.id = up.userid AND c.id = up.company_id AND u.id>1 AND u.id<>:user_id ";
			if(Auth::user()->role != 1 && Auth::user()->role != 2)
			{
				$sql .= " AND u.role != 1 AND u.role != 2";
			}
			if(Auth::user()->role == 2)
			{
				$sql .= " AND u.role != 1";
			}
			if(Auth::user()->role == 3)
			{
				$sql .= " AND up.company_id=:company_id";
			}
			$sql .=" ORDER BY u.updated_at DESC";
			
			$user_id = Auth::user()->id;
			// $company_id = Session::get('user_profile')[0]->company_id;
			$company_id = Auth::user()->user_userprofile->userprofile_company->id;
			if(Auth::user()->role == 3){
				$query = DB::select($sql, ['company_id' => $company_id, 'user_id' => $user_id]);
			}
			else {
				$query = DB::select($sql, ['user_id' => $user_id]);
			}
							
								

			//$query = User::where('status','=',1)->orderBy('updated_at', 'DESC')->get();
			/*$query = User::with('user_userprofile')->whereHas('user_userprofile', function($q) use($company_id){					
					$q->where('company_id', '=', $company_id); // '=' is optional
					})->where('status','=',1)->where('id', '!=', $user_id )->orderBy('updated_at', 'DESC')->get();*/
			//echo $query;
			//exit;
				
			
			
			return datatables()->of($query)
					->addColumn('name', function($data){
						$name = '<a class="clickname" href="#"  id="anchor_'.$data->id.'" data-id="'.$data->id.'" data-toggle="modal" data-target="#myModal">'. $data->first_name . ' ' . $data->last_name .'</a>';
						return $name;
					})
					->addColumn('company_name', function($data){
                        $company_name = $data->company_name;
                        return $company_name;
                    })
					->addColumn('action', function($data){
                        /*$button = '<div class="row action-btn-cs">
										<div class="col-md-2 col-6 text-center">
											<a class="priview-label btn btn-gradient-info btn-rounded btn-icon" href="'.Route('users.edit', $data->id).'"><i class="mdi mdi-border-color" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
										</div>
										<div class="col-md-6 col-6 text-center">
											<form action="'.Route('users.destroy', $data->id).'" method="POST">';
						$button .= csrf_field();
						$button .= '<input type="hidden" name="_method" value="DELETE">';
						$button .= 	'<button type="submit" onclick="return confirm(';
						$button .= 	'\'Are you sure to delete this User?\'';
									
						$button .= 	')" class="btn btn-gradient-danger btn-rounded btn-sm btn-icon"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Remove"></i> </button>
											</form>
										</div>									
									</div>';
						return $button;*/
						$button = GlassHelper::CommanActionButtons($data);
                        return $button;
					})
					->addColumn('status', function($data){
                        $status = '<div class="toggle-btn-cs"><input type="checkbox" name="toggle" class="toggleitem" data-id="'.$data->id.'" data-toggle="toggle" data-off="Disable" data-on="Enable"';
						$status .= $data->status ? 'checked' : '';
                        $status .= '></div>';
                        return $status;
                    })
                    ->rawColumns(['name', 'company_name','action', 'status'])
                    ->make(true);
        }
		
        // $citizen = Citizen::with(['getTehsil', 'getSchemes'])->get();
		return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$company = Company::where('status', '=', 1)->get();	
		return view('users.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	private function numberformation($str){
		$new_str = str_replace(' ', '', $str);
		$finalnumber =	preg_replace("/[^A-Za-z0-9 ]/", '', $new_str);
		return $finalnumber;
	}
    public function store(Request $request)
    {
		//
		$rules = [
			'user_firstname' => 'required|regex:/(^[A-Za-z ]+$)+/|max:255',
			'user_lastname' => 'required|regex:/(^[A-Za-z ]+$)+/|max:255', 
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
			'user_zip' => 'nullable|numeric|regex:/^[0-9\+]{4,10}$/',
			'user_name' => 'required',		//company validation
			'role' => 'required',
		];
		$customMessages = [			
			'user_firstname.required' => 'Firstname required',
			'user_firstname.regex' => 'Valid Firstname required',
			'user_lastname.required' => 'Lastname required',
			'user_lastname.regex' => 'Valid Lastname required',
			'user_email.required' => 'Email required.',
			'user_email.email' => 'Valid Email format required.',
			'user_password.required' => 'Valid password required',
			'user_password.regex' => 'Password should have at least one digit, one lower case letter, one upper case letter and one special character with min 6 characters',
			'user_zip.numeric' => 'Valid Zipcode required',
			'user_zip.regex' => 'Valid Zipcode required',
			'user_name.required' => 'Company required.',	//company validation msg
			'role.required' => 'Role required',
		];
		
		if(Auth::user()->role > 2){
			unset($rules['user_name']); //remove copmpany validation
			unset($rules['role']); //remove role validation
		}

		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		
		try{			
			// Without PGI company
			if(Auth::user()->role == 3 || Auth::user()->role == 4)
			{			
				$userprofile = Session::get('user_profile');
				$request->company_name = $userprofile[0]->company_name;
				$request->company_id = $userprofile[0]->company_id;
				$request->role = 4; //normal user
			}
			
			$user = new User([
				'name'=>$request->company_name,
				'email' => $request->user_email,
				'password' => bcrypt($request->user_password),
				'email_verified_at'=> Carbon::now()->toDateTimeString(),
				'status'=> 1
			]);

			$user->role = $request->role;

			$userexist = User::where('email','=',$request->user_email)->where('status','=',1)->first();
			if($userexist) {
				$result = [
						"error" => "Email already exist."
					];
				return response()->json(['errors'=>$result]);
			}
			if($user->save()){
				// Mail::to($request->user_email)
						// ->cc(['ckchintan1991@gmail.com'])
						// ->send(new Registered($request->user_firstname,$request->user_email,$request->user_password));
				$profile = new UserProfile([
					'userid' => $user->id,
					'company_name' => $request->company_name,
				]);
				
				if($request->has('user_firstname')){
					$profile->firstname = $request->user_firstname;
				}
				if($request->has('user_lastname')){
					$profile->lastname = $request->user_lastname;
				}
				/*if($request->has('user_discount')){
					$profile->discount = $request->user_discount;
				}*/
				
				if($request->has('user_number')){
					$profile->phone_number = $this->numberformation($request->user_number);
				}
				
				if($request->has('address')){
					$profile->address = $request->address;
				}
				
				if($request->has('user_city')){
					$profile->city = $request->user_city;
				}
				
				if($request->has('user_state')){
					$profile->state = $request->user_state;
				}
				
				if($request->has('user_country')){
					$profile->country = $request->user_country;
				}
				
				if($request->has('user_zip')){
					$profile->zip = $request->user_zip;
				}
				if($request->has('company_id')){
					$profile->company_id = $request->company_id;
				}
				
				
				$profile->save();
				
				return response()->json(['success'=>'User created successfully']);
				
			}else{
				$result = [
						"error" => "User Entry Failed!"
					];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			echo $e->getMessage();exit;
			// catch code			
			$result = [
						"error" => "User Entry Failed!"
					];
			return response()->json(['errors'=>$result]);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		try{
			$user = User::findOrFail($id);
			$userprofile = UserProfile::where('userid','=',$id)->first();	
			$role = Role::findOrFail($user->role);	
			$company = Company::findOrFail($userprofile->company_id);
			return view('users.show',compact('user','userprofile', 'role', 'company'));
		}catch(\Exception $e){
			// catch code
			return redirect()->back()->with("error","User not found !");
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		try{
			$user = User::findOrFail($id);			
			$userprofile = UserProfile::where('userid','=',$id)->first();
			$role = Role::findOrFail($user->role);
			$company = Company::findOrFail($userprofile->company_id);
			return view('users.edit',compact('user','userprofile','role', 'company'));
		}catch(\Exception $e){
			// catch code
			return redirect()->back()->with("error","User not found !");
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
		$rules = [
            'user_password' => 'nullable|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
		];
		$customMessages = [
			'user_password.regex' => 'Password should have at least one digit, one lower case letter, one upper case letter and one special character with min 6 characters',
		];
		
		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        try{
			$user = User::findOrFail($id);
			$userprofile = UserProfile::where('userid','=',$id)->first();
		
			if($request->has('user_discount')){
				$userprofile->discount = $request->user_discount;
			}
			   
			
			if($request->has('user_password') && $request->user_password != ""){
				if ( preg_match('/\s/',$request->user_password) ) {
					$result = [
							"error" => "Space not allowed in password !"
						];
					return response()->json(['errors'=>$result]);
				}
				$user->password = bcrypt($request->user_password);
				$user->update();
			}
			if($userprofile->update()){
				return response()->json(['success'=>'User updated successfully']);
				// return redirect()->back()->with("success","User updated successfully !");
			}else{
				$result = [
						"error" => "User update Entry Failed!"
					];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			// catch code
			$result = [
						"error" => "User update Entry Failed!"
					];
			return response()->json(['errors'=>$result]);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
		try{
			$user = User::findorFail($id);
			$user->status = !$user->status;
			if($user->save())
			{
				if($user->status)
				{
					return response()->json(['success'=>'User Enabled successfully']);
				}
				else{
					return response()->json(['success'=>'User Disabled successfully']);
				}
				
			}
		}
		catch(\Exception $e){
			// catch code
			$result = [
						"error" => "User Update Failed!"
					];
			return response()->json(['errors'=>$result]);
		}	
    }
}
