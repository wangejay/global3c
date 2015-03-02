<?php
/* 
Plugin Name: Big Featured Images
Description:  One column image featured category
Version: 1.0 
Author: Stefan Naumovski 
*/    
add_action( 'widgets_init', 'img_feat_widget' );

function img_feat_widget() {register_widget( 'img_feat_cat' );}

class img_feat_cat extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'img_featured_category_bf', // Widget ID
			'Big Featured Images',  //Name
			array( 'description' => 'This widget displays posts with bigger images. It also can display your review posts or select a category. If you want to display reviews, tick the show reviews only box. There is also an option that lets you choose how many posts 
should be visible. This widget also has three different forms.',) // Args
		);}
		
		/* Front-end display of widget. */
		
	public function widget( $args, $instance ) {
	
		/* Default widget settings. */

		$defaults = array( 'title' => 'Big Featured Images', 'number' => 2, 'review' => 0, 'widget_size' => 'one-third', 'categories' => 0);
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

<div class="img-featured-category">
	<ul class="img-featured">
		<?php if($review) {$bf_posts = new WP_Query(array(  'tax_query' => array(array('taxonomy' => 'post_format', 'field' => 'slug', 'terms' => array('post-format-aside'))),'posts_per_page' => $number, 'ignore_sticky_posts' => 1 ));}
		else
		{$bf_posts = new WP_Query(array( 'cat' => $categories, 'posts_per_page' => $number, 'ignore_sticky_posts' => 1 ));}			
		while
			 ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<div class="img-featured-posts-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('image-featured'); ?>
				</a>
				<?php } ?>
			</div>
			<!--img-featured-posts-image-->
			<?php if($review) { ?>
			<div class="img-featured-review-score">
				<?php echo get_post_meta( get_the_ID(), 'bf_review_total', true ); ?>
			</div>
			<!--review-score-->
			<?php } ?>
			<div class="img-featured-title">
				<span class="date">
				<?php echo get_the_date(); ?>
				</span>
				<h2>
					<a href="<?php the_permalink() ?>" class="blog-post-title">
					<?php the_title(); ?>
					</a>
				</h2>
			</div>
			<!--img-featured-title-->
		</li>
		<?php endwhile; ?>
	</ul>
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
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['categories'] = $new_instance['categories'];
		$instance['review'] = $new_instance['review'];
		$instance['widget_size'] = $new_instance['widget_size'];	
		
		return $instance;
	}

	function form( $instance ) {
		
		/* Default widget settings. */

		$defaults = array( 'title' => 'Big Featured Images', 'number' => 2, 'review' => 0, 'widget_size' => 'one-third', 'categories' => 0);
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