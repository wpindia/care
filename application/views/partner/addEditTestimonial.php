<div id="partner-testimonial">

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
	        			<label for="testimonial-name">Parent Name*</label>
					</div>
					<div class="input-field col s6 m6 l6 ">
						<input id="testimonial-designation" name="testimonial-designation" type="text" value="<?php echo $testimonialDetails['designation']?>">
            			<label for="title">Child Name</label>
					</div>
				</div>

					<div class="row">
						<div class="col s12 m12 l12 ">
							<label for="branch-id">Branch Name*</label>
							<select id="branch-id" name="branch-id">
							<option value="0">Select Branch</option>
							<?php 
								foreach($branches as $branch){
									echo '<option value="'.$branch['id'].'">'. $branch['branch_name']  .'</option>';
								} 
							?>
							</select>
		                </div>
	                </div>

					<div class="row">	
						<div class="col s12 m12 l12 input-field">
							<textarea id="testimonial-description" name="testimonial-description" class="tinymce-editor"><?php echo $testimonialDetails['description']?></textarea>
	            			<label for="description" class="custom">Testimonial*</label>
						</div>
					</div>

					
					<div class="row">
						<div class="col s12 m12 l12 center">
							<input type="submit" value="Save" id="save-testimonial" class="btn daycare-green-btn compact">
							<a class="waves-effect waves-light daycare-default-btn " href="<?php echo partner_base_url('dashboard') ?>">Cancel</a>
						</div>
					</div>
							
			</form>	
		</div>
	</div>
</div>