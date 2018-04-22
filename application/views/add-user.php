<div id="partner-users">
	<div class="container">
		<div id="form-section" class="custom-grey">
			<div class="center">
				<?php 
					echo validation_errors(); 
				?>
			</div>
			<form id="frm_manageUsers" name="frm_manageUsers" action="<?php echo partner_base_url('create-user');?>" method="post">
				<h3 class="center">Add Co-user</h3>

				<div class="row">
					<div class="input-field col s4 m4 l4 ">
						<input id="couser-name" name="couser-name" type="text" data-length="10">
            			<label for="couser-name">Co-User Name*</label>
					</div>

					<div class="input-field col s4 m4 l4 ">
						<input id="couser-email" name="couser-email" type="email" data-length="10">
            			<label for="couser-email">Co-User Email ID*</label>
					</div>

					<div class="input-field col s4 m4 l4 ">
						<input id="couser-mobile" class="number" name="couser-mobile" type="text" data-length="10">
            			<label for="couser-mobile">Co-User Mobile No</label>
					</div>

					
				</div>

				<div class="row">
					<div class="col s12 m12 l12 center">
						<input type="submit" value="Save" id="save-users" class="jfh-green btn default-btn white">
						
					</div>
				</div>		
			</form>	
		</div>

	</div>
</div>