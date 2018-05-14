					<div id="manage-images" class="">
						<div class="row">
							<div class="col s12 m12 l12 wrapper">
								<?php foreach($galleryImages as $galleryImage){ ?>
									<div class="left margin-bottom40">
									<?php 

									$source = 'uploads/admin/' . $galleryImage->vendor_id .'/'. $galleryImage->branch_id . '/gallery/' . $galleryImage->image_name;
									?>
									<img src="<?php echo base_url($source) ?>" width="200" class="partner-gallery" /><br/>
									<div class="featured-content-delete">
										
										<a href="" class="delete center" data-option-id="<?php echo $galleryImage->id ?>">
											<i class="material-icons">delete_forever</i> 
										</a>
									</div>
									
									</div>
								<?php } ?>
							</div>
						</div>
					</div>