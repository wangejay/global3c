<?php 
/* Black flag page template
 * Template Name: Page with Sidebar
 * Description: Adds sidebar to the page
 */
?>
<?php get_header(); ?>

<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="post-page-title">
		<h1>
			<?php the_title(); ?>
		</h1>
	</div>
	<!--post-page-title-->
	<?php  $bf_subtitle = get_post_meta(get_the_ID(), 'bf_sub_title', true); if(empty($bf_subtitle)) {}  else { echo '<div id="post-page-subtitle">'.$bf_subtitle.'</div><!--post-subtitle-->';}  ?>
	<div id="primary">
		<div class="post-page-content-wrapper">
			<div id="post-content" class="content page-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<?php endwhile; endif; ?>
		</div>
	</div>
	<div id="secondary">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Sidebar')): endif; ?>
	</div>
	<!--secondary-->
</div>
<?php get_footer(); ?>