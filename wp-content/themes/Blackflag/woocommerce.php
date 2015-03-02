<?php 
/**
 * Black flag page
**/ 
?>
<?php get_header(); ?>

<div id="main">
<div id="primary">
	<?php woocommerce_content(); ?>
</div>
<div id="secondary">
	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Woocommerce Sidebar')): endif; ?>
</div>
<!--secondary-->

<div id="fullwidth">
	<div class="home-widget three-thirds">
		<h3>
			<span class="widget-title">
			Top Rated Products
			</span>
		</h3>
		<div class="jumping-posts">
			<ul>
				<?php
			add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
            $args = array( 'post_type' => 'product', 'stock' => 1, 'posts_per_page' => 4, 'order' => 'ASC' );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				<li>
					<div class="jumping-posts-image">
						<a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_single');?>
					</div>
					</a>
					<div class="jumping-posts-text">
						<div class="jumping-posts-category">
							<?php echo $product->get_rating_html(); ?>
						</div>				
						<div class="jumping-posts-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php echo wp_trim_words( get_the_title(), 7 ); ?>
							</a>
						</div>
						<!--jumping-posts-title-->
						<div class="jumping-posts-excerpt">
							<?php echo excerpt(20); ?>
						</div>
						<!--jumping-posts-excerpt-->
					</div>
					<!--jumping-posts-text-->			
				</li>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</ul>
		</div>
	</div>
</div>
<?php get_footer(); ?>