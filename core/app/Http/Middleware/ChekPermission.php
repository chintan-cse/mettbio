<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChekPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){          
            $role_id = Auth::user()->role;
            $namedRoute 		= \Route::currentRouteName();           
            $current_url_check  = DB::table('menus')->select('menu_url')->where('menu_url', $namedRoute)->get()->toArray();

           
            /*$routes_list = array('users.index', 'users.create', 
                    'role.index', 'role.create', 
                    'template.index', 'template.create',
                    'glass.index', 'glass.create', 
                    'hardwareitem.index', 'hardwareitem.create', 'hardwarecategory.index', 'hardwarecategory.create',
                    'miter.index', 'miter.create', 
                    'oversize.edit', 'fabrication.edit', 'report.index'
                    );*/ 
                       
            
            if ($namedRoute)
            {
                if ($current_url_check)
                {
                    $permissionCheck = DB::table('menus')
                        ->join('permissions', 'permissions.menu_id', '=', 'menus.id')
                        ->where('role_id', $role_id)
                        ->where('menu_url', $namedRoute)
                        ->get()->toArray();                    
                    if (empty($permissionCheck) || count($permissionCheck) <= 0)
                    {
                        return response()->view('errors.404', [], 404);
                    }
                }
            }
        }        

        return $next($request);
    }
}
