<?php 
	$logo = ( true == empty( $vendorData['logo'] ) ) ? generate_image_url('images/reskilling/default-partner-icon.png') : generate_image_url( 'images/reskilling/desktop/vendors/' . $vendorData['logo'] );
?>

<?php if( $partnerData['is_admin'] && false == $partnerData['is_email_verified'] ) { ?>
    <div class="row white">
        <div class="col m12 l12 s12 center padding10">
            <div class="pad10">
                <p class="">Your profile is under review, since your email ID is not verified.</p>

                <a class="waves-effect waves-light default-btn jfh-green" id='resend-verification' data-email='<?php echo $partnerData['email_id']; ?>' >Resend</a>
            </div>
        </div>

    </div>
<?php } ?>

<div class="row white header-section">
	<div class="col l12 m12 s12">
		<div class="col l8 m8 s8">
			<h2 class="left-align page-title">Dashboard</h2>
		</div>
		<div class="col l4 m4 s4">	
			<div class="right-align">
            	<a class="waves-effect waves-light jfh-transparent default-btn " href="<?php echo partner_base_url('profile') ?>">View profile</a>
            </div>
		</div>
	</div>		
</div>

<div class="container">	
	<section class="">
        <div class="row ">
	    	<div class="col l4 m4 s12" id="left-col">
	       		<div class="card center padding25">
	       			<a class="block" href="<?php echo partner_base_url('profile') ?>">
	       				<img id="profile-image" src="<?php echo $logo  ?>" />
	       			</a>
	       			<h4><?php echo $vendorData['legal_name'] ?><h4>
	       			<?php if( $vendorData['is_featured'] == 1 ){ ?>
	       				<span class="sprite reskilling-hot-icon"></span>
	       			<?php } ?>

	       			<hr/>
	       			Profile Views: <?php echo $vendorData['profile_view_count'] ?>
	       		</div>
	       </div>
			
			<?php if( $totalCourses > 0 ){ ?>	        
	        <div class="col l8 m8 s12" id="courses">
	       		<div class="card small">
	       			<div class="card-content">
				    	<h2 class="left">Courses </h2>
				      
				      	<div class="right">
				      		<span class="circle-counter" title="Total Courses"><?php echo $totalCourses ?></span>	
				      		<a class="btn btn-floating cyan pulse" href="<?php echo partner_base_url('courses/add-course') ?>"><i class="material-icons">add</i></a>
							<a class="btn btn-floating cyan pulse" href="<?php echo partner_base_url('courses') ?>"><i class="material-icons">edit</i></a>
						</div>	
					</div>

					<div class="card-tabs">
			    	<ul id="courses-details" class="tabs">
				    	<li class="tab col s3 m4 l4"><a class="active" href="#courses-top">Top 5 - By views</a></li>
				    	<li class="tab col s3 m4 l4"><a href="#courses-bottom">Top 5 - By clicks</a></li>
				    	<li class="tab col s3 m4 l4"><a href="#courses-new">Latest 5</a></li>
				 	</ul>	  
			    </div>

			    <div class="card-content grey lighten-4">
			      <div id="courses-top" class="col s12 ">
			      	<?php
			      		if(count($topViewedCourses) > 0 ){
				      		foreach( $topViewedCourses as $key=>$value ){
				      			$no = $key + 1;
				      			echo $no . '. ' . $value['title'] . ' <span title="Total views" class="circle-counter top">' . $value['total_views'] .'</span>'. '<br/>';
				      		}
			      		} else{
			      			echo 'No Courses found.';
			      		}
			      	?>
			      </div>
				  <div id="courses-bottom" class="col s12 ">
				  	<?php
				  		if(count($topClickedCourses) > 0 ){
				      		foreach( $topClickedCourses as $key=>$value ){
				      			$no = $key + 1;
				      			echo $no . '. ' . $value['title'] . ' <span title="Total clicks" class="circle-counter top">' . $value['total_clicks'] .'</span>'. '<br/>';
				      		}
				      	}else{
			      			echo 'No Courses found.';
			      		}	
			      	?>
				  </div>
				  <div id="courses-new" class="col s12 ">
				  	<?php
				  		if(count($newCourses) > 0 ){
				      		foreach( $newCourses as $key=>$value ){
				      			$no = $key + 1;
				      			echo $no . '. ' . $value['title'] . '<br/>';
				      		}
			      		}else{
			      			echo 'No Courses found.';
			      		}
			      	?>
				  </div>
			    </div>

	       		</div>
	        </div>
	        <?php } ?>

	       	<?php if( $totalAssessments > 0 ){ ?>
	       	<div class="col s12 m8 l8" id="assessments">
				<div class="card small">
				    <div class="card-content">
				    	<h3 class="left">Assessments </h3>
				      
				      	<div class="right">
				      		<span class="circle-counter" title="Total Assessments"><?php echo $totalAssessments ?></span>	
				      		<a class="btn btn-floating cyan pulse" href="<?php echo partner_base_url('assessments/add-assessment') ?>"><i class="material-icons">add</i></a>
							<a class="btn btn-floating cyan pulse" href="<?php echo partner_base_url('assessments') ?>"><i class="material-icons">edit</i></a>
						</div>	
					</div>
				    
				    <div class="card-tabs">
				    	<ul id="assessments-details" class="tabs">
					    	<li class="tab col s3 m4 l4"><a class="active" href="#assessments-top">Top 5 - By views</a></li>
					    	<li class="tab col s3 m4 l4"><a href="#assessments-bottom">Top 5 - By clicks</a></li>
					    	<li class="tab col s3 m4 l4"><a href="#assessments-new">Latest 5</a></li>
					 	</ul>	  
				    </div>

				    <div class="card-content grey lighten-4">
				      <div id="assessments-top" class="col s12 ">
				      	<?php
					      	if(count($topViewedAssessments) > 0 ){	
					      		foreach( $topViewedAssessments as $key=>$value ){
					      			$no = $key + 1;
					      			echo $no . '. ' . $value['title'] . ' <span title="Total views" class="circle-counter top">' . $value['total_views'] .'</span>'. '<br/>';
					      		}
					      	}else{
					      		echo 'No Assessments found.';
					      	}	
				      	?>
				      </div>
					  <div id="assessments-bottom" class="col s12 ">
					  	<?php
					  		if(count($topClickedAssessments) > 0 ){	
					      		foreach( $topClickedAssessments as $key=>$value ){
					      			$no = $key + 1;
					      			echo $no . '. ' . $value['title'] . ' <span title="Total clicks" class="circle-counter top">' . $value['total_clicks'] .'</span>'. '<br/>';
					      		}
					      	}else{
					      		echo 'No Assessments found.';
					      	}	
				      	?>	
					  </div>
					  <div id="assessments-new" class="col s12 ">
					  	<?php
					  		if(count($newAssessments) > 0 ){	
					      		foreach( $newAssessments as $key=>$value ){
					      			$no = $key + 1;
					      			echo $no . '. ' . $value['title'] . '<br/>';
					      		}
					      	}else{
					      		echo 'No Assessments found.';
					      	}	
				      	?>
					  </div>
				    </div>

				</div>
		   	</div>
		   	<?php } ?>

		   	<?php if( $totalServices > 0 ){ ?>
			<div class="col s12 m8 l8" id="services">
				<div class="card small ">
				    <div class="card-content">
				    	<h3 class="left">Services</h3>
				      
				      	<div class="right">
				      		<span class="circle-counter" title="Total Services"><?php echo $totalServices ?></span>	
				      		<a class="btn btn-floating cyan pulse" href="<?php echo partner_base_url('services/add-service') ?>"><i class="material-icons">add</i></a>
							<a class="btn btn-floating cyan pulse" href="<?php echo partner_base_url('services') ?>"><i class="material-icons">edit</i></a>
						</div>	
					</div>
				    
				    <div class="card-tabs">
				    	<ul id="services-details" class="tabs">
					    	<li class="tab col s3 m4 l4"><a class="active" href="#services-top">Top 5 - By views</a></li>
					    	<li class="tab col s3 m4 l4"><a href="#services-bottom">Top 5 - By clicks</a></li>
					    	<li class="tab col s3 m4 l4"><a href="#services-new">Latest 5</a></li>
					 	</ul>	  
				    </div>

				    <div class="card-content grey lighten-4">
				      <div id="services-top" class="col s12 ">
				      	<?php
				      		if(count($topViewedServices) > 0 ){	
					      		foreach( $topViewedServices as $key=>$value ){
					      			$no = $key + 1;
					      			echo $no . '. ' . $value['title'] . ' <span title="Total views" class="circle-counter top">' . $value['total_views'] .'</span>'. '<br/>';
					      		}
					      	} else{
					      		echo 'No Services found.'; 
					      	}	
				      	?>
				      </div>
					  <div id="services-bottom" class="col s12 ">
					  	<?php
					  		if(count($topClickedServices) > 0 ){
					      		foreach( $topClickedServices as $key=>$value ){
					      			$no = $key + 1;
					      			echo $no . '. ' . $value['title'] . ' <span title="Total clicks" class="circle-counter top">' . $value['total_clicks'] .'</span>'. '<br/>';
					      		}
					      	} else{
					      		echo 'No Services found.'; 
					      	}	
				      	?>
					  </div>
					  <div id="services-new" class="col s12 ">
					  	<?php
					  		if(count($newServices) > 0 ){
					      		foreach( $newServices as $key=>$value ){
					      			$no = $key + 1;
					      			echo $no . '. ' . $value['title'] .'<br/>';
					      		}
					      	} else{
					      		echo 'No Services found.'; 
					      	}	
				      	?>
					  </div>
				    </div>

				</div>
			</div>
			<?php } ?>
	       
	    </div>
	</section>    
</div>
       
