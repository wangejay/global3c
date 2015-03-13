<?php 
/* Black flag page template
 * Template Name: homepagelife
 * Description :Homepagelife
 */
?>
<?php get_header(); ?>

<div id="main">
	<div id="fullwidth" class="widget-area">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('homepagelife')): endif; ?>
	</div>
</div>
<?php get_footer(); ?>