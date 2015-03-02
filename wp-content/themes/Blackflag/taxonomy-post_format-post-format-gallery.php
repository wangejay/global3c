<?php get_header(); ?>

<div id="main">
	<div id="tv-mode">
		<?php
	//video wrapper and share buttons
	$id_post = (isset($_POST['id']));
	if ($id_post == ''){
		global $wp_query;
		$postID = $wp_query->post->ID;
		}
		else {
			$postID = $_POST['id'];
		}
		$permalink = get_permalink( $postID );
		$pinimage = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'slider-img' );
		$category = get_the_category($postID);
		$the_title = get_the_title($postID);
		$bf_subtitle = get_post_meta($postID, 'bf_sub_title', true);
		$bf_excerpt = 	wp_trim_words( get_post_field('post_excerpt', $postID), 30);
		$bf_content = 	wp_trim_words( get_post_field('post_content', $postID), 30);

		?>
		<div id="post-page-title" class="tv-format-title">
			<h1>
				<?php echo $the_title; ?>
			</h1>
		</div>
		<!--tv-format-title-->
		<div id="post-page-subtitle" class="tv-format-subtitle">
			<?php if(empty($bf_subtitle) && empty($bf_excerpt)) { echo $bf_content; }  elseif (empty($bf_subtitle) && !empty($bf_excerpt)) { echo $bf_excerpt;} elseif (!empty($bf_subtitle)) {echo $bf_subtitle;}?>
		</div>
		<!--tv-format-subtitle-->
		<div class="tv-video-wrapper">
			<div class="tv-page-video-wrapper">
				<?php bf_gallery_tax($postID); ?>
			</div>
			<!--tv-page-video-wrapper-->
			<div class="share-tv">
				<div class="share-tv-title">
					<?php echo get_option('bf_share_this_video'); ?>
				</div>
				<ul>
					<li>
						<a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" target="blank" class="fb-share-icon" title="Share this post on Facebook">
						</a>
					</li>
					<li>
						<a href="https://twitter.com/intent/tweet?original_referer=<?php echo $permalink; ?>&amp;&tw_p=tweetbutton&url=<?php echo $permalink; ?>" target="_blank"  class="twitter-share-icon" title="Share this post on Twitter">
						</a>
					</li>
					<li>
						<a href="https://plusone.google.com/_/+1/confirm?hl=en-US&amp;url=<?php echo $permalink; ?>" target="_blank" class="google-share-icon" title="Share this post on Google Plus">
						</a>
					</li>
					<li>
						<a href="http://pinterest.com/pin/create/bookmarklet/?media=<?php $pinimg = wp_get_attachment_image_src( get_post_thumbnail_id( $postID), 'post-thumb' ); echo $pinimg[0]; ?>&url=<?php echo $permalink; ?>&is_video=false&description=<?php echo $the_title; ?>" target="_blank" class="pinterest-share-icon" title="Share this post on Pinterest">
						</a>
					</li>
					<li>
						<a href="http://www.stumbleupon.com/submit?url=<?php echo $permalink; ?>&title=<?php echo $the_title; ?>" target="_blank" class="stumble-share-icon" title="Share this post on Stumbleupon">
						</a>
					</li>
					<li>
						<a href="http://www.reddit.com/submit?url=<?php echo $permalink; ?>&title=<?php echo $the_title; ?>" target="_blank" class="reddit-share-icon" title="Share this post on Reddit">
						</a>
					</li>
				</ul>
				<span class="category-tv-icon">
				<a href="<?php echo get_category_link($category[0]->term_id )?>">
				<?php echo $category[0]->cat_name;?>
				</a>
				</span>
			</div>
		</div>
		<div class="tv-page-widget home-widget three-thirds">
			<h3>
				<span class="widget-title">
				<?php echo get_option('bf_gallery_carousel_title'); ?>
				</span>
			</h3>
			<?php $bf_tv_widget_style = get_option('bf_tv_widget_style'); if ($bf_tv_widget_style == 'one') {  ?>
			<div class="tv-carousel">
				<ul class="slides">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li>
						<div class="carousel-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a class="ajax" href="<?php the_ID(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('carousel-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!--carousel-image-->
						<div class="carousel-text">
							<div class="carousel-category">
								<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</div>
							<!--carousel-category-->
							<div class="carousel-title">
								<a class="ajax" href="<?php the_ID() ?>">
								<?php echo wp_trim_words( get_the_title(), 7 ); ?>
								</a>
							</div>
							<!--carousel-title-->
						</div>
						<!--carousel-text-->
						
					</li>
					<?php endwhile; endif; ?>
				</ul>
			</div>
			<!--tv-carousel-->
			<?php } elseif($bf_tv_widget_style == 'two'){?>
			<ul class="featured-thumbnails">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li>
					<div class="featured-posts-image">
						<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
						<a class="ajax" href="<?php the_ID(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('small-thumb'); ?>
						</a>
						<?php } ?>
					</div>
					<!---featured-posts-image-->
					<div class="featured-posts-text">
						<span class="category-icon">
						<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
						</span>
						<div class="featured-posts-title">
							<a class="ajax" href="<?php the_ID() ?>">
							<?php echo wp_trim_words( get_the_title(), 10 ); ?>
							</a>
						</div>
						<!--featured-posts-title-->
						<span class="post-date">
						<?php echo get_the_date(); ?>
						</span>
					</div>
					<!--featured-posts-text-->
				</li>
				<?php endwhile; endif; ?>
			</ul>
			<div class="pagination pagination-load-more">
				<?php next_posts_link( 'Load More', '' ); ?>
			</div>
			<!--pagination-->
			
			<?php }elseif($bf_tv_widget_style == 'three'){ ?>
			<ul class="small-category">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li>
					<div class="small-image">
						<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
						<a class="ajax" href="<?php the_ID(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('carousel-thumb'); ?>
						</a>
						<?php } ?>
					</div>
					<!---small-image-->
					<div class="small-text">
						<div class="small-title">
							<a class="ajax" href="<?php the_ID() ?>">
							<?php echo wp_trim_words( get_the_title(), 7 ); ?>
							</a>
						</div>
						<!--small-title-->
					</div>
					<!--small-text-->
				</li>
				<?php endwhile; endif; ?>
			</ul>
			<div class="pagination pagination-load-more">
				<?php next_posts_link( 'Load More', '' ); ?>
			</div>
			<!--pagination-->
			<?php } ?>
		</div>
		<!--tv-page-widget-->
	</div>
	<!--tv-mode-->
</div>
<!--main-->
<?php get_footer(); ?>