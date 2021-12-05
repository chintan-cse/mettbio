<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Helpers\GlassHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserProfile;
use App\Company;
use App\Role;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function authenticated()
	{
  
        $role = Auth::user()->role; 
        
        $roleRow = Role::find($role);

        if( $role == 4 || $role == 0 || (Auth::user()->id!=1 && Auth::user()->status==0) || ($roleRow->status == 0))
        {
            //die('Unauthorized User');           
            Auth::logout();
            return redirect('/login')->with('message','Unauthorized user !!'); 
        }

        $user_permissions = array();   
        $user_permissions = GlassHelper::GetPermissionFromRoleId($role);
        //dd($user_permissions);
       
        $user_profile = UserProfile::where('userid', Auth::user()->id)->first();

        if(empty($user_profile) || empty($user_permissions)) {
            Auth::logout();
            return redirect('/login')->with('message','Unauthorized user !!');            
        }
        else{   
            $company = Company::findorFail($user_profile->company_id);            
            $company_name = $company->company_name;          
            $company_status = $company->status;
            
            if($company_status==0 && $role == 3)
            {
                Auth::logout();
                return redirect('/login')->with('message','Unauthorized user !!');  
            }
            else{
                $user =  Auth::user();
                $user->name = $company_name; 
                $user_profile->company_name = $company_name; 
                Session::push('user_permissions', $user_permissions);          
                Session::push('user_profile', $user_profile);
            }
        }
                
        if( $role == 3)
        {   
            return redirect('/users');
        }
        return redirect('/home');
	}

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	public function logout()
    {
        Session::forget('user_permissions');
        Session::forget('user_profile');
        Auth::logout();
		return redirect('/login');
    }
    

    private function GetPermissionFromRoleId($role_id){

        $permissions = DB::table('menus')
            ->select(DB::raw('menus.id, menus.name, menus.menu_url, menus.parent_id, menus.icon'))
            ->join('permissions', 'permissions.menu_id', '=', 'menus.id')
            ->where('permissions.role_id',$role_id)            
            ->orderBy('id','ASC')
            ->get()->toArray();

        $user_permissions = [];
        foreach($permissions as $permission)          
        {
            $user_permissions[] = $permission->menu_url; 
        } 
        return $user_permissions;
    }
}
