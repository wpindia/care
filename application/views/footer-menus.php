<?php
/**
 * This file is used for display the footer menus and loading the js files
 * @author Rajesh Kumar
 */
?>
	
	<div class="footer-container footer-menus">
		<div class="row">
			<div class="col s12 m6 no-padding">
				<ul class="col s12 footer-list desktop list-inline">
					<li class="col s6 left-side-menu">
						<ul class="sub-ul">
							<li><a target="_blank" href="<?php echo partner_base_url(); ?>">Partner Zone</a></li> 
							<li><a target="_blank" href="<?php echo base_url('reskilling'); ?>">Reskilling</a></li> 
							<li><a target="_blank" href="<?php echo base_url('reskilling-partners-for-career-development'); ?>">Partners </a></li>
							<li><a target="_blank" href="<?php echo base_url('accelherate'); ?>">AccelHERate </a></li>
							<li><a target="_blank" href="<?php echo base_url('restarther'); ?>">RestartHer</a></li>
						</ul>
					</li>
					<li class="col s6 right-side-menu">
						<ul class="sub-ul">
							<li><a target="_blank" href="<?php echo EMP_DOMAIN_URL; ?>">Employers' Zone</a></li>
							<li><a target="_blank" href="<?php echo base_url('mentor'); ?>">Mentors' Zone</a></li>
							<li><a target="_blank" href="<?php echo base_url('about-us'); ?>">About Us</a></li>
							<li><a target="_blank" href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
							<?php
							if (isset($logged) && !($logged)) {
								?>
								<li><a href="<?php echo partner_base_url('signup'); ?>" class="">Sign Up</a></li> 
								<?php
							}
							?>
						</ul>
					</li>
				</ul>
			</div>
			<div class="col s12 m6 no-padding">
				<div class="col s12 no-padding social-media-hold center">
					<h3>Follow us on</h3>
					<ul class="list-inline">
						<li><a href="https://www.facebook.com/jobsforher" target="blank"><i class="social-icons-sprite social-icons facebook-icon"></i></a></li>
						<li><a href="https://www.linkedin.com/company/jobsforher?report.success=KJ_KkFGTDCfMt-A7wV3Fn9Yvgwr02Kd6AZHGx4bQCDiP6-2rfP2oxyVoEQiPrcAQ7Bf" target="blank"><i class="social-icons-sprite social-icons linkedin-icon"></i></a></li>
						<li><a href="https://twitter.com/jobsforher" target="blank"><i class="social-icons-sprite social-icons twitter-icon"></i></a></li>
						<li>
							<a href="https://youtube.com/jobsforher" target="_blank" class="youtube-icon">
								<i class="social-icons-sprite social-icons youtube-icon"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
