<div class="container">

	<div class="row margin-top-10">
		<div class="col s12 m12 l12">
			<div class="col s3 m3 l3">
				<a href="<?php echo base_url() ?>">
					<img src="images/logo.png">
				</a>	
			</div>
			<div class="col s9 m9 l9 ">
			<?php if($logged == 1) {?>
				<a class="btn-flat right daycare-green" href="<?php echo base_url('logout') ?>"> Log out</a>
				
			<?php }elseif($logged == 0) {?>		
			
				<a href="<?php echo base_url('signup')?>" class="btn center daycare-green">Free Listing</a>
				<a href="<?php echo base_url('signin') ?>" class="btn right daycare-green">Sign In</a>
			
			<?php } ?>
			</div>
		</div>
	</div>

</div>	
