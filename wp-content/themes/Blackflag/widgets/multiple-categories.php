<?php   
/* 
Plugin Name: Featured Category
Description: Featured category widget
Version: 1.0 
Author: Stefan Naumovski 
*/    

add_action( 'widgets_init', 'multiple_categories_widget' );

function multiple_categories_widget() {register_widget( 'multiple_categories' );}

class multiple_categories extends WP_Widget {
	
	/* Register widget with WordPress. */

	function __construct() {
		parent::__construct(
			'multiple_categories_bf', // Widget ID
			'Multiple Categories',// Name
			array( 'description' => 'This widget displays a certain category of your choosing, or if you tick the three category slider box, than you can select two additional categories. The latest post from the categories will have a bigger image, while the others will have smaller ones.This widget also has three different forms.')// Args
		);}
		
		/* Front-end display of widget. */
		
		public function widget( $args, $instance ) {
			/* Default widget settings. */
	
			$defaults = array( 'title' => 'Multiple Categories', 'more_categories' => 0, 'widget_size' => 'one-third', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0', );
			$instance = wp_parse_args( (array) $instance, $defaults ); 
			
			$title = apply_filters( 'widget_title', $instance['title'] );
			$category_one = $instance['category_one'];
			$category_two = $instance['category_two'];
			$category_three = $instance['category_three'];
			$more_categories = $instance['more_categories'];
			$widget_size = $instance['widget_size'];
			
			
			$args['before_widget'] = str_replace('class="home-widget', 'class="home-widget '. $widget_size , $args['before_widget']);					
			echo $args['before_widget'];
			if (! empty( $title )){
				echo '<h3><div class="widget-title">'. $title . '</div>';}else{echo '<h3>';}?>
<?php if($more_categories) { ?>

<div class="feat-cat-categories <?php if (empty( $title )){ echo'no-title-feat-cat';}?>">
	<ul>
		<li>
			<a href="#">
			<?php echo get_cat_name($category_one); ?>
			</a>
		</li>
		<li>
			<a href="#">
			<?php echo get_cat_name($category_two); ?>
			</a>
		</li>
		<li>
			<a href="#">
			<?php echo get_cat_name($category_three); ?>
			</a>
		</li>
	</ul>
</div>
<!--feat-cat-categories-->
<?php } ?>
<?php echo '</h3>';?>
<div class="featured-category-widget-slider">
	<?php if($more_categories) { ?>
	<div class="cat-slider">
		<ul class="slides">
			<li>
				<?php } ?>
				<ul class="featured-posts-category-big">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_one, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('big-cat-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<div class="featured-posts-content">
								<?php echo excerpt(20); ?>
							</div>
							<!--featured-posts-content-->
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<ul class="tv-featured-posts small-feat-posts">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_one, 'posts_per_page' => 3, 'offset' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('small-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<span class="post-date">
							<?php echo get_the_date(); ?>
							</span>
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<?php if( $widget_size == 'three-thirds' ) { ?>
				<ul class="tv-featured-posts small-feat-posts">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_one, 'posts_per_page' => 3, 'offset' => 4, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('small-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<span class="post-date">
							<?php echo get_the_date(); ?>
							</span>
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<?php } ?>
				<?php if($more_categories) { ?>
			</li>
			<li>
				<ul class="featured-posts-category-big">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_two, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('big-cat-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<div class="featured-posts-content">
								<?php echo excerpt(20); ?>
							</div>
							<!--featured-posts-content-->
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<ul class="tv-featured-posts small-feat-posts">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_two, 'posts_per_page' => 3, 'offset' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('small-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<span class="post-date">
							<?php echo get_the_date(); ?>
							</span>
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<?php if( $widget_size == 'three-thirds' ) { ?>
				<ul class="tv-featured-posts small-feat-posts">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_two, 'posts_per_page' => 3, 'offset' => 4, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('small-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<span class="post-date">
							<?php echo get_the_date(); ?>
							</span>
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<?php } ?>
			</li>
			<li>
				<ul class="featured-posts-category-big">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_three, 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('big-cat-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<div class="featured-posts-content">
								<?php echo excerpt(20); ?>
							</div>
							<!--featured-posts-content-->
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<ul class="tv-featured-posts small-feat-posts">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_three, 'posts_per_page' => 3, 'offset' => 1, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('small-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<span class="post-date">
							<?php echo get_the_date(); ?>
							</span>
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<?php if( $widget_size == 'three-thirds' ) { ?>
				<ul class="tv-featured-posts small-feat-posts">
					<?php $bf_posts = new WP_Query(array( 'cat' => $category_three, 'posts_per_page' => 3, 'offset' => 4, 'ignore_sticky_posts' => 1 )); while ( $bf_posts->have_posts()) : $bf_posts->the_post(); ?>
					<li>
						<div class="featured-posts-image">
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('small-thumb'); ?>
							</a>
							<?php } ?>
						</div>
						<!---featured-posts-image-->
						<div class="featured-posts-text">
							<span class="category-icon">
							<?php $category = get_the_category(); if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';} ?>
							</span>
							<div class="featured-posts-title">
								<a href="<?php the_permalink() ?>">
								<?php echo wp_trim_words( get_the_title(), 10 ); ?>
								</a>
							</div>
							<!--featured-posts-title-->
							<span class="post-date">
							<?php echo get_the_date(); ?>
							</span>
						</div>
						<!--featured-posts-text-->
					</li>
					<?php endwhile; ?>
				</ul>
				<?php } ?>
			</li>
		</ul>
	</div>
	<!--cat-slider-->
	
	<?php } ?>
</div>
<!--featured-category-widget-slider-->
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
		$instance['more_categories'] = $new_instance['more_categories'];
		$instance['widget_size'] = $new_instance['widget_size'];		
		return $instance;
	}
	
	function form( $instance ) {
		
		/* Default widget settings. */

		$defaults = array( 'title' => 'Featured category', 'more_categories' => 0, 'widget_size' => 'one-third');
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>

<!-- Widget Title-->
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">
		Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
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
	<label for="<?php echo $this->get_field_id('category_one'); ?>">
		Select Category:
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

<!-- More categories -->
<p>
	<label for="<?php echo $this->get_field_id( 'more_categories' ); ?>">
		Three category slider:
	</label>
	<input type="checkbox" id="<?php echo $this->get_field_id( 'more_categories' ); ?>" name="<?php echo $this->get_field_name( 'more_categories' ); ?>" <?php checked( (bool) $instance['more_categories'], true ); ?> />
</p>

<!-- Category two -->
<p>
	<label for="<?php echo $this->get_field_id('category_two'); ?>">
		(Optional)Select Category:
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

<!-- Category three -->
<p>
	<label for="<?php echo $this->get_field_id('category_three'); ?>">
		(Optional)Select Category:
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