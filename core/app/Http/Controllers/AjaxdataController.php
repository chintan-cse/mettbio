<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\UserProfile;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Company;
use App\TestType;
use App\Sample;
use Response;

class AjaxdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   function massuserdelete(Request $request)
    {
        $requestids = $request->id;
		foreach($requestids as $id){
			$user = User::find($id);
			$user->status = !$user->status;
			$user->save();
		}
        $status = 'success';
		$url = redirect()->route('users.index')->with('success','Status changed successfully.');
		return Response::json(array('status' => $status,'url' => $url));
    }
	
	function massroledelete(Request $request)
    {
        $requestids = $request->id;
		foreach($requestids as $id){
			$role = Role::find($id);
			$role->status = !$role->status;
			$role->save();
		}
        $status = 'success';
		$url = redirect()->route('role.index')->with('success','Status changed successfully.');
		return Response::json(array('status' => $status,'url' => $url));
	}
	
	function masscompanydelete(Request $request)
	{
		$requestids = $request->id;
		foreach($requestids as $id){
			$company = Company::find($id);
			$company->status = !$company->status;
			$company->save();
		}
        $status = 'success';
		$url = redirect()->route('company.index')->with('success','Status changed successfully.');
		return Response::json(array('status' => $status,'url' => $url));
	}
	
	function masstesttypedelete(Request $request)
	{
		$requestids = $request->id;
		foreach($requestids as $id){
			$testtype = TestType::find($id);
			$testtype->status = !$testtype->status;
			$testtype->save();
		}
        $status = 'success';
		$url = redirect()->route('testtype.index')->with('success','Status changed successfully.');
		return Response::json(array('status' => $status,'url' => $url));
	}
	
	function masssampledelete(Request $request)
	{
		$requestids = $request->id;
		foreach($requestids as $id){
			$testtype = Sample::find($id);
			$testtype->status = !$testtype->status;
			$testtype->save();
		}
        $status = 'success';
		$url = redirect()->route('testtype.index')->with('success','Status changed successfully.');
		return Response::json(array('status' => $status,'url' => $url));
	}
}
