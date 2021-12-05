<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestType;
use App\TestTypeMethod;
use App\TestTypeSubmethod;
use App\Templatelist;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Helpers\GlassHelper;

class TestTypeController extends Controller
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
			return datatables()->of(TestType::with([])->get())
					->addColumn('typename', function($data){
                        $typename = '<a class="clickname" href="#"  id="anchor_'.$data->id.'" data-id="'.$data->id.'" data-toggle="modal" data-target="#myModal">'.$data->typename.'</a>';
                        return $typename;
                    })
                    ->addColumn('action', function($data){
						$button = GlassHelper::CommanActionButtons($data);
                        return $button;
					})
					->addColumn('status', function($data){
                        $status = '<div class="toggle-btn-cs"><input type="checkbox" name="toggle" class="toggleitem" data-id="'.$data->id.'" data-toggle="toggle" data-off="Disable" data-on="Enable"';
						$status .= $data->status ? 'checked' : '';
                        $status .= '></div>';
                        return $status;
                    })
                    ->rawColumns(['typename','action', 'status'])
                    ->make(true);
        }
		return view('testtype.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$templatelist = Templatelist::get();
		return view('testtype.create',compact('templatelist'));
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
		$rules = [
			'testtypename' => 'required',
		];
		$customMessages = [			
			'testtypename.required' => 'Type Name required',
		];

		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		
		try{
			$testtype = new TestType();
			$testtype->typename = $request->testtypename;
			if(empty($request->testtype)){
				$result = [
							"error" => "Type need atleast one Type method !",
						];
				return response()->json(['errors'=>$result]);
			}
			if($request->testtype[0]['methodname'] == "") {
				$result = [
					"error" => "Type need atleast one Type method !",
				];
				return response()->json(['errors'=>$result]);
			}
			if(count($request->testtype) > 0) {
				if($testtype->save()){
					foreach($request->testtype as $typevalues){
						if($typevalues['methodname'] != "") {
							$testtypemethod = new TestTypeMethod();
							$testtypemethod->methodname = $typevalues['methodname'];
							if($typevalues['templateid'] != "") {
								$testtypemethod->template_id = $typevalues['templateid'];
							}
							if($typevalues['exposuretime'] != "") {
								$testtypemethod->exposure_time = $typevalues['exposuretime'];
							}
							$testtypemethod->testtype_id = $testtype->id;
							if($testtypemethod->save()){
								if(isset($typevalues['method']) && !empty($typevalues['method'])){
									foreach($typevalues['method'] as $methodvalues){
										$submethodvalues = new TestTypeSubmethod();
										if(isset($methodvalues['submethodname']) && $methodvalues['submethodname'] != "") {
											$submethodvalues->submethodname = $methodvalues['submethodname'];
											$submethodvalues->testtype_id = $testtype->id;
											$submethodvalues->testtypemethod_id = $testtypemethod->id;
											$submethodvalues->save();
										}
									}
								}								
							}
						}						
					}
				}
				return response()->json(['success'=>'Test Type created successfully']);
			}else{
				$result = [
					"error" => "Type need atleast one Type method !",
				];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			$result = [
				"error" => "Something went wrong!",
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
		try{
			$templatelist = Templatelist::get();
			$testtype = TestType::with(['testtype_method','testtype_submethod'])->findOrFail($id);
			return view('testtype.edit',compact('testtype','templatelist'));
		}catch(\Exception $e){
			// catch code
			return redirect()->back()->with("error","Glass not found !");
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
        //
		$rules = [
			'testtypename' => 'required',
		];
		$customMessages = [			
			'testtypename.required' => 'Type Name required',
		];

		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		
		try{
			$testtype = TestType::findOrFail($id);
			$testtype->typename = $request->testtypename;
			if(empty($request->testtype)){
				$result = [
							"error" => "Type need atleast one Type method !",
						];
				return response()->json(['errors'=>$result]);
			}
			if($request->testtype[0]['methodname'] == "") {
				$result = [
					"error" => "Type need atleast one Type method !",
				];
				return response()->json(['errors'=>$result]);
			}
			if(count($request->testtype) > 0) {
				if($testtype->update()){
					foreach($request->testtype as $typevalues){
						if(isset($typevalues['methodid']) && $typevalues['methodid'] != ""){
							// $testtypemethod = TestTypeMethod::findOrFail($typevalues['methodid']);
							// $submethodvalues = TestTypeSubmethod::where('testtypemethod_id','=',$typevalues['methodid'])->get();
							// if($submethodvalues) {
								// foreach($submethodvalues as $submethod) {
									// $submethod->delete();	
								// }
							// }
							// $testtypemethod->delete();
							if(isset($typevalues['methodname']) && $typevalues['methodname'] != "") {
								$testtypemethod = TestTypeMethod::findOrFail($typevalues['methodid']);
								$testtypemethod->methodname = $typevalues['methodname'];
								if($typevalues['templateid'] != "") {
									$testtypemethod->template_id = $typevalues['templateid'];
								}
								if($typevalues['exposuretime'] != "") {
									$testtypemethod->exposure_time = $typevalues['exposuretime'];
								}
								$testtypemethod->testtype_id = $testtype->id;
								if($testtypemethod->update()){
									if(isset($typevalues['method']) && !empty($typevalues['method'])){
										foreach($typevalues['method'] as $methodvalues){
											if(isset($methodvalues['submethodid']) && $methodvalues['submethodid'] != ""){
												$submethodvalues = TestTypeSubmethod::findOrFail($methodvalues['submethodid']);
												if(isset($methodvalues['submethodname']) && $methodvalues['submethodname'] != "") {
													// $submethodvalues = new TestTypeSubmethod();
													$submethodvalues->submethodname = $methodvalues['submethodname'];
													$submethodvalues->testtype_id = $testtype->id;
													$submethodvalues->testtypemethod_id = $testtypemethod->id;
													$submethodvalues->update();												
												}
											}else{
												if(isset($methodvalues['submethodname']) && $methodvalues['submethodname'] != "") {
													$submethodvalues = new TestTypeSubmethod();
													$submethodvalues->submethodname = $methodvalues['submethodname'];
													$submethodvalues->testtype_id = $testtype->id;
													$submethodvalues->testtypemethod_id = $testtypemethod->id;
													$submethodvalues->save();		
												}
											}												
										}
									}								
								}
							}
						}else{
								$testtypemethod = new TestTypeMethod();
								$testtypemethod->methodname = $typevalues['methodname'];
								if($typevalues['templateid'] != "") {
									$testtypemethod->template_id = $typevalues['templateid'];
								}
								if($typevalues['exposuretime'] != "") {
									$testtypemethod->exposure_time = $typevalues['exposuretime'];
								}
								$testtypemethod->testtype_id = $testtype->id;
								if($testtypemethod->save()){
									if(isset($typevalues['method']) && !empty($typevalues['method'])){
										foreach($typevalues['method'] as $methodvalues){
											$submethodvalues = new TestTypeSubmethod();
											if(isset($methodvalues['submethodname']) && $methodvalues['submethodname'] != "") {
												$submethodvalues->submethodname = $methodvalues['submethodname'];
												$submethodvalues->testtype_id = $testtype->id;
												$submethodvalues->testtypemethod_id = $testtypemethod->id;
												$submethodvalues->save();
											}
										}
									}								
								}
							}						
					}
				}
				return response()->json(['success'=>'Test Type updated successfully']);
			}else{
				$result = [
					"error" => "Type need atleast one Type method !",
				];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			$result = [
				"error" => "Something went wrong!",
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
        //
		try{
            $testtype = TestType::find($id);
            $testtype->status = !$testtype->status;
            if($testtype->save())
            {
                if($testtype->status)
                {
                    return response()->json(['success'=>'Type Enabled successfully']);
                }
                else{
                    return response()->json(['success'=>'Type Disabled successfully']);
                }
                
            }
        }catch(\Exception $e){
			// catch code
			$result = [
						"error" => "Type Update Failed!"
					];
			return response()->json(['errors'=>$result]);
		}
    }
}
