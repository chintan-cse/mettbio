<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sample;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Helpers\GlassHelper;

class RowDataPdfController extends Controller
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
			return datatables()->of(Sample::where('status','=',1)->orderBy('updated_at', 'DESC')->get())
					->addColumn('sampleid', function($data){
                        $sampleid = '<a class="clickname" href="#"  id="anchor_'.$data->id.'" data-id="'.$data->id.'" data-toggle="modal" data-target="#myModal">'.$data->sampleid.'</a>';
                        return $sampleid;
                    })
					->addColumn('printpreview', function($data){
                        $printpreview = '<button data-sampleid="'.$data->id.'" type="button" class="previewpdf btn btn-gradient-primary btn-sm">Print Preview</button>';
                        return $printpreview;
                    })
					->addColumn('print', function($data){
						if($data->current_status == 1) {
							$print = '<button data-sampleid="'.$data->id.'" type="button" class="printpdf btn btn-gradient-primary btn-sm">Print</button>';
						}else{
							$print = '<button data-sampleid="'.$data->id.'" type="button" class="printpdf btn btn-gradient-primary btn-sm" disabled>Print</button>';
						}
                        return $print;
                    })
                    ->rawColumns(['sampleid','printpreview','print'])
                    ->make(true);
        }
		return view('rowpdf.index');
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
	
	public function rowpdfprint(Request $request)
    {
        //
		$sample = Sample::find($request->sampleid);
		$sample->current_status = 2;
		$sample->sampleprintdate = now();
		$sample->update();
		return response()->json(['success'=>'Print Generated successfully']);
    }
}
