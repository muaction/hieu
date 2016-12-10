<?php
/**
 * @package Rhythm
 */
?>
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
					<?php if(count(get_the_category()) > 1 ) :?>
						<?php foreach(get_the_category() as $key => $category): ?>
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
<!-- End Post -->