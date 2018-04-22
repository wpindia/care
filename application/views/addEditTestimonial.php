<div id="partner-testimonial">
	<div class="row white header-section">
		<div class="col l12 m12 s12">
			<div class="col l8 m8 s8">
				<?php 
				$pageTitle = 'Edit testimonial';
				if(empty($testimonialDetails['title'])){
					$pageTitle = 'Add testimonial';
				} 
				?>
				<h2 class="left-align page-title"><?php echo $pageTitle ?></h2>
			</div>
			
		</div>		
	</div>

	<div class="container white padding25">
		<div id="form-section" class="">
			<div class="center">
				<?php 
					echo validation_errors(); 
				?>
			</div>
			<form id="frm_addEdittestimonial" name="frm_addEdittestimonial" action="<?php echo partner_base_url('profile/save-testimonial');?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="testimonial-id" value="<?php echo $testimonialDetails['id'] ?>" />
				<div class="row">

					<div class="input-field col s6 m6 l6">
						<input id="testimonial-name" name="testimonial-name" type="text" value="<?php echo $testimonialDetails['name']?>">
	        			<label for="testimonial-name">Testimonial By*</label>
					</div>
					<div class="input-field col s6 m6 l6 ">
						<input id="testimonial-designation" name="testimonial-designation" type="text" value="<?php echo $testimonialDetails['designation']?>">
            			<label for="title">Designation</label>
					</div>
				</div>

					<div class="row">
						<div class="col s12 m12 l12 ">
						<?php 
							$featuredImage = '';
							if($testimonialDetails['image_name'] != ''){
								$featuredImage = generate_image_url('uploads/admin/reskilling/testimonials/' . $vendorId . '/' . $testimonialDetails['image_name']);
							}
						?>	
		                    <label for="title">Image</label>
		                    <input type="text" class="hide" name="testimonial-image" id="testimonial-image" value="<?php echo $testimonialDetails['image_name']?>">
							<input type="file" name="featured-image" class="dropify" id="featured-image"
							data-default-file="<?php echo $featuredImage;?>" data-allowed-file-extensions="png jpeg jpg" data-max-file-size="1M" />
		                </div>
	                </div>

					<div class="row">	
						<div class="col s12 m12 l12 input-field">
							<textarea id="testimonial-description" name="testimonial-description" class="tinymce-editor"><?php echo $testimonialDetails['description']?></textarea>
	            			<label for="description" class="custom">Description*</label>
						</div>
					</div>

					
					<div class="row">
						<div class="col s12 m12 l12 center">
							<input type="submit" value="Save" id="save-testimonial" class="jfh-green btn default-btn white">
							<a class="waves-effect waves-light jfh-transparent default-btn " href="<?php echo partner_base_url('profile') ?>">Cancel</a>
						</div>
					</div>
							
			</form>	
		</div>
	</div>
</div>