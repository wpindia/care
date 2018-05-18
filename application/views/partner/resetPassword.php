<div id="reset-password-content" class="container row">
	<div class="white col s12 m6 offset-m3 l4 offset-l4 z-depth-6 card-panel">
			<h1 class="center">Reset Password </h1>
			<div class="wrapper">
				<?php //echo ( true == isset( $signinErrors ) ) ? $signinErrors : ''; ?>
				<form id="frmresetpassword" name="frmresetpassword" class="" method="POST" action="<?php echo partner_base_url('update-password')?>">
						<div class="input-field fields-hold">
							<input id="password" name="password" placeholder="Enter new password*" type="password" class="" value="">
						</div>
						<div class="input-field fields-hold">
							<input id="re_password" name="re_password" placeholder="Re-type new password*" type="password" class="" value="">
						</div>
						<br/>
					
						<button id="b-reset-link" class="center waves-effect waves-light btn daycare-green-flat-btn signin-button" type="submit">Change Password</button>
						<br/><br/>
																	
				</form>
			</div>	
		
	</div>
</div>


