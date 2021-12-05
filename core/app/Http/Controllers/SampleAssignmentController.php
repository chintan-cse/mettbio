<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\TestType;
use App\TestTypeMethod;
use App\TestTypeSubmethod;
use App\Sample;
use App\SampleAssigned;
use App\UserProfile;
use App\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Helpers\GlassHelper;

class SampleAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$query = SampleAssigned::with(['assignto_sample','assignto_user'])->whereIn('sampleid', function ($subquery) {
						$subquery->select('id')
							->from('samples')
							->whereIn('current_status',array(1,6))
							->where('status','=',1);
					})->orderBy('updated_at', 'DESC')->get();
		if(request()->ajax())
        {
			return datatables()->of($query)
					->addColumn('sampleid', function($data){
                        $sampleid = '<a class="clickname" href="#"  id="anchor_'.$data->sampleid.'" data-id="'.$data->sampleid.'" data-toggle="modal" data-target="#myModal">'.$data->assignto_sample->sampleid.'</a>';
                        return $sampleid;
                    })
					->addColumn('assignto', function($data){
                        if(isset($data->userid) && $data->userid != "") {
							$assignto = '<div id="alreadyassign_'.$data->sampleid.'">';
							$assignto .= $data->assignto_user->user_userprofile->firstname.' '.$data->assignto_user->user_userprofile->lastname;
							$assignto .= '</div>';
						}else{
							$assignto = '<b>Not Assign Yet..</b>';
						}
                        return $assignto;
                    })
					->addColumn('changeto', function($data){
						$users = User::with(['user_userprofile'])->where('status','=',1)->get();
						$dropdown = '<div class="form-group"><div class="select2-purple"><select id="user_select_'.$data->sampleid.'" class="form-control select2" name="user_select_'.$data->sampleid.'" style="width: 100%;" required><option value="" selected="selected">Select User</option>';
						foreach($users as $value) {
							$dropdown .= '<option value="'.$value->id.'">'.$value->user_userprofile->firstname.' '.$value->user_userprofile->lastname.'</option>';
						}
						$dropdown .= '</select></div></div>';
                        $changeto = $dropdown;
                        return $changeto;
                    })
					->addColumn('change', function($data){
                        $change = '<button data-sampleid="'.$data->sampleid.'" type="button" class="changeuser btn btn-gradient-primary btn-sm">Change</button>';
                        return $change;
                    })
                    ->rawColumns(['sampleid','assignto','changeto', 'change'])
                    ->make(true);
        }
		return view('assign.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
	
	public function sampleassignto(Request $request)
    {
        //
		$sampleassignto = SampleAssigned::where('sampleid','=',$request->sampleid)->first();
		$sampleassignto->userid = $request->userid;
		$sampleassignto->save();
		$user = User::with(['user_userprofile'])->find($request->userid);
		$name = $user->user_userprofile->firstname.' '.$user->user_userprofile->lastname;
		return response()->json(['success'=>'User updated successfully','username'=>$name]);
		
    }
}
