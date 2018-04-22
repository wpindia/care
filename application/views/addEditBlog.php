<div id="partner-blog">
	<div class="row white header-section">
		<div class="col l12 m12 s12">
			<div class="col l8 m8 s8">
				<?php 
				$pageTitle = 'Edit Blog';
				if(empty($blogDetails['title'])){
					$pageTitle = 'Add Blog';
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
			<form id="frm_addEditBlog" name="frm_addEditBlog" action="<?php echo partner_base_url('profile/save-blog');?>" method="post">
				<input type="hidden" name="blog-id" value="<?php echo $blogDetails['id'] ?>" />

				<h4>Paste the blog link and we will fetch the rest!</h4>
				<div class="row">

					<div class="input-field col s12 m12 l12">
						<input id="blog-link" name="blog-link" type="text" value="<?php echo $blogDetails['blog_link']?>">
	        			<label for="link">Link*</label>
					</div>
				</div>

				<div id="other_details" class="hide">
					<div class="row">
						<div class="input-field col s12 m12 l12 ">
							<input id="blog-title" name="blog-title" type="text" value="<?php echo $blogDetails['title']?>">
	            			<label for="title">Title*</label>
						</div>
						
					</div>

					<div class="row">
						<div class="col s12 m12 l12 ">
		                    <label for="title">Image</label>
		                    <img src="<?php echo $blogDetails['image_path'] ?>" class="thumbnail-image" height="200" width="200">
		                    <input type="hidden" name="blog-image" value="<?php echo $blogDetails['image_path'] ?>" id="blog-image">
		                </div>
	                </div>

					<div class="row">	
						<div class="col s12 m12 l12 input-field">
							<textarea id="blog-description" name="blog-description" class="tinymce-editor"><?php echo $blogDetails['description']?></textarea>
	            			<label for="description" class="custom">Description*</label>
						</div>
					</div>

					
					<div class="row">
						<div class="col s12 m12 l12 center">
							<input type="submit" value="Save" id="save-blog" class="jfh-green btn default-btn white">
							<a class="waves-effect waves-light jfh-transparent default-btn " href="<?php echo partner_base_url('profile') ?>">Cancel</a>
						</div>
					</div>
				</div>			
			</form>	
		</div>
	</div>
</div>