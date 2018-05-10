<div class="container">
	<div id="daycares" class="row">

		<?php 
		if(count($daycares) > 0) {
		foreach($daycares as $daycare){
			$weekdaysStartTime 	= getFormattedTime($daycare['weekdays_start_time']);
	    	$weekdaysEndTime 	= getFormattedTime($daycare['weekdays_end_time']);
	    	$url 				= partner_base_url('edit-branch/'.$daycare['id']);
	    	$areaName 			= getAreaNameById($daycare['area_id']);
	    	$cityName 			= getCityNameById($daycare['city_id']);
		?>
		<div class="col s12 m3 l3">
	    	<div class="card medium">
		        <div class="card-image">
		          <?php $image = 'images/' . $daycare['featured_image'] ?>
		          <img class="responsive-image" src="<?php echo base_url($image) ?>">
		          <span class="card-title"><?php echo ucwords($daycare['vendor_name']) ?></span>
		        </div>
		        
		        <div class="card-content">
				  <h4>
				  	<i class="material-icons small">location_on</i> Location: 
		          	<?php echo trim( $areaName ) ?><br/>
		          </h4>
		          <h4>
				  	<i class="material-icons small">location_city</i> City: 
		          	<?php echo trim( $cityName ) ?><br/>
		          </h4>
		          			        
		          <h4><i class="material-icons small">visibility</i>Profile Views: <?php echo $daycare['total_views'] ?></h4>
		        </div>
		        <a href="<?php echo $url ?>" class="edit-daycare btn block daycare-green-flat-btn"><i class="material-icons">edit</i>Edit Daycare </a>
		         	  		 	
		    </div>
		</div>
	<?php }
		}
	?>
		<div class="col s12 m3 l3">
	    	<a href="<?php echo partner_base_url('create-branch')?>">
		    	<div class="card medium">
			        <div class="card-content center">
					  	<i class="material-icons large">add_circle_outline</i>
			        </div>
			        <a href="<?php echo partner_base_url('create-branch')?>" class="edit-daycare btn block daycare-green-flat-btn"><i class="material-icons">add</i>Add Daycare </a>
			         	  		 	
			    </div>
		    </a>
		</div>
	</div>
</div>
		   	
       
