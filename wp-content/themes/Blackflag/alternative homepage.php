<?php 
/* Black flag page template
 * Template Name: Alternative Homepage
 * Description :Alternative Homepage
 */
?>
<?php get_header(); ?>

<div id="main">
	<div id="fullwidth" class="widget-area">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Alternative Homepage')): endif; ?>
	</div>
</div>
<?php get_footer(); ?>