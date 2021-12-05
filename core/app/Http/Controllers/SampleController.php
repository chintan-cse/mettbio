<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestType;
use App\TestTypeMethod;
use App\TestTypeSubmethod;
use App\Sample;
use App\SampleAssigned;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Helpers\GlassHelper;
use Response;

class SampleController extends Controller
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
			return datatables()->of(Sample::with(['sample_testtype','sample_testtypemethod','sample_testtypesubmethod'])->orderBy('updated_at', 'DESC')->get())
					->addColumn('sampleid', function($data){
                        $sampleid = '<a class="clickname" href="#"  id="anchor_'.$data->id.'" data-id="'.$data->id.'" data-toggle="modal" data-target="#myModal">'.$data->sampleid.'</a>';
                        return $sampleid;
                    })
					->addColumn('typemethod', function($data){
                        $typemethod = $data->sample_testtypemethod->methodname;
                        return $typemethod;
                    })
					->addColumn('clientname', function($data){
                        $clientname = $data->client_name;
                        return $clientname;
                    })
					->addColumn('productname', function($data){
                        $productname = $data->product_name;
                        return $productname;
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
                    ->rawColumns(['sampleid','typemethod','clientname','productname','action', 'status'])
                    ->make(true);
        }
		return view('sample.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$testtype = TestType::where('status','=',1)->get();
		return view('sample.create',compact('testtype'));
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
			'nabl_value' => 'required',
			'testtype_id' => 'required',
			'testtypemethod_id' => 'required',
			'clientname' => 'required',
			'contactnumber' => 'required|numeric|regex:/^[0-9\+]{10,15}$/',
			'clientemail' => 'required|email',
			'productname' => 'required',
			'productmaterial' => 'required',
			'producttype' => 'required',
			'productbatchno' => 'required',
			'productheatno' => 'required',
		];
		$customMessages = [			
			'nabl_value.required' => 'NABL type required',
			'testtype_id.required' => 'Test Type required',
			'testtypemethod_id.required' => 'Test Type Method required',
			'clientname.required' => 'Client Name required',
			'contactnumber.required' => 'Valid Client Contact Number required with Min 10 and Max 15 Digits.',
			'contactnumber.numeric' => 'Valid Client Contact Number required with Min 10 and Max 15 Digits.',
			'contactnumber.regex' => 'Valid Client Contact Number required with Min 10 and Max 15 Digits.',
			'clientemail.required' => 'Valid Client Email address required.',
			'clientemail.email' => 'Valid Client Email address required.',
			'productname.required' => 'Product Name required',
			'productmaterial.required' => 'Product Material required.',
			'producttype.required' => 'Product Type required.',
			'productbatchno.required' => 'Pruduct Batch No required.',
			'productheatno.required' => 'Product Heat No required',
		];

		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		
		try{
			$sampledata = new Sample();
			if($request->nabl_value != "" && $request->nabl_value == 'nabl') {
				$sampledata->nabl_status = 1;
			}else{
				$sampledata->nabl_status = 0;
			}
			$sampledata->sampleid = GlassHelper::getSampleIdFormat('create',$request->nabl_value);
			$sampledata->testtype_id = $request->testtype_id;
			$sampledata->testtypemethod_id = $request->testtypemethod_id;
			if(isset($request->testtypesubmethod_id) && $request->testtypesubmethod_id != "") {
				$sampledata->testtypesubmethod_id = $request->testtypesubmethod_id;
			}
			$sampledata->client_name = $request->clientname;
			if(isset($request->clientaddress) && $request->clientaddress != "") {
				$sampledata->client_address = $request->clientaddress;
			}
			
			if(isset($request->subvendor) && $request->subvendor != "") {
				$sampledata->client_subvendor = $request->subvendor;
			}
			$sampledata->client_contact = $request->contactnumber;
			$sampledata->client_mail = $request->clientemail;
			$sampledata->product_name = $request->productname;
			$sampledata->product_material = $request->productmaterial;
			$sampledata->product_type = $request->producttype;
			$sampledata->product_batchno = $request->productbatchno;
			$sampledata->product_heatno = $request->productheatno;
			if(isset($request->productclientname) && $request->productclientname != "") {
				$sampledata->product_clientname = $request->productclientname;
			}
			if(isset($request->reportdate) && $request->reportdate != "") {
				$reportdate = date('Y-m-d',strtotime($request->reportdate));
				$sampledata->required_report_date = $reportdate;
			}else{
				$sampledata->required_report_date = null;
			}
			
			if($request->return_status != "" && $request->return_status == 'on') {
				$sampledata->return_status = 1;
				if((isset($request->same_client_address) && $request->same_client_address != "" && $request->same_client_address == 'on') || (isset($request->returnaddress) && $request->returnaddress != "")) {
					if($request->same_client_address == 'on') {
						$sampledata->return_same_client = 1;
						if(isset($request->clientaddress) && $request->clientaddress != "") {
							$sampledata->return_client_address = $request->clientaddress;
						}
					}else{
						$sampledata->return_same_client = 0;
						$sampledata->return_client_address = $request->returnaddress;
					}
				}else{
					$result = [
						"error" => "Return Address Information Required!"
					];
					return response()->json(['errors'=>$result]);
				}
			}else{
				$sampledata->return_status = 0;
			}
			
			$sampledata->current_status = 1;
			
			if($sampledata->save()){
				$assignsample = new SampleAssigned();
				$assignsample->sampleid = $sampledata->id;
				$assignsample->save();
				return response()->json(['success'=>'Sample created successfully']);
			}else{
				$result = [
					"error" => "Something Went Wrong. Try Again !"
				];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			echo $e->getMessage();exit;
			// catch code
			return redirect()->back()->with("error","Sample not found !");
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
			$sample = Sample::with(['sample_testtype','sample_testtypemethod','sample_testtypesubmethod'])->findOrFail($id);
			$testtype = TestType::where('status','=',1)->get();
			$testtypemethod = TestTypeMethod::where('testtype_id','=',$sample->testtype_id)->get();
			$testtypesubmethod = TestTypeSubmethod::where('testtype_id','=',$sample->testtype_id)->where('testtypemethod_id','=',$sample->testtypemethod_id)->get();
			return view('sample.edit',compact('testtype','testtypemethod','testtypesubmethod','sample'));
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
			'nabl_value' => 'required',
			'testtype_id' => 'required',
			'testtypemethod_id' => 'required',
			'clientname' => 'required',
			'contactnumber' => 'required|numeric|regex:/^[0-9\+]{10,15}$/',
			'clientemail' => 'required|email',
			'productname' => 'required',
			'productmaterial' => 'required',
			'producttype' => 'required',
			'productbatchno' => 'required',
			'productheatno' => 'required',
		];
		$customMessages = [			
			'nabl_value.required' => 'NABL type required',
			'testtype_id.required' => 'Test Type required',
			'testtypemethod_id.required' => 'Test Type Method required',
			'clientname.required' => 'Client Name required',
			'contactnumber.required' => 'Valid Client Contact Number required with Min 10 and Max 15 Digits.',
			'contactnumber.numeric' => 'Valid Client Contact Number required with Min 10 and Max 15 Digits.',
			'contactnumber.regex' => 'Valid Client Contact Number required with Min 10 and Max 15 Digits.',
			'clientemail.required' => 'Valid Client Email address required.',
			'clientemail.email' => 'Valid Client Email address required.',
			'productname.required' => 'Product Name required',
			'productmaterial.required' => 'Product Material required.',
			'producttype.required' => 'Product Type required.',
			'productbatchno.required' => 'Pruduct Batch No required.',
			'productheatno.required' => 'Product Heat No required',
		];

		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		
		try{
			$sampledata = Sample::findOrFail($id);
			if($request->nabl_value != "" && $request->nabl_value == 'nabl') {
				$sampledata->nabl_status = 1;
			}else{
				$sampledata->nabl_status = 0;
			}
			$sampledata->sampleid = GlassHelper::getSampleIdFormat('edit',$request->nabl_value,$id);
			$sampledata->testtype_id = $request->testtype_id;
			$sampledata->testtypemethod_id = $request->testtypemethod_id;
			if(isset($request->testtypesubmethod_id) && $request->testtypesubmethod_id != "") {
				$sampledata->testtypesubmethod_id = $request->testtypesubmethod_id;
			}
			$sampledata->client_name = $request->clientname;
			if(isset($request->clientaddress) && $request->clientaddress != "") {
				$sampledata->client_address = $request->clientaddress;
			}
			
			if(isset($request->subvendor) && $request->subvendor != "") {
				$sampledata->client_subvendor = $request->subvendor;
			}
			$sampledata->client_contact = $request->contactnumber;
			$sampledata->client_mail = $request->clientemail;
			$sampledata->product_name = $request->productname;
			$sampledata->product_material = $request->productmaterial;
			$sampledata->product_type = $request->producttype;
			$sampledata->product_batchno = $request->productbatchno;
			$sampledata->product_heatno = $request->productheatno;
			if(isset($request->productclientname) && $request->productclientname != "") {
				$sampledata->product_clientname = $request->productclientname;
			}
			if(isset($request->reportdate) && $request->reportdate != "") {
				$reportdate = date('Y-m-d',strtotime($request->reportdate));
				$sampledata->required_report_date = $reportdate;
			}else{
				$sampledata->required_report_date = null;
			}
			
			if($request->return_status != "" && $request->return_status == 'on') {
				$sampledata->return_status = 1;
				if((isset($request->same_client_address) && $request->same_client_address != "" && $request->same_client_address == 'on') || (isset($request->returnaddress) && $request->returnaddress != "")) {
					if($request->same_client_address == 'on') {
						$sampledata->return_same_client = 1;
						if(isset($request->clientaddress) && $request->clientaddress != "") {
							$sampledata->return_client_address = $request->clientaddress;
						}
					}else{
						$sampledata->return_same_client = 0;
						$sampledata->return_client_address = $request->returnaddress;
					}
				}else{
					$result = [
						"error" => "Return Address Information Required!"
					];
					return response()->json(['errors'=>$result]);
				}
			}else{
				$sampledata->return_status = 0;
			}
			
			if($sampledata->update()){
				return response()->json(['success'=>'Sample created successfully']);
			}else{
				$result = [
					"error" => "Something Went Wrong. Try Again !"
				];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			// catch code
			return redirect()->back()->with("error","Sample not found !");
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
            $sample = Sample::find($id);
            $sample->status = !$sample->status;
            if($sample->save())
            {
                if($sample->status)
                {
                    return response()->json(['success'=>'Sample Enabled successfully']);
                }
                else{
                    return response()->json(['success'=>'Sample Disabled successfully']);
                }
                
            }
        }catch(\Exception $e){
			// catch code
			$result = [
						"error" => "Sample Update Failed!"
					];
			return response()->json(['errors'=>$result]);
		}
    }
	
	public function gettypemethods(Request $request)
    {
		$testtypeid = $request->testtypeid;
		$testtypemethods = TestTypeMethod::where('testtype_id','=',$testtypeid)->get();
		$status = 'success';
		return Response::json(array('status' => $status,'testtypemethods' => $testtypemethods));
    }
	
	public function gettypesubmethods(Request $request)
    {
		$testtypemethodid = $request->testtypemethodid;
		$testtypesubmethods = TestTypeSubmethod::where('testtypemethod_id','=',$testtypemethodid)->get();
		$status = 'success';
		return Response::json(array('status' => $status,'testtypesubmethods' => $testtypesubmethods));
    }
}
