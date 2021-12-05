<?php

namespace app\Helpers;

use App\Sample;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;

class GlassHelper
{
	public static function instance()
	{
	    return new AllowHelper();
    }
	
	public static function GetPermissionFromRoleId($role_id)  {
        
        $permissions = array();

        $permissions = DB::table('menus')
        ->select(DB::raw('menus.id, menus.name, menus.menu_url, menus.parent_id, menus.icon'))
        ->join('permissions', 'permissions.menu_id', '=', 'menus.id')
        ->where('permissions.role_id',$role_id)            
        ->orderBy('id','ASC')
        ->get()->toArray();

        $user_permissions = array();
        foreach($permissions as $permission)          
        {
            $user_permissions[] = $permission->menu_url; 
        } 
        return $user_permissions;
    }

    public static function CommanActionButtons($data){
        
        $namedRoute = \Route::currentRouteName();         
        $module_nm = explode(".", $namedRoute)[0];
        $module_edit = $module_nm . ".edit";
        $module_delete = $module_nm . ".destroy";

        $user_permissions = Session::get('user_permissions');

        $button = '<div class="row action-btn-cs">';
        /*if( in_array($module_edit, $user_permissions[0]) ||
            in_array($module_delete, $user_permissions[0])){*/

            if(in_array($module_edit, $user_permissions[0])){
                $button .= '<div class="col-md-2 col-6 text-center">
                                    <a class="btn btn-gradient-info btn-rounded btn-icon" href="'.Route( $module_edit, $data->id).'"><i class="mdi mdi-border-color" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                </div>';
            }
           /*if(in_array($module_delete, $user_permissions[0])){               
                $button .=		'<div class="col-md-6 col-6 text-center">
                                    <form action="'.Route($module_delete, $data->id).'" method="POST">';
                $button .= csrf_field();
                $button .= '<input type="hidden" name="_method" value="DELETE">';
                $button .= 	'<button type="submit" onclick="return confirm(';
                $button .= 	'\'Are you sure to delete this Item?\'';
                            
                $button .= 	')" class="btn btn-gradient-danger btn-rounded btn-sm btn-icon"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Remove"></i> </button>
                                    </form>
                                </div>';
           }
        }*/
        else{
            $button .= '<div class="col-md-2 col-6 text-center">
                           <i class="mdi mdi-key" data-toggle="tooltip" data-placement="top" title="No Permission"></i>
                        </div>';
        }
        $button .='</div>'; 
        return $button;        
    }
	
	public static function getSampleIdFormat($type,$nabl_value,$sampleid=null){
		$atolchararr = array(
			'01' => 'A',
			'02' => 'B',
			'03' => 'C',
			'04' => 'D',
			'05' => 'E',
			'06' => 'F',
			'07' => 'G',
			'08' => 'H',
			'09' => 'I',
			'10' => 'J',
			'11' => 'K',
			'12' => 'L',
		);
		if($nabl_value != "" && $nabl_value == 'nabl') {
			$id = 'ST';
		}else{
			$id = 'NST';
		}
		$id .= date('Y');
		$id .= $atolchararr[date('m')];
		$id .= date('d');
		$latestsample = Sample::orderBy('id', 'DESC')->first();
		if($type == 'create') {
			if($latestsample == ""){
				$num = 1;
				$num_padded = sprintf("%02d", $num);
				$id .= $num_padded;			
			}else{
				if(!$latestsample->nabl_status) {
					$str = substr($latestsample->sampleid,1);
				}else{
					$str = $latestsample->sampleid;
				}
				$lastdigit = substr( $latestsample->sampleid, -2);
				$lastdate = substr( $latestsample->sampleid,7,2);
				$lastmonth = substr( $latestsample->sampleid,6,1);
				$lastyear = substr( $latestsample->sampleid,2,4);
				if($lastyear == date('Y') && $lastmonth == $atolchararr[date('m')] && $lastdate == date('d')) {
					$num_padded = sprintf("%02d", $lastdigit +1);
				}else{
					$num = 1;
					$num_padded = sprintf("%02d", $num);
				}
				$id .= $num_padded;
			}
		}else if($type == 'edit') {
			$latestsample = Sample::findOrFail($sampleid);
			if(!$latestsample->nabl_status) {//with n
				if($nabl_value != "" && $nabl_value == 'nabl') {
					$id = substr($latestsample->sampleid,1);
				}else{
					$id = $latestsample->sampleid;
				}
			}else{//without n
				if($nabl_value != "" && $nabl_value == 'nabl') {
					$id = $latestsample->sampleid;
				}else{
					$id = substr_replace($latestsample->sampleid,"N",0,0);
				}
			}
		}
		return $id;
    }

}