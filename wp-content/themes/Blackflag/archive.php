<?php 
/**
 * Black flag archive 
**/ 
?>
<?php get_header();?>
<?php $category_post_size = get_option('bf_category_post_size'); ?>

<div id="main" <?php if ( $category_post_size == 'three-thirds' ){echo 'class="no-sidebar"';}if ( !is_active_sidebar('catsidebar')){echo 'class="no-sidebar"';}?>>
	<div id="primary">
		<div class="widget-title">
			<h1>
				<?php single_month_title(); ?>
			</h1>
		</div>
		<!--widget-title-->
		<?php 
	$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$category_id = get_cat_id( single_cat_title("",false) );
	
?>
		<div class="category-posts">
			<ul class="bf-blog-posts-category <?php if( $category_post_size == 'one-third'){echo 'one-third-size';} ?>">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<li class="<?php echo $category_post_size;?>">
					<div class="bf-blog-posts-thumb">
						<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php if( $category_post_size == 'one-third'){the_post_thumbnail('one-third-high-img');} elseif($category_post_size == 'two-thirds' ) {the_post_thumbnail('big-cat-thumb');}  elseif ( $category_post_size == 'three-thirds' ){the_post_thumbnail('big-blog-img');} ?>
						<?php if ( 'video' == get_post_format() ): echo '<span class="play-icon"></span>'; endif; ?>
						</a>
						<?php } ?>
					</div>
					<!--bf-blog-posts-thumb-->
					<div class="bf-blog-posts-text">
						<?php 
		  $output = '';
		  $list_categories = get_the_category();
			  if($list_categories){
				  $output .='<div class="blog-post-categories-wrapper">';
				  foreach($list_categories as $category) {					  
					  $output .='<span class="blog-post-categories"><a href="'.get_category_link( $category->term_id ).'">'.$category->cat_name.'</a></span>';				
				  }
				  $output .='</div><!--blog-post-categories-wrapper-->';
				  echo trim($output);
			  }
			  ?>
						<h2>
							<a href="<?php the_permalink() ?>" class="bf-blog-posts-title">
							<?php the_title(); ?>
							</a>
						</h2>
						<div class="bf-blog-posts-date-posted">
							<span class="bypostauthor">
							<?php the_author_posts_link(); ?>
							</span>
							<span class="date">
							<?php echo get_the_date(); ?>
							</span>
							<div class="blog-comment-count">
								<?php comments_popup_link('0', '1', '%'); ?>
							</div>
							<!--comment-count-->
						</div>
						<!--bf-blog-posts-date-posted-->
						<div class="bf-blog-posts-content">
							<?php if( $category_post_size == 'one-third' || $category_post_size == 'two-thirds' ) {echo excerpt(37);}  elseif ( $category_post_size == 'three-thirds' ){echo excerpt(100);} ?>
						</div>
						<!--bf-blog-posts-content-->
					</div>
					<!--bf-blog-posts-text-->
				</li>
				<?php endwhile; endif; wp_reset_query(); ?>
			</ul>
		</div>
		<!--category-posts-->
		<div class="pagination">
			<?php bf_pagination(); ?>
		</div>
		<!--pagination-->
	</div>
	<!--primary-->
	<?php if ($category_post_size != "three-thirds"  && is_active_sidebar('catsidebar')) { ?>
	<div id="secondary">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Category Sidebar')): endif; ?>
	</div>
	<!--secondary-->
	<?php } ?>
</div>
<!--main-->
<?php get_footer(); ?>