<?php 
/**
 * Black flag category page
**/ 
?>
<?php get_header();?>
<?php $category_post_size = get_option('bf_category_post_size'); ?>


<div id="main" <?php if ( $category_post_size == 'three-thirds' ){echo 'class="no-sidebar"';}if ( !is_active_sidebar('catsidebar')){echo 'class="no-sidebar"';}?>>
	<div id="fullwidth" class="widget-area">

			<?php
			$classes = get_body_class();
			if (in_array('category-tech',$classes)) {
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('cattech')): endif; 
			} else {
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('catbrand')): endif; 
			}
			?>

		<!--home-widget three-thirds-->
	</div>
	<!--fullwidth-->
	
	
	<?php if ($category_post_size != "three-thirds" && is_active_sidebar('catsidebar')) { ?>
	<div id="secondary">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Category Sidebar')): endif; ?>
	</div>
	<!--secondary-->
	<?php } ?>
	<?php $bf_popular_widget = get_option('bf_popular_widget'); if ($bf_popular_widget == "true") { ?>
	
	
	<?php } ?>
</div>
<!--main-->
<?php get_footer(); ?>