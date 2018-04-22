<div id="signin-content" class="container row">
	
	<h1 class="">Sign In</h1>
		
	<div class="col s12 m6 offset-m3 l4 offset-l4 z-depth-6 card-panel">
		
		
			<?php echo ( true == isset( $signinErrors ) ) ? $signinErrors : ''; ?>
			<form id="frmsignin" name="frmsignin" class="" method="POST" action="<?php echo base_url('validate-user')?>">
					<div class="input-field fields-hold">
						<input id="email" name="email" placeholder="Email ID*" type="email" class="" value="">
					</div>
				
					<div class="input-field fields-hold">
						<input id="s_password" name="password" placeholder="Password*" type="password" value="">
						<div class="show-hide" id="showHide">Show</div>
					</div>
				

					<button id="b-signin" class="center waves-effect waves-light btn daycare-green signin-button" type="submit">Sign In</button>
					
					<div class="f-password">
						<a class="center modal-trigger modal-action modal-close" href="#forgot-password">
							<span class="jfh-purple-text">Forgot password?</span>
						</a>
					</div>
				
					<a href="<?php echo base_url('signup') ?>" class="signup-link show-signin center">
						New to JobsForHer? <span class="purple-color">Sign up now</span>
					</a>
				
			</form>
		
	</div>
</div>
