<?php 
/**
 * Black flag page
**/ 
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
	<!--post-subtitle-->
	<div id="post-content" class="content fullwidth page-content">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
	</div>
	<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>