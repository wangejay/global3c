<?php   
/* 
Plugin Name: Tv-widget
Description: Tv-widget-display latest news from video.
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'tv_widget_latest' );

function tv_widget_latest() {register_widget( 'tv_widget' );}

class tv_widget extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'tv_widget_bf', // Widget ID
			'TV-Widget', // Name
			array( 'description' =>'This widget automatically displayes the latest videos you have uploaded. When a visitor clicks on the video, he is taken to the video page directly. You can set how many of your latest videos should be visible on the widget. Visually very similar to the Multiple Categories widget.Also has 3 forms.', ) // Args
			);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			/* Default widget settings. */
			$defaults = array( 'title' => 'New on Theme TV', 'widget_size' => 'one-third');
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$widget_size = $instance['widget_size'];
			
			
			$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);	
			echo $args['before_widget'];
			?>

<div class="tv-featured">
	<?php if ( ! empty( $title ) )
				echo '<div class="tv-featured-title"><a href="' . get_post_format_link( 'video' ) . '">' . $title . '</a></div>'; ?>
	<ul class="tv-featured-posts tv-big">
		<?php $bf_posts = new WP_Query(array( 'tax_query' => array(array('taxonomy' => 'post_format', 'field' => 'slug', 'terms' => array( 'post-format-video' ))), 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<div class="featured-posts-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('big-cat-thumb'); ?>
				</a>
				<?php } ?>
			</div>
			<!---featured-posts-image-->
			<div class="featured-posts-text">
				<span class="category-icon">
				<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
				</span>
				<div class="featured-posts-title">
					<a href="<?php the_permalink() ?>">
					<?php echo wp_trim_words( get_the_title(), 10 ); ?>
					</a>
				</div>
				<!--featured-posts-title-->
				<div class="featured-posts-content">
					<?php echo excerpt(20); ?>
				</div>
				<!--featured-posts-content-->
			</div>
			<!--featured-posts-text-->
		</li>
		<?php endwhile; ?>
	</ul>
	<ul class="tv-featured-posts small-feat-posts">
		<?php $bf_posts = new WP_Query(array( 'tax_query' => array(array('taxonomy' => 'post_format', 'field' => 'slug', 'terms' => array( 'post-format-video' ))), 'posts_per_page' => 3, 'ignore_sticky_posts' => 1, 'offset' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<div class="featured-posts-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
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
					<a href="<?php the_permalink() ?>">
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
		<?php endwhile; ?>
	</ul>
	<?php if( $widget_size == 'three-thirds' ) { ?>
	<ul class="tv-featured-posts small-feat-posts">
		<?php $bf_posts = new WP_Query(array( 'tax_query' => array(array('taxonomy' => 'post_format', 'field' => 'slug', 'terms' => array( 'post-format-video' ))), 'posts_per_page' => 3, 'ignore_sticky_posts' => 1, 'offset' => 4 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<div class="featured-posts-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
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
					<a href="<?php the_permalink() ?>">
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
		<?php endwhile; ?>
	</ul>
	<?php } ?>
</div>
<!--featured-category-->

<?php

	/* After widget. */
	
	echo $args['after_widget'];
	}


	/* Widget settings. */


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
	/* Strip tags. */
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['widget_size'] = $new_instance['widget_size'];	
		
		return $instance;
	}
	
	
	function form( $instance ) {
		
	/* Default widget settings. */
		
		$defaults = array( 'title' => 'New on Theme TV', 'widget_size' => 'one-third');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

<!-- Widget Title-->
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
</p>

<!-- widget_size -->
<p>
	<label for="<?php echo $this->get_field_id( 'widget_size' ); ?>">
		Widget size:
	</label>
	</br>
	<input type="radio" name="<?php echo $this->get_field_name( 'widget_size' ); ?>" value="one-third" <?php checked('one-third', $instance['widget_size']); ?> class="one-third"/>
	<input type="radio" name="<?php echo $this->get_field_name( 'widget_size' ); ?>" value="two-thirds" <?php checked('two-thirds', $instance['widget_size']); ?> class="two-thirds" />
	<input type="radio" name="<?php echo $this->get_field_name( 'widget_size' ); ?>" value="three-thirds" <?php checked('three-thirds', $instance['widget_size']); ?> class="three-thirds"/>
</p>
<?php }} ?>