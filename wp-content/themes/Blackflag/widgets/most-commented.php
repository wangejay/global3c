<?php   
/* 
Plugin Name: Most commented
Description: Most commented widget - display most commented posts.
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'most_commented_posts' );

function most_commented_posts() {register_widget( 'most_commented_widget' );}

class most_commented_widget extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'most_commented_widget_bf', // Widget ID
			'Most commented posts', // Name
			array( 'description' =>'A simple widget that displays the most commented posts on your site, along with the number of comments. This widget does not have three forms, only 1/3.', ) // Args
			);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
		/* Default widget settings. */
		
			$defaults = array( 'title' => 'Most commented', 'number' => 2);
			$instance = wp_parse_args( (array) $instance, $defaults );			

			$title = apply_filters( 'widget_title', $instance['title'] );
			$number = $instance['number'];
			
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];	
			?>

<div class="most-commented">
	<ul class="most-commented-posts">
		<?php $most_commented_query = new WP_Query('orderby=comment_count&posts_per_page='.$number.''); 
		while ($most_commented_query->have_posts()) : $most_commented_query->the_post(); ?>
		<li>
			<div class="most-commented-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_title(); ?>
				</a>
			</div>
			<!--most-commented-title-->
			<div class="most-commented-count">
				<?php comments_popup_link('0', '1', '%'); ?>
			</div>
			<!--comment-count-->
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<!--most-commented-->

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
		
		return $instance;
	}
	
	
	function form( $instance ) {
		
	/* Default widget settings. */
		
		$defaults = array( 'title' => 'Most commented', 'number' => 2);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

<!-- Widget Title-->
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
</p>

<!-- Number of posts -->
<p>
	<label for="<?php echo $this->get_field_id( 'number' ); ?>">
		Number of posts to show:
	</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
</p>
<?php }} ?>