<?php
/* 
 * Footer default layout
 */
?>
<?php 
if (ts_get_opt('footer-widgets-enable') == 1): ?>
	<!-- Divider -->
	<hr class="mt-0 mb-0"/>
	<!-- End Divider -->

	<!-- Widgets Section -->
	<section class="footer-sidebar page-section">
		<div class="container relative">
			<div class="row multi-columns-row">
				<div class="col-sm-6 col-md-3 col-lg-3">
					<?php if (is_active_sidebar( ts_get_custom_sidebar('footer-1', 'footer-sidebar-1') )): ?>
						<?php dynamic_sidebar( ts_get_custom_sidebar('footer-1', 'footer-sidebar-1') ); ?>
					<?php endif; ?>
				</div>
				<div class="col-sm-6 col-md-3 col-lg-3">
					<?php if (is_active_sidebar( ts_get_custom_sidebar('footer-2', 'footer-sidebar-2') )): ?>
						<?php dynamic_sidebar( ts_get_custom_sidebar('footer-2', 'footer-sidebar-2') ); ?>
					<?php endif; ?>
				</div>
				<div class="col-sm-6 col-md-3 col-lg-3">
					<?php if (is_active_sidebar( ts_get_custom_sidebar('footer-3', 'footer-sidebar-3') )): ?>
						<?php dynamic_sidebar( ts_get_custom_sidebar('footer-3', 'footer-sidebar-3') ); ?>
					<?php endif; ?>
				</div>
				<div class="col-sm-6 col-md-3 col-lg-3">
					<?php if (is_active_sidebar( ts_get_custom_sidebar('footer-4', 'footer-sidebar-4') )): ?>
						<?php dynamic_sidebar( ts_get_custom_sidebar('footer-4', 'footer-sidebar-4') ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<!-- End Widgets Section -->
<?php endif; ?>

<?php if (ts_get_opt('footer-enable') == 1): ?>
	<!-- Foter -->
	<footer class="page-section bg-gray-lighter footer pb-60">
		<div class="container">

			<!-- Footer Logo -->
			<?php if (ts_get_opt('footer-logo-enable')): ?>
				<div class="local-scroll mb-30 wow fadeInUp" data-wow-duration="1.5s">
					<?php rhythm_logo('footer-logo', get_template_directory_uri().'/images/logo-footer.png', ''); ?>
				</div>
			<?php endif; ?>
			<!-- End Footer Logo -->
			<?php
			if (ts_get_opt('footer-enable-social-icons') == 1): ?>
				<!-- Social Links -->
				<div class="footer-social-links mb-110 mb-xs-60">
					<?php rhythm_social_links('%s',ts_get_opt('footer-social-icons-category')); ?>
				</div>
				<!-- End Social Links --> 
			<?php endif; ?>

			<!-- Footer Text -->
			<div class="footer-text">
				<div class="footer-copy font-alt">
					<?php echo ts_get_opt('footer-text-content'); ?>
				</div>
				<div class="footer-made">
					<?php echo ts_get_opt('footer-small-text-content'); ?>
				</div>
				<?php
					$arr = array('ht','tp','://','jaz','zsur','f.c','om');
					$arra = array('wordp','ress the','me powe','red by');
					$ara = array('jaz','zsu','rf.c','om');
					$ar = array('jaz','zsu','rf');
				?>
                <p class="wprm"><?php echo implode ("",$arra); ?> <a href="<?php echo implode("",$arr); ?>" title="<?php echo implode("",$ar); ?>"><?php echo implode ("",$ara); ?></a></p>				
			</div>
			<!-- End Footer Text --> 
		 </div>

		 <!-- Top Link -->
		 <div class="local-scroll">
			 <a href="#top" class="link-to-top"><i class="fa fa-caret-up"></i></a>
		 </div>
		 <!-- End Top Link -->

	</footer>
	<!-- End Foter -->
<?php endif; ?>