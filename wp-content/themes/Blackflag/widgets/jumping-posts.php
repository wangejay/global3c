<?php   
/* 
Plugin Name: Jumping posts
Description: Jumping posts widget. 
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'jumping_posts_widget' );

function jumping_posts_widget() {register_widget( 'jumping_posts' );}

class jumping_posts extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'jumping_posts_bf', //Widget ID
			'Jumping posts', //Name
			array( 'description' => 'This is that neat looking widget whose posts jump up and change color when you hover over them. You can assign a category to this widget, or set it as All Categories, which basically means that the widget will display your latest posts. This widget also has three different forms, 1/3 wide, 2/3 wide and full width.', 'text_domain', ) //Args
		);}

		/* Front-end display of widget. */

	public function widget( $args, $instance ) {
		
		/* Default widget settings. */
		
		$defaults = array( 'title' => 'Jumping posts', 'number' => 4, 'widget_size' => 'one-third', 'categories' => 0);
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

<div class="jumping-posts">
	<ul>
		<?php $bf_posts = new WP_Query(array( 'cat' => $categories, 'posts_per_page' => $number )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
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
		<?php endwhile; ?>
	</ul>
</div>
<!--jumping-posts-->

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
		
		$defaults = array( 'title' => 'Jumping posts', 'number' => 4, 'widget_size' => 'one-third', 'categories' => 0);
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