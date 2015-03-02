<?php
/* 
Plugin Name: Featured category
Description:  Featured cateogry with small images display
Version: 1.0 
Author: Stefan Naumovski 
*/    
add_action( 'widgets_init', 'small_img_widget' );

function small_img_widget() {register_widget( 'small_img_cat' );}

class small_img_cat extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'small_img_category_bf', // Widget ID
			'Small featured images',  //Name
			array( 'description' => 'This widget displays posts with small images. Whats different about it is  that you can display your review posts here, but also you can select a category, not just reviews. If you want to display reviews, tick the show reviews only box. There is also an option that lets you choose how many posts should be visible. This widget also has three different forms.', ) // Args
		);}
		
		/* Front-end display of widget. */
		
	public function widget( $args, $instance ) {
		/* Default widget settings. */

		$defaults = array( 'title' => 'Small featured images', 'number' => 4, 'review' => 0, 'widget_size' => 'one-third', 'categories' => 0);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$categories = $instance['categories'];
		$number = $instance['number'];
		$review = $instance['review'];
		$widget_size = $instance['widget_size'];
		
		$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);	
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];	
			?>

<div id="small-wrapper">
	<ul class="small-category">
		<?php if($review) {$bf_posts = new WP_Query(array(  'tax_query' => array(array('taxonomy' => 'post_format', 'field' => 'slug', 'terms' => array('post-format-aside'))),'posts_per_page' => $number, 'ignore_sticky_posts' => 1 ));}
		else
		{$bf_posts = new WP_Query(array( 'cat' => $categories, 'posts_per_page' => $number, 'ignore_sticky_posts' => 1 ));}			
		while
			 ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<div class="small-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('carousel-thumb'); if ( 'video' == get_post_format() ): echo '<span class="play-icon"></span>'; endif; ?>
				</a>
				<?php } ?>
				<?php if($review) { ?>
				<div class="img-featured-review-score">
					<?php echo get_post_meta( get_the_ID(), 'bf_review_total', true ); ?>
				</div>
				<!--review-score-->
				<?php } ?>
			</div>
			<!---small-image-->
			<div class="small-text">
				<div class="small-title">
					<a href="<?php the_permalink() ?>">
					<?php echo wp_trim_words( get_the_title(), 7 ); ?>
					</a>
				</div>
				<!--small-title-->
			</div>
			<!--small-text-->
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<?php

		/* After widget. */

		echo $args['after_widget'];
	}
	
		/* Widget settings. */
		
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags. */
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['categories'] = $new_instance['categories'];
		$instance['review'] = $new_instance['review'];
		$instance['widget_size'] = $new_instance['widget_size'];
		
		return $instance;
	}

	function form( $instance ) {
		
		/* Default widget settings. */

		$defaults = array( 'title' => 'Small featured images', 'number' => 4, 'review' => 0, 'widget_size' => 'one-third', 'categories' => 0);
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

<!-- Number of posts -->
<p>
	<label for="<?php echo $this->get_field_id( 'number' ); ?>">
		Number of posts to show:
	</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
</p>

<!-- Category -->
<p>
	<label for="<?php echo $this->get_field_id('categories'); ?>">
		(Optional)Select Category:
	</label>
	<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" style="width:100%;">
		<option value='all' <?php if ('all' == (isset($instance['categories']))) echo 'selected="selected"'; ?>>
		All Categories
		</option>
		<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
		<?php foreach($categories as $category) { ?>
		<option value='<?php echo $category->term_id; ?>' <?php if(isset($instance['categories'])){ if ($category->term_id == $instance['categories']) echo 'selected="selected"';}?>>
		<?php echo $category->cat_name; ?>
		</option>
		<?php } ?>
	</select>
</p>

<!-- review -->
<p>
	<label for="<?php echo $this->get_field_id( 'review' ); ?>">
		Filter reviews:
	</label>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'review' ); ?>" name="<?php echo $this->get_field_name( 'review' ); ?>" <?php checked( (bool) $instance['review'], true ); ?> />
</p>
<?php }} ?>