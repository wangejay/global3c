<?php   
/* 
Plugin Name: Featured Categories
Description: Featured Categories posts from 3 diferenet categories.
Version: 1.0 
Author: Stefan Naumovski 
*/    
add_action( 'widgets_init', 'featured_category_list_widget' );

function featured_category_list_widget() {register_widget( 'featured_category_list' );}

class featured_category_list extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'featured_list_posts_bf', //Widget ID
			'Featured Categories', //Name
			array( 'description' => 'This widgets lets you chosse up to 3 categories that will be displayed. The latest posts from each of those categories willbe visible with the image, and the others with titles as links. This widget also has three different forms, but depending on which one you select, thats how many categories will be visible. For example if you select the 2/3rds form, than only 2 categories will be visible.', ) //Args
		);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			/* Default widget settings. */
		
			$defaults = array( 'title' => 'Featured category', 'widget_size' => 'one-third', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0', );
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$category_one = $instance['category_one'];
			$category_two = $instance['category_two'];
			$category_three = $instance['category_three'];
			$widget_size = $instance['widget_size'];
						
			$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);		
			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
				?>

<div class="category-small">
	<ul class="featured-small">
		<?php $bf_posts = new WP_Query(array( 'cat' => $category_one, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<div class="blog-post-categories-wrapper">
				<span class="blog-post-categories">
				<a href="<?php echo get_category_link($category_one); ?>">
				<?php echo get_cat_name($category_one);?>
				</a>
				</span>
			</div>
			<div class="blog-post-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('big-cat-thumb'); ?>
				</a>
				<?php } ?>
			</div>
			<!--blog-post-image-->
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
			
			<div class="blog-post-content">
				<?php echo excerpt(30); ?>
			</div>
			<!--blog-post-content-->
		</li>
		<?php endwhile; ?>
	</ul>
	<ul class="featured-category-small-links">
		<?php $bf_posts = new WP_Query(array( 'cat' => $category_one, 'posts_per_page' => 4, 'offset' => '1' )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<h2>
				<a href="<?php the_permalink() ?>" >
				<?php echo wp_trim_words( get_the_title(), 8 ); ?>
				</a>
			</h2>
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<!--category-small-->

<?php if( $widget_size == 'two-thirds' || $widget_size == 'three-thirds' ) { ?>
<div class="category-small">
	<ul class="featured-small">
		<?php $bf_posts = new WP_Query(array( 'cat' => $category_two, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<div class="blog-post-categories-wrapper">
				<span class="blog-post-categories">
				<a href="<?php echo get_category_link($category_two); ?>">
				<?php echo get_cat_name($category_two);?>
				</a>
				</span>
			</div>
			<div class="blog-post-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('big-cat-thumb'); ?>
				</a>
				<?php } ?>
			</div>
			<!--blog-post-image-->
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
			
			<div class="blog-post-content">
				<?php echo excerpt(30); ?>
			</div>
			<!--blog-post-content-->
		</li>
		<?php endwhile; ?>
	</ul>
	<ul class="featured-category-small-links">
		<?php $bf_posts = new WP_Query(array( 'cat' => $category_two, 'posts_per_page' => 4, 'offset' => '1' )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<h2>
				<a href="<?php the_permalink() ?>" >
				<?php echo wp_trim_words( get_the_title(), 8 ); ?>
				</a>
			</h2>
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<!--category-small-->
<?php } ?>
<?php if( $widget_size == 'three-thirds' ) { ?>
<div class="category-small">
	<ul class="featured-small">
		<?php $bf_posts = new WP_Query(array( 'cat' => $category_three, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<div class="blog-post-categories-wrapper">
				<span class="blog-post-categories">
				<a href="<?php echo get_category_link($category_three); ?>">
				<?php echo get_cat_name($category_three);?>
				</a>
				</span>
			</div>
			<div class="blog-post-image">
				<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('big-cat-thumb'); ?>
				</a>
				<?php } ?>
			</div>
			<!--blog-post-image-->
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
			
			<div class="blog-post-content">
				<?php echo excerpt(30); ?>
			</div>
			<!--blog-post-content-->
		</li>
		<?php endwhile; ?>
	</ul>
	<ul class="featured-category-small-links">
		<?php $bf_posts = new WP_Query(array( 'cat' => $category_three, 'posts_per_page' => 4, 'offset' => '1' )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
		<li>
			<h2>
				<a href="<?php the_permalink() ?>" >
				<?php echo wp_trim_words( get_the_title(), 8 ); ?>
				</a>
			</h2>
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<!--category-small-->
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
		$instance['category_one'] = $new_instance['category_one'];
		$instance['category_two'] = $new_instance['category_two'];
		$instance['category_three'] = $new_instance['category_three'];
		$instance['widget_size'] = $new_instance['widget_size'];
			
		return $instance;
	}
	
	function form( $instance ) {
			
		/* Default widget settings. */
		
		$defaults = array( 'title' => 'Featured category', 'widget_size' => 'one-third', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0',);
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

<!-- cateogry-one -->
<p>
	<label for="<?php echo $this->get_field_id('category_one'); ?>">
		Select Category: One
	</label>
	<select id="<?php echo $this->get_field_id('category_one'); ?>" name="<?php echo $this->get_field_name('category_one'); ?>" style="width:100%;">
		<option value='all' <?php if ('all' == (isset($instance['category_one']))) echo 'selected="selected"'; ?>>
		All Categories
		</option>
		<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
		<?php foreach($categories as $category) { ?>
		<option value='<?php echo $category->term_id; ?>' <?php if(isset($instance['category_one'])){ if ($category->term_id == $instance['category_one']) echo 'selected="selected"';}?>>
		<?php echo $category->cat_name; ?>
		</option>
		<?php } ?>
	</select>
</p>

<!-- cateogry-two -->
<p>
	<label for="<?php echo $this->get_field_id('category_two'); ?>">
		Select Category: Two
	</label>
	<select id="<?php echo $this->get_field_id('category_two'); ?>" name="<?php echo $this->get_field_name('category_two'); ?>" style="width:100%;">
		<option value='all' <?php if ('all' == (isset($instance['category_two']))) echo 'selected="selected"'; ?>>
		All Categories
		</option>
		<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
		<?php foreach($categories as $category) { ?>
		<option value='<?php echo $category->term_id; ?>' <?php if(isset($instance['category_two'])){ if ($category->term_id == $instance['category_two']) echo 'selected="selected"';}?>>
		<?php echo $category->cat_name; ?>
		</option>
		<?php } ?>
	</select>
</p>

<!-- cateogry-three -->
<p>
	<label for="<?php echo $this->get_field_id('category_three'); ?>">
		Select Category: Three
	</label>
	<select id="<?php echo $this->get_field_id('category_three'); ?>" name="<?php echo $this->get_field_name('category_three'); ?>" style="width:100%;">
		<option value='all' <?php if ('all' == (isset($instance['category_three']))) echo 'selected="selected"'; ?>>
		All Categories
		</option>
		<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
		<?php foreach($categories as $category) { ?>
		<option value='<?php echo $category->term_id; ?>' <?php if(isset($instance['category_three'])){ if ($category->term_id == $instance['category_three']) echo 'selected="selected"';}?>>
		<?php echo $category->cat_name; ?>
		</option>
		<?php } ?>
	</select>
</p>
<?php }}?>