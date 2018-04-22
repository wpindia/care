<div id="signin-content" class="modal jfh-modal">
	<div class="modal-header">
		<h2 class="modal-title">Sign In</h2>
		<a class="waves-effect modal-action modal-close close-icn-hold" href="javascript:void(0);">
			<span class="sprite close-icon"></span>
		</a>
	</div>

	<div class="modal-content">
		
		<div class="row no-margin modal-sub-content email-register">
			<?php echo ( true == isset( $signinErrors ) ) ? $signinErrors : ''; ?>
			<form id="frmsignin" name="frmsignin" class="" method="POST" action="<?php echo partner_base_url('validate-user')?>">
				<div class="row">
					<div class="input-field fields-hold">
						<input id="email" name="email" placeholder="Email ID*" type="email" class="" value="">
					</div>
				</div>

				<div class="row">
					<div class="input-field fields-hold">
						<input id="s_password" name="password" placeholder="Password*" type="password" value="">
						<div class="show-hide" id="showHide">Show</div>
					</div>
				</div>

				<div class="row center">
					<button id="b-signin" class="waves-effect waves-light btn jfh-green signin-button" type="submit">Sign In</button>
					
					<div class="f-password">
						<a class="center modal-trigger modal-action modal-close" href="#forgot-password">
							<span class="jfh-purple-text">Forgot password?</span>
						</a>
					</div>
				</div>

				<div class="row">
					<a href="<?php echo partner_base_url('signup') ?>" class="signup-link show-signin center">
						New to JobsForHer? <span class="purple-color">Sign up now</span>
					</a>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="forgot-password" class="modal jfh-modal">
	<div class="modal-header">
		<h2 class="modal-title">Forgot password</h2>
		<a class="waves-effect modal-action modal-close close-icn-hold jfh-reset" href="javascript:;"><span class="sprite close-icon"></span></a>
	</div>
		<div class="modal-content">
			<form class="show-form" id="reset_password" name="reset_password" method="POST" action="<?php echo partner_base_url('account/forgotPassword');?>">
				<div class="row hide row-reset forgot-message">
					<div class="sucTxt center jfh-color">A password reset message has been sent to your registered email id, please click the link in that message to set your password.</div>
				</div>
				<p class="error hide">Invalid email id. Please enter a valid email id</p>
				<div class="row reset-hide">
					<p>Just fill your email ID.<br>We will help you to recover your password.</p>
				</div>
				<div class="row reset-hide">
					<div class="input-field fields-hold">
						<input id="email_id" name="email_id" type="email" data-error=".errorTxt-forgot" class="validate" required>
						<label for="email_id">Email ID*</label>
						<div class="errorTxt-forgot"><?php echo form_error('email_id'); ?></div>
					</div>
				</div>
				<div class="row center">
					<button id="forgot-password" class="waves-effect waves-light btn jfh-green reset-hide" type="submit">Submit</button>
					<button class="waves-effect waves-light btn jfh-transparent modal-action modal-close jfh-reset" type="button">Cancel</button>
				</div>
			</form>
		</div>	
</div>

<div id="delete-featured-content" class="modal jfh-modal">
    <div class="modal-header">
		<h2 class="modal-title">Delete Content</h2>
		<a class="waves-effect modal-action modal-close close-icn-hold" href="javascript:void(0);">
			<span class="sprite close-icon"></span>
		</a>
	</div>

        <div class="modal-content">
            <div class="">
                <form>
                    <div class="row">
                        <div class="col l12 m12 s12">
                            <div class="align-center">
                                <h4 class="modal-warning">Are you sure you want to delete?</h4>
                            </div>
                        </div>    
                    </div>

                    <div class="row">
                        <ul>
                            <li class="left">
                            	<a class="waves-effect waves-light jfh-green default-btn delete-yes">Yes</a>
                            </li>
                            <li class="left">
                                <a href="<?php echo partner_base_url('profile')?>" class="cancel-button modal-action modal-close default-btn jfh-transparent">
                                    Cancel
                                </a>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>

