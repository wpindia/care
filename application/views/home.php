<div id="section1" class="home-section-carousel">
	<div id="home-carousel" class="col s12 m12 l12 owl-carousel owl-theme ">

		
			<div class="slide1">
				<img src="images/carousel-1.jpg" />
			</div>

			<div class="slide2">
				<img src="images/carousel-2.jpg" />
			</div>
		

	</div>
</div>

<div id="section2" class="clients">
	<div id="daycares" class="row">
	    <?php foreach($daycares as $daycare){
	    	$weekdaysStartTime 	= getFormattedTime($daycare['weekdays_start_time']);
	    	$weekdaysEndTime 	= getFormattedTime($daycare['weekdays_end_time']);
	    	$url 				= $daycare['seo_name'];
	    	$areaName 			= getAreaNameById($daycare['area_id']);
	    	$cityName 			= getCityNameById($daycare['city_id']);
	    ?>
	    <div class="col s12 m3 l3">
	    	<div class="card medium">
		        <div class="card-image">
		          <?php $image = 'images/' . $daycare['featured_image'] ?>
		          <img class="responsive-image" src="<?php echo $image ?>">
		          <span class="card-title"><?php echo ucwords($daycare['vendor_name']) ?></span>
		        </div>
		        
		        <div class="card-content">
		          <i class="material-icons small">location_on</i> 
		          <?php echo trim( $areaName . ', '. $cityName ) ?><br/>
		          <i class="material-icons small">group</i><?php echo $daycare['age_group'] ?><br/>
		          <i class="material-icons small">access_time</i> <?php echo $weekdaysStartTime . ' - ' . $weekdaysEndTime ?><br/>
		        </div>
		        <a target="_blank" href="<?php echo base_url($url)?>" class="read-more btn block daycare-green-flat-btn">Read more</a> 	  		 	
		    </div>
		</div>
	    <?php } ?>
	  </div>
</div>