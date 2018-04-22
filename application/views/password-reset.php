<?php
/**
 * Password Reset File
 *
 * @author Rajesh Kumar
 */


if( $this->session->has_userdata('passwordResetMessage') ){
	$passwordResetMessage = $this->session->userdata('passwordResetMessage');
	//echo "<pre>"; print_r($passwordResetMessage); echo "</pre>";
	$this->session->unset_userdata('passwordResetMessage');
}
if(false == empty($setupMessage)){
	echo '
		<div class="message-section timeout" id="message_alert_box" >
			<div id="card-alert" class="card success ">
				<div class="card-content center"><p>'.$setupMessage.'</p>
				</div>
			</div>
		</div>';
}
?>


<section class="full-container password-reset-container">
	<?php
	if ((!isset($password_setmessage) || $password_setmessage == '') && !empty($user_details) || (isset($passwordResetMessage['status']) && $passwordResetMessage['status'] == false)) {
		if(isset($setPassword) && $setPassword == true && $user_details['password'] == ''){ 
			?>
			<div class="row reset-password-section set-password">
				<form id="passwordresetform" class="row flex-container" method="POST" action="<?php echo base_url('setpassword');?>">
					<input type="hidden" name="token" value="<?php echo $token;?>">
					<div class="set-password-left col s12 m6 flex-item">
						<div class="text-box center">
							<img class="img-responsive" src="<?php echo generate_image_url('images/logo-black.png');?>" alt="Logo JFH Black">
							<h1 class="set-password-text">You are almost there. Set a password and gain access to job opportunities, family-friendly companies, mentors, reskilling, and inspiration.</h1>
						</div>
					</div>
					<div class="set-password-right col s12 m6 flex-item">
						<div class="row">
							<div class="input-field fields-hold">
								<input type="email" id="email-id" name='email-id' data-error=".errorTxtemail" readonly="true" value="<?php echo $email;?>">
								<div class="errorTxtemail"></div>
							</div>
						</div>
						<div class="row">
							<div class="input-field fields-hold no-margin">
								<input placeholder="Set a password" type="password" id="new_pswd" name='new_pswd' class="password" data-error=".errorTxtpass">
								<div class="show-hide" id="showHide">Show</div>
								<div class="errorTxtpass"></div>
							</div>
						</div>
						<div class="row"></div>
						<div class="row center margin-top-20">
							<button type="submit" class="waves-light btn jfh-green">Sign In</button>
						</div>
						<div class="row margin-top-20">
							<p class="tnc center">By signing in, I agree to the <a href="<?php echo base_url('terms-of-use');?>" target="_blank">Terms &amp; Conditions </a></p>
						</div>
					</div>
				</form>
			</div>
			<?php 
		}else {
			?>
			<div class="row reset-password-section">
				<div class="col s12">
					<h1>Reset Password</h1>
				</div>
				<form id="passwordresetform" class="row" method="POST" action="<?php echo $form_url;?>">
					<input type="hidden" name="token" value="<?php echo $token;?>">
					<div class="row">
						<div class="input-field fields-hold">
							<input placeholder="Enter password" type="password" id="new_pswd" name='new_pswd' class="validate" data-error=".errorTxtpass">
							<div class="errorTxtpass"></div>
						</div>
					</div>
					<div class="row">
						<div class="input-field fields-hold">
							<input placeholder="Enter confirm password" type="password" id="cnfm_pswd" name='cnfm_pswd' class="validate" data-error=".errorTxtcnfpass">
							<div class="errorTxtcnfpass"></div>
						</div>
					</div>
					<div class="col s12 center margin-top-20">
						<button type="submit" class="waves-light btn jfh-green sm">Reset Password</button>
						<a class="waves-effect waves-light btn sm white-btn" href="<?php echo partner_base_url();?>">Cancel</a>
					</div>
				</form>
			</div>
			<?php
		}
	} else {
		$message = '<span class="flash-message error">Token mismatch</span>';
		if(isset($setupMessage)){
			$message = $setupMessage;
		}
		?>
		<div class="row reset-password-section padding-30">
			<div class="errorTxtpasswordreset margin-top-10 margin-bottom-15">
				<h6 class="flash-message error red-text center"><?php echo $message;?></h6>
			</div>
			<div class="row center">
				<a class="purple-text" href="<?php echo partner_base_url();?>">Go Back</a>
			</div>
		</div>
		<?php 
	} ?>
</section>