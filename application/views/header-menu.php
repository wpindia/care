<div class="row margin-top-10">
	<div class="col s12 m12 l12">
		<div class="col s3 m3 l3">
			<a href="<?php echo base_url() ?>">
				<img src="images/logo.png">
			</a>	
		</div>
		<div class="col s9 m9 l9">
			<div class="col s2 m2 l2">
				<select id="preferred-city" name="preferred-city">
					<option value="1">Bangalore</option>
					<option value="2">Pune</option>
					<option value="3">Mumbai</option>
				</select>	
			</div>
			<div class="col s4 m4 l4">
				<input type="text" name="location" id="location"  />	
			</div>
			<div class="s3 m3 l3">
				<?php if($logged == 1) {?>
					<a class="btn-flat right daycare-green-btn" href="<?php echo base_url('logout') ?>"> Log out</a>
					
				<?php }elseif($logged == 0) {?>		
				<div class="margin20">
					<a id="login" href="<?php echo base_url('signin') ?>" class="btn right daycare-default-btn padding10">Partner LogIn</a>
					<a id="free-listing" href="<?php echo base_url('signup')?>" class="margin-right-20 btn right daycare-green-btn padding10">Free Listing</a>
					
				</div>
				<?php } ?>
			</div>	
		</div>
	</div>
</div>