<?php 
/**
 * Black flag footer
**/ 
?>
</section>
<!--wrapper-->

<footer id="footer">
	<div class="footer-wrap">
		<?php if(get_option('bf_instagram')||get_option('bf_youtube')||get_option('bf_google')||get_option('bf_pinterest')||get_option('bf_twitter')||get_option('bf_facebook')) { ?>
		<div class="content-social">
			<ul>
				<?php if(get_option('bf_facebook')) { ?>
				<li>
					<a href="http://www.facebook.com/<?php echo get_option('bf_facebook'); ?>" class="fb-social-icon" target="_blank">
					</a>
				</li>
				<?php } ?>
				<?php if(get_option('bf_twitter')) { ?>
				<li>
					<a href="http://www.twitter.com/<?php echo get_option('bf_twitter'); ?>" class="twitter-social-icon" target="_blank">
					</a>
				</li>
				<?php } ?>
				<?php if(get_option('bf_pinterest')) { ?>
				<li>
					<a href="http://www.pinterest.com/<?php echo get_option('bf_pinterest'); ?>" class="pinterest-social-icon" target="_blank">
					</a>
				</li>
				<?php } ?>
				<?php if(get_option('bf_google')) { ?>
				<li>
					<a href="https://plus.google.com/<?php echo get_option('bf_google'); ?>/posts" class="google-social-icon" target="_blank">
					</a>
				</li>
				<?php } ?>
				<?php if(get_option('bf_youtube')) { ?>
				<li>
					<a href="http://www.youtube.com/user/<?php echo get_option('bf_youtube'); ?>" class="youtube-social-icon" target="_blank">
					</a>
				</li>
				<?php } ?>
				<?php if(get_option('bf_instagram')) { ?>
				<li>
					<a href="http://instagram.com/<?php echo get_option('bf_instagram'); ?>" class="instagram-social-icon" target="_blank">
					</a>
				</li>
				<?php } ?>
				<li>
					<a href="<?php bloginfo('rss_url'); ?>" class="rss-social-icon">
					</a>
				</li>
			</ul>
		</div>
		<!--content-social-->
		<?php } ?>
		<nav id="bottom-menu">
			<?php if ( has_nav_menu( 'bottom-menu' ) ) {wp_nav_menu(array('theme_location' => 'bottom-menu', 'depth' => 1));} ?>
		</nav>
		<!--bottom-menu-->
		<div class="copyright">
			<div class="copyright-text">
				<?php echo get_option('bf_copyright'); ?>
			</div>
			<!--copyright-text-->
		</div>
		<!--copyright-->
	</div>
	<!--footer-wrap-->
</footer>
<!--footer-->
<?php wp_footer(); ?>
<?php echo get_option('bf_tracking'); ?>
</body></html>