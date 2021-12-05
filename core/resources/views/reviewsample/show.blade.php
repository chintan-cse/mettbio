<div class="row">
    <div class="col-md-12">
		<div class="row  profile-row req ">	
			<div class="col-md-12">
				<div class="row pop-label">
					<label>Test Start Details : </label>
					<span>{{date('d/m/Y h:m:s', strtotime($sampledata->sampleteststartdate))}}</span>		
				</div>
				<div class="row pop-label">
					<label>Test End Details : </label>
					<span>{{date('d/m/Y h:m:s', strtotime($sampledata->sampletestenddate))}}</span>		
				</div>
				<div class="row pop-label">
					<label>Interruption Hrs : </label>
					<span>{{$totalinterruption}} Min.</span>		
				</div>
				<div class="row pop-label">
					<label>Total Exposure Time : </label>
					<span>{{$sampledata->sample_testtypemethod->exposure_time}} Hrs.</span>		
				</div>
			</div>
		</div>
		<div class="row  profile-row req ">	
			<div class="col-md-12">
				<table class="table">
					<thead>
					  <tr>
						<th>Sr No</th>
						<th>Date</th>
						<th>Observation</th>
						<th>Fog Collection (ml/hr)</th>
						<th>pH</th>
					  </tr>
					</thead>
					<tbody>
					@foreach($sampledata->sample_testdata as $testdata)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{date('d/m/Y', strtotime($testdata->datelist))}}</td>
							<td>{{$testdata->observationhours}} Hrs.</td>
							<td>{{$testdata->fogvalue}}</td>
							<td>{{$testdata->phvalue}}</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="3" style="text-align:center;">Avg.</td>
							<td>{{$avgfog}}</td>
							<td>{{$avgph}}</td>
						</tr>
					</tbody>
				  </table>
			</div>
		</div>
		
		<div class="row  profile-row req ">	
			<div class="col-md-12">
				<table class="table">
					<thead>
					  <tr>
						<th>Sr No</th>
						<th>Date</th>
						<th>Exposure Hrs.</th>
						<th>Observation <br/>(White Rust,Red Rust)</th>
						<th>Remark</th>
					  </tr>
					</thead>
					<tbody>
					@foreach($sampledata->sample_testdata as $testdata)
						<tr>
							<td>{{$loop->index + 1}}</td>
							<td>{{date('d/m/Y', strtotime($testdata->datelist))}}</td>
							<td>{{$testdata->observationhours}} Hrs.</td>
							<td>@if($testdata->rust == 'yes') White/Red Rust @else No @endif</td>
							<td>{{$testdata->remarks}}</td>
						</tr>
					@endforeach
					</tbody>
				  </table>
			</div>
		</div>
		
		<div class="row  profile-row req ">	
			<div class="col-md-12">
				@if(isset($sampledata->before_images) && $sampledata->before_images != "")
					<div class="row pop-label">
					Sample Condition before Test
					@foreach(unserialize($sampledata->before_images) as $beforeimages)
						<div class="col-md-4">
							<img src="{{Storage::disk('sampleimage')->url($beforeimages)}}" style="width: 100%;height: 100%;">
						</div>
					@endforeach
					</div>
				@endif
			</div>
		</div>
		
		<div class="row  profile-row req ">	
			<div class="col-md-12">
				@foreach($sampledata->sample_testdata as $testdata)
					@if(isset($testdata->testedimages) && $testdata->testedimages != "")
						Sample Condition after Test ({{$testdata->observationhours}} Hrs. ISO 9227:2017)
						<div class="row pop-label">
						@foreach(unserialize($testdata->testedimages) as $afterimages)
							<div class="col-md-4">
								<img src="{{Storage::disk('sampleimage')->url($afterimages)}}" style="width: 100%;height: 100%;">
							</div>
						@endforeach
						</div>
						<div class="row pop-label">
							<table class="table">
								<tbody>
								<tr>
									<td>Date: {{date('d/m/Y', strtotime($testdata->datelist))}}</td>
									<td>pH: {{$testdata->phvalue}}</td>
									<td>Fog Collection: {{$testdata->fogvalue}}</td>
								</tr>
								<tr>
									<td>Remark : {{$testdata->remarks}}</td>
								</tr>
								</tbody>
							</table>
						</div>
					@endif
				@endforeach
			</div>
		</div>
	</div>
</div>