<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\TestType;
use App\TestTypeMethod;
use App\TestTypeSubmethod;
use App\Sample;
use App\SampleAssigned;
use App\Sampletestdata;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Helpers\GlassHelper;
use Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TestCertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$userid = Auth::user()->id;
		$sample = Sample::whereIn('id', function ($subquery) use($userid) {
						$subquery->select('sampleid')
							->from('sampleassigned')
							->where('userid','=',$userid);
					})->orderBy('updated_at', 'DESC')->get();
		return view('testcertification.index',compact('sample'));
    }
	
	private function randomnumber() {
        $number = rand (10,99);
        return $number;
    }
	
	private function createPathAndFile($doc,$sampleid,$filename,$type) {
		$subpath = 'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'sampleimage';
		$wpath = storage_path($subpath);
		$wpath .= DIRECTORY_SEPARATOR;
		$wpath .= $sampleid;
		$returnvalue = $sampleid;
		//create directory
		if(!File::exists($wpath)){
			File::makeDirectory($wpath, 0755, true, true);
		};
		//Write data back to pdf file
		$wpath .= DIRECTORY_SEPARATOR;
		if($type == 'beforetested'){
			$wpath .= 'beforetesting';
		}else if($type == 'tested'){
			$wpath .= 'aftertesting';
		}
		$returnvalue .= DIRECTORY_SEPARATOR;
		if($type == 'beforetested'){
			$returnvalue .= 'beforetesting';
		}else if($type == 'tested'){
			$returnvalue .= 'aftertesting';
		}
		if(!File::exists($wpath)){
			File::makeDirectory($wpath, 0755, true, true);
		};														
		$wpath .= DIRECTORY_SEPARATOR;								
		$wpath .= $filename;
		$returnvalue .= DIRECTORY_SEPARATOR;
		$returnvalue .= $filename;
		//Write data back to pdf file
		file_put_contents($wpath, $doc);
		return $returnvalue;
	}
	
	
	private function daysList($hours,$sampleid,$templateid) {
		$hid = 24; // Hours in a day - could be 24, 8, etc
		$days = round($hours/$hid);
		$Date = date('Y-m-d');
		if( $days < 0 ){
			echo "hours";
		}else{
			for($i=1;$i<=$days;$i++) {
				$sampletestdata = new Sampletestdata();
				$sampletestdata->sampleid = $sampleid;
				$sampletestdata->templateid = $templateid;
				$sampletestdata->datelist = date('Y-m-d', strtotime($Date. ' + '.$i.' days'));
				$sampletestdata->observationhours = $hid * $i;
				$sampletestdata->save();
			}
		}
	}

	public function generatetest(Request $request){
		$validimagetype = array('jpeg','png','jpg','JPEG','PNG','JPG');
		$rules = [
			'testcert_sample_id' => 'required',
		];
		$customMessages = [			
			'testcert_sample_id.required' => 'Sample selection required',
		];

		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		
		try{
			$sampleid = $request->testcert_sample_id;
			$sample = Sample::with(['sample_testtype','sample_testtypemethod','sample_testtypesubmethod'])->findOrFail($sampleid);
			if($sample) {
				$beforeimagelist = array();
				if($request->has('sampleimage_beforetesting') && !empty($request->has('sampleimage_beforetesting'))){
					foreach($request->file('sampleimage_beforetesting') as $value){
						$docextension = $value->getClientOriginalExtension();
						if(in_array($docextension,$validimagetype)){
							$filename = $sample->sampleid.'_'.$this->randomnumber().'_'.$value->getClientOriginalName();
							$beforeimage = $this->createPathAndFile(File::get($value),$sample->sampleid,$filename,'beforetested');
							array_push($beforeimagelist,$beforeimage);
						}else{
							$result = [
								"error" => "Please upload Image in JPG,PNG format only.!"
							];
							return response()->json(['errors'=>$result]);
						}
					}
					$beforeimagestr = serialize($beforeimagelist);
					$sample->before_images = $beforeimagestr;
				}
				$sample->current_status = 3;
				$sample->sampleteststartdate = now();
				$hours = $sample->sample_testtypemethod->exposure_time;
				$this->daysList($hours,$sampleid,$sample->sample_testtypemethod->template_id);
				if($sample->update()){
					$templateid = $sample->sample_testtypemethod->template_id;
					$sampletestdata = Sampletestdata::where('sampleid','=',$sampleid)->where('templateid','=',$templateid)->get();
					return view('testcertification.testdata',compact('sampleid','templateid','sampletestdata'))->render();	
				}else{
					$result = [
						"error" => "Something went wrong !"
					];
					return response()->json(['errors'=>$result]);
				}
			}else{
				$result = [
					"error" => "Sample not found !"
				];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			echo $e->getMessage();exit;
			// catch code
			return redirect()->back()->with("error","Sample not found !");
		}
	}
	
	public function afterselectsample(Request $request) {		
		try{
			$sample = Sample::with(['sample_testtype','sample_testtypemethod','sample_testtypesubmethod'])->find($request->sampleid);
			if($sample) {
				if($sample->current_status == 1 || $sample->current_status == 2){
					return view('testcertification.afterselectsample',compact('sample'))->render();
				}else{
					$sampleid = $sample->id;
					$templateid = $sample->sample_testtypemethod->template_id;
					$sampletestdata = Sampletestdata::where('sampleid','=',$sampleid)->where('templateid','=',$templateid)->get();
					return view('testcertification.testdata',compact('sampleid','templateid','sampletestdata'))->render();
				}
			}
		}catch(\Exception $e){
			echo $e->getMessage();exit;
			// catch code
			return redirect()->back()->with("error","Testentry not found !");
		}
	}
	
	public function testdataentry(Request $request) {
		$validimagetype = array('jpeg','png','jpg','JPEG','PNG','JPG');
		$rules = [
			'entryrow' => 'required',
			'fog' => "required|numeric|between:1.0,2.0",
			'ph' => "required|numeric|between:6.2,7.5",
			'rusting' => 'required',
			'interruptiontime' => 'required|numeric',
		];
		$customMessages = [			
			'entryrow.required' => 'Entry Row value missing.',
			'fog.required' => 'Fog Required.',
			'fog.numeric' => 'Fog value should be between 1.0 and 2.0.',
			'fog.between' => 'Fog value should be between 1.0 and 2.0.',
			'ph.required' => 'PH required.',
			'ph.numeric' => 'PH value should be between 6.2 and 7.5.',
			'ph.between' => 'PH value should be between 6.2 and 7.5.',
			'interruptiontime.required' => 'Interruption Time required.',
			'interruptiontime.numeric' => 'Interruption Time value should be numeric.',
		];

		$validator = Validator::make( $request->all(), $rules, $customMessages );
		
		if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
		try{
			$entryrow = $request->entryrow;
			$earlierrow = $entryrow - 1;
			$sampletestdata = Sampletestdata::with(['sampletestdata_sample'])->find($entryrow);
			$earliersampletestdata = Sampletestdata::where('sampleid','=',$sampletestdata->sampleid)->where('templateid','=',$sampletestdata->templateid)->with(['sampletestdata_sample'])->find($earlierrow);
			if($earliersampletestdata){
				if(!$earliersampletestdata->filled){
					$result = [
						"error" => "Earlier Data Entries are pending. !"
					];
					return response()->json(['errors'=>$result]);
				}
			}
			$sampletestdata->fogvalue = $request->fog;
			$sampletestdata->phvalue = $request->ph;
			$sampletestdata->rust = $request->rusting;
			$sampletestdata->interruptiontime = $request->interruptiontime;
			$aftermagelist = array();
			if($request->has('testedimages') && !empty($request->testedimages)){
				foreach($request->file('testedimages') as $value){					
					$docextension = $value->getClientOriginalExtension();
					if(in_array($docextension,$validimagetype)){
						$filename = $sampletestdata->sampletestdata_sample->sampleid.'_'.$this->randomnumber().'_'.$value->getClientOriginalName();
						$afterimage = $this->createPathAndFile(File::get($value),$sampletestdata->sampletestdata_sample->sampleid,$filename,'tested');
						array_push($aftermagelist,$afterimage);
					}else{
						$result = [
							"error" => "Please upload Image in JPG,PNG format only.!"
						];
						return response()->json(['errors'=>$result]);
					}
				}
				$afterimagestr = serialize($aftermagelist);
				$sampletestdata->testedimages = $afterimagestr;
			}
			if($request->has('remarks') && !empty($request->remarks)){
				$sampletestdata->remarks = $request->remarks;
			}
			$sampletestdata->filled = 1;
			if($sampletestdata->update()){
				if(isset($request->lastentry) && $request->lastentry == 'last'){
					$sample = Sample::findOrFail($sampletestdata->sampleid);
					$sample->current_status = 4;
					$sample->sampletestenddate = now();
					$sample->update();
				}
				return response()->json(['success'=>'Testentry Data updated successfully !']);
			}else{
				$result = [
						"error" => "Testentry not found !"
					];
				return response()->json(['errors'=>$result]);
			}
		}catch(\Exception $e){
			echo $e->getMessage();exit;
			// catch code
			return redirect()->back()->with("error","Testentry not found !");
		}
	}
}
