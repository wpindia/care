
<div id="partner-home">
	<div class="container">
		<div class="row">
			<div class="col s12 m12 l12 no-padding">
				<h1 class="center">PARTNER ZONE</h1>
				<div class="center description">
					List your business for FREE with India's only day care listing portal.<br/>
					Millions of parents are looking for the right daycare on day-care.in. <br/>Start your digital journey with day-care.in.<br/> Let’s take the first step and create your account:
				</div>
			</div>
		</div> 

		<div id="form-section" class="custom-grey">
			<div class="center">
				<?php echo validation_errors(); ?>
			</div>
			<form id="frm_signup" name="frm_signup" action="<?php echo partner_base_url('signupProcess');?>" method="post">
				<div class="row">
					<div class="col s12 m6 l6 input-field">
						<i class="material-icons signup-icons">business</i>
						<input type="text" name="vendor_name" id="vendor_name" class="form-class" placeholder="Day Care Name*" data-error="" value="<?php echo set_value('vendor_name'); ?>">
					</div>
					<div class="col s12 m6 l6 input-field">
						<i class="material-icons signup-icons">person_outline</i>
						<input type="text" name="contact_name" id="contact_name" class="form-class" placeholder="Contact Name*" data-error="" value="<?php echo set_value('contact_name'); ?>">
					</div>
				</div>

				<div class="row">
					<div class="col s12 m6 l6 input-field">
						<i class="material-icons signup-icons">mail_outline</i>
						<input type="email" name="email" id="email" class="form-class" placeholder="Primary Email ID*" data-error=".errorTxtemail" value="<?php echo set_value('email'); ?>">

					</div>
				
					<div class="col s12 m6 l6 input-field">
						<i class="material-icons signup-icons">lock_outline</i>
						<input type="password" name="password" id="password" class="form-class" placeholder="Password*" data-error=".errorTxtpassword" value="<?php echo set_value('password'); ?>">
					</div>
				</div>

				<div class="row">
					<div class="col s12 m6 l6 input-field">
						<i class="material-icons signup-icons">phone_iphone</i>
						<input type="text" name="mobile_no" id="mobile_no" class="number form-class" placeholder="Mobile No*" data-error=".errorTxtmob" value="<?php echo set_value('mobile_no'); ?>">
					</div>
					
					<div class="col s12 m6 l6 input-field">
						<i class="material-icons signup-icons">location_on</i>
						<select id="city" class="" name="city" >
							<option value="" >Choose City*</option>
							<option value="1" >Bangalore</option>
							<option value="2" >Pune</option>
							<option value="3" >Mumbai</option>
						</select>
					</div>
				</div>

				
				<div class="row">
					<div class="col s12 m12 l12 center">
						
						<button class="daycare-green-round-btn waves-effect waves-light btn" type="submit" name="action">Sign Up
						    <i class="material-icons right">send</i>
						</button>
						<br/>
						<br/>
						<div class="short-description">
							By logging in, you agree to day-care.in's<br/>
							<a class="jfh-purple-text" target="_blank" href="<?php echo base_url('terms-of-use') ?>">Privacy Policy</a> and <a class="jfh-purple-text" target="_blank" href="<?php echo base_url('privacy-policy') ?>">Terms of Use</a>
							<br/><br/>
							Are you an existing partner?
							<a class="" href="<?php echo partner_base_url('signin') ?>">
								 Sign in.
							</a>
							<br/>
							Have questions? Feel free to call us on +91-9923206515 <br/>or email us at enquiries@day-care.in		
														
						</div>
					</div>
				</div>		
			</form>	
		</div>

	</div>
</div>			

	