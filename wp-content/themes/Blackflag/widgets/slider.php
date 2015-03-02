<?php
/* 
Plugin Name: Slider 
Description: Slider by selecting tags.
Version: 1.0 
Author: Stefan Naumovski 
*/    
add_action( 'widgets_init', 'Slider_widget' );

function Slider_widget() {register_widget( 'Slider' );}

class Slider extends WP_Widget {
	
	/* Register widget with WordPress. */

	function __construct() {
		parent::__construct(
				'slider_widget_bf', 	//Widget ID
				'Slider', // Name
				array( 'description' => 'This is the slider widget. It displays posts based on tags. It has three sizes, 1/3 of the page , 2/3 of the page, or full width. You can also select if the control thumbs are visible on the slider, or rather use the arrows as a navigation.', ) // Args
		);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			
			$defaults = array( 'title' => 'Image Slider', 'number' => 3, 'slider_control' => 'on', 'widget_size' => 'one-third', 'tags' => 0);
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$number = $instance['number'];
			$tags = $instance['tags'];
			$slider_control = $instance['slider_control'];		
			$widget_size = $instance['widget_size'];
		
			$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);				
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];	
			?>
<?php if($slider_control != 'on'){ ?>

<div class="solo-slider-container <?php echo get_option('bf_slider_picker');?>">
	<div class="flexslider">
		<ul class="slides">
			<?php $bf_posts = new WP_Query(array( 'tag' => $tags, 'posts_per_page' => $number  )); while($bf_posts->have_posts()) : $bf_posts->the_post();?>
			<li>
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php if( $widget_size == 'one-third' ) {the_post_thumbnail('one-third-slider-img');} elseif( $widget_size == 'two-thirds' ){the_post_thumbnail('two-thirds-slider-img');} elseif ( $widget_size == 'three-thirds' ){the_post_thumbnail('three-thirds-slider-img');} ?>
				</a>
				<?php } ?>
				<div class="slider-text-box">
					<span class="slide-date">
					<?php echo get_the_date(); ?>
					</span>
					<div class="slide-title">
						<h2>
							<a href="<?php the_permalink() ?>">
							<?php the_title(); ?>
							</a>
						</h2>
					</div>
					<!--slider-text-box-->
					<div class="slide-info">
						<span class="slide-excerpt">
						<?php  $bf_subtitle = get_post_meta(get_the_ID(), 'bf_sub_title', true); if(empty($bf_subtitle)) { echo excerpt(22); }  else { echo $bf_subtitle;}  ?>
						</span>
					</div>
					<!--slider-info-->
				</div>
				<!--slider-text-box-->
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
	<!--flexslider-->
</div>
<!--slider-container-->

<?php } ?>
<?php if($slider_control == 'on'){ ?>
<div class="slider-container">
	<div class="wide-slider <?php echo get_option('bf_slider_picker');?>">
		<ul class="slides">
			<?php if( $widget_size == 'one-third' ){$slides_number_posts = '6';} else {$slides_number_posts = '5';}; ?>
			<?php $bf_posts = new WP_Query(array( 'tag' => $tags, 'posts_per_page' => $slides_number_posts)); while($bf_posts->have_posts()) : $bf_posts->the_post();?>
			<li>
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php if( $widget_size == 'one-third' ) {the_post_thumbnail('one-third-slider-img');} elseif( $widget_size == 'two-thirds' ){the_post_thumbnail('two-thirds-wide-slider-img');} elseif ( $widget_size == 'three-thirds' ){the_post_thumbnail('three-thirds-wide-slider-img');} ?>
				</a>
				<?php } ?>
				<div class="slider-text-box">
					<span class="slide-date">
					<?php echo get_the_date(); ?>
					</span>
					<div class="slide-title">
						<h2>
							<a href="<?php the_permalink() ?>">
							<?php the_title(); ?>
							</a>
						</h2>
					</div>
					<!--slider-text-box-->
					<div class="slide-info">
						<span class="slide-excerpt">
						<?php  $bf_subtitle = get_post_meta(get_the_ID(), 'bf_sub_title', true); if(empty($bf_subtitle)) { echo excerpt(22); }  else { echo $bf_subtitle;}  ?>
						</span>
					</div>
					<!--slider-info-->
				</div>
				<!--slider-text-box-->
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
	<!--flexslider-->
</div>
<!--slider-container-->

<div class="wide-slider-control">
	<ul>
		<?php $bf_posts = new WP_Query(array( 'tag' => $tags, 'posts_per_page' => $slides_number_posts)); while($bf_posts->have_posts()) : $bf_posts->the_post();?>
		<li>
			<div class="wide-slider-thumb">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="#" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('slider-thumb'); ?>
				</a>
				<?php } ?>
			</div>
			<!---wide-slider-thumb-->
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<!--wide-slider-control-->
<?php } ?>
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
		$instance['slider_control'] = $new_instance['slider_control'];	
		$instance['widget_size'] = $new_instance['widget_size'];		
		return $instance;
	}		
	
		/* Default widget settings. */
		
	function form( $instance ) {	
		$defaults = array( 'title' => 'Image Slider', 'number' => 3, 'slider_control' => 'on', 'widget_size' => 'one-third', 'tags' => 0);
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
		Number of slides:
	</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
</p>

<!--Tags-->
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
</p>

<!--slider_control-->
<p>
	<label for="<?php echo $this->get_field_id( 'slider_control' ); ?>">
		Show control thumbs:
	</label>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'slider_control' ); ?>" name="<?php echo $this->get_field_name( 'slider_control' ); ?>" <?php checked( (bool) $instance['slider_control'], true ); ?> />
</p>
<?php }} ?>