<?php 
/**
 * Black flag post page
**/ 
?>
<?php get_header(); ?>

<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div id="post-page-title">
		<h1>
			<?php the_title(); ?>
		</h1>
	</div>
	<!--post-page-title-->
	<div id="post-page-subtitle">
		<?php  $bf_subtitle = get_post_meta(get_the_ID(), 'bf_sub_title', true); if(empty($bf_subtitle)) { echo excerpt(30); }  else { echo $bf_subtitle;}  ?>
	</div>
	<!--post-subtitle-->
	
	<?php $bf_post_media_size = get_option('bf_post_media_size'); if ($bf_post_media_size == "true") { 		
       		$video_embed = wp_oembed_get(get_post_meta($post->ID, "blackflag_video_link", true), array('width'=>1008) );
        	$mageee = 'three-thirds-slider-img';?>
	<?php }elseif($bf_post_media_size == "false"){
			$video_embed = wp_oembed_get(get_post_meta($post->ID, "blackflag_video_link", true), array('width'=>642) );
        	$mageee = 'post-page-slider-img';?>
	<div id="primary">
		<?php } ?>
		<?php if ( $bf_post_media_size != "off") { ?>
		<div id="media-wrapper">
			<?php
        		   	
				if ( ! get_post_format() || 'aside' == get_post_format() ): // Standard or Review
					echo '<div class="image-wrapper">';
					if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {the_post_thumbnail($mageee);
					if(!empty(get_post(get_post_thumbnail_id())->post_excerpt)) {echo '<div class="image-caption">' . get_post(get_post_thumbnail_id())->post_excerpt . '</div>';};}
					echo '</div><!--image-wrapper-->';
				elseif ( 'video' == get_post_format() ): // Video
					echo '<div class="video-wrapper">' .$video_embed. '</div><!--video-wrapper-->';
				elseif ( 'gallery' == get_post_format() ): // Gallery
					echo bf_gallery();
				endif;?>
		</div>
		<!--media-wrapper-->
		<?php } ?>
		<?php if ($bf_post_media_size == "true" || $bf_post_media_size == "off") { ?>
		<div id="primary">
			<?php } ?>
			<div class="post-page-content-wrapper">
				<div class="post-info">
					<span class="post-author">
					<?php echo get_option('bf_word_before_author'); ?>
					<?php the_author_posts_link(); ?>
					</span>
					<span class="post-page-date">
					<?php echo get_the_date(); ?>
					</span>
				</div>
				<!--post-info-->
				<div id="post-content" class="content">
					<?php the_content();
				  wp_link_pages(array(  
    				'before' => '<div class="pagination">' . 'Pages:',  
   					 'after' => '</div>'  
  					  ));   ?>
				</div>
				<!--post-content-->
				<?php if ( 'aside' == get_post_format() ): // Review
					echo bf_review();
				endif;?>
				<?php $bf_tags_title = get_option('bf_post_tags_title'); $bf_post_tags = get_option('bf_post_tags'); if ($bf_post_tags == 'true') {?>
				<?php the_tags('<div class="post-tags"><div class="tags-title">'.$bf_tags_title.'</div><!--tags-title-->', '', '</div><!--post-tags-->');} 
				
		  		$bf_post_categories = get_option('bf_post_categories');
		  if ($bf_post_categories == 'true') {							
		  		$output = '';
		 		 $list_categories = get_the_category();
		  		 $bf_category_title = get_option('bf_post_category_title');
		  
			  if($list_categories){
				  $output .='<div class="post-categories-wrapper"><div class="post-categories-title">'.$bf_category_title.'</div>';
				  foreach($list_categories as $category) {					  
					  $output .='<span class="blog-post-categories"><a href="'.get_category_link( $category->term_id ).'">'.$category->cat_name.'</a></span>';				
				  }
				  $output .='</div><!--post-categories-wrapper-->';
				  echo trim($output);
			 	 }
		 	 }
			  ?>
				<?php $bf_share_post = get_option('bf_share_post'); if ($bf_share_post == "true") { ?>
				<div class="share-post">
					<div class="share-title">
						<?php echo get_option('bf_share_this_article'); ?>
					</div>
					<ul>
						<li>
							<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="blank" class="fb-share-icon" title="Share this post on Facebook">
							</a>
						</li>
						<li>
							<a href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;&tw_p=tweetbutton&url=<?php the_permalink(); ?>" target="_blank"  class="twitter-share-icon" title="Share this post on Twitter">
							</a>
						</li>
						<li>
							<a href="https://plusone.google.com/_/+1/confirm?hl=en-US&amp;url=<?php the_permalink(); ?>" target="_blank" class="google-share-icon" title="Share this post on Google Plus">
							</a>
						</li>
						<li>
							<a href="http://pinterest.com/pin/create/bookmarklet/?media=<?php $pinimg = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumb' ); echo $pinimg[0]; ?>&url=<?php the_permalink(); ?>&is_video=false&description=<?php the_title(); ?>" target="_blank" class="pinterest-share-icon" title="Share this post on Pinterest">
							</a>
						</li>
						<li>
							<a href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank" class="stumble-share-icon" title="Share this post on Stumbleupon">
							</a>
						</li>
						<li>
							<a href="http://www.reddit.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank" class="reddit-share-icon" title="Share this post on Reddit">
							</a>
						</li>
					</ul>
				</div>
				<!--share-post-->
				<?php } ?>
				<?php count_views($post->ID); ?>
				<?php $bf_nav_links = get_option('bf_next_prev_links'); if ($bf_nav_links == "true") { ?>
				<div class="nav-next-prev">
					<?php
                    $prev_post = get_previous_post();
					$next_post = get_next_post();
					
                    if ( !empty( $prev_post ) ){ 
                    ?>
					<div class="nav-previous">
						<div class="previous-article">
							<?php $older_article = get_option('bf_older_article');?>
							<?php previous_post_link ( '%link', $older_article); ?>
						</div>
						<!--previous-article-->
						<div class="previous-title">
							<h2>
								<?php previous_post_link ( '%link', '%title'); ?>
							</h2>
							<div class="post-date">
								<span class="bypostauthor">
								<?php echo get_option('bf_word_before_author'); ?>
								<a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $prev_post->post_author)); ?>">
								<?php the_author_meta('display_name', $prev_post->post_author); ?>
								</a>
								-
								</span>
								<span class="date-prev">
								<?php echo mysql2date('M j, Y', $prev_post->post_date); ?>
								</span>
							</div>
							<!--post-date-->
						</div>
						<!--previous-title-->
					</div>
					<!--nav-previous-->
					<?php } ?>
					<div class="splitter">
					</div>
					<!--splitter-->
					<?php
                    if ( !empty( $next_post ) ){ 
                    ?>
					<div class="nav-next">
						<div class="next-article">
							<?php $next_article = get_option('bf_next_article');?>
							<?php next_post_link ( '%link', $next_article); ?>
						</div>
						<!--next-article-->
						<div class="next-title">
							<h2>
								<?php next_post_link( '%link', '%title' ); ?>
							</h2>
							<div class="post-date">
								<span class="bypostauthor">
								<?php echo get_option('bf_word_before_author'); ?>
								<a href="<?php echo get_author_posts_url(get_the_author_meta('ID', $next_post->post_author)); ?>">
								<?php the_author_meta('display_name', $next_post->post_author); ?>
								</a>
								-
								</span>
								<span class="date-next">
								<?php echo mysql2date('M j, Y', $next_post->post_date); ?>
								</span>
							</div>
							<!--post-date-->
						</div>
						<!--next-title-->
					</div>
					<!--nav-next-->
					<?php } ?>
				</div>
				<!--nav-next-prev-->
				<?php } ?>
				<?php $bfauthorbox = get_option('bf_author_box'); if ($bfauthorbox == "true") { ?>
				<div id="author-info">
					<div id="author-image">
						<?php echo get_avatar( get_the_author_meta('email'), '96' ); ?>
					</div>
					<!--author-image-->
					<div id="author-desc">
						<h2>
							<?php the_author_posts_link(); ?>
						</h2>
						<div class="description-author">
							<?php the_author_meta('description'); ?>
						</div>
						<!--description-author-->
						<ul class="author-social">
							<?php if(get_the_author_meta('facebook')) { ?>
							<li>
								<a href="http://facebook.com/<?php the_author_meta('facebook'); ?>" class="fb-social-icon" target="_blank">
								</a>
							</li>
							<?php } ?>
							<?php if(get_the_author_meta('twitter')) { ?>
							<li>
								<a href="https://twitter.com/<?php the_author_meta('twitter'); ?>" class="twitter-social-icon" target="_blank">
								</a>
							</li>
							<?php } ?>
							<?php if(get_the_author_meta('google')) { ?>
							<li>
								<a href="http://plus.google.com/<?php the_author_meta('google'); ?>?rel=author" class="google-social-icon" target="_blank">
								</a>
							</li>
							<?php } ?>
							<?php if(get_the_author_meta('pinterest')) { ?>
							<li>
								<a href="http://www.pinterest.com/<?php the_author_meta('pinterest'); ?>?rel=author" class="pinterest-social-icon" target="_blank">
								</a>
							</li>
							<?php } ?>
							<?php if(get_the_author_meta('instagram')) { ?>
							<li>
								<a href="http://www.instagram.com/<?php the_author_meta('instagram'); ?>" class="instagram-social-icon" target="_blank">
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>
					<!--author-desc-->
				</div>
				<!--author-info-->
				<?php } ?>
				<?php $bf_show_comments = get_option('bf_show_comments'); if ($bf_show_comments == "true") { ?>
				<div class="comments">
					<?php comments_template(); ?>
				</div>
				<!--comments-->
				<?php } ?>
			</div>
			<!--post-page-contentn-wrapper-->
		</div>
		<!--primary-->
		
		<div id="secondary" class="widget-area">
			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Post Sidebar')): endif; ?>
		</div>
		<!--secondary-->
	</div>
	<!--post-->
	
	<?php endwhile; endif; ?>
	<?php $bf_related = get_option('bf_related'); if ($bf_related == "true") { ?>
	<div id="fullwidth">
		<div class="home-widget three-thirds">
			<?php if(get_option('bf_related_by')) { ?>
			<h3>
				<span class="widget-title">
				<?php echo get_option('bf_related_by'); ?>
				</span>
			</h3>
			<?php } 
				
if(get_option('bf_related_choice')== 'tags'){related_posts_tags();} elseif(get_option('bf_related_choice')== 'category'){related_posts_category();} elseif(get_option('bf_related_choice')== 'author'){related_posts_author();}  ?>
		</div>
		<!--home-widget-->
	</div>
	<!--fullwidth-->
	<?php } ?>
</div>
<!--main-->

<?php get_footer(); ?>