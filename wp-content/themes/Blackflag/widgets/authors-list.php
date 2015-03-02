<?php   

/* 
Plugin Name: Author widget
Description: Author widget
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'author_show_widget' );

function author_show_widget() {register_widget( 'author_show_widget_bf' );}

class author_show_widget_bf extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'author_show_bf', // Widget ID
			'Author widget', // Name
			array( 'description' => 'This widget displays the author of the blog. You have the option to chosse what user is the author from the dropdown menu. An image and short bio, along with the social media icons will appear on the widget.', ) // Args
			);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			
			/* Default widget settings. */
			
			$defaults = array( 'title' =>'About me', 'display_author' => '1');
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			/* Widget settings. */
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$display_author = $instance['display_author'];
			
			$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget one-third', $args['before_widget']);
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			?>
<?php $curauth = get_userdata( $display_author ); ?>

<div class="featured-author">
	<a href="<?php echo get_author_posts_url($curauth->ID); ?>">
	<div class="featured-author-image">
		<?php echo get_avatar( $curauth->ID, '276' ); ?>
	</div>
	<!--author-image-->
	</a>
	<div class="featured-author-desc">
		<h2>
			<a href="<?php echo get_author_posts_url($curauth->ID); ?>">
			<?php echo $curauth->display_name; ?>
			</a>
		</h2>
		<?php echo $curauth->description; ?>
	</div>
	<!--author-desc-->
	<ul class="author-social">
		<?php if($curauth->facebook) { ?>
		<li>
			<a href="http://facebook.com/<?php echo $curauth->facebook; ?>" class="fb-social-icon" target="_blank">
			</a>
		</li>
		<?php } ?>
		<?php if($curauth->twitter) { ?>
		<li>
			<a href="https://twitter.com/<?php echo $curauth->twitter; ?>" class="twitter-social-icon" target="_blank">
			</a>
		</li>
		<?php } ?>
		<?php if($curauth->google) { ?>
		<li>
			<a href="http://plus.google.com/<?php echo $curauth->google; ?>?rel=author" class="google-social-icon" target="_blank">
			</a>
		</li>
		<?php } ?>
		<?php if($curauth->pinterest) { ?>
		<li>
			<a href="http://www.pinterest.com/<?php echo $curauth->pinterest; ?>?rel=author" class="pinterest-social-icon" target="_blank">
			</a>
		</li>
		<?php } ?>
		<?php if($curauth->instagram) { ?>
		<li>
			<a href="http://www.instagram.com/<?php echo $curauth->instagram; ?>?rel=author" class="instagram-social-icon" target="_blank">
			</a>
		</li>
		<?php } ?>
	</ul>
</div>
<!--author-info-->

<?php

			/* After widget. */

			echo $args['after_widget'];
		}
		
			/* Widget settings. */
			
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			/* Strip tags. */
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['display_author'] = $new_instance['display_author'];
			
			return $instance;
		}
				
		function form( $instance ) {
			
			/* Default widget settings. */
			
			$defaults = array( 'title' =>'About me', 'display_author' => '1');
			$instance = wp_parse_args( (array) $instance, $defaults );
			 ?>

<!-- Widget Title-->

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
</p>
<!-- Choose Author-->
<p>
	<label for="<?php echo $this->get_field_id( 'display_author' ); ?>">
		Choose Author:
	</label>
	<?php wp_dropdown_users( array('id' => $this->get_field_id( 'display_author' ),
                                                'name' => $this->get_field_name( 'display_author' ),
                                                'selected' => $instance['display_author']
                                                ) ); ?>
</p>
<?php }} ?>