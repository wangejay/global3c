<?php 
/**
 * Black flag ticker
**/ 
?>
<?php
function homepage_latest_loop() {?>
<ul class="bf-blog-posts-category">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<li>
		<div class="bf-blog-posts-thumb">
			<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php the_post_thumbnail('big-blog-img'); ?>
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
				<?php echo excerpt(100); ?>
			</div>
			<!--bf-blog-posts-content-->
		</div>
		<!--bf-blog-posts-text-->
	</li>
<?php endwhile; endif; ?>
</ul>

<div class="pagination">
	<?php bf_pagination(); ?>
</div><!--pagination-->

<?php }; ?>