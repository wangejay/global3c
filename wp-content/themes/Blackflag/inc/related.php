<?php 
/**
 * Black flag related posts functions
**/ 
?>
<?php 
function related_posts_tags($count=4) {
	
	//Related Posts by tags
	
		global $post;
		$tags = wp_get_post_tags($post->ID);
		
			if ($tags) {
				$tag_ids = array();
				
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				
					$args=array(
						'tag__in' => $tag_ids,
						'post__not_in' => array($post->ID),
						'posts_per_page'=>$count, 
						'ignore_sticky_posts' => 1
							);
				
					$my_query = new wp_query( $args );		
					if( $my_query->have_posts() ) {
					echo '<div class="jumping-posts"><ul>';
					while( $my_query->have_posts() ) {
					$my_query->the_post(); ?>

<li>
	<div class="jumping-posts-image">
		<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<?php the_post_thumbnail('jumping-posts-thumb'); if ( 'video' == get_post_format() ): echo '<span class="play-icon"></span>'; endif; ?>
		</a>
		<?php } ?>
	</div>
	<!---jumping-posts-image-->
	<div class="jumping-posts-text">
		<div class="jumping-posts-category">
			<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
		</div>
		<!--carousel-category-->
		<div class="jumping-posts-title">
			<a href="<?php the_permalink() ?>">
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
<?php }	echo '</ul></div>';}}
		wp_reset_query();}	

function related_posts_category( $count=4) {
	
			//related posts by category

				global $post;
				$categories = get_the_category($post->ID);
				
					if ($categories) {
					$category_ids = array();
					foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
					$args=array(
						'category__in' => $category_ids,
						'post__not_in' => array($post->ID),
						'posts_per_page'=> $count, 
						'ignore_sticky_posts' => 1
							);

						$my_query = new wp_query( $args );
						if( $my_query->have_posts() ) {
						echo '<div class="jumping-posts"><ul>';
						while( $my_query->have_posts() ) {
						$my_query->the_post();?>
<li>
	<div class="jumping-posts-image">
		<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<?php the_post_thumbnail('jumping-posts-thumb'); if ( 'video' == get_post_format() ): echo '<span class="play-icon"></span>'; endif; ?>
		</a>
		<?php } ?>
	</div>
	<!---jumping-posts-image-->
	<div class="jumping-posts-text">
		<div class="jumping-posts-category">
			<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
		</div>
		<!--carousel-category-->
		<div class="jumping-posts-title">
			<a href="<?php the_permalink() ?>">
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
<?php }	echo '</ul></div>';}}
		wp_reset_query();}
 
function related_posts_author($count=4) {

//related posts by author

				global $post;
				$author = get_the_author_meta('ID');
					
				$args=array(
					'author' => $author,
					'post__not_in' => array( $post->ID ),
					'posts_per_page' => $count );
			
					$my_query = new wp_query( $args );
					if( $my_query->have_posts() ) {
					echo '<div class="jumping-posts"><ul>';
					while( $my_query->have_posts() ) {
					$my_query->the_post();?>
<li>
	<div class="jumping-posts-image">
		<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<?php the_post_thumbnail('jumping-posts-thumb'); if ( 'video' == get_post_format() ): echo '<span class="play-icon"></span>'; endif; ?>
		</a>
		<?php } ?>
	</div>
	<!---jumping-posts-image-->
	<div class="jumping-posts-text">
		<div class="jumping-posts-category">
			<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
		</div>
		<!--carousel-category-->
		<div class="jumping-posts-title">
			<a href="<?php the_permalink() ?>">
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
<?php }echo '</ul></div>';} wp_reset_query();} 


function bf_popular_posts() {
	
$popular_post = get_option('bf_popular_post');	
$category = get_category( get_query_var( 'cat' ) );
$pop_cat = $category->cat_ID;

if( $popular_post == 'week'){	

					
	$week = date('W');
		$args = array(
			'cat'      => $pop_cat,
			'posts_per_page'=> '4',
			'w' => $week,
			'meta_key' => 'post_views_count',
			'orderby' => 'meta_value_num',
			'order'    => 'DESC'
			);
			
} elseif ($popular_post == 'year'){

	$year = date('Y');
		$args = array(
			'cat'      => $pop_cat,
			'posts_per_page'=> '4',
			'year'     => $year,
			'meta_key' => 'post_views_count',
			'orderby' => 'meta_value_num',
			'order'    => 'DESC'
			);	
} elseif($popular_post == 'month'){
	
	$month = date('m');
		$args = array(
			'cat'      => $pop_cat,
			'posts_per_page'=> '4',
			'monthnum'     => $month,
			'meta_key' => 'post_views_count',
			'orderby' => 'meta_value_num',
			'order'    => 'DESC'
			);
}elseif($popular_post == 'forever'){
	
		$args = array(
			'cat'      => $pop_cat,
			'posts_per_page'=> '4',
			'meta_key' => 'post_views_count',
			'orderby' => 'meta_value_num',
			'order'    => 'DESC'
			);	
}
									
									
					 		$popular_posts = new WP_Query($args); if($popular_posts->have_posts()): 
						?>
<div class="jumping-posts">
	<ul>
		<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>
		<li>
			<div class="jumping-posts-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('jumping-posts-thumb'); if ( 'video' == get_post_format() ): echo '<span class="play-icon"></span>'; endif; ?>
				</a>
				<?php } ?>
			</div>
			<!---jumping-posts-image-->
			<div class="jumping-posts-text">
				<div class="jumping-posts-category">
					<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
				</div>
				<!--jumping-posts-category-->
				<div class="jumping-posts-title">
					<a href="<?php the_permalink() ?>">
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
	</ul>
</div>
<?php endif;}
?>