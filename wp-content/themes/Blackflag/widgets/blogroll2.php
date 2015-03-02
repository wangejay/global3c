<?php   
/* 
Plugin Name: Blog Posts 2
Description: The blog posts widget displayed in blogroll. 
Version: 1.0 
Author: Stefan Naumovski 
*/    
add_action ( 'widgets_init', 'bf_blog_posts_widget' );

function bf_blog_posts_widget() {register_widget ( 'bf_blog_posts' );}

class bf_blog_posts extends WP_Widget {
	
	/* Register widget with WordPress. */

	function __construct() {
		parent::__construct ( 
		'bf_blog_posts_bf',	//Widget ID
		'Blogroll 2',	// Name
		array( 'description' => 'Another widget that displays your posts in a alternative blog roll style. You can select how many posts you want to be displayed and of course, what category should they be. Also you can choose to hide/show the author of those posts. This widget also has three different forms.', ) // Args
	);}
	
		/* Front-end display of widget. */
	
	public function widget($args, $instance) {
		
		/* Default widget settings. */

		$defaults = array( 'title' => 'Blog Posts', 'number' => 3, 'widget_size' => 'one-third', 'categories' => 0, 'author' => 'on');
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		/* Widget settings. */
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );	
		$number = $instance ['number'];
		$categories = $instance ['categories'];
		$widget_size = $instance['widget_size'];
		$author = $instance['author'];
		
		$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);		
		echo $args ['before_widget'];
			if (! empty( $title ))
				echo $args['before_title'] . $title . $args['after_title'];?>

<ul class="bf-blog-posts-category">
	<?php $bf_posts = new WP_Query(array( 'cat' => $categories, 'posts_per_page' => $number )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
	<li <?php post_class(); ?>>
		<div class="bf-blog-posts-thumb">
			<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php if( $widget_size == 'one-third'){the_post_thumbnail('one-third-high-img');} elseif($widget_size == 'two-thirds' ) {the_post_thumbnail('big-cat-thumb');}  elseif ( $widget_size == 'three-thirds' ){the_post_thumbnail('big-blog-img');} ?>
			<?php if ( 'video' == get_post_format() ): echo '<span class="play-icon"></span>'; endif; ?>
			</a>
			<?php } ?>
		</div>
		<!--bf-blog-posts-thumb-->
		<div class="bf-blog-posts-text">
			<?php 
		  $output = '';
		  $list_categories = get_the_category();
			  if($list_categories){
				  $output .='<div class="blog-post-categories-wrapper">';
				  foreach($list_categories as $category) {					  
					  $output .='<span class="blog-post-categories"><a href="'.get_category_link( $category->term_id ).'">'.$category->cat_name.'</a></span>';				
				  }
				  $output .='</div><!--blog-post-categories-wrapper-->';
				  echo trim($output);
			  }
			  ?>
			<h2>
				<a href="<?php the_permalink() ?>" class="bf-blog-posts-title">
				<?php the_title(); ?>
				</a>
			</h2>
			<div class="bf-blog-posts-date-posted">
				<?php if($author) { ?>
				<span class="bypostauthor">
				<?php the_author_posts_link(); ?>
				</span>
				<?php } ?>
				<span class="date">
				<?php echo get_the_date(); ?>
				</span>
				<div class="blog-comment-count">
					<?php comments_popup_link('0', '1', '%'); ?>
				</div>
				<!--comment-count-->
			</div>
			<!--bf-blog-posts-date-posted-->
			<div class="bf-blog-posts-content">
				<?php if( $widget_size == 'one-third' || $widget_size == 'two-thirds' ) {echo excerpt(37);}  elseif ( $widget_size == 'three-thirds' ){echo excerpt(100);} ?>
			</div>
			<!--bf-blog-posts-content-->
		</div>
		<!--bf-blog-posts-text-->
	</li>
	<?php endwhile; ?>
</ul>
<?php		
	/* After widget. */
		
	echo $args ['after_widget'];
	}
	
		/* Widget settings. */
			
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		/* Strip tags. */
		
		$instance ['title'] = strip_tags ( $new_instance ['title'] );
		$instance ['number'] = strip_tags ( $new_instance ['number'] );
		$instance ['categories'] = $new_instance ['categories'];
		$instance['widget_size'] = $new_instance['widget_size'];
		$instance['author'] = $new_instance['author'];
		
		return $instance;
	}
	function form($instance) {
		
		/* Default widget settings. */

		$defaults = array( 'title' => 'Blog Posts', 'number' => 3, 'widget_size' => 'one-third', 'categories' => 0, 'author' => 'on');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

<!-- Widget Title-->
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width: 90%;" />
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
	<input
				id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>"	value="<?php echo $instance['number']; ?>" size="3" />
</p>

<!-- Author -->
<p>
	<label for="<?php echo $this->get_field_id( 'author' ); ?>">
		Show Author:
	</label>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'author' ); ?>" name="<?php echo $this->get_field_name( 'author' ); ?>" <?php checked( (bool) $instance['author'], true ); ?> />
</p>

<!--Category -->
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