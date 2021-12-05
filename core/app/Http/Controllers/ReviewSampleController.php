<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sample;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ReviewSampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		//
		if(request()->ajax())
        {
			return datatables()->of(Sample::where('status','=',1)->where('current_status','=',4)->orderBy('updated_at', 'DESC')->get())
					->addColumn('sampleid', function($data){
                        $sampleid = $data->sampleid;
                        return $sampleid;
                    })
					->addColumn('reviewsample', function($data){
                        $reviewsample = '<button data-sampleid="'.$data->id.'" data-toggle="modal" data-target="#myModal" type="button" class="reviewsample btn btn-gradient-primary btn-sm">Sample Review</button>';
                        return $reviewsample;
                    })
					->addColumn('finalised', function($data){
						if($data->current_status == 4) {
							$finalised = '<button data-sampleid="'.$data->id.'" type="button" class="finalisedsample btn btn-gradient-primary btn-sm">Finalise</button>';
						}else{
							$finalised = '<button data-sampleid="'.$data->id.'" type="button" class="finalisedsample btn btn-gradient-primary btn-sm" disabled>Finalised</button>';
						}
                        return $finalised;
                    })
                    ->rawColumns(['sampleid','reviewsample','finalised'])
                    ->make(true);
        }
		return view('reviewsample.index');
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
		try{
			$sampledata = Sample::with(['sample_testtype','sample_testtypemethod','sample_testtypesubmethod','sample_testdata'])->findOrFail($id);
			$totalinterruption = 0;
			$totalfog = 0;
			$totalph = 0;
			$totalcount = count($sampledata->sample_testdata);
			foreach($sampledata->sample_testdata as $testdata) {
				$totalinterruption = $testdata->interruptiontime + $totalinterruption;
			}
			foreach($sampledata->sample_testdata as $testdata) {
				$totalfog = $testdata->fogvalue + $totalfog;
			}
			foreach($sampledata->sample_testdata as $testdata) {
				$totalph = $testdata->phvalue + $totalph;
			}
			$avgfog = $totalfog / $totalcount;
			$avgph = $totalph / $totalcount;
			$subpath = 'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'sampleimage';
			$storagepath = storage_path($subpath);
			return view('reviewsample.show',compact('sampledata','totalinterruption','avgfog','avgph','storagepath'));
		}catch(\Exception $e){
			// catch code
			return redirect()->back()->with("error","Template not found !");
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
	
	public function finalised(Request $request)
    {
        //
		$sample = Sample::find($request->sampleid);
		$sample->current_status = 5;
		$sample->update();
		return response()->json(['success'=>'Sample Finalised successfully']);
    }
}
