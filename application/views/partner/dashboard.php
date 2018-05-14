<div class="container">
	<div id="daycares" class="row">
		<div class="col s12 m3 l3">
	    	<a href="<?php echo partner_base_url('create-branch')?>">
		    	<div class="card small">
			        <div class="card-content center">
					  	<i class="material-icons large">add_circle_outline</i>
			        </div>
			        <a href="<?php echo partner_base_url('create-branch')?>" class="add-daycare btn block daycare-green-flat-btn"><i class="material-icons">add</i>Add Branch </a>
			         	  		 	
			    </div>
		    </a>
		</div>
		<?php 
		if(count($daycares) > 0) {
		foreach($daycares as $daycare){
			$weekdaysStartTime 	= getFormattedTime($daycare['weekdays_start_time']);
	    	$weekdaysEndTime 	= getFormattedTime($daycare['weekdays_end_time']);
	    	$editUrl 			= partner_base_url('edit-branch/'.$daycare['id']);
	    	$viewUrl 			= base_url(urldecode($daycare['seo_name']));
	    	$areaName 			= getAreaNameById($daycare['area_id']);
	    	$cityName 			= getCityNameById($daycare['city_id']);
	    	$featuredImage      = 'uploads/admin/'.$daycare['vendor_id'].'/'.$daycare['featured_image'];
		?>
		<div class="col s12 m3 l3">
	    	<div class="card small">
		        <div class="card-image">
		          
		          <img class="responsive-image" src="<?php echo base_url($featuredImage) ?>">
		          <span class="card-title"><?php echo ucwords($daycare['branch_name']) ?></span>
		        </div>
		        
		        <div class="card-content">
				  <h4>
				  	<i class="material-icons small">location_on</i> Location: 
		          	<?php echo trim( $areaName ) . ', ' . trim( $cityName ) ?><br/>
		          </h4>
		          <h4>
				  	          			        
		          <h4><i class="material-icons small">visibility</i>Profile Views: <?php echo $daycare['total_views'] ?></h4>
		        </div>
		        
		        <a href="<?php echo $editUrl ?>" class="edit-daycare btn block daycare-green-flat-btn"><i class="material-icons">edit</i>Edit Branch </a>
		        <a href="<?php echo $viewUrl ?>" target="_blank" class="view-daycare btn block daycare-green-flat-btn"><i class="material-icons">visibility</i>View Branch </a> 	  		 	 	
		    </div>
		</div>
	<?php }
		}
	?>
		
	</div>
</div>
		   	
       
