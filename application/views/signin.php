<div id="signin-content" class="container row">
	
	
		
	<div class="white col s12 m6 offset-m3 l4 offset-l4 z-depth-6 card-panel">
			<h1 class="center">Log In </h1>	
		
			<?php echo ( true == isset( $signinErrors ) ) ? $signinErrors : ''; ?>
			<form id="frmsignin" name="frmsignin" class="" method="POST" action="<?php echo partner_base_url('validate-user')?>">
					<div class="input-field fields-hold">
						<input id="email" name="email" placeholder="Email ID*" type="email" class="" value="">
					</div>
				
					<div class="input-field fields-hold">
						<input id="s_password" name="password" placeholder="Password*" type="password" value="">
						<div class="hide" id="showHide">Show</div>
					</div>
				

					<button id="b-signin" class="center waves-effect waves-light btn daycare-green-flat-btn signin-button" type="submit">Sign In</button>
					
					<div class="f-password hide">
						<a class="center modal-trigger modal-action modal-close" href="#forgot-password">
							<span class="jfh-purple-text">Forgot password?</span>
						</a>
					</div>
					
					<a href="<?php echo partner_base_url('signup') ?>" class="signup-link center block">
						New to day-care.in? <span class="">Sign up now</span>
					</a>
				
			</form>
		
	</div>
</div>
