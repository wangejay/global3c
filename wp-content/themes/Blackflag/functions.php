<?php

// Theme Options

include( 'inc/meta-fields.php' );
include( 'inc/related.php' );
include( 'inc/review.php' );
include( 'inc/super-menu.php' );
include( 'inc/bf-customize.php' );
include( 'inc/live-style.php' );
include( 'inc/bf-help.php' );
include( 'inc/ticker.php' );
include( 'inc/widget-presets.php' );
include( 'inc/gallery.php' );
include( 'inc/latesthome.php' );

//Theme Javascript Files

function blackflag_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script('jquery-masonry');
		wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'));
		wp_enqueue_script('blackflag', get_template_directory_uri() . '/js/bf-scripts.js', array('jquery'));
		wp_enqueue_script('respond', get_template_directory_uri() . '/js/respond.min.js', array('jquery'));	
		wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array('jquery'));	
}
add_action('wp_enqueue_scripts', 'blackflag_scripts');

// Title

function bf_wp_title($title) {
	global $page, $paged, $s;

	// vars
	$the_title = get_bloginfo( 'name', 'display' );
	$site_description = get_bloginfo( 'description', 'display' );
	
	//specific page title
	if (is_home() || is_front_page()) {
		$title = "$the_title - $site_description";
	}elseif( is_single() || is_page() ){
		$title = single_post_title();
	}elseif(is_search()) { 
		$title ="Search results for $s";
	} elseif ( is_404() ){
		$title ="$the_title - not found";
	} elseif(is_archive()){
		$title =single_cat_title()." - $the_title";	
	} else {$title ="$the_title"; }
	
	if (class_exists('Woocommerce')) {
		if(is_shop()) { 
			$title ="Shop - $the_title";	
	}}
	// Add a page number if necessary:
	if ($paged >= 2 || $page >= 2 ) {
		$title .= " - " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
	}
	return $title;
}
add_filter( 'wp_title', 'bf_wp_title', 10, 2 );

// Add RSS links to <head> section

add_theme_support( 'automatic-feed-links' );

//Content Width

if ( ! isset( $content_width ) ) $content_width = 642;

//Background enable

$args = array(
	'default-color' => 'ebebeb',
	'default-image' => get_template_directory_uri() . '/images/widget-presets/blog/blogbackground.jpg',
);
add_theme_support( 'custom-background', $args );

//Header-image enable

$args = array( 
	'flex-height' => true,
 	'flex-width' => true,
	'width'         => 270,
	'height'        => 90,
	'default-image' => get_template_directory_uri() . '/images/logo.png',
	'header-text'   => false,
	'random-default' => false,

);
add_theme_support( 'custom-header', $args );

//Editor-style

function bf_editor_styles() {
    add_editor_style( 'inc/bf-editor-style.css' );
}
add_action( 'init', 'bf_editor_styles' );

//Post Formats

add_theme_support( 'post-formats', array('video', 'aside', 'gallery'));

//Rename Post Format

function rename_post_formats( $rename_format ) {
    if ( $rename_format == 'Aside' )
        return 'Review';

    return $rename_format;
}
add_filter( 'esc_html', 'rename_post_formats' );

function live_rename_formats() { 
    global $post;
    if ( $post == 'post-new.php' || $post == 'post.php' ) { ?>
<script type="text/javascript">
        jQuery('document').ready(function() {
            jQuery("span.post-state-format").each(function() { 
                if ( jQuery(this).text() == "Aside" )
                    jQuery(this).text("Review");             
            });
        });      
        </script>
<?php }
}
add_action('admin_head', 'live_rename_formats');

//Widgets and Areas

		//Areas
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Homepage',
		'id' => 'Homepage',
		'before_widget' => '<div class="home-widget"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	));	
	
	register_sidebar(array(
		'name' => 'Alternative Homepage',
		'id' => 'alternative_homepage',
		'before_widget' => '<div class="home-widget"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	));	

	register_sidebar(array(
		'name' => 'Category Sidebar',
		'id' => 'catsidebar',
		'before_widget' => '<div class="home-widget"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	));
	
	register_sidebar(array(
		'name' => 'Post Sidebar',
		'id' => 'postsidebar',
		'before_widget' => '<div class="home-widget"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	));
	
	register_sidebar(array(
		'name' => 'Page Sidebar',
		'id' => 'pagesidebar',		
		'before_widget' => '<div class="home-widget"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3><div class="widget-title">',
		'after_title' => '</div></h3>',
	));
	
	if (class_exists('Woocommerce')) {		
	register_sidebar(array(
		'name' => 'Woocommerce Sidebar',
		'id' => 'woocommercesidebar',		
		'before_widget' => '<div class="home-widget"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3><div class="widget-title">',
		'after_title' => '</div></h3>',
	));
	}
	
	if(function_exists('bp_is_active')){		
	register_sidebar(array(
		'name' => 'Buddypress Sidebar',
		'id' => 'bpsidebar',		
		'before_widget' => '<div class="home-widget"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3><div class="widget-title">',
		'after_title' => '</div></h3>',
	));
	}
	if ( class_exists('bbPress') ) {
	register_sidebar(array(
		'name' => 'bbPress Sidebar',
		'id' => 'bbpress_sidebar',		
		'before_widget' => '<div class="home-widget"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3><div class="widget-title">',
		'after_title' => '</div></h3>',
	));		
	}
	
	
}



		//Widgets

include("widgets/multiple-categories.php");
include("widgets/small-featured-images.php");
include("widgets/big-featured-images.php");
include("widgets/featured-categories.php");
include("widgets/blogroll1.php");
include("widgets/slider.php");
include("widgets/carousel.php");
include("widgets/jumping-posts.php");
include("widgets/blogroll2.php");
include("widgets/tabber.php");
include("widgets/video.php");
include("widgets/tv-widget.php");
include("widgets/about-us.php");
include("widgets/ad-widget.php");
include("widgets/authors-list.php");
include("widgets/thumbnails.php");
include("widgets/most-commented.php");

		//Widgets style
		
function bf_widgets_style(){
	echo 
"<style type='text/css'>
	div.widget[id*=_bf] .widget-title h4:before {content: '';background: url(".get_template_directory_uri()."/images/stepfox-tiny-logo-widgets.png)no-repeat;width: 16px;height: 16px;float: left;margin-right: 5px;}
	div.widget[id*=_bf] .widget-title h4{color: #0F7BB8;}
	div.widget[id*=_bf] input[type=radio]{height:30px;border-radius:0;width:30%;margin-right:2%;text-indent:0;font-size:12px;line-height:30px;color:#747474;font-weight:700;font-family: Open Sans;background-color: #D1D1D1;text-shadow: 1px 1px 0px #FFF;box-shadow: inset 1px 1px 1px #AAA;}
	div.widget[id*=_bf] input[type=radio]:checked:before{border-radius:0;padding:0;margin:0;height:100%;width:100%;background-color: #0DA000;text-indent:0;font-size:12px;line-height:30px;color:#FFF;font-weight:700;font-family: Open Sans;text-shadow: 1px 1px 0px #000;box-shadow: none;}
	div.widget[id*=_bf] .one-third:before{content: '1/3';}
	div.widget[id*=_bf] .two-thirds:before{content: '2/3';}
	div.widget[id*=_bf] .three-thirds:before{content: '3/3';}
</style>"
;}
add_action('admin_print_styles-widgets.php', 'bf_widgets_style');



// Register Custom Menus

function reg_menus() {
	register_nav_menus(
		array(
			'main-menu' =>'Main Menu',
			'top-menu' => 'Top Menu',
			'bottom-menu' => 'Bottom Menu', )
	  	);
	  }

add_action( 'init', 'reg_menus' );

// Register Thumbnails

if ( function_exists( 'add_theme_support' ) ) {
add_theme_support( 'post-thumbnails' );
add_image_size( 'jumping-posts-thumb', 252, 185, true );
add_image_size( 'two-thirds-wide-slider-img', 672, 436, true );
add_image_size( 'three-thirds-wide-slider-img', 843, 499, true );
add_image_size( 'small-thumb', 75, 75, true );
add_image_size( 'image-featured', 336, 185, true );
add_image_size( 'big-cat-thumb', 276, 184, true );
add_image_size( 'one-third-slider-img', 336, 371, true );
add_image_size( 'two-thirds-slider-img', 672, 371, true );
add_image_size( 'three-thirds-slider-img', 1008, 515, true );
add_image_size( 'big-blog-img', 612, 371, true );
add_image_size( 'post-page-slider-img', 642, 371, true );
add_image_size( 'carousel-thumb', 167, 185, true );
add_image_size( 'big-carousel-thumb', 167, 371, true );
add_image_size( 'slider-thumb', 165, 99, true );
add_image_size( 'review-img', 230, 160, true );
add_image_size( 'one-third-high-img', 276, 305, true );
}


// Excerpt Limit

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
		if(!empty($excerpt)) {
			$excerpt = implode(' ',$excerpt).'...';
		}else{
			$excerpt = '';
		}
  } elseif ( strpos( get_the_excerpt(), 'more-link' ) === false ) {
  	$excerpt = implode(' ',$excerpt).'...';  
  } else {
    $excerpt = implode(' ',$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;

}

function bf_excerpt_length($length) {return 120;}
add_filter('excerpt_length', 'bf_excerpt_length');


//Page view counter

function count_views($postID) {
	if (is_single()) {
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
}

function get_views($postID) {
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0";
		}
		return $count;
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Get the page number

function bf_pagination() {
  global $wp_query;
  $big = 999999999; 
  echo paginate_links ( array (
		  'base' => str_replace ( $big, '%#%', get_pagenum_link ( $big ) ),
		  'format' => '?paged=%#%',
		  'current' => max ( 1, get_query_var ( 'paged' ) ),
		  'total' => $wp_query->max_num_pages,
  ) );	
}

// Video Page number of posts
function video_page_queries( $query ) {
	$bf_tv_widget_style = get_option('bf_tv_widget_style'); 
	if ($bf_tv_widget_style == 'one') {
			if(is_tax() && $query->is_main_query()){
      $query->set('posts_per_page', 50);
    }
	}elseif($bf_tv_widget_style == 'two'||$bf_tv_widget_style == 'three') {
			if(is_tax() && $query->is_main_query()){
      $query->set('posts_per_page', 6);
    }
	}
  }
add_action( 'pre_get_posts', 'video_page_queries' );

// category archive and search number of posts
function archive_page_queries( $query ) {
	$bf_category_number = get_option('bf_category_number'); 
	if (class_exists('Woocommerce')) {
	if(is_archive() && ! is_tax() && $query->is_main_query() && ! is_woocommerce()){
		  $query->set('posts_per_page', $bf_category_number);
    }}else{
	if(is_archive() && ! is_tax() && $query->is_main_query()){
		  $query->set('posts_per_page', $bf_category_number);
    }	
	}

}
add_action( 'pre_get_posts', 'archive_page_queries' );


//wrap embed
function bf_responsive_embed( $the_embed ) {
    return '<div class="video-container">' . $the_embed . '</div>';
}
add_filter( 'embed_oembed_html', 'bf_responsive_embed', 10, 3 );

//woocommerce
add_theme_support( 'woocommerce' );

function wp_enqueue_woocommerce_style(){
    wp_register_style( 'woocommerce', get_template_directory_uri() . '/inc/woocommerce.css' );
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'woocommerce' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
  function jk_related_products_args( $args ) {
 
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // arranged in 2 columns
	return $args;
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
 
if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
	    woocommerce_upsell_display( 4,4 ); // Display 4 products in rows of 4
	}
}

add_filter('loop_shop_per_page', create_function('$cols', 'return 16;') );
//Woocommerce thumbnails dimensions
function blackflagtheme_woocommerce_image_dimensions() {
	global $pagenow;
 
	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}
 
  	$catalog = array(
		'width' 	=> '148',	// px
		'height'	=> '148',	// px
		'crop'		=> 1 		// true
	);
 
	$single = array(
		'width' 	=> '308',	// px
		'height'	=> '308',	// px
		'crop'		=> 1 		// true
	);
 
	$thumbnail = array(
		'width' 	=> '75',	// px
		'height'	=> '75',	// px
		'crop'		=> 0 		// false
	);
 
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}
 
add_action( 'after_switch_theme', 'blackflagtheme_woocommerce_image_dimensions', 1 );

	//buddypress images

	define ( 'BP_AVATAR_THUMB_WIDTH', '75' );
	define ( 'BP_AVATAR_THUMB_HEIGHT', '75' );
	define ( 'BP_AVATAR_FULL_WIDTH', '250' );
	define ( 'BP_AVATAR_FULL_HEIGHT', '250' );
	

?>