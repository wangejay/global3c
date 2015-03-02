<?php 
/**
 * Black flag ticker
**/ 
?>
<?php
function ticker() {?>

<div class="ticker-heading">
	<?php echo get_option('bf_ticktitle'); ?>
</div>
<!--ticker-heading-->
<div id="ticker-list-box">
	<ul class="ticker-list">
		<?php $recent = new WP_Query(array( 'tag' => get_option('bf_ticker_tags'), 'posts_per_page' => get_option('bf_ticker_num') )); while($recent->have_posts()) : $recent->the_post();?>
		<li>
			<a href="<?php the_permalink() ?>">
			<span class="ticker-sign">
			<?php echo get_option('bf_sign_before_link'); ?>
			</span>
			<?php the_title(); ?>
			</a>
		</li>
		<?php endwhile; ?>
	</ul>
	<a class="ticker-left">
	</a>
	<a class="ticker-right">
	</a>
</div>
<!--ticker-list-box-->

<?php }; ?>