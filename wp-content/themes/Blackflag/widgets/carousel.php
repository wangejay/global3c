<?php
/* 
Plugin Name: Carousel Widget 
Description: Carousel posts widget.
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'carousel_posts_widget' );

function carousel_posts_widget() {register_widget( 'Carousel_widget' );}

class Carousel_widget extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'carousel_widget_bf', // Widget ID
			'Carousel', // Name
			array( 'description' => 'This widget displays posts from a tag of your choice. Enter a title for this widget and select the tags you would like to use. You can also select "All Tags" to display your latest posts. There is also an option that lets you choose how many posts you would like to display. This widget also has three different forms, 1/3 wide, 2/3 wide and full width.', ) // Args
			);}
	
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
		/* Default widget settings. */
		
			$defaults = array( 'title' => 'Carousel Widget', 'number' => 10, 'widget_size' => 'one-third', 'tags' => 0, 'img_size' => 0);
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$number = $instance['number'];
			$tags = $instance['tags'];
			$widget_size = $instance['widget_size'];
			$img_size = $instance['img_size'];
		
		$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);		
		echo $args ['before_widget'];
			if (! empty( $title ))
				echo $args['before_title'] . $title . $args['after_title'];?>

<div <?php if($img_size == 'on'){echo 'id="big-carousel"';}; ?> class="carousel">
	<ul class="slides">
		<?php $bf_posts = new WP_Query(array( 'tag' => $tags, 'posts_per_page' => $number)); while($bf_posts->have_posts()) : $bf_posts->the_post();?>
		<li>
			<div class="carousel-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php if($img_size == 'on'){the_post_thumbnail('big-carousel-thumb');}else{the_post_thumbnail('carousel-thumb');}; if ( 'video' == get_post_format() ): echo '<span class="play-icon"></span>'; endif;?>
				</a>
				<?php } ?>
			</div>
			<!---carousel-image-->
			<div class="carousel-text">
				<div class="carousel-category">
					<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
				</div>
				<!--carousel-category-->
				<div class="carousel-title">
					<a href="<?php the_permalink() ?>">
					<?php echo wp_trim_words( get_the_title(), 7 ); ?>
					</a>
				</div>
				<!--carousel-title-->
			</div>
			<!--carousel-text-->
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<!--carousel-->

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
		$instance['tags'] = $new_instance['tags'];
		$instance['widget_size'] = $new_instance['widget_size'];
		$instance['img_size'] = $new_instance['img_size'];

		return $instance;
	}


	function form( $instance ) {

		/* Default widget settings. */
		
		$defaults = array( 'title' => 'Carousel Widget', 'number' => 10, 'widget_size' => 'one-third', 'tags' => 0, 'img_size' => 0);
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

<!-- Maximum number of posts -->
<p>
	<label for="<?php echo $this->get_field_id( 'number' ); ?>">
		Number of posts:
	</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
</p>

<!-- Pick a tag to display -->
<p>
	<label for="<?php echo $this->get_field_id('tags'); ?>">
		Tag:
	</label>
	<select id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>" style="width:100%;">
		<option value='all' <?php if ('all' == (isset($instance['tags']))) echo 'selected="selected"'; ?>>
		No Tag Selected
		</option>
		<?php $tags = get_tags('hide_empty=0'); ?>
		<?php foreach($tags as $tag) { ?>
		<option value='<?php echo $tag->slug; ?>' <?php if(isset($instance['tags'])){ if ($tag->slug == $instance['tags']) echo 'selected="selected"';} ?>>
		<?php echo $tag->name; ?>
		</option>
		<?php } ?>
	</select>
	
	<!-- image size -->
<p>
	<label for="<?php echo $this->get_field_id( 'img_size' ); ?>">
		Tall Image Size:
	</label>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'img_size' ); ?>" name="<?php echo $this->get_field_name( 'img_size' ); ?>" <?php checked( (bool) $instance['img_size'], true ); ?> />
</p>
</p>
<?php }}?>