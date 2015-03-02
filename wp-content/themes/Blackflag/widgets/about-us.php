<?php   

/* 
Plugin Name: About us
Description: About us widget 
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'about_widget' );

function about_widget() {register_widget( 'about_widget_bf' );}

class about_widget_bf extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'about_bf', // Widget ID
			'About us', // Name
			array( 'description' => 'Like its name suggests, this widgets lets you write something about yourself, so your visitors can get to know you better. It also displays your social media icons. This widget has only 1 form.', ) // Args
			);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			
			/* Default widget settings. */
			
			$defaults = array( 'title' =>'About us', 'text' =>'write something here...');
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			/* Widget settings. */
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$text = $instance['text'];
			
			
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			?>

<div class="about-widget">
	<div class="about-logo">
		<a href="<?php echo home_url(); ?>">
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>"/>
		</a>
	</div>
	<!--about-logo-->
	<?php if(get_option('bf_instagram')||get_option('bf_youtube')||get_option('bf_google')||get_option('bf_pinterest')||get_option('bf_twitter')||get_option('bf_facebook')) { ?>
	<div class="about-social">
		<ul>
			<?php if(get_option('bf_facebook')) { ?>
			<li>
				<a href="http://www.facebook.com/<?php echo get_option('bf_facebook'); ?>" class="fb-social-icon" target="_blank">
				</a>
			</li>
			<?php } ?>
			<?php if(get_option('bf_twitter')) { ?>
			<li>
				<a href="http://www.twitter.com/<?php echo get_option('bf_twitter'); ?>" class="twitter-social-icon" target="_blank">
				</a>
			</li>
			<?php } ?>
			<?php if(get_option('bf_pinterest')) { ?>
			<li>
				<a href="http://www.pinterest.com/<?php echo get_option('bf_pinterest'); ?>" class="pinterest-social-icon" target="_blank">
				</a>
			</li>
			<?php } ?>
			<?php if(get_option('bf_google')) { ?>
			<li>
				<a href="https://plus.google.com/<?php echo get_option('bf_google'); ?>/posts" class="google-social-icon" target="_blank">
				</a>
			</li>
			<?php } ?>
			<?php if(get_option('bf_youtube')) { ?>
			<li>
				<a href="http://www.youtube.com/user/<?php echo get_option('bf_youtube'); ?>" class="youtube-social-icon" target="_blank">
				</a>
			</li>
			<?php } ?>
			<?php if(get_option('bf_instagram')) { ?>
			<li>
				<a href="http://instagram.com/<?php echo get_option('bf_instagram'); ?>" class="instagram-social-icon" target="_blank">
				</a>
			</li>
			<?php } ?>
			<li>
				<a href="<?php bloginfo('rss_url'); ?>" class="rss-social-icon">
				</a>
			</li>
		</ul>
	</div>
	<!--content-social-->
	<?php } ?>
	<div class="about-text">
		<?php echo wpautop($text); ?>
	</div>
	<!--about-text-->
</div>
<!--about-widget-->

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
			
			return $instance;
		}
				
		function form( $instance ) {
			
			/* Default widget settings. */
			
			$defaults = array( 'title' =>'About us', 'text' =>'write something here...');
			$instance = wp_parse_args( (array) $instance, $defaults );
			$text = format_to_edit($instance['text']);
			 ?>

<!-- Widget Title-->

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
</p>
<!-- About text-->
<p>
	<label for="<?php echo $this->get_field_id( 'text' ); ?>">
		About us text:
	</label>
	<textarea class="widefat" rows="16" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>">
<?php echo $text; ?>
</textarea>
</p>
<?php }} ?>