<?php   

/* 
Plugin Name: Thumbnails
Description: Thumbnails widget 
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'thumbnails_widget' );

function thumbnails_widget() {register_widget( 'thumbnails_widget_bf' );}

class thumbnails_widget_bf extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'thumbnails_bf', // Widget ID
			'Thumbnails', // Name
			array( 'description' => 'A widget that displays the latest posts from a category or the latest posts in general. The difference being that these posts are displayed with small thumbs. You can set how many of them should be visible. This widget has 3 forms, displaying the thumbnails in one column, two columns or three.', ) // Args
			);}
		
		/* Front-end display of widget. */
	public function widget( $args, $instance ) {
		
		/* Default widget settings. */
		
		$defaults = array( 'title' => 'Thumbnail widget', 'number' => 3, 'widget_size' => 'one-third', 'categories' => 0);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = $instance['number'];
		$categories = $instance['categories'];
		$widget_size = $instance['widget_size'];
						
		$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);							
		echo $args['before_widget'];
		if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			?>

<ul class="featured-thumbnails">
	<?php $bf_posts = new WP_Query(array( 'cat' => $categories, 'posts_per_page' => $number )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
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
		$instance['widget_size'] = $new_instance['widget_size'];	
		return $instance;
	}
	

	function form( $instance ) {
		
		/* Default widget settings. */
		
		$defaults = array( 'title' => 'Thumbnail widget', 'number' => 3, 'widget_size' => 'one-third', 'categories' => 0);
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
<?php }} ?>