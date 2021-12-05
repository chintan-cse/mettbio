<div class="row">
        <div class="col-md-12">
						<div class="row  profile-row req ">	
							<div class="col-lg-4 col-12">
								<div class="row pop-label">
									<label>Firstname : </label>
									<span>{{$userprofile->firstname}}</span>		
								</div>
							</div>
							<div class="col-lg-4 col-12">
								<div class="row pop-label">							
									<label>Lastname : </label>								
									<span>{{$userprofile->lastname}}</span>
								</div>
							</div>						
							<div class="col-lg-4 col-12">
								<div class="row pop-label">
									<label>Company name : </label>
									<span>{{$company->company_name}}</span>		
								</div>
							</div>
							<div class="col-lg-4 col-12">
								<div class="row pop-label">							
									<label>Email : </label>								
									<span>{{$user->email}}</span>
								</div>
							</div>
							<div class="col-lg-4 col-12">
								<div class="row pop-label">
									<label>Phone Number : </label>
									<span>{{$userprofile->phone_number}}</span>		
								</div>
							</div>
							<div class="col-lg-4 col-12">
								<div class="row pop-label">							
									<label>City : </label>								
									<span> {{$userprofile->city}}</span>
								</div>
							</div>

						</div>
					
						<div class="row  profile-row req ">		
							
						
							<div class="col-lg-4 col-12">
								<div class="row pop-label">
									<label>State : </label>
									<span> {{$userprofile->state}}</span>		
								</div>
							</div>
							<div class="col-lg-4 col-12">
								<div class="row pop-label">							
									<label>Country : </label>								
									<span> {{$userprofile->country}}</span>
								</div>
							</div>
							<div class="col-lg-4 col-12">
								<div class="row pop-label">							
									<label>Zipcode : </label>								
									<span> {{$userprofile->zip}}</span>
								</div>
							</div>
						</div>
						<div class="row  profile-row req ">							
							<!--<div class="col-lg-12 col-12">
								<div class="row pop-label">
									<label>Discount(%) : </label>
									<span> {{$userprofile->discount}}</span>		
								</div>
							</div>-->
							<div class="col-lg-12 col-12">
								<div class="row pop-label">							
									<label>Address : </label>								
									<span> {{$userprofile->address}}</span>
								</div>
							</div>
						</div>
						<div class="row  profile-row req ">		
								<div class="col-lg-3 col-12">
									<div class="row pop-label">
										<label>Role : </label>								
										<span>{{$role->role_name}}</span>
									</div>
								</div>
						</div>		
						
			</div>

</div>