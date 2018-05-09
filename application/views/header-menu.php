<div class="row margin-top-10">
	<div class="col s12 m12 l12">
		<div class="col s3 m3 l3">
			<a href="<?php echo base_url() ?>">
				<img class="responsive-img" src="<?php echo base_url('images/logo.png')?>">
			</a>	
		</div>
		<?php //if( true == $showSearch ){ ?>
		<div class="col s9 m9 l9">
			<div class="col s5 m4 l2">
				<select id="preferred-city" name="preferred-city">
					<option value="1">Bangalore</option>
					<option value="2">Pune</option>
					<option value="3">Mumbai</option>
				</select>	
			</div>
			<div class="col s7 m4 l4">
				<input type="text" name="location" placeholder="Enter your area" value="<?php echo $selectedArea ?>" id="location"  />	
			</div>
			<div class="m4 l3 hide-on-small-only">
				<div class="margin20">
					<a id="free-listing" href="<?php echo partner_base_url('signup')?>" class="margin-right-20 btn right daycare-green-btn padding10">Free Listing</a>
					
				</div>
				
			</div>	
		</div>
		<?php //} ?>
	</div>
</div>