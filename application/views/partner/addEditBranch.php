 <div id="partner-home">
	<div class="container">
		<div id="form-section" class="custom-grey">
			<div class="center">
				<?php 
					echo validation_errors(); 
					$profile_image = $logo = $featured_image = $cover_image = '';
					
					if(isset($daycareDetails['logo']) && $daycareDetails['logo'] != ''){
						$profile_image = $daycareDetails['logo'];
					}

					if($profile_image != ''){
						$logo = generate_image_url('images/reskilling/desktop/vendors/'. $profile_image);
					}					

					if(isset($daycareDetails['cover_image']) && $daycareDetails['cover_image'] != ''){
						$cover_image = $daycareDetails['cover_image'];
					}

					if($cover_image != ''){
						$featured_image = generate_image_url('images/reskilling/desktop/vendors/'. $cover_image);
					}
				?>
			</div>

			<form id="frm_addEditProfile" name="frm_addEditProfile" action="<?php echo partner_base_url('save-branch');?>" method="post" enctype="multipart/form-data">
				<h2 class="center">Partner Details</h2>

				<div class="row white">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Logo & Cover Image
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s12 m4 l4 profile-image-section">
										<label for="logo">Logo</label>
										<input type="text" class="visbilty-none hide" name="profile_image" id="profile_image" value="<?php echo $profile_image;?>">
										<input type="file" name="logo" class="dropify" id="logo"
										data-default-file="<?php echo $logo;?>"  />
										
										<div class="error"><?php echo form_error('profile_image'); ?></div>
														
									</div>
									
									<div class="col s12 m8 l8 cover-image-section">
										<label for="cover_image">Cover Image</label>
										<input type="text" class="visbilty-none hide" name="cover_image" id="cover_image" value="<?php echo $cover_image;?>">
										<input type="file" name="featured-image" class="dropify" id="featured_image"
										data-default-file="<?php echo $featured_image;?>" />
										
										<div class="error"><?php echo form_error('profile_image'); ?></div>
														
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>



				<div class="row white">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>About your Daycare
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">
	
								<div class="row">
									<div class="col s12 m12 l12 input-field">
										<textarea id="aboutus" name="aboutus" class="tinymce-editor"><?php echo $daycareDetails['description']?></textarea>
				            			<label for="aboutus" class="custom">About Us*</label>
									</div>
								</div>

								<div class="row">
									<div class="col s12 m12 l12 input-field">
										<textarea id="additional-information" name="additional-information" class="tinymce-editor">
											<?php echo $daycareDetails['additional-information']?></textarea>
				            			<label for="additional-information" class="custom">Additional Information</label>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>

				<div class="row white">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Contact Info
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s12 m12 l12 input-field">
										<textarea id="registered-address" name="registered-address" class=""><?php echo $daycareDetails['address']?></textarea>
				            			<label for="registered-address" class="custom">Address Line 1</label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12 m4 l4 other-details">
										<input id="contact_name" name="contact_name" type="text" data-length="10" value="<?php echo $daycareDetails['contact_name']?>">
				            			<label for="contact_name">Contact Name</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="email" name="email" type="text" value="<?php echo $daycareDetails['email']?>">
				            			<label for="email">Email</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="mobile" name="mobile" type="text" data-length="10" value="<?php echo $daycareDetails['mobile']?>">
				            			<label for="mobile">Mobile/Phone No</label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12 m4 l4 other-details">
										<input id="pan" name="pan" type="text" data-length="10" value="<?php echo $daycareDetails['city_id']?>">
				            			<label for="pan">City</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="gst" name="gst" type="text" data-length="10" value="<?php echo $daycareDetails['area']?>">
				            			<label for="gst">Area</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="sac" name="sac" type="text" data-length="10" value="<?php echo $daycareDetails['zip']?>">
				            			<label for="sac">Zip</label>
									</div>
								</div>

							</div>
						</li>
					</ul>
				</div>				
				

				<div class="row white">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Timings
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="input-field col s12 m3 l3 other-details">
										<select id="weekdays_start_time" class="" name="weekdays_start_time" >
											<option value="" >Weekdays Start Time</option>
											<option value="6:00 am" >6:00 am</option>
										</select>
				            			<label for="weekdays_start_time">Weekdays Start Time</label>
									</div>

									<div class="input-field col s12 m3 l3 other-details">
										<select id="weekdays_end_time" class="" name="weekdays_end_time" >
											<option value="" >Weekdays End Time</option>
											<option value="6:00 pm" >6:00 am</option>
										</select>
				            			<label for="weekdays_end_time">Weekdays End Time</label>
									</div>
								</div>
								
								<div class="row">	

									<div class="input-field col s12 m3 l3 other-details">
										<select id="weekend_start_time" class="" name="weekend_start_time" >
											<option value="" >Weekend Start Time</option>
											<option value="6:00 pm" >6:00 am</option>
										</select>
				            			<label for="weekend_start_time">Weekend Start Time</label>
									</div>

									<div class="input-field col s12 m3 l3 other-details">
										<select id="weekend_end_time" class="" name="weekend_end_time" >
											<option value="" >Weekend End Time</option>
											<option value="6:00 pm" >6:00 am</option>
										</select>
				            			<label for="weekend_end_time">Weekend End Time</label> 
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>				
	
						
						

				

				<div class="row white">
					<ul id="features-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Features
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s3 m3 l3">
										<input type="checkbox" name="food_provided" id="food_provided" class="margin20"  />
					      				<label for="food_provided">Food Provided</label>
					      			</div>	

					      			<div class="col s3 m3 l3">
					      				<input type="checkbox" id="doctor_on_call" name="doctor_on_call" class="margin20" />
					      				<label for="doctor_on_call">Doctor on call</label>
				      				</div>

				      				<div class="col s3 m3 l3">
					      				<input type="checkbox" id="open_on_weekends" name="open_on_weekends" class="margin20" />
					      				<label for="open_on_weekends">Open on weekends</label>
				      				</div>

				      				<div class="col s3 m3 l3">
					      				<input type="checkbox" id="activities_available" name="activities_available" class="margin20" />
					      				<label for="activities_available">Activities</label>
				      				</div>

				      				<div class="col s3 m3 l3">
					      				<input type="checkbox" id="pick_drop" name="pick_drop" class="margin20" />
					      				<label for="pick_drop">Pickup & Drop</label>
				      				</div>

				      				<div class="col s3 m3 l3">
					      				<input type="checkbox" id="credit_debit_card" name="credit_debit_card" class="margin20" />
					      				<label for="credit_debit_card">Credit/Debit Card Payment</label>
				      				</div>
								</div>
								
							</div>
						</li>
					</ul>
				</div>				

				<div class="row white">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Video & Image Gallery
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="input-field col s12 m4 l4 other-details">
										<input id="video-id" name="video-id" type="text" value="">
				            			<label for="video-id">Video URL</label>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>				
				
				<div class="row white">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Social Links
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">

								<div class="row">
									<div class="input-field col s12 m4 l4 other-details">
										<input id="facebook-id" name="facebook-id" type="text" data-length="10" value="<?php echo $daycareDetails['facebook_id']?>">
				            			<label for="facebook-id">Facebook ID</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="twitter-id" name="twitter-id" type="text" data-length="10" value="<?php echo $daycareDetails['twitter_id']?>"> 
				            			<label for="twitter-id">Twitter ID</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										<input id="linkedin-id" name="linkedin-id" type="text" data-length="10" value="<?php echo $daycareDetails['linkedin_id']?>">
				            			<label for="linkedin-id">Linkedin ID</label>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>

				<div class="row">
					<div class="col s12 m12 l12 center">
						<input type="submit" value="Save" id="save-branch" class="btn daycare-green-btn compact">
						
					</div>
				</div>		
			</form>	
		</div>

	</div>
</div>