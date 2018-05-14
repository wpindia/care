<?php 
	$weekDaysStartTime 	= $daycareDetails['weekdays_start_time'];
	$weekDaysEndTime 	= $daycareDetails['weekdays_end_time'];
	$weekEndStartTime 	= $daycareDetails['weekend_start_time'];
	$weekEndEndTime 	= $daycareDetails['weekend_end_time'];
	//show($weekendStartTime);
?>

 <div id="partner-home">
	<div class="container">
		<div id="form-section" class="custom-grey">
			<div class="center">
				<?php 
					echo validation_errors(); 
					$profile_image = $logo = $featured_image = $cover_image = '';
					
					if(isset($daycareDetails['logo']) && $daycareDetails['logo'] != ''){
						$logo = generateImageUrl( 'uploads/admin/'. $daycareDetails['vendor_id'] . '/' . $daycareDetails['logo'] );
					}

					if(isset($daycareDetails['featured_image']) && $daycareDetails['featured_image'] != ''){
						$featured_image = generateImageUrl( 'uploads/admin/'. $daycareDetails['vendor_id'] . '/' . $daycareDetails['featured_image'] );
					}
					//var_dump($logo);
					//show($featured_image);	
				?>
			</div>

			<form id="frm_addEditProfile" name="frm_addEditProfile" action="<?php echo partner_base_url('save-branch');?>" method="post" enctype="multipart/form-data">
				<h2 class="center">Branch Details</h2>
				<input type="hidden" name="daycare-id" value="<?php echo $daycareDetails['id'];?>"/>
				<div class="row">
					<div class="input-field col s6 m6 l6">
						<input id="branch_name" name="branch_name" type="text" value="<?php echo $daycareDetails['branch_name']?>" <?php if($daycareDetails['id']>0) echo "readonly" ?>>
            			<label for="daycare-name">Branch Name</label>
					</div>

				</div>
				<div class="row white">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Logo & Cover Image
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="margin20">If you are having size-limit issues,Use <a href="http://compressor.io" target="_blank"> compressor.io</a> to compress your images.</div>
									<div class="col s12 m4 l4 profile-image-section">
										<label for="logo">Logo</label>
										<input type="text" class="visbilty-none hide" name="profile_image" id="profile_image" value="<?php echo $daycareDetails['logo'];?>">
										<input type="file" name="logo" class="dropify" id="logo" data-default-file="<?php echo $logo;?>" data-min-width="50" data-max-width="105" data-min-height="50" data-max-height="105" data-allowed-file-extensions="png jpeg jpg" data-max-file-size="300K"  />
										
										<div class="error"><?php echo form_error('profile_image'); ?></div>
														
									</div>
									
									<div class="col s12 m8 l8 cover-image-section">
										<label for="cover_image">Cover Image</label>
										<input type="text" class="visbilty-none hide" name="cover_image" id="cover_image" value="<?php echo $daycareDetails['featured_image'];?>">
										<input type="file" name="featured_image" class="dropify" id="featured_image"
										data-default-file="<?php echo $featured_image;?>" data-min-width="1000" data-max-width="1175" data-min-height="150" data-max-height="440" data-allowed-file-extensions="png jpeg jpg" data-max-file-size="500K" />
										
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
										<textarea id="additional-information" name="additional_information" class="tinymce-editor">
											<?php echo $daycareDetails['additional_information']?></textarea>
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
										<input type="text" id="address" name="address" class="" value="<?php echo $daycareDetails['address']?>" />
										<label for="address" class="custom">Society/Bungalow Name*</label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12 m4 l4 other-details">
										<input id="contact_name" name="contact_name" type="text" value="<?php echo $daycareDetails['contact_name']?>">
				            			<label for="contact_name">Contact Name*</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="email" name="email" type="text" value="<?php echo $daycareDetails['email']?>">
				            			<label for="email">Email*</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="mobile" name="mobile" type="number" pattern="[0-9]*" maxlength="10" class="numbers" value="<?php echo $daycareDetails['mobile']?>">
				            			<label for="mobile">Mobile/Phone No*</label>
									</div>
								</div>

								<div class="row">

									<div class="input-field col s12 m4 l4 other-details">
										<select name="city" id="preferred-city" <?php if($daycareDetails['id']>0) echo "disabled" ?> >
											<option value="0">Select City</option>
											<?php foreach($cities as $city){?>

												<option value="<?php echo $city['id'] ?>" <?php if($daycareDetails['city_id'] == $city['id'] ) echo "selected"; ?>><?php echo $city['name'] ?></option>
											<?php } ?> 
										</select>
				            			<label for="city">City*</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										<?php $areaName = getAreaNameById($daycareDetails['area_id']); ?>
										<input type="text" id="preferred-area" name="area" placeholder="Enter your area" value="<?php echo $areaName ?>" id="location" <?php if($daycareDetails['id']>0) echo "disabled" ?> />	
				            			<label for="gst">Area*</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="zip" name="zip" type="number" pattern="[0-9]*" maxlength="6" value="<?php echo $daycareDetails['zip']?>">
				            			<label for="sac">Zip</label>
									</div>
									<?php if($daycareDetails['id']>0){?>
									<div class="col s12 m12 l12">
										<h6 class="red padding20">If you wish to change city or area email us at <a class="black-text" href="mailto:support@day-care.in">support@day-care.in</a> </h6>
									</div>
									<?php } ?>
								</div>

							</div>
						</li>
					</ul>
				</div>				
				

				<div class="row white">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Fees, Age Group & Timings
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<?php 
								$selected = ''; 
								//show($daycareDetails['weekdays_start_time']);
							?>
							<div class="collapsible-body">
								<div class="row">
									<div class="input-field col s12 m3 l3">
										<input type="text" name="fees" id="fees" value="<?php echo $daycareDetails['fees'] ?>" class="margin20" />
					      				<label for="fees">Fees(in Rs)</label>
									</div>

									<div class="input-field col s12 m3 l3 other-details">
										<select id="weekdays_start_time" class="" name="weekdays_start_time" >
											<option value="" >Weekdays Start Time</option>
											<option value="6:00" <?php if( $weekDaysStartTime == "06:00:00") echo "selected" ?> >6:00 am</option>
											<option value="6:30" <?php if($weekDaysStartTime == "06:30:00") echo "selected" ?> >6:30 am</option>
											<option value="7:00" <?php if($weekDaysStartTime == "07:00:00") echo "selected" ?> >7:00 am</option>
											<option value="7:30" <?php if($weekDaysStartTime == "07:30:00") echo "selected" ?> >7:30 am</option>
											<option value="8:00" <?php if($weekDaysStartTime == "08:00:00") echo "selected" ?> >8:00 am</option>
											<option value="8:30" <?php if($weekDaysStartTime == "08:30:00") echo "selected" ?> >8:30 am</option>
											<option value="9:00" <?php if($weekDaysStartTime == "09:00:00") echo "selected" ?> >9:00 am</option>
											<option value="9:30" <?php if($weekDaysStartTime == "09:30:00") echo "selected" ?> >9:30 am</option>
											<option value="10:00" <?php if($weekDaysStartTime == "10:00:00") echo "selected" ?> >10:00 am</option>
											<option value="10:30" <?php if($weekDaysStartTime == "10:30:00") echo "selected" ?> >10:30 am</option>
											<option value="11:00" <?php if($weekDaysStartTime == "11:00:00") echo "selected" ?> >11:00 am</option>
											<option value="11:30" <?php if($weekDaysStartTime == "11:30:00") echo "selected" ?> >11:30 am</option>
											<option value="12:00" <?php if($weekDaysStartTime == "12:00:00") echo "selected" ?> >12 noon</option>

											<option value="12:30" <?php if($weekDaysStartTime == "12:30:00") echo "selected" ?> >12:30 pm</option>
											<option value="13:00" <?php if($weekDaysStartTime == "13:00:00") echo "selected" ?> >1:00 pm</option>
											<option value="13:30" <?php if($weekDaysStartTime == "13:30:00") echo "selected" ?> >1:30 pm</option>
											<option value="14:00" <?php if($weekDaysStartTime == "14:00:00") echo "selected" ?> >2:00 pm</option>
											<option value="14:30" <?php if($weekDaysStartTime == "14:30:00") echo "selected" ?> >2:30 pm</option>
											<option value="15:00" <?php if($weekDaysStartTime == "15:00:00") echo "selected" ?> >3:00 pm</option>
											<option value="15:30" <?php if($weekDaysStartTime == "15:30:00") echo "selected" ?> >3:30 pm</option>
											<option value="16:00" <?php if($weekDaysStartTime == "16:00:00") echo "selected" ?> >4:00 pm</option>
											<option value="16:30" <?php if($weekDaysStartTime == "16:30:00") echo "selected" ?> >4:30 pm</option>
											<option value="17:00" <?php if($weekDaysStartTime == "17:00:00") echo "selected" ?> >5:00 pm</option>
											<option value="17:30" <?php if($weekDaysStartTime == "17:30:00") echo "selected" ?> >5:30 pm</option>
											<option value="18:00" <?php if($weekDaysStartTime == "18:00:00") echo "selected" ?> >6:00 pm</option>
										</select>
				            			<label for="weekdays_start_time">Weekdays Start Time</label>
									</div>

									<div class="input-field col s12 m3 l3 other-details">
										<select id="weekdays_end_time" class="" name="weekdays_end_time" >
											<option value="" >Weekdays End Time</option>
											<option value="6:00" <?php if( $weekDaysEndTime == "06:00:00") echo "selected" ?> >6:00 am</option>
											<option value="6:30" <?php if($weekDaysEndTime == "06:30:00") echo "selected" ?> >6:30 am</option>
											<option value="7:00" <?php if($weekDaysEndTime == "07:00:00") echo "selected" ?> >7:00 am</option>
											<option value="7:30" <?php if($weekDaysEndTime == "07:30:00") echo "selected" ?> >7:30 am</option>
											<option value="8:00" <?php if($weekDaysEndTime == "08:00:00") echo "selected" ?> >8:00 am</option>
											<option value="8:30" <?php if($weekDaysEndTime == "08:30:00") echo "selected" ?> >8:30 am</option>
											<option value="9:00" <?php if($weekDaysEndTime == "09:00:00") echo "selected" ?> >9:00 am</option>
											<option value="9:30" <?php if($weekDaysEndTime == "09:30:00") echo "selected" ?> >9:30 am</option>
											<option value="10:00" <?php if($weekDaysEndTime == "10:00:00") echo "selected" ?> >10:00 am</option>
											<option value="10:30" <?php if($weekDaysEndTime == "10:30:00") echo "selected" ?> >10:30 am</option>
											<option value="11:00" <?php if($weekDaysEndTime == "11:00:00") echo "selected" ?> >11:00 am</option>
											<option value="11:30" <?php if($weekDaysEndTime == "11:30:00") echo "selected" ?> >11:30 am</option>
											<option value="12:00" <?php if($weekDaysEndTime == "12:00:00") echo "selected" ?> >12 noon</option>

											<option value="12:30" <?php if($weekDaysEndTime == "12:30:00") echo "selected" ?> >12:30 pm</option>
											<option value="13:00" <?php if($weekDaysEndTime == "13:00:00") echo "selected" ?> >1:00 pm</option>
											<option value="13:30" <?php if($weekDaysEndTime == "13:30:00") echo "selected" ?> >1:30 pm</option>
											<option value="14:00" <?php if($weekDaysEndTime == "14:00:00") echo "selected" ?> >2:00 pm</option>
											<option value="14:30" <?php if($weekDaysEndTime == "14:30:00") echo "selected" ?> >2:30 pm</option>
											<option value="15:00" <?php if($weekDaysEndTime == "15:00:00") echo "selected" ?> >3:00 pm</option>
											<option value="15:30" <?php if($weekDaysEndTime == "15:30:00") echo "selected" ?> >3:30 pm</option>
											<option value="16:00" <?php if($weekDaysEndTime == "16:00:00") echo "selected" ?> >4:00 pm</option>
											<option value="16:30" <?php if($weekDaysEndTime == "16:30:00") echo "selected" ?> >4:30 pm</option>
											<option value="17:00" <?php if($weekDaysEndTime == "17:00:00") echo "selected" ?> >5:00 pm</option>
											<option value="17:30" <?php if($weekDaysEndTime == "17:30:00") echo "selected" ?> >5:30 pm</option>
											<option value="18:00" <?php if($weekDaysEndTime == "18:00:00") echo "selected" ?> >6:00 pm</option>
											<option value="18:30" <?php if($weekDaysEndTime == "18:30:00") echo "selected" ?> >6:30 pm</option>
											<option value="19:00" <?php if($weekDaysEndTime == "19:00:00") echo "selected" ?> >7:00 pm</option>
											<option value="19:30" <?php if($weekDaysEndTime == "19:30:00") echo "selected" ?> >7:30 pm</option>
											<option value="20:00" <?php if($weekDaysEndTime == "20:00:00") echo "selected" ?> >8:00 pm</option>
										</select>
				            			<label for="weekdays_end_time">Weekdays End Time</label>
									</div>
								</div>
								
								<div class="row">	
									<div class="input-field col s12 m3 l3">
										<input type="text" name="age_group" id="age_group" value="<?php echo $daycareDetails['age_group'] ?>" class="margin20" />
					      				<label for="age_group">Age Group</label>
									</div>	
									<div class="input-field col s12 m3 l3 other-details">
										<select id="weekend_start_time" class="" name="weekend_start_time" >
											<option value="" >Weekend Start Time</option>
											<option value="6:00" <?php if( $weekEndStartTime == "06:00:00") echo "selected" ?> >6:00 am</option>
											<option value="6:30" <?php if($weekEndStartTime == "06:30:00") echo "selected" ?> >6:30 am</option>
											<option value="7:00" <?php if($weekEndStartTime == "07:00:00") echo "selected" ?> >7:00 am</option>
											<option value="7:30" <?php if($weekEndStartTime == "07:30:00") echo "selected" ?> >7:30 am</option>
											<option value="8:00" <?php if($weekEndStartTime == "08:00:00") echo "selected" ?> >8:00 am</option>
											<option value="8:30" <?php if($weekEndStartTime == "08:30:00") echo "selected" ?> >8:30 am</option>
											<option value="9:00" <?php if($weekEndStartTime == "09:00:00") echo "selected" ?> >9:00 am</option>
											<option value="9:30" <?php if($weekEndStartTime == "09:30:00") echo "selected" ?> >9:30 am</option>
											<option value="10:00" <?php if($weekEndStartTime == "10:00:00") echo "selected" ?> >10:00 am</option>
											<option value="10:30" <?php if($weekEndStartTime == "10:30:00") echo "selected" ?> >10:30 am</option>
											<option value="11:00" <?php if($weekEndStartTime == "11:00:00") echo "selected" ?> >11:00 am</option>
											<option value="11:30" <?php if($weekEndStartTime == "11:30:00") echo "selected" ?> >11:30 am</option>
											<option value="12:00" <?php if($weekEndStartTime == "12:00:00") echo "selected" ?> >12 noon</option>

											<option value="12:30" <?php if($weekEndStartTime == "12:30:00") echo "selected" ?> >12:30 pm</option>
											<option value="13:00" <?php if($weekEndStartTime == "13:00:00") echo "selected" ?> >1:00 pm</option>
											<option value="13:30" <?php if($weekEndStartTime == "13:30:00") echo "selected" ?> >1:30 pm</option>
											<option value="14:00" <?php if($weekEndStartTime == "14:00:00") echo "selected" ?> >2:00 pm</option>
											<option value="14:30" <?php if($weekEndStartTime == "14:30:00") echo "selected" ?> >2:30 pm</option>
											<option value="15:00" <?php if($weekEndStartTime == "15:00:00") echo "selected" ?> >3:00 pm</option>
											<option value="15:30" <?php if($weekEndStartTime == "15:30:00") echo "selected" ?> >3:30 pm</option>
											<option value="16:00" <?php if($weekEndStartTime == "16:00:00") echo "selected" ?> >4:00 pm</option>
											<option value="16:30" <?php if($weekEndStartTime == "16:30:00") echo "selected" ?> >4:30 pm</option>
											<option value="17:00" <?php if($weekEndStartTime == "17:00:00") echo "selected" ?> >5:00 pm</option>
											<option value="17:30" <?php if($weekEndStartTime == "17:30:00") echo "selected" ?> >5:30 pm</option>
											<option value="18:00" <?php if($weekEndStartTime == "18:00:00") echo "selected" ?> >6:00 pm</option>
										</select>
				            			<label for="weekend_start_time">Weekend Start Time</label>
									</div>

									<div class="input-field col s12 m3 l3 other-details">
										<select id="weekend_end_time" class="" name="weekend_end_time" >
											<option value="" >Weekend End Time</option>
											<option value="6:00" <?php if( $weekEndEndTime == "06:00:00") echo "selected" ?> >6:00 am</option>
											<option value="6:30" <?php if($weekEndEndTime == "06:30:00") echo "selected" ?> >6:30 am</option>
											<option value="7:00" <?php if($weekEndEndTime == "07:00:00") echo "selected" ?> >7:00 am</option>
											<option value="7:30" <?php if($weekEndEndTime == "07:30:00") echo "selected" ?> >7:30 am</option>
											<option value="8:00" <?php if($weekEndEndTime == "08:00:00") echo "selected" ?> >8:00 am</option>
											<option value="8:30" <?php if($weekEndEndTime == "08:30:00") echo "selected" ?> >8:30 am</option>
											<option value="9:00" <?php if($weekEndEndTime == "09:00:00") echo "selected" ?> >9:00 am</option>
											<option value="9:30" <?php if($weekEndEndTime == "09:30:00") echo "selected" ?> >9:30 am</option>
											<option value="10:00" <?php if($weekEndEndTime == "10:00:00") echo "selected" ?> >10:00 am</option>
											<option value="10:30" <?php if($weekEndEndTime == "10:30:00") echo "selected" ?> >10:30 am</option>
											<option value="11:00" <?php if($weekEndEndTime == "11:00:00") echo "selected" ?> >11:00 am</option>
											<option value="11:30" <?php if($weekEndEndTime == "11:30:00") echo "selected" ?> >11:30 am</option>
											<option value="12:00" <?php if($weekEndEndTime == "12:00:00") echo "selected" ?> >12 noon</option>

											<option value="12:30" <?php if($weekEndEndTime == "12:30:00") echo "selected" ?> >12:30 pm</option>
											<option value="13:00" <?php if($weekEndEndTime == "13:00:00") echo "selected" ?> >1:00 pm</option>
											<option value="13:30" <?php if($weekEndEndTime == "13:30:00") echo "selected" ?> >1:30 pm</option>
											<option value="14:00" <?php if($weekEndEndTime == "14:00:00") echo "selected" ?> >2:00 pm</option>
											<option value="14:30" <?php if($weekEndEndTime == "14:30:00") echo "selected" ?> >2:30 pm</option>
											<option value="15:00" <?php if($weekEndEndTime == "15:00:00") echo "selected" ?> >3:00 pm</option>
											<option value="15:30" <?php if($weekEndEndTime == "15:30:00") echo "selected" ?> >3:30 pm</option>
											<option value="16:00" <?php if($weekEndEndTime == "16:00:00") echo "selected" ?> >4:00 pm</option>
											<option value="16:30" <?php if($weekEndEndTime == "16:30:00") echo "selected" ?> >4:30 pm</option>
											<option value="17:00" <?php if($weekEndEndTime == "17:00:00") echo "selected" ?> >5:00 pm</option>
											<option value="17:30" <?php if($weekEndEndTime == "17:30:00") echo "selected" ?> >5:30 pm</option>
											<option value="18:00" <?php if($weekEndEndTime == "18:00:00") echo "selected" ?> >6:00 pm</option>
											<option value="18:30" <?php if($weekEndEndTime == "18:30:00") echo "selected" ?> >6:30 pm</option>
											<option value="19:00" <?php if($weekEndEndTime == "19:00:00") echo "selected" ?> >7:00 pm</option>
											<option value="19:30" <?php if($weekEndEndTime == "19:30:00") echo "selected" ?> >7:30 pm</option>
											<option value="20:00" <?php if($weekEndEndTime == "20:00:00") echo "selected" ?> >8:00 pm</option>
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
										<input type="checkbox" name="food_provided" id="food_provided" value="1" class="margin20" <?php if( $daycareDetails['is_food_available'] == 1 ) echo "checked" ?> />
					      				<label for="food_provided">Food Provided</label>
					      			</div>	

					      			<div class="col s3 m3 l3">
					      				<input type="checkbox" id="doctor_on_call" name="doctor_on_call" value="1" class="margin20" <?php if( $daycareDetails['is_doctor_on_call_available'] == 1 ) echo "checked" ?> />
					      				<label for="doctor_on_call">Doctor on call</label>
				      				</div>

				      				<div class="col s3 m3 l3">
					      				<input type="checkbox" id="open_on_weekends" name="open_on_weekends" value="1" class="margin20" <?php if( $daycareDetails['is_open_on_weekends'] == 1 ) echo "checked" ?> />
					      				<label for="open_on_weekends">Open on weekends</label>
				      				</div>

				      				<div class="col s3 m3 l3">
					      				<input type="checkbox" id="activities_available" name="activities_available" value="1" class="margin20" <?php if( $daycareDetails['are_activities_available'] == 1 ) echo "checked" ?> />
					      				<label for="activities_available">Activities</label>
				      				</div>

				      				<div class="col s3 m3 l3">
					      				<input type="checkbox" id="pick_drop" name="pick_drop" value="1" class="margin20" <?php if( $daycareDetails['is_pick_drop_available'] == 1 ) echo "checked" ?> />
					      				<label for="pick_drop">Pickup & Drop</label>
				      				</div>

				      				<div class="col s3 m3 l3">
					      				<input type="checkbox" id="credit_debit_card" name="credit_debit_card" value="1" class="margin20" <?php if( $daycareDetails['is_digital_payment_available'] == 1 ) echo "checked" ?> />
					      				<label for="credit_debit_card">Credit/Debit Card Payment</label>
				      				</div>
								</div>
								
							</div>
						</li>
					</ul>
				</div>				

				<div class="row white hide">
					<ul id="images-collapsible" class="collapsible" data-collapsible="accordion">
						<li class="active">
							<div class="collapsible-header active">
								<i class="material-icons jfh-purple-text">note</i>Video & Image Gallery
								<i class="material-icons right">arrow_drop_down</i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="input-field col s12 m4 l4 other-details">
										<input id="video_url" name="video_url" type="text" value="<?php echo $daycareDetails['video_url'] ?>">
				            			<label for="video_url">Video URL</label>
									</div>
								</div>

								<div class="row">
									<?php 
										/*if(count($sampleImages)){ 
											echo '<div class="row">';
											foreach( $sampleImages as $sampleImage ){
												$imagePath = generate_image_url('uploads/admin/reskilling/samples/'. $serviceDetails["vendor_id"] .'/services/' . $sampleImage['image_name']);
												echo '<div id="sample-'.$sampleImage['id'].'" class="left margin20 center"><img class="" src="'.$imagePath.'" />';
												echo '<br/><input type="button" class="center delete-sample default-btn jfh-green" value="Delete" data-entity-id="'.$serviceDetails["id"].'" data-id="'.$sampleImage['id'].'"></div>';
											}
											echo '</div><hr/>';
										} */
									?>
									<div class="file-field input-field">
								      <div class="btn jfh-green">
								        <span>File</span>
								        <input name="sampleFiles[]" type="file" multiple>
								      </div>
								      <div class="file-path-wrapper">
								        <input class="file-path validate" type="text" placeholder="Upload one or more files">
								      </div>
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
										<input id="facebook_id" name="facebook_id" type="text" value="<?php echo $daycareDetails['facebook_id']?>">
				            			<label for="facebook-id">Facebook ID</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										 <input id="twitter_id" name="twitter_id" type="text" value="<?php echo $daycareDetails['twitter_id']?>"> 
				            			<label for="twitter-id">Twitter ID</label>
									</div>

									<div class="input-field col s12 m4 l4 other-details">
										<input id="instagram_id" name="instagram_id" type="text" value="<?php echo $daycareDetails['instagram_id']?>">
				            			<label for="instagram_id">Instagram ID</label>
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