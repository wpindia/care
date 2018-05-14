<div class="container white padding25">
	<div class="row">
		<h1>Manage Gallery</h1>
		<div class="col s6 m5 l5" id="left-section">	
			
			<label for="branch-id">Branch Name</label>
			<select id="branch-id" name="branch-id">
			<option value="0">Select Branch</option>
			<?php 
				foreach($branches as $branch){
					echo '<option value="'.$branch['id'].'">'. $branch['branch_name']  .'</option>';
				} 
			?>
			</select>
			
			<div id="upload-wrapper" class="hide">
				<div id="eventsmessage" class="white"></div>
				<div id="multipleupload">Upload</div>
				<input type="button" value="Submit" class="daycare-green-round-btn btn waves-effect waves-light" id="upload" />
			</div>
		</div>
		<div class="col s6 m6 l6">
			<div id="branch-images" class="margin20">
			</div>
		</div>
	</div>
	

	<?php 
		/*if(count($images)>0){
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
		}*/
	?>
</div>
