<?php
/* 
Plugin Name: Tabs (Tabs-widget) 
Description:  Tabs widget that shows Lastest, Popular and most commented posts.
Version: 1.0 
Author: Stefan Naumovski 
*/    
add_action( 'widgets_init', 'Tabs_widget' );

function Tabs_widget() {register_widget( 'Tabs' );}

class Tabs extends WP_Widget {
	
	/* Register widget with WordPress. */
	
	function __construct() {
		parent::__construct(
			'Tabs_bf', 	//Widget ID
			'Tabs Widget', // Name
			array( 'description' => 'This is a classical tabber widget, displaying the latest posts, the most popular ones and most commented posts from throughout the site. You have an option to change the title of each one of those, and select how many posts should be displayed. This widget has only one form (1/3).', ) // Args
		);}
		
		/* Front-end display of widget. */
		
	function widget( $args, $instance ) {
		/* Default widget settings. */
		$defaults = array( 'latest_title' => 'Latest','popular_title' => 'Popular','comments_title' => 'Commented', 'latest_number' => 3, 'categories' => 0);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		extract( $args );
		$latest_title = $instance['latest_title'];
		$popular_title = $instance['popular_title'];
		$comments_title = $instance['comments_title'];
		$latest_number = $instance['latest_number'];
		$categories = $instance['categories'];
		echo $args['before_widget'];
		?>

<div class="tabber-container">
	<ul class="tabs">
		<li>
			<h4>
				<a href="#tab1">
				<?php echo $latest_title; ?>
				</a>
			</h4>
		</li>
		<li>
			<h4>
				<a href="#tab2">
				<?php echo $popular_title; ?>
				</a>
			</h4>
		</li>
		<li>
			<h4>
				<a href="#tab3">
				<?php echo $comments_title; ?>
				</a>
			</h4>
		</li>
	</ul>
	<div id="tab1" class="tabber-content">
		<ul class="featured-thumbnails">
			<?php $bf_posts = new WP_Query(array('cat' => $categories, 'posts_per_page' => $latest_number, 'ignore_sticky_posts' => 1 )); while($bf_posts->have_posts()) : $bf_posts->the_post();?>
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
	</div>
	<!--tab1-->
	<div id="tab2" class="tabber-content">
		<?php $today = getdate();
			$bf_pop = array(
				'cat' => $categories,
				'posts_per_page'=> $latest_number,
				'year'     => $today["year"],
				//'monthnum' => $today["mon"],
				'meta_key' => 'post_views_count',
				'orderby' => 'meta_value_num',
				'order'    => 'DESC'
				);
					$popular_posts = new WP_Query($bf_pop); if($popular_posts->have_posts()): ?>
		<ul class="featured-thumbnails">
			<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>
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
		<?php endif; ?>
	</div>
	<!--tab2-->
	
	<div id="tab3" class="tabber-content">
		<ul class="featured-thumbnails">
			<?php $most_commented_query = new WP_Query('orderby=comment_count&posts_per_page='.$latest_number.'&cat='.$categories.''); 
		while ($most_commented_query->have_posts()) : $most_commented_query->the_post(); ?>
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
	</div>
	<!--tab3-->
</div>
<!--tabber-container-->
<?php

	/* After widget. */	
	
		echo $after_widget;
	}
	
	/* Widget settings. */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags. */
		
		$instance['latest_title'] = strip_tags( $new_instance['latest_title'] );
		$instance['popular_title'] = strip_tags( $new_instance['popular_title'] );
		$instance['comments_title'] = strip_tags( $new_instance['comments_title'] );
		$instance['latest_number'] = strip_tags( $new_instance['latest_number'] );
		$instance['categories'] = $new_instance['categories'];
		return $instance;
	}
	

		
	function form( $instance ) {
		/* Default widget settings. */
		$defaults = array( 'latest_title' => 'Latest','popular_title' => 'Popular','comments_title' => 'Commented', 'latest_number' => 3);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

<!--Latest-posts-title-->
<p>
	<label for="<?php echo $this->get_field_id( 'latest_title' ); ?>">
		Latest Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'latest_title' ); ?>" name="<?php echo $this->get_field_name( 'latest_title' ); ?>" value="<?php echo $instance['latest_title']; ?>" style="width:90%;" />
</p>

<!--Latest posts number of posts-->
<p>
	<label for="<?php echo $this->get_field_id( 'latest_number' ); ?>">
		Number of posts to show:
	</label>
	<input id="<?php echo $this->get_field_id( 'latest_number' ); ?>" name="<?php echo $this->get_field_name( 'latest_number' ); ?>" value="<?php echo $instance['latest_number']; ?>" size="3" />
</p>

<!--Latest posts category-->
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

<!--Popular-posts-title-->
<p>
	<label for="<?php echo $this->get_field_id( 'popular_title' ); ?>">
		Popular Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'popular_title' ); ?>" name="<?php echo $this->get_field_name( 'popular_title' ); ?>" value="<?php echo $instance['popular_title']; ?>" style="width:90%;" />
</p>

<!--Comments-posts-title-->
<p>
	<label for="<?php echo $this->get_field_id( 'comments_title' ); ?>">
		Comments Title:
	</label>
	<input id="<?php echo $this->get_field_id( 'comments_title' ); ?>" name="<?php echo $this->get_field_name( 'comments_title' ); ?>" value="<?php echo $instance['comments_title']; ?>" style="width:90%;" />
</p>
<?php }} ?>