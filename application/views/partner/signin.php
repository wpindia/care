<div id="signin-content" class="container row">
	<div class="white col s12 m6 offset-m3 l4 offset-l4 z-depth-6 card-panel">
			<h1 class="center">Log In </h1>	
			<div class="center">
				<?php echo validation_errors(); ?>
			</div>
			<?php //echo ( true == isset( $signinErrors ) ) ? $signinErrors : ''; ?>
			<form id="frmsignin" name="frmsignin" class="" method="POST" action="<?php echo partner_base_url('validate-user')?>">
					<div class="input-field fields-hold">
						<input id="email" name="email" placeholder="Email ID*" type="email" class="" value="">
					</div>
				
					<div class="input-field fields-hold">
						<input id="s_password" name="password" placeholder="Password*" type="password" value="">
						<div class="hide" id="showHide">Show</div>
					</div>
				

					<button id="b-signin" class="center waves-effect waves-light btn daycare-green-flat-btn signin-button" type="submit">Sign In</button>
					
					<div class="row">
						<div class="col s12 m5 l5 additional-links">
						<a id="forgot-password">Forgot Password?</a>
						</div>
						<div class="col s12 m7 l7 additional-links right">
							New to day-care.in? 
							<a href="<?php echo partner_base_url('signup') ?>" class="signup-link">
								<span class="">Sign up</span>
							</a>
						</div>	
					</div>
				
			</form>
		
	</div>
</div>

<div id="forgot-password-content" class="container row hide">
	<div class="white col s12 m6 offset-m3 l4 offset-l4 z-depth-6 card-panel">
			<h1 class="center">Forgot Password </h1>
			<div class="notification-message center hide margin20">
				
			</div>
			<div class="wrapper">
				<div class="center">
					We will send you a link to reset your password.
					Enter Email Address
				</div>	
				
				<?php //echo ( true == isset( $signinErrors ) ) ? $signinErrors : ''; ?>
				<form id="frmforgotpassword" name="frmforgotpassword" class="" method="POST" action="<?php echo partner_base_url('send-reset-password')?>">
						<div class="input-field fields-hold">
							<input id="email" name="email" placeholder="Email ID*" type="email" class="" value="">
						</div>
						<br/>
					
						<button id="b-reset-link" class="center waves-effect waves-light btn daycare-green-flat-btn signin-button" type="submit">Send Reset Link</button>
						
						<div class="row margin20">
							<div class="col s12 m12 l12 center">
								<a id="signin-link" class="">Signin</a>
							</div>
						</div>
					
				</form>
			</div>	
		
	</div>
</div>


