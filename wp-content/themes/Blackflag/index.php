<?php 
/**
 * Black flag main
**/ 
?>
<?php get_header(); ?>

<div id="main">
	<?php $bf_display_latest_posts = get_option('bf_display_latest_posts'); if ($bf_display_latest_posts == 'true') { ?>
	<div class="home-latest-posts">
		<?php homepage_latest_loop(); ?>
	</div>
	<?php }; ?>
	<!--latest-posts-->
	<div id="fullwidth" class="widget-area">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage')): endif; ?>
	</div>
	<!--fullwidth-->
</div>
<!--main-->
<?php get_footer(); ?>