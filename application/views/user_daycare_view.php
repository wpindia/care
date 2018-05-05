<div class="wrapper" id="user_daycare_view">
	<div class="row margin-bottom0">
		<div class="col s12 m12 l12 padding0 section1">
			<div class="featured-image">
				<img class="block responsive-img" src="<?php echo base_url('images/carousel-1.jpg')?>" />
			</div>	
			<div class="daycare-title row margin-bottom0">
				<div class="col s2 m1 l1">
					<img class="" src="<?php echo base_url('images/kidsoorja.png')?>">
				</div>
				<div class="col s9 m9 l9">
					<h1 class=""><?php echo ucwords( $daycareDetails['vendor_name'] ) ?></h1>	
				</div>	
			</div>
			
			
      		<div class="care-side-menu">
      		<!-- <a class='dropdown-button btn right ' href='#' data-activates='dropdown1'><i class="material-icons large">menu</i></a> -->
      		</div>

		  <!-- Dropdown Structure -->
		  <ul id='dropdown1' class='dropdown-content'>
		    <li><a href="#!" title="About-us" class="about-us"><i class="material-icons">info</i></a></li>
		    <li><a href="#!" title="Features" class="features"><i class="material-icons">star</i></a></li>
		    <li><a href="#!" title="Gallery" class="gallery"><i class="material-icons">camera</i></a></li>
		    <li><a href="#!" title="Reviews" class="reviews"><i class="material-icons">rate_review</i></a></li>
		  	<li><a href="#!"  title="Location" class="location"><i class="material-icons ">location_on</i></a></li>
		    <li><a href="#!" title="Phone" class="location"><i class="material-icons">phone</i></a></li>
		    	
		  </ul>

		</div>
	</div>
	<div id="about-us-section" class="row margin-bottom0" style="background:#e57368;min-height:200px">
		<div class="col s12 m12 l12">
			<div  class="section ">
				<h3>About Us</h3>	
				<?php echo $daycareDetails['description'] ?>
			</div>	
		</div>
	</div>

	<div id="features-section" class="row margin-bottom0" style="background:#ffcf40;min-height:200px">
		<div class="section ">	
		<h3>Features</h3>
			<div class="col s12 m4 l4">
				<i class="material-icons">check</i> Timings: 8.30 a.m to 7.30 p.m<br/><br/>
				<i class="material-icons">check</i> Age-Group: 10 months+<br/><br/>
				<i class="material-icons">check</i> Trained & caring staff<br/><br/>
			</div>

			<div class="col s12 m4 l4">
				<i class="material-icons">
					<?php if($daycareDetails['is_food_available']) echo "check"; else echo "clear";?> 
				</i> 
				Food provided<br/><br/>
				<i class="material-icons">
					<?php if($daycareDetails['is_open_on_weekends']) echo "check"; else echo "clear";?> 
				</i> Open on weekend<br/><br/>

				<i class="material-icons">
					<?php if($daycareDetails['is_pick_drop_available']) echo "check"; else echo "clear";?> 
				</i> Transport available<br/><br/>
			</div>
			
			<div class="col s12 m4 l4">
				<i class="material-icons">
					<?php if($daycareDetails['are_activities_available']) echo "check"; else echo "clear";?> 
				</i>
				Activities<br/><br/>
				<i class="material-icons">
					<?php if($daycareDetails['is_doctor_on_call_available']) echo "check"; else echo "clear";?> 
				</i>Doctor on call<br/><br/>

				<i class="material-icons">
					<?php if($daycareDetails['is_digital_payment_available']) echo "check"; else echo "clear";?> 
				</i>Aceepts Credit/Debit Card<br/><br/>				
			</div>

				
		</div>
	</div>

	<div id="gallery-section" class="row margin-bottom0 padding20" style="background:#8cb859;min-height:200px" >	
		<div class="section">
		<h3>Gallery</h3>
		<div id="gallery" class="col s12 m12 l12 owl-carousel owl-theme ">
			<div class="slide1">
				<img src="<?php echo base_url('images/gallery-1.jpg')?>" title="playing" />
			</div>

			<div class="slide2">
				<img src="<?php echo base_url('images/gallery-2.jpg')?>" title="laughing" />
			</div>
			<div class="slide3">
				<img src="<?php echo base_url('images/gallery-3.jpg')?>" title="laughing" />
			</div>
			<div class="slide4">
				<img src="<?php echo base_url('images/gallery-4.jpg')?>" title="laughing" />
			</div>
			<div class="slide5">
				<img src="<?php echo base_url('images/gallery-5.jpg')?>" title="laughing" />
			</div>
		</div>
		</div>
	</div>

	<div id="review-section" class="row margin-bottom0 padding20" style="background:#e57368;min-height:200px" >		<div class="section">
		<div class="col s12 m12 l12">
			<div class="col s12 m6 l6">
			<h3 class="white-text">Enquiry</h3>
			
				<form id="frm_signup" name="frm_signup" action="<?php echo base_url('signupProcess');?>" method="post">
				<div class="row">
					<div class="col s12 m6 l6 input-field ">
						<input type="text" name="contact_name" id="contact_name" class="form-class black-text" placeholder="Contact Name" data-error="" value="<?php echo set_value('contact_name'); ?>">
					</div>
				</div>

				<div class="row">
					<div class="col s12 m6 l6 input-field">
						<input type="email" name="email" id="email" class="form-class" placeholder="Email ID*" data-error=".errorTxtemail" value="<?php echo set_value('email'); ?>">

					</div>
				
					
				</div>

				<div class="row">
					<div class="col s12 m6 l6 input-field">
						
						<input type="text" name="mobile_no" id="mobile_no" class="number form-class" placeholder="Mobile No*" data-error=".errorTxtmob" value="<?php echo set_value('mobile_no'); ?>">
					</div>
					
					
				</div>

				
				<div class="row">
					<div class="col s12 m12 l12">
						
						<button class="daycare-default-round-btn waves-effect waves-light btn" type="submit" name="action">Submit
						    <i class="material-icons right">send</i>
						</button>
						
					</div>
				</div>		
			</form>
			</div>
			<div id="testimonials-section" class="col s12 m6 l6">
				<h3 class="white-text">What our parents say</h3>
				<div id="testimonials" class="owl-carousel owl-theme ">
					<div class="slide1">
					I can't say enough good things about Little Kid n Me. Everyone on their staff is wonderful, especially the director. I highly recommend this daycare!<br/>

					<span class="author">David J.<br/>
					Parent
					</span>
					</div>
					<div class="slide2">
						This place is wonderful! Both my children love attending. My son is flourishing in the preschool and my daughter couldn't wait for summer camp to start!<br/>

						<span class="author">Jessica M.<br/>
						Parent
						</span>	
					</div>
				</div>	
			</div>
		</div>
		</div>
	</div>

	<div id="other-center-section" class="row margin-bottom0 padding20" style="background:#ffcf40;min-height:200px" >	
		<h3>Other Centers</h3>	
		<div class="col s12 m3 l3">
	      	<a href="<?php echo base_url('title/1')?>" class="block">
		      <div class="card medium">
		        <div class="card-image">
		          <img src="<?php echo base_url('images/sample-1.jpg')?>">
		          <span class="card-title">Kids Oorja</span>
		          
		        </div>
		        <div class="card-content">
		          <i class="material-icons small">location_on</i> Kothrud, Pune.<br/>
		          <i class="material-icons small">group</i>10 months+<br/>
		          <i class="material-icons small">access_time</i> 8.30a.m - 7.30p.m<br/>
		        </div>
		      </div>
		    </a>  
	    </div>
		  
	</div>

	<div id="contact-us-section" class="row margin-bottom0 padding20" style="background:#8cb859;min-height:200px">
		<div class="col s12 m12 l12">
			<div class="col s12 m3 l3">
				<h3>Contact Us</h3>	
				<!--<div class="btn daycare-green-round-btn margin20">Contact DayCare</div>-->
				<!--<div class="contact-us-details padding20" >-->
					<i class="material-icons">person</i> <?php echo $daycareDetails['contact_name'] ?><br/><br/>
					<i class="material-icons">phone</i> <?php echo $daycareDetails['mobile'] ?> <br/><br/>
					<i class="material-icons">email</i> <a href="mailto:<?php echo $daycareDetails['email'] ?>"><?php echo $daycareDetails['email'] ?></a><br/>
				<!--</div>-->
			</div>
			<div class="col s12 m9 l9">
				<h3>Our Location</h3>
				<iframe height="300px" width="100%" src="//www.google.com/maps/embed/v1/directions?origin=
      &destination=<?php echo $daycareDetails['address'] ?>&zoom=12&key=<?php echo GOOGLE_MAPS_API_KEY ?>">
  </iframe>	
			</div>	
		</div>
	</div>	
</div>	
