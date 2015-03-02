<?php   
/* 
Plugin Name: Video
Description: Video widget 
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'embed_widget' );

function embed_widget() {register_widget( 'embed_vid' );}

class embed_vid extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'embed_vid_widget_bf', // Widget ID
			'Video', // Name
			array( 'description' => 'This widget displays a video that can be played directly on the homepage, or where ever you place it. Just add a link to the video, and select the size of the Video widget. It has the usual 3 form. 1/3, 2/3rds and full width.', ) // Args
			);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			
			/* Default widget settings. */
			
			$defaults = array( 'title' =>'Video', 'widget_size' => 'one-third');
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$link_to_vid = $instance['link_to_vid'];
			$widget_size = $instance['widget_size'];
						
			$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);			
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			?>

<div class="embed-widget">
	<?php
				if( $widget_size == 'one-third' ) {$video_size=336;} elseif( $widget_size == 'two-thirds' ){$video_size=612;} elseif ( $widget_size == 'three-thirds' ){$video_size=1008;}				
        		$video_embed = wp_oembed_get($link_to_vid, array('width'=>$video_size) );    	
				echo '<div class="embed-wrapper">' .$video_embed. '</div>';
				?>
</div>
<!--embed-widget-->

<?php

			/* After widget. */

			echo $args['after_widget'];
		}
		
			/* Widget settings. */
			
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			/* Strip tags. */
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['link_to_vid'] = strip_tags( $new_instance['link_to_vid'] );
			$instance['widget_size'] = $new_instance['widget_size'];
			
			return $instance;
		}
				
		function form( $instance ) {
			
			/* Default widget settings. */
			
			$defaults = array( 'title' =>'Video', 'widget_size' => 'one-third');
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

<!-- Link to Video-->
<p>
	<label for="<?php echo $this->get_field_id( 'link_to_vid' ); ?>">
		Link your video
	</label>
	<input id="<?php echo $this->get_field_id( 'link_to_vid' ); ?>" name="<?php echo $this->get_field_name( 'link_to_vid' ); ?>" value="<?php if(isset($instance['link_to_vid'])){ echo $instance['link_to_vid'];} ?>" style="width:90%;" />
</p>
<?php }} ?>