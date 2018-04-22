<div id="partner-event">
	<div class="row white header-section">
		<div class="col l12 m12 s12">
			<div class="col l8 m8 s8">
				<?php 
				$pageTitle = 'Edit event';
				if(empty($eventDetails['title'])){
					$pageTitle = 'Add event';
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
			<form id="frm_addEditevent" name="frm_addEditevent" action="<?php echo partner_base_url('profile/save-event');?>" method="post">
				<input type="hidden" name="event-id" value="<?php echo $eventDetails['id'] ?>" />	
				<h4>Paste the event link and we will fetch the rest!</h4>
				<div class="row">

					<div class="input-field col s12 m12 l12">
						<input id="event-url" name="event-url" type="text" value="<?php echo $eventDetails['event_url']?>">
	        			<label for="link">Link*</label>
					</div>
				</div>

				<div id="other_details" class="hide">
					<div class="row">
						<div class="input-field col s12 m12 l12 ">
							<input id="event-title" name="event-title" type="text" value="<?php echo $eventDetails['title']?>">
	            			<label for="title">Title*</label>
						</div>
						
					</div>

					<div class="row">
						<div class="col s12 m12 l12 ">
		                    <label for="title">Image</label>
		                    <img src="<?php echo $eventDetails['image_name'] ?>" class="thumbnail-image" height="200" width="200">
		                    <input type="hidden" name="event-image" value="<?php echo $eventDetails['image_name'] ?>" id="event-image">
		                </div>
	                </div>

					<div class="row">	
						<div class="col s12 m12 l12 input-field">
							<textarea id="event-description" name="event-description" class="tinymce-editor1"><?php echo $eventDetails['description']?></textarea>
	            			<label for="description" class="custom">Description*</label>
						</div>
					</div>

					
					<div class="row">
						<div class="col s12 m12 l12 center">
							<input type="submit" value="Save" id="save-event" class="jfh-green btn default-btn white">
							<a class="waves-effect waves-light jfh-transparent default-btn " href="<?php echo partner_base_url('profile') ?>">Cancel</a>
						</div>
					</div>
				</div>			
			</form>	
		</div>
	</div>
</div>