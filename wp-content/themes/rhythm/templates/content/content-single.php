<?php
/**
 * @package Rhythm
 */
?>

<?php $categories = get_the_category(); ?>

<?php if( (count($categories) != 1) && ($categories[0]->slug != "du-an") ): ?>
<!-- Post -->
<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item mb-80 mb-xs-40'); ?>>

	<!-- Text -->
	<div class="blog-item-body">
		
		<?php get_template_part('templates/content/parts/single-media'); ?>

		<div class="hug_custom_title">
			<h3><?php echo get_the_title(); ?></h3>
		</div>

		<div class="hug_custom_info clearfix">
			<ul class="itemInfo">
				<!-- Date created -->
				<li class="dateCreated">
					<?php the_date(); ?>
					<!-- 06 <span>Tháng 12</span> -->
				</li>
				<!-- Item Hits -->
				<li class="itemHits">
					<i class="fa fa-eye"></i><?php echo ' '.getPostViews(get_the_ID()); ?> Views</li>
				<!-- Item category -->
				<li class="itemCategory">
					<i class="fa fa-file-o"></i> 
					<?php if(count($categories) > 1 ) :?>
						<?php foreach($categories as $key => $category): ?>
							<?php echo str_repeat(", ", $key); ?><a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><?php echo $category->name; ?></a>
						<?php endforeach;?>
					<?php endif;?>
				</li>
			</ul>
		</div>

		<?php the_excerpt(); ?>

		<?php the_content(); ?>
		
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'hieu' ),
				'after'  => '</div>',
			) );
		?>
		
	</div>
	<!-- End Text -->
</div>
<?php else: ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="text">
		<?php if (ts_get_opt('portfolio-enable-featured-image') == 1): ?>
			<?php get_template_part('templates/portfolio/parts/featured-image'); ?>

		<?php endif; ?>

		<?php if (ts_get_opt('portfolio-enable-gallery') == 1): ?>
			<?php switch (ts_get_opt('portfolio-gallery-type')):
				case 'slider':
					get_template_part('templates/portfolio/parts/slider');
					break;
				case 'fullwidth-slider':
					get_template_part('templates/portfolio/parts/fullwidth-slider');
					break;
				case 'classic':
				default:
					get_template_part('templates/portfolio/parts/gallery');

			endswitch; ?>
		<?php endif; ?>

		<?php if (ts_get_opt('portfolio-content-bottom') != 1): ?>
			<?php get_template_part('templates/portfolio/parts/editor-content'); ?>
		<?php endif; ?>

		<!-- hug_detail_duan -->

		<ul class="works-grid work-grid-4 clearfix font-alt hide-titles hover-white" id="work-grid" style="position: relative; height: 217.141px;">
		   <!-- Work Item -->
		   <li class="work-item mix " style="position: absolute; left: 0px; top: 0px;">
		      <a href="http://hieu.local/du-an/hunglm/" target="_self" class="work-ext-link">
		         <div class="work-img">
		            <img width="570" height="367" src="http://hieu.local/wp-content/uploads/2015/06/photographer-91-570x367.jpg" class="attachment-ts-medium size-ts-medium wp-post-image" alt="" srcset="http://hieu.local/wp-content/uploads/2015/06/photographer-91-570x367.jpg 570w, http://hieu.local/wp-content/uploads/2015/06/photographer-91-720x463.jpg 720w" sizes="(max-width: 570px) 100vw, 570px">							
		         </div>
		         <div class="work-intro">
		            <h3 class="work-title">hunglm</h3>
		            <div class="work-descr">
		            </div>
		         </div>
		      </a>
		   </li>
		   <!-- End Work Item -->
		</ul>

		<?php if (ts_get_opt('portfolio-enable-project-details') == 1): ?>
			<?php get_template_part('templates/portfolio/parts/project-details'); ?>
		<?php endif; ?>

		<?php if (ts_get_opt('portfolio-content-bottom') == 1): ?>
			<?php get_template_part('templates/portfolio/parts/editor-content'); ?>
		<?php endif; ?>
	</div>
</article>
<?php endif; ?>
<!-- End Post -->