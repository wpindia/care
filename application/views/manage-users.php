 <div id="partner-users">
	<div class="container">
		<div id="form-section" class="custom-grey">
			<div class="center">
				<?php 
					echo validation_errors(); 
				?>
			</div>
			<form id="frm_manageUsers" name="frm_manageUsers" action="<?php echo partner_base_url('save-users');?>" method="post">
				<h3 class="center">Manage Users</h3>
				<?php foreach( $userDetails as $userDetail ) {?>
				<div class="row">
					<div class="input-field col s3 m3 l3 ">
						<input id="couser-name" readonly="readonly" name="couser-name" type="text" value="<?php echo $userDetail['name'] ?>" data-length="10">
            			<label for="couser-name">Co-User Name*</label>
					</div>

					<div class="input-field col s3 m3 l3 ">
						<input id="couser-email" readonly="readonly" name="couser-email" type="text" data-length="10" value="<?php echo $userDetail['email_id'] ?>">
            			<label for="couser-email">Co-User Email ID*</label>
					</div>

					<div class="input-field col s3 m3 l3 ">
						<input id="couser-mobile" readonly="readonly" class="number" name="couser-mobile" type="text" value="<?php echo $userDetail['mobile'] ?>" data-length="10">
            			<label for="couser-mobile">Co-User Mobile No</label>
					</div>
					
					<div class="col s3 m3 l3 ">
						<?php $statusValue = ( $userDetail['status'] == 'INACTIVE' ) ? 'ACTIVATE' :'INACTIVATE' ?>
						<input type="button" value="<?php echo $statusValue ?>" data-id="<?php echo $userDetail['id'] ?>" class="status-change jfh-green btn default-btn white">

					</div>
				</div>
				<?php } ?>
				
			</form>	
		</div>

	</div>
</div>