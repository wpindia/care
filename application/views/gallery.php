<div class="row white header-section">
	<div class="col l12 m12 s12">
		<div class="col l8 m8 s8">
			<h2 class="left-align page-title">Image Gallery</h2>
		</div>
		
	</div>		
</div>

<div class="container white padding25">
	<div id="eventsmessage" class="white"></div>
	<div id="multipleupload">Upload</div>
	<input type="button" value="Submit" class="waves-effect waves-light jfh-green default-btn" id="upload" />
	<br/>
	<br/>

	<?php 
		if(count($images)>0){
			echo '<input id="show-images" class="waves-effect waves-light jfh-transparent default-btn" type="button" value="Manage Images">
					<div id="manage-images" class="padding25">
						<div class="row">
							<div class="col s12 m12 l12 wrapper">';
							foreach($images as $image){
								echo '<div class="left">';
								$source = 'uploads/admin/reskilling/gallery/' . $image['entity_id'] .'/'. $image['image_name'];
								echo '<img src="'.generate_image_url($source).'" class="partner-gallery" /><br/>';
								echo '<div class="featured-content-delete"><span class="delete" data-option-text="Image" data-featured-option="reskilling_gallery" data-option-id="'.$image['id'] .'"> </span></div>';
								
								echo '</div>';
							}
					echo '</div>
						</div>
					</div>
					';
		}
	?>
</div>
