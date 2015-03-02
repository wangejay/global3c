<?php   

/* 
Plugin Name: Ad widget
Description: Ad widget with different sizes
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'ad_widget' );

function ad_widget() {register_widget( 'ad_widget_bf' );}

class ad_widget_bf extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'ad_widget_sizes_bf', // Widget ID
			'Ad Widget', // Name
			array( 'description' => 'This is where you place your ads. Just copy the Ad code in the appropriate field, and select what size is your advertisement.', ) // Args
			);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			
			/* Default widget settings. */
			
			$defaults = array( 'title' =>'advertisment', 'text' =>'Paste the ad code here', 'ad_size' => 'size2');
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			/* Widget settings. */
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$text = $instance['text'];
			$ad_size = $instance['ad_size'];
			
			if($ad_size == 'size1'||$ad_size == 'size2' || $ad_size == 'size3' || $ad_size == 'size4' || $ad_size == 'size7'){$widget_size = 'one-third';}elseif($ad_size == 'size5' || $ad_size == 'size8'){$widget_size = 'two-thirds';}elseif($ad_size == 'size6' || $ad_size == 'size9'){$widget_size = 'three-thirds';}
			
			$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);	
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			?>

<div class="ad-widget-sizes">
	<div class="<?php echo $ad_size; ?>">
		<?php echo $text; ?>
	</div>
</div>
<!--ad-widget-sizes-->

<?php

			/* After widget. */

			echo $args['after_widget'];
		}
		
			/* Widget settings. */
			
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			/* Strip tags. */
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['text'] = $new_instance['text'];
			$instance['ad_size'] = $new_instance['ad_size'];
			
			return $instance;
		}
				
		function form( $instance ) {
			
			/* Default widget settings. */
			
			$defaults = array( 'title' =>'advertisment', 'text' =>'Paste the ad code here', 'ad_size'=>'size2');
			$instance = wp_parse_args( (array) $instance, $defaults );
			$text = $instance['text'];
			 ?>

<!-- Widget Title-->

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
</p>
<!-- Ad code-->
<p>
	<label for="<?php echo $this->get_field_id( 'text' ); ?>">
		Code text:
	</label>
	<textarea class="widefat" rows="16" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>">
<?php echo $text; ?>
</textarea>
</p>
<!-- Ad size-->
<p>
	<select name="<?php echo $this->get_field_name('ad_size'); ?>" class="widefat">
		<option value="size1" <?php selected( $instance['ad_size'], 'size1' ); ?>>
		250x250
		</option>
		<option value="size2" <?php selected( $instance['ad_size'], 'size2' ); ?>>
		336x280
		</option>
		<option value="size3" <?php selected( $instance['ad_size'], 'size3' ); ?>>
		300x250
		</option>
		<option value="size4" <?php selected( $instance['ad_size'], 'size4' ); ?>>
		300x600
		</option>
		<option value="size5" <?php selected( $instance['ad_size'], 'size5' ); ?>>
		468x60
		</option>
		<option value="size6" <?php selected( $instance['ad_size'], 'size6' ); ?>>
		728x90
		</option>
		<option value="size7" <?php selected( $instance['ad_size'], 'size7' ); ?>>
		flexible up to 336px
		</option>
		<option value="size8" <?php selected( $instance['ad_size'], 'size8' ); ?>>
		flexible up to 672px
		</option>
		<option value="size9" <?php selected( $instance['ad_size'], 'size9' ); ?>>
		flexible up to 1008px
		</option>
	</select>
</p>
<?php }} ?>