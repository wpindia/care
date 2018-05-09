<?php
	$dashboard_menu = $branch_menu = '';
	if(isset($pageName)){
		switch ($pageName) {
			case 'dashboard':
				$dashboard_menu = 'active';
			break;

			case 'create-branch':
				$branch_menu = 'active';
			break;
		}
	}
?>			


<div class="row margin-top-10">
	<div class="col s12 m12 l12">
		<nav class="white" role="navigation">
			<div class="col s3 m3 l3">
				<a href="<?php echo partner_base_url() ?>" class="block">
					<img class="responsive-img" src="<?php echo base_url('images/logo.png')?>">
				</a>	
			</div>

			<div class="col s9 m9 l9">
					<?php if($logged == 1) {?>
					<ul class="left left-side-menu hide-on-med-and-down">
						<li><a class="<?php echo $dashboard_menu; ?>" href="<?php echo partner_base_url('dashboard')?>">Dashboard</a></li>
						<li><a class="<?php echo $branch_menu; ?>" href="<?php echo partner_base_url('create-branch')?>">Create branch</a></li>

					</ul>
					<?php } ?>
							
				<div class="s3 m3 l3 margin20">
					<?php if($logged == 1) {?>
						
						<a class="btn-flat right daycare-green-btn" href="<?php echo partner_base_url('logout') ?>"> Log out</a>
						
					<?php }elseif($logged == 0) {?>		
					<div class="">
						<a id="login" href="<?php echo partner_base_url('signin') ?>" class="btn right daycare-default-btn padding10">Partner LogIn</a>
						<a id="free-listing" href="<?php echo partner_base_url('signup')?>" class="margin-right-20 btn right daycare-green-btn padding10">Free Listing</a>
						
					</div>
					<?php } ?>
				</div>	
			</div>
		</nav>
	</div>
</div>