<?php 
/* Black flag page template
 * Template Name: homepagefun
 * Description : Homepage-fun
 */
?>
<?php get_header(); ?>

<div id="main">
	<div id="fullwidth" class="widget-area">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('homepagefun')): endif; ?>
	</div>
</div>
<?php get_footer(); ?>