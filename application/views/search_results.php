<div class="container">
	<div id="section2" class="clients">
		<div id="daycares" class="row">
	    <?php 
	    if(count($daycares) > 0 ){
	    foreach($daycares as $daycare){
	    	$weekdaysStartTime 	= getFormattedTime($daycare['weekdays_start_time']);
	    	$weekdaysEndTime 	= getFormattedTime($daycare['weekdays_end_time']);
	    	$url 				= base_url( urldecode($daycare['seo_name']) );
	    	$areaName 			= getAreaNameById($daycare['area_id']);
	    	$cityName 			= getCityNameById($daycare['city_id']);
	    ?>
	    <div class="col s12 m3 l3">
	    	<div class="card medium">
		        <div class="card-image">
		          <?php $image = 'uploads/admin/' . $daycare['vendor_id'] .'/'. $daycare['featured_image'] ?>
		          <img class="responsive-image" src="<?php echo base_url($image) ?>">
		          <span class="card-title"><?php echo ucwords($daycare['vendor_name']) ?></span>
		        </div>
		        
		        <div class="card-content">
		          <i class="material-icons small">location_on</i> 
		          <?php echo trim( $areaName . ', '. $cityName ) ?><br/>
		          <i class="material-icons small">group</i><?php echo $daycare['age_group'] ?><br/>
		          <i class="material-icons small">access_time</i> <?php echo $weekdaysStartTime . ' - ' . $weekdaysEndTime ?><br/>
		        </div>
		        <a target="_blank" href="<?php echo $url ?>" class="read-more btn block daycare-green-flat-btn">Read more</a> 	  		 	
		    </div>
		</div>
	    <?php } 
		} else{
			echo '<h2> We aren\'t there yet. Try another search. </h2>';
		}
	    ?>
	  </div>
	  
	</div>
</div>

