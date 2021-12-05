<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use Validator;
//use Session;
use App\Helpers\GlassHelper;
class CompanyController extends Controller
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
			return datatables()->of(Company::orderBy('updated_at', 'DESC')->where('id','!=',1)->get())
					->addColumn('company_name', function($data){
                        $company_name = '<a class="clickname" href="#"  id="anchor_'.$data->id.'" data-id="'.$data->id.'" data-toggle="modal" data-target="#myModal">'.$data->company_name.'</a>';
                        return $company_name;
                    })
					->addColumn('action', function($data){
                        $button = GlassHelper::CommanActionButtons($data);
                        return $button;
                        /*$user_permissions = Session::get('user_permissions');

                        $button = '<div class="row action-btn-cs">';
                        if( in_array('company.edit', $user_permissions[0]) ||
                            in_array('company.destroy', $user_permissions[0])){

                            if(in_array('company.edit', $user_permissions[0])){
                                $button .= '<div class="col-md-2 col-6 text-center">
                                                    <a class="btn btn-gradient-info btn-rounded btn-icon" href="'.Route('company.edit', $data->id).'"><i class="mdi mdi-border-color" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                                </div>';
                            }
                            if(in_array('company.destroy', $user_permissions[0])){               
                                $button .=		'<div class="col-md-6 col-6 text-center">
                                                    <form action="'.Route('company.destroy', $data->id).'" method="POST">';
                                $button .= csrf_field();
                                $button .= '<input type="hidden" name="_method" value="DELETE">';
                                $button .= 	'<button type="submit" onclick="return confirm(';
                                $button .= 	'\'Are you sure to delete this Glass Item?\'';
                                            
                                $button .= 	')" class="btn btn-gradient-danger btn-rounded btn-sm btn-icon"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Remove"></i> </button>
                                                    </form>
                                                </div>';
                            }
                        }
                        else{
                            $button .= '<div class="col-md-2 col-6 text-center">
                                           <i class="mdi mdi-key" data-toggle="tooltip" data-placement="top" title="No Permission"></i>
                                        </div>';
                        }
                        $button .='</div>'; 
                        return $button;*/
                    })
                    ->addColumn('status', function($data){
                        $status = '<div class="toggle-btn-cs"><input type="checkbox" name="toggle" class="toggleitem" data-id="'.$data->id.'" data-toggle="toggle" data-off="Disable" data-on="Enable"';
						$status .= $data->status ? 'checked' : '';
                        $status .= '></div>';
                        return $status;
                    })
                    ->rawColumns(['company_name','action', 'status'])
                    ->make(true);
        }
		
        // $citizen = Citizen::with(['getTehsil', 'getSchemes'])->get();
		return view('company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //for percentage validation   -- between:0,99.99
        $rules =[
            'company_id' => 'required|numeric|between:0,999999|unique:company,company_id',
            'company_name' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:50',
            'email' => 'nullable|email|unique:company,email',
            'discount' => 'numeric|between:0,99.99', 
        ];

        $validator = Validator::make( $request->all(), $rules);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

		try{
            $company = new Company();
            $company->company_id = $request->company_id;
            $company->company_name = $request->company_name;
            $company->email = $request->email;
            $company->discount = number_format($request->discount, 2);
            $company->status = 1;

            if($company->save()){
                return response()->json(['success'=>'Company created successfully']);				
            }
            else{
                $result = [
                        "error" => "Company Entry Failed!"
                    ];
                return response()->json(['errors'=>$result]);
            }
        }
        catch(\Exception $e) {
                // catch code			
                $result = [
                    "error" => "Company Entry Failed!"
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
		try{
			$company = Company::findOrFail($id);
			return view('company.show')->with('company', $company);
		}catch(\Exception $e){
			// catch code
			return redirect()->back()->with("error","Company not found !");
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
        try{
            
            $company = Company::findOrFail($id);
            return view('company.edit', compact('company'));

        }catch(\Exception $e){
            return redirect()->back()->with("error","Company not found !");
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

        $rules =[
            'company_id' => 'required|numeric|between:0,999999|unique:company,company_id,'.$id,
            'company_name' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:50',
            'email' => 'nullable|email|unique:company,email,'.$id,
            'discount' => 'numeric|between:0,99.99', 
        ];

        $validator = Validator::make( $request->all(), $rules);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		
		try{
			$company = Company::findOrFail($id);
            $company->company_id = $request->company_id;
            $company->company_name = $request->company_name;
            $company->email = $request->email;
            $company->discount = number_format($request->discount, 2);
			
			if($company->update()){
				return response()->json(['success'=>'Company updated successfully']);
			}else{
				$result = [
						"error" => "Company Update Failed!"
					];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			// catch code
			$result = [
						"error" => "Company Update Failed!"
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
            $company = Company::findOrFail($id);
            $company->status = !$company->status;
            if($company->save())
            {
                if($company->status)
                {
                    return response()->json(['success'=>'Company Enabled successfully']);
                }
                else{
                    return response()->json(['success'=>'Company Disabled successfully']);
                }
                
            }
        }catch(\Exception $e){
			// catch code
			$result = [
						"error" => "Company Update Failed!"
					];
			return response()->json(['errors'=>$result]);
		}
        //return redirect()->back()->with("success", "Company deleted!");
    }
}
