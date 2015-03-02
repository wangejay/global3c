<?php   
/* 
Plugin Name: Blog Posts  1
Description: The blog posts widget displayed in blogroll. 
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'blog_category_widget' );

function blog_category_widget() {register_widget( 'blog_category' );}

class blog_category extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'blog_category_bf', // Widget ID
			'Blogroll 1', // Name
			array( 'description' =>'A widget, that displays your posts in a blog roll style. You can select how many posts you want to be displayed 
and of course, what category should they be. Also you can choose to hide/show the author of those posts, and add an alternative look to the 2/3 form of the widget. This alternative look makes the posts look in a classical blog style. This widget also has three different forms. It can be 1 column of posts(1/3), two columns(2/3), and three columns(full width).', ) // Args
			);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			
		/* Default widget settings. */
			
			$defaults = array( 'title' => 'Blogroll1', 'number' => 6, 'author' => 'on', 'widget_size' => 'one-third', 'categories' => '0', 'image_full_width' => '0', 'excerptnumber'=>'90');
			$instance = wp_parse_args( (array) $instance, $defaults );
			
		/* Widget settings. */
		
			$title = apply_filters( 'widget_title', $instance['title'] );
			$categories = $instance['categories'];
			$number = $instance['number'];
			$excerptnumber = $instance['excerptnumber'];
			$author = $instance['author'];
			$widget_size = $instance['widget_size'];
			$image_full_width = $instance['image_full_width'];
			
			$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);			
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			?>

<div class="blog-category <?php if($widget_size == 'two-thirds' && $image_full_width == 'on' ) {echo 'bloglook';} ?>">
	<ul>
		<?php $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1; $bf_posts = new WP_Query(array( 'paged' => $paged, 'cat' => $categories, 'posts_per_page' => $number, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<?php if($widget_size == 'two-thirds' && $image_full_width == 'on' ) { ?>
		<li>
			<div class="blog-post-title-box">
				<div class="blog-post-title">
					<h2>
						<a href="<?php the_permalink() ?>" class="blog-post-title">
						<?php the_title(); ?>
						</a>
					</h2>
				</div>
				<!--blog-post-title-->
			</div>
			<!--blog-post-title-box-->
			<div class="bloglook-categories">
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
				<div class="blog-comment-count">
					<?php comments_popup_link('0', '1', '%'); ?>
				</div>
				<!--comment-count-->
			</div>
			<!--bloglook-categories-->
			
			<div class="blog-post-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php if($widget_size == 'two-thirds' && $image_full_width == 'on' ) {the_post_thumbnail('big-blog-img');} else {the_post_thumbnail('big-cat-thumb');} ?>
				</a>
				<?php } ?>
			</div>
			<!--blog-post-image-->
			<div class="post-date">
				<?php if($author) { ?>
				<span class="bypostauthor">
				<?php the_author_posts_link(); ?>
				</span>
				<?php } ?>
				<span class="date">
				<?php echo get_the_date(); ?>
				</span>
			</div>
			<!--post-date-->
			<div class="blog-post-content">
				<?php echo nl2br(excerpt($excerptnumber)); ?>
			</div>
			<!--blog-post-content-->
		</li>
		<?php }else{ ?>
		<li>
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
			<div class="blog-post-title-box">
				<div class="blog-post-title">
					<h2>
						<a href="<?php the_permalink() ?>" class="blog-post-title">
						<?php the_title(); ?>
						</a>
					</h2>
				</div>
				<!--blog-post-title-->
			</div>
			<!--blog-post-title-box-->
			
			<div class="blog-post-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php if($widget_size == 'two-thirds' && $image_full_width == 'on' ) {the_post_thumbnail('big-blog-img');} else {the_post_thumbnail('big-cat-thumb');} ?>
				</a>
				<?php } ?>
			</div>
			<!--blog-post-image-->
			<div class="post-date">
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
			<!--post-date-->
			<div class="blog-post-content">
				<?php echo nl2br(excerpt($excerptnumber)); ?>
			</div>
			<!--blog-post-content-->
		</li>
		<?php } ?>
		<?php endwhile; ?>
	</ul>
</div>
<!--featured-category-medium-->
<?php if($widget_size == 'two-thirds' && $image_full_width == 'on' ) {?>
<div class="pagination blog-pagination">
	<?php $big = 999999999;

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $bf_posts->max_num_pages
					) ); ?>
</div>
<!--pagination-->
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
		$instance['excerptnumber'] = strip_tags( $new_instance['excerptnumber'] );
		$instance['categories'] = $new_instance['categories'];
		$instance['author'] = $new_instance['author'];
		$instance['widget_size'] = $new_instance['widget_size'];
		$instance['image_full_width'] = $new_instance['image_full_width'];	
		
		return $instance;
	}
	
	
	function form( $instance ) {
		
				/* Default widget settings. */
			$defaults = array( 'title' => 'Blogroll1', 'number' => 4, 'author' => 'on', 'widget_size' => 'one-third', 'categories' => '0', 'image_full_width' => '0', 'excerptnumber'=>'90');
			$instance = wp_parse_args( (array) $instance, $defaults );
		
		
 ?>

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

<!-- Number of posts -->
<p>
	<label for="<?php echo $this->get_field_id( 'number' ); ?>">
		Number of posts to show:
	</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
</p>

<!-- Number of words -->
<p>
	<label for="<?php echo $this->get_field_id( 'excerptnumber' ); ?>">
		Number of words(max: 120):
	</label>
	<input id="<?php echo $this->get_field_id( 'excerptnumber' ); ?>" name="<?php echo $this->get_field_name( 'excerptnumber' ); ?>" value="<?php echo $instance['excerptnumber']; ?>" size="3" />
</p>

<!-- Author -->
<p>
	<label for="<?php echo $this->get_field_id( 'author' ); ?>">
		Show Author:
	</label>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'author' ); ?>" name="<?php echo $this->get_field_name( 'author' ); ?>" <?php checked( (bool) $instance['author'], true ); ?> />
</p>

<!--two-thirds-image-full-width-->
<p>
	<label for="<?php echo $this->get_field_id( 'image_full_width' ); ?>">
		two thirds: full width image
	</label>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'image_full_width' ); ?>" name="<?php echo $this->get_field_name( 'image_full_width' ); ?>" <?php checked( (bool) $instance['image_full_width'], true ); ?> />
</p>
<?php }} ?>