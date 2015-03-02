<?php 
/**
 * Black flag theme header
**/ 
?>
<!DOCTYPE html>
<html <?php language_attributes();?>><head>
<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
<?php wp_title(); ?>
</title>
<!-- keywords description author -->
<meta name="keywords" content="<?php bloginfo( 'keywords' ); ?>" />
<meta name="description" content="<?php bloginfo( 'description' ); ?>" />
<!--apple icon-->
<link rel="apple-touch-icon" href="<?php echo get_option('bf_apple_touch_icon'); ?>"/>
<!--favicon-->
<link rel="shortcut icon" href="<?php echo get_option('bf_favicon'); ?>" />
<!--stylesheet-->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
<!--viewport-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--charset-->
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<!--rss-comments-->
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>"/>
<!--rss-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<!--atom-->
<link rel="alternate" type="application/atom+xml" title="Atom" href="<?php bloginfo('atom_url'); ?>" />
<!--pingback-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--Facebook Open Graph-->
<!--FB page title-->
<meta property="og:title" content="<?php if (! function_exists('bp_is_active') ) {if (is_single() || is_page()) {echo get_the_title();} else {bloginfo('name');}}else {if (is_single() || is_page() && !is_buddypress()) {echo get_the_title();} elseif(is_buddypress()){wp_title();} else {bloginfo('name');}} ?>" />
<!--FB description-->
<meta property="og:description" content="<?php if (is_single() || is_page()) {echo substr(strip_tags($post->post_content), 0, 200); echo '...';} else {bloginfo('description');} ?>"/>
<!--FB url-->
<meta property="og:url" content="<?php if ( is_home() || is_front_page() ){echo home_url();} else{the_permalink();} ?>"/>
<!--FB image-->
<meta property="og:image" content="<?php if (is_single() || is_page()) {$fbthumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'two-thirds-wide-slider-img'); echo $fbthumb[0];} else {header_image();}?>" />
<!--FB type-->
<meta property="og:type" content="<?php if (is_single() || is_page()) { echo "article"; } else { echo "website";} ?>"/>
<!--FB site name-->
<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header id="header">
	<div id="top-navigation">
		<nav id="top-menu">
			<?php if ( has_nav_menu( 'top-menu' ) ) {wp_nav_menu(array('theme_location' => 'top-menu', 'depth' => 1, 'fallback_cb'     => 'wp_page_menu')); } ?>
		</nav>
		<!--top-menu-->
		
		<?php if ( class_exists( 'WooCommerce' ) ) {
			global $woocommerce; if ( sizeof( $woocommerce->cart->cart_contents ) != 0 ) { ?>
			<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">	<?php echo '<span class="cart-top">Cart</span>'; ?> - <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></a>
		<?php }} ?>
		
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
	</div>
	<!--top-navigation-->
	<div id="logo" class="<?php  echo get_option('bf_header_position'); ?>">
		<div id="site-logo">
			<a href="<?php echo home_url(); ?>">
			<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>"/>
			</a>
		</div>
		<!--site-logo-->
		<div id="header-ad">
			<?php echo get_option('bf_header_ad'); ?>
		</div>
		<!--header-ad-->
	</div>
	<!--logo-->
	<div id="nav-wrapper">
		<div id="navigation" class="<?php echo get_option('bf_fixed_menu'); ?>">
			<nav id="main-nav">
				<div class="fixed-logo">
					<a href="<?php echo home_url(); ?>">
					<img src="<?php echo get_option('bf_menu_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/>
					</a>
				</div>
				<!--fixed-logo-->
				<div id="mob-menu">
					&#9776;  
					Menu
				</div>
				<!--mob-menu-->
				<?php if ( has_nav_menu( 'main-menu' ) ) {wp_nav_menu(array(
				'theme_location' => 'main-menu',
				'depth' => 10, 
				'fallback_cb'     => 'wp_page_menu',
				'walker' => new bf_super_menu()
				));}else { echo '<span class=add-menu>ADD MENU</div>';} ?>
				<div class="search-box">
					<?php get_search_form(); ?>
				</div>
				<!--search-box-->
			</nav>
			<!--main-nav-->
		</div>
		<!--navigation-->
	</div>
	<!--nav-wrapper-->
	<div class="ticker-box">
		<?php $bf_display_ticker = get_option('bf_display_ticker'); if ($bf_display_ticker == "true") { ?>
		<div id="ticker">
			<?php ticker(); ?>
		</div>
		<!--ticker-->
		<div class="ticker-title-date">
			<div id="ticker-today-date">
				<?php echo date(get_option('date_format')); ?>
			</div>
			<!--ticker-today-date-->
		</div>
		<!--ticker-title-date-->
		<?php } ?>
	</div>
	<!--ticker-box-->
</header>
<!--header-->

<section id="wrapper" class="hfeed">