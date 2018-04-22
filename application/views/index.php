<?php 
	$coverImage     = ( true == $partnerDetails['is_featured'] && false == empty( $partnerDetails['cover_image'] ) ) ? generate_image_url('images/reskilling/desktop/vendors/' . $partnerDetails['cover_image'] ) : generate_image_url('images/mentor/featured-default.jpg');

	$logo = ( true == empty( $partnerDetails['logo'] ) ) ? generate_image_url('images/soc.png') : generate_image_url( 'images/reskilling/desktop/vendors/' . $partnerDetails['logo'] );

	$featuredClass = ( true == $partnerDetails['is_featured'] ) ? 'featured-timeline' : '';
?>

<div id="profile" class="container">
	
		<div id="header" class="row white">
			<div class="timeline-content <?php echo $featuredClass ?>" >
				<?php if( true == $partnerDetails['is_featured'] ) { ?>
	                    <div class="cover cover-image">
	                        <img class="responsive-img partner-featured-image" src="<?php echo $coverImage ?>" alt="<?php echo 'partner cover image - JFH';?>" width="100%;" height="200px">
	                    </div>
	            <?php } ?>
	            <div class="row cover cover-headline">            
					<div class="col s2 m2 l2">
						<div class="cover-logo">
							<img class="responsive-img partner-logo-img" src="<?php echo $logo ?>" alt="<?php echo $partnerDetails['legal_name'] ?>" width="100" height="100">
						</div>
					</div>

					<div class="col s6 m7 l7">
						<div class="cover-description">
							<div class="timeline-cover-name">
								<h1 class="">
									<?php echo $partnerDetails['legal_name'] ?>																							
								</h1>
							</div>
							
						</div>
					</div>

					<div class="col s4 m3 l3 ">
						<div class="followers hide" id="">
							<span class="follower-counts hide" id="followers_count">335</span>
							<span class="follower-text hide">Followers</span>
						</div>
						<?php if(true == $isAdmin){?>
						<div class="timeline-cover-social timeline-action">
							
							<a href="<?php echo partner_base_url('create-profile'); ?>" title="Edit Profile" class="btn jfh-green default-btn" id="" data-id="">
								Edit Profile
							</a>
							
						</div>
						<?php } ?>
					</div>
				</div>	
			</div>	
		</div>
	
	<div class="row">
		<?php if($partnerDetails['is_featured'] == 0){?>
			<div class="col s12 m12 l12 no-padding" id="left-content">
		<?php } else{ ?>	
			<div class="col s12 m8 l8 no-padding" id="left-content">
		<?php 
		}
		?>		
			<div class="description section white padding25">
				<h2>About Us:</h2>
				<?php echo $partnerDetails['description'] ?>
			</div>

			<?php if(count($newCourses) > 0 || count($newAssessments) > 0 || count($newServices) > 0 ) {?> 
			<div class="section white">	
				
					<div class="card sidebar-card">
						<ul class="collapsible sidebar-collapse" data-collapsible="accordion">
							<?php if(count($newCourses) > 0 ){?>	
							<li class="active">
								
								<div class="collapsible-header active">
									Active Courses
									<i class="material-icons right">arrow_drop_down</i>

								</div>
								<div class="collapsible-body">
									<?php 
										foreach( $newCourses as $course) {
											$courseLogo 	= ( false == empty( $course['logo'] ) ) ? generate_image_url('images/reskilling/desktop/courses/'. $course['logo'] ) : generate_image_url('images/reskilling/default-course-icon.png');
												$courseLink     = base_url('courses') . '/' . $course['slug'];
												//$courseType   	= $course['reskillingModeType']['name'];

										?>
											<div class="row">

												<div class="col s3 m3 l2 course-logo-wrapper no-padding">
													<div class="entity-logo">
														<a class="block" target="_blank" href="<?php echo $courseLink ?>">
															<img class="responsive-img course-image" alt="<?php echo $course['title'] ?>" src="<?php echo $courseLogo ?>" width="100px" height="100">
														</a>
													</div>
												</div>
												
												<div class="col s9 m9 l10 no-padding">
													<div class="side course-content">
														<input type="hidden" class="course-id" value="<?php echo $course['id'] ?>">
														<a class="block" target="_blank"  href="<?php echo $courseLink ?>" title="<?php echo $course['title'] ?>" >
															<h4 class="course-name margin-bottom-5">
																<?php echo $course['title'] ?>
																<?php if( true == $course['is_featured'] ){
																	echo '<span class="sprite reskilling-hot-icon"></span><span class="hot-icon-text">Featured</span>';	
																}
																?>		
															</h4>
															<div class="description">
																<?php echo substr($course['description'] ,0, 250 ) . ' ...' ?>
															</div>
														</a>
															
															
													</div>
												</div>
											</div>	
											<hr/>
											

										<?php	
										}
									?>
										<div class="center">
											<a target="_blank" href="<?php echo partner_base_url('offerings') ?>" class="center btn default-btn follower-btn" id="" data-id="">
												View more
											</a>
										</div>	
								</div>
								
							</li>
							<?php } ?>

							<?php if(count($newAssessments) > 0 ){?>
							<li>
								<div class="collapsible-header active">
									Active Assessments
									<i class="material-icons right">arrow_drop_down</i>

								</div>
								<div class="collapsible-body">
									<?php 
										foreach( $newAssessments as $assessment) {
											$assessmentLogo = ( false == empty( $assessment['logo'] ) ) ? generate_image_url('images/reskilling/desktop/assessments/'. $assessment['logo'] ) : generate_image_url('images/reskilling/default-assessment-icon.png');
												$assessmentLink     = base_url('career-assessment') . '/' . $assessment['slug'];
												//$assessmentType   	= $assessment['reskillingModeType']['name'];

										?>
											<div class="row">

												<div class="col s3 m3 l2 assessment-logo-wrapper no-padding">
													<div class="entity-logo">
														<a class="block" target="_blank" href="<?php echo $assessmentLink ?>">
															<img class="responsive-img assessment-image" alt="<?php echo $assessment['title'] ?>" src="<?php echo $assessmentLogo ?>" width="100px" height="100">
														</a>
													</div>
												</div>
												
												<div class="col s9 m9 l10 no-padding">
													<div class="side assessment-content">
														<a class="block" target="_blank"  href="<?php echo $assessmentLink ?>" title="<?php echo $assessment['title'] ?>" >
															<h4 class="assessment-name margin-bottom-5">
																<?php echo $assessment['title'] ?>
																<?php if( true == $assessment['is_featured'] ){
																	echo '<span class="sprite reskilling-hot-icon"></span><span class="hot-icon-text">Featured</span>';	
																}
																?>		
															</h4>
															<div class="description">
																<?php echo substr($assessment['description'] ,0, 250 ) . ' ...' ?>
															</div>
														</a>
															
															
													</div>
												</div>
											</div>	
											<hr/>
											

										<?php	
										}
									?>
										<div class="center">
											<a target="_blank" href="<?php echo partner_base_url('offerings') ?>" class="center btn default-btn follower-btn" id="" data-id="">
												View more
											</a>
										</div>	
								</div>
								
								
							</li>
							<?php } ?>	

										<?php if(count($newServices) > 0 ){?>
							<li>
								<div class="collapsible-header active">
									Active Services
									<i class="material-icons right">arrow_drop_down</i>

								</div>
								<div class="collapsible-body">
									<?php 
										foreach( $newServices as $service) {
											$serviceLogo = ( false == empty( $service['logo'] ) ) ? generate_image_url('images/reskilling/desktop/services/'. $service['logo'] ) : generate_image_url('images/reskilling/default-service-icon.png');
												$serviceLink     = base_url('expert-services') . '/' . $service['slug'];
												//$serviceType   	= $service['reskillingModeType']['name'];

										?>
											<div class="row">

												<div class="col s3 m3 l2 service-logo-wrapper no-padding">
													<div class="entity-logo">
														<a class="block" target="_blank" href="<?php echo $serviceLink ?>">
															<img class="responsive-img service-image" alt="<?php echo $service['title'] ?>" src="<?php echo $serviceLogo ?>" width="100px" height="100">
														</a>
													</div>
												</div>
												
												<div class="col s9 m9 l10 no-padding">
													<div class="side service-content">
														<a class="block" target="_blank"  href="<?php echo $serviceLink ?>" title="<?php echo $service['title'] ?>" >
															<h4 class="service-name margin-bottom-5">
																<?php echo $service['title'] ?>
																<?php if( true == $service['is_featured'] ){
																	echo '<span class="sprite reskilling-hot-icon"></span><span class="hot-icon-text">Featured</span>';	
																}
																?>		
															</h4>
															<div class="description">
																<?php echo substr($service['description'] ,0, 250 ) . ' ...' ?>
															</div>
														</a>
															
															
													</div>
												</div>
											</div>	
											<hr/>
											

										<?php	
										}
									?>
										<div class="center">
											<a target="_blank" href="<?php echo partner_base_url('offerings') ?>" class="center btn default-btn follower-btn" id="" data-id="">
												View more
											</a>
										</div>	
								</div>
								
								
							</li>
							<?php } ?>

						</ul>
					</div>
				
			</div> 
			<?php } ?>
			<?php if(false == empty($partnerDetails['registered_address'])) { ?>
			<div class="section white padding25">	
				<h2>Address:</h2> 
				<?php echo $partnerDetails['registered_address'] ?>
				
			</div>
			<?php } ?>

			<?php if($partnerDetails['is_featured'] == 1 ){?>
				<div class="section white padding25">	
					<h2 class="left">Image Gallery:</h2>
					<a href="<?php echo partner_base_url('create-gallery') ?>" class="waves-effect waves-light green-button right add-featured-content">
                        <i class="material-icons">add</i>Manage Images
                    </a>
                    <div class="clearfix"></div>
                    <?php if( count($galleryImages) > 0 ){ ?>
					<div id="partner-gallery" class="owl-carousel owl-theme jfh-theme center jfh-carousel" data-indicators="true">
						<?php 
						foreach($galleryImages as $galleryImage){
							$source = 'uploads/admin/reskilling/gallery/' . $galleryImage['entity_id'] .'/'. $galleryImage['image_name'];
						?>	
							<img src="<?php echo generate_image_url($source)?>" class="responsive-img" />
						<?php
						}
						?>	
					</div>
					<?php } ?>			
				</div>	
			<?php } ?>

		</div>
		
		<?php if($partnerDetails['is_featured'] == 1){?>
			<div class="col s12 m4 l4" id="right-content">
				<div class="section partner-blogs white padding25">
					<h2 class="title left">Blogs</h2>	
								
					<?php if(isset($blogs) && !empty($blogs)){ ?>
						<a href="<?php echo partner_base_url('profile/create-blog') ?>" class="waves-effect waves-light green-button right add-featured-content">
	                        <i class="material-icons">add</i>Add new
	                    </a>
	                    <div class="clearfix"></div>
						<div id="partner-blog" class="owl-carousel featured_carousel jfh-theme center jfh-carousel" data-indicators="true">
							<?php 
							foreach($blogs as $keys => $post){
								$name = $post['title'];
								$description = custom_echo(strip_tags($post['description']),160);
								$image = generate_image_url('images/blog-default.jpg');
								if(trim($post['image_path']) != '') {
									$image = generate_image_url($post['image_path']);
								}
								$link = $post['blog_link'];
								?>
								
								
									<div class="blog-card">
										<div class="featured-content-edit">
                                            <a href="<?php echo partner_base_url('profile/edit-blog/' . $post['id'] ) ?>" target="_blank">
                                            	<span class="edit" data-featured-option="blogs" data-option-id="<?php echo $post['id'] ?>"></span>
                                            </a>
                                        </div>
                                        <div class="featured-content-delete">    
                                            <span class="delete" data-option-text="Blog" data-featured-option="blogs" data-option-id="<?php echo $post['id'] ?>"> </span>
                                        </div>
										<a class="block" title="<?php echo $name;?>" href="<?php echo $link;?>" target="_blank">
											<div class=" blog-image-holder">
												<img alt="<?php echo $name;?>" class="responsive-img blog-image" src="<?php echo $image; ?>">
											</div>
											<div class="card-blog-content">
												<h4 class="header-title"><?php echo $name;?></h4>
												<p class="description"><?php echo $description;?></p>
											</div>
										</a>
										<a title="Read more" class="block jfh-card-read read-more" target="_blank" href="<?php echo $link;?>">
											Read more
										</a>
									</div>
								
							<?php } ?>
						</div>
				
					<?php }else{?>
						<div class="clearfix"></div>
	                    <div class="center">
		                    <a target="_blank" class="center waves-effect waves-light" href="<?php echo partner_base_url('profile/create-blog') ?>">
		                        
		                        <img src="<?php echo generate_image_url('images/blank-profile.png') ?>" class="responsive-img ">
		                        
		                        <h3 class="add-new-title" >Add Blog</h3>
		                    </a>
	                    </div>
		            <?php }  
		            ?>		
				</div>		
				
				<div class="section partner-events white padding25">
					<h2 class="title left">Events</h2>
						
					<?php if(isset($events) && !empty($events)){ ?>
						<a href="<?php echo partner_base_url('profile/create-event') ?>" class="waves-effect waves-light green-button right add-featured-content">
	                        <i class="material-icons">add</i>Add new
	                    </a>
	                    <div class="clearfix"></div>
						<div id="partner-event" class="owl-carousel featured_carousel jfh-theme center jfh-carousel" data-indicators="true">
							<?php 
							foreach($events as $keys => $post){
								$name = $post['title'];
								$description = custom_echo(strip_tags($post['description']),160);
								$image = generate_image_url('images/event-default.jpg');
								if(trim($post['image_name']) != '') {
									$image = generate_image_url($post['image_name']);
								}
								$link = $post['event_url'];
								?>
								
								
									<div class="event-card">
										<div class="featured-content-edit">
                                            <a href="<?php echo partner_base_url('profile/edit-event/' . $post['id'] ) ?>" target="_blank">
                                            	<span class="edit" data-featured-option="external_events" data-option-id="<?php echo $post['id'] ?>"></span>
                                            </a>
                                        </div>
                                        <div class="featured-content-delete">    
                                            <span class="delete" data-option-text="Event" data-featured-option="external_events" data-option-id="<?php echo $post['id'] ?>"> </span>
                                        </div>
										<a class="block" title="<?php echo $name;?>" href="<?php echo $link;?>" target="_blank">
											<div class=" event-image-holder">
												<img alt="<?php echo $name;?>" class="responsive-img event-image" src="<?php echo $image; ?>">
											</div>
											<div class="card-event-content">
												<h4 class="header-title"><?php echo $name;?></h4>
												<p class="description"><?php echo $description;?></p>
											</div>
										</a>
										<a title="Read more" class="block jfh-card-read read-more" target="_blank" href="<?php echo $link;?>">
											Read more
										</a>
									</div>
								
							<?php } ?>
						</div>
				
					<?php }else{?>
						<div class="clearfix"></div>
	                    <div class="center">
		                    <a target="_blank" class="center waves-effect waves-light" href="<?php echo partner_base_url('profile/create-event') ?>">
		                        
		                        <img src="<?php echo generate_image_url('images/blank-profile.png') ?>" class="responsive-img ">
		                        
		                        <h3 class="add-new-title" >Add event</h3>
		                    </a>
		                </div>    
		            <?php }  
		            ?>		
				</div>

				<?php if( false == empty($partnerDetails['video_url']) ){ ?>
				<div class="section white padding25">
					<h2>Videos:</h2>
					
					<?php
                        $videoId = generateYoutubeURL( $partnerDetails['video_url'] );
                    ?>
                    <iframe class="youtube" width="100%" height="300px" src="https://www.youtube.com/embed/<?php echo $videoId ?>" frameborder="0" allowfullscreen></iframe>		
					
				</div>
				<?php } ?>

				<div class="section partner-testimonials white padding25">
					
					<h2 class="title left">Testimonials</h2>	
					
					<?php if(isset($testimonials) && !empty($testimonials)){ ?>
						<a href="<?php echo partner_base_url('profile/create-testimonial') ?>" class="waves-effect waves-light green-button right add-featured-content">
	                        <i class="material-icons">add</i>Add new
	                    </a>
	                    <div class="clearfix"></div>
						<div id="partner-testimonial" class="owl-carousel featured_carousel jfh-theme center jfh-carousel" data-indicators="true">
							<?php 
							foreach($testimonials as $keys => $post){
								$name = $post['name'];
								$designation = $post['designation'];
								$image = generate_image_url('images/testimonial-default.jpg');
								if(trim($post['image_name']) != '') {
									$path = 'uploads/admin/reskilling/testimonials/'. $partnerDetails['id'] . '/' . $post['image_name'];
									$image = generate_image_url($path);
								}
								$description = $post['description'];
								if(false == empty($designation)){
									$designation = ', ' . $designation;
								}
								?>

								<div class="wrapper">
									<div class="featured-content-edit">
	                                    <a href="<?php echo partner_base_url('profile/edit-testimonial/' . $post['id'] ) ?>" target="_blank">
	                                    	<span class="edit" data-featured-option="reskilling_testimonials" data-option-id="<?php echo $post['id'] ?>"></span>
	                                    </a>
	                                </div>
	                                <div class="featured-content-delete">    
	                                    <span class="delete" data-option-text="Testimonial" data-featured-option="reskilling_testimonials" data-option-id="<?php echo $post['id'] ?>"> </span>
	                                </div>
									<div class="left">
										<img src="<?php echo $image ?>" />
									</div>
									<div class="left">
										<h4 class="header-title"><?php echo $name ?><span><?php echo $designation ?></span></h4>
										<div class="description">
											
											<?php echo $description ?>
										</div>
									</div>
								</div>
									
									
								
							<?php } ?>
						</div>
				
					<?php }else{?>
						<div class="clearfix"></div>
		                <div class="center">
		                    <a target="_blank" class="center waves-effect waves-light" href="<?php echo partner_base_url('profile/create-testimonial') ?>">
		                        
		                        <img src="<?php echo generate_image_url('images/blank-profile.png') ?>" class="responsive-img ">
		                        
		                        <h3 class="add-new-title" >Add testimonial</h3>
		                    </a>
		                </div>    
		            <?php }  
		            ?>		
				</div>		
			</div>	
		<?php 
		}
		?>	
	</div>	
</div>