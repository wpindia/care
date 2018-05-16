<div id="partner-testimonial">

	<div class="container white padding25">
		<div id="form-section" class="">
			<div class="center">
				<?php 
					echo validation_errors(); 
				?>
			</div>

			<form id="frm_addEditTestimonial" name="frm_addEditTestimonial" action="<?php echo partner_base_url('save-testimonial');?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="testimonial-id" value="<?php echo $testimonialDetails['id'] ?>" />
				<div class="row">
					<div class="col s6 m4 l4 ">
						<label for="branch-id">Branch Name*</label>
						<select id="branchId" name="branchId">
							<option value="">Select Branch</option>
							<?php 
								foreach($branches as $branch){
									echo '<option value="'.$branch['id'].'">'. $branch['branch_name']  .'</option>';
								} 
							?>
						</select>
	                </div>
					<div class="input-field col s6 m4 l4">
						<input id="parentName" name="parentName" type="text" value="<?php echo $testimonialDetails['parent_name']?>">
	        			<label for="parentName">Parent Name*</label>
					</div>
					<div class="input-field col s6 m4 l4 ">
						<input id="childName" name="childName" type="text" value="<?php echo $testimonialDetails['child_name']?>">
            			<label for="title">Child Name</label>
					</div>
				</div>

					<div class="row">
						
	                </div>

					<div class="row">	
						<div class="col s12 m12 l12 input-field">
							<textarea id="testimonial" name="testimonial" class="tinymce-editor"><?php echo $testimonialDetails['testimonial']?></textarea>
	            			<label for="testimonial" class="custom">Testimonial*</label>
						</div>
					</div>

					
					<div class="row">
						<div class="col s12 m12 l12 center">
							<input type="submit" value="Save" id="save-testimonial" class="btn daycare-green-btn compact"> or 
							<a class="waves-effect waves-light daycare-default-btn " href="<?php echo partner_base_url('dashboard') ?>">Cancel</a>
						</div>
					</div>
							
			</form>	
		</div>
	</div>
</div>