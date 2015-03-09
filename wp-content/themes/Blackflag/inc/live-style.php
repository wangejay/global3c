<?php 
/**
 * Black flag live-style
**/ 
?>
<?php 

function blackflag_head() {

	$slide_style = get_option('bf_slider_picker');
	if($slide_style == 'slider_fx1'){$slide_picker='slide';}else{$slide_picker='fade';}
	
	$bf_title_picker = get_option('bf_title_picker');
	$bloginfo = get_template_directory_uri();
	$menu_background = get_option('bf_menu_background');
	$menucolor = get_option('bf_menu_color');
	$menu_font_weight = get_option('bf_menu_font_weight');
	$menu_hover_color =  get_option('bf_menu_hover_color');
	$main_color = get_option('bf_main_color');
	$widget_fx = get_option('bf_widget_fx');
	$image_effect = get_option('bf_image_effect');
	$font = get_option('bf_fonts');
	$menu_font = get_option('bf_menu_font');
	$widget_font = get_option('bf_widget_font');
	$search_color = get_option('bf_search_color');
	$menu_border_color = get_option('bf_menu_border_color');
	$slider_word_color = get_option('bf_slider_word_color');
	$overlay_color = get_option('bf_overlay_color');
	$uppercase_title = get_option('bf_uppercase_title');
	$bf_content_font_size = get_option('bf_content_font_size').'px'; 
	$bf_content_line_height = $bf_content_font_size * 1.5.'px';
	$header_img_size = get_custom_header()->width.'px';
	

	

//Css
	echo "

<style type='text/css'>

#post-content{font-size:$bf_content_font_size;line-height:$bf_content_line_height;}

::selection{background:$main_color;}
::-moz-selection{background:$main_color;}
#wp-calendar #today{background:$main_color !important;color:#FFF;text-shadow:none;}
#top-navigation, .widget-title.style_title2{border-top:3px solid $main_color; }
#site-logo{width:$header_img_size;max-width:100%;}
body{font-family:$font;}

#main-nav ul li:hover > .menu-link{color:$menu_hover_color;}
#main-nav ul li > .menu-link{font-weight:$menu_font_weight;}

.widget-title, .tv-featured-title{font-family:$widget_font;}

#main-nav .menu-links.inside-menu, .img-featured-review-score{background:$main_color;}
.sub-meni .menu-links.inside-menu li{background: $menu_background;border-bottom: 1px solid $menu_border_color;}
.sub-meni .menu-links.inside-menu li a{color: $menucolor;}
.menu-links.inside-menu .menu-link:after {border-top: 8px solid $main_color;}
.load-circle{border-bottom:5px solid $main_color;border-right:5px solid $main_color;box-shadow: 0 0 35px $main_color;}
.total-score, .score-width, .bf-blog-posts-thumb:hover .play-icon, .jumping-posts-image:hover .play-icon, .carousel-image:hover .play-icon, .small-image:hover .play-icon{background: $main_color;}
.menu-item .menu-link, #mob-menu{color:$menucolor;}

.flex-active .wide-slider-thumb:after, .post-page-gallery-thumbnails .flex-active-slide:after{border-color:$main_color;}
.sidebar-title-line, ul.tabs li.active, ul.tabs li{border-color:$main_color;}
.blog-comment-count:after{border-top: 8px solid $main_color;}

.blog-comment-count, .blog-post-categories, ul.tabs li.active{background:$main_color;}

.menu-link{border-right:1px solid $menu_border_color;}
#navigation{border-color:$menu_border_color;}
.sub-menu-wrapper{border-top:1px solid $menu_border_color;}

.sub-menu-wrapper{box-shadow: 0 3px 0 0 $main_color, inset -1px 0 0 #ebebeb, 1px 0 0 #FFF;}
.fixed-menu .sub-menu-wrapper{box-shadow: 0 3px 0 0 $main_color, inset -1px 0 0 #ebebeb;}	
.jumping-posts li:hover .jumping-posts-text, .sub-meni .menu-links.inside-menu li:hover{background:$main_color;border-color:$main_color;}
.jumping-posts li:hover .jumping-posts-text:before{border-bottom: 14px solid $main_color;}
.img-featured-review-score:before{border-top: 9px solid $main_color;}
.jumping-posts-category a, .ticker-sign{color:$main_color;}

.most-commented-count a{color:$main_color;}

.widget-title .last-word{color:$main_color;}
.last-word{color:$slider_word_color;}

.small-category li:after, .img-featured li:after, .wide-slider li:after, .solo-slider-container .flexslider li:after{
	opacity:0.6;
background: -moz-linear-gradient(top,  transparent  0%, $overlay_color 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,transparent ), color-stop(100%,$overlay_color)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  transparent  0%,$overlay_color 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  transparent  0%,$overlay_color 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  transparent  0%,$overlay_color 100%); /* IE10+ */
background: linear-gradient(to bottom,  transparent  0%,$overlay_color 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='transparent ', endColorstr='$overlay_color',GradientType=0 ); /* IE6-9 */
}

.submit-button{background:$main_color url($bloginfo/images/search-icon$search_color.png) no-repeat 8px;}
#submit, .woocommerce input#searchsubmit{background:$main_color;}

#ticker-today-date, .ticker-heading{color:$main_color;}
.single-post #post-content:first-letter{font-size:67px; color:$main_color;float: left;line-height: 60px;margin-right: 8px;}

#post-content a, .img-featured-title h2 a:hover, .slide-title a:hover, .blog-post-title h2 a:hover, #ticker a:hover, #top-menu ul li a:hover, .category-tv-icon a, #top-menu-today-date{color:$main_color;}

#wide-containter .flex-control-paging li a:hover, #navigation{background:$menu_background;}
.page-numbers.current, .sticky h2 a, #author-desc h2 a, #author-desc h2, .previous-article a, .next-article a, .slide-info .slide-author a, #cancel-comment-reply-link, .medium-featured-posts-title h2 a:hover, .three-posts-title a:hover, .required, .tagcloud a:hover, .post-tags a:hover, .slider-text-box .category-icon a:hover, #main-nav .menu-text a:hover, .carousel-text a:hover, #main-nav .menu-links.inside-menu li:hover .menu-text a:hover, .bypostauthor a, .post-author a, .three-posts-read-more a:hover, .post-author a:visited, a:hover, .feat-cat-categories a, .featured-posts-title a:hover, .featured-posts-text .category-icon a, .carousel-category a, .category-sidebar-news a, .ticker-cat a, #main-nav ul .category-sidebar-news a, .good-title, .bad-title {color:$main_color;}
#main-nav ul li a, #mob-menu{font-family: Verdana, Arial, Noto Sans CJK TC, Microsoft YaHei, Microsoft JhengHei !important;}
#post-page-title h1{text-transform:$uppercase_title;}
blockquote, .content q.left, .content q{border-left: 2px solid $main_color;color:$main_color;}
.content q.right{border-left:0;border-right: 2px solid $main_color;color:$main_color;}
.img-featured-posts-image:hover .img-featured-title h2:after{border-bottom: 2px solid $main_color;}
@media screen and (max-width: 708px) {#main-nav ul li {background:$menu_background;}#main-nav ul li:hover a{color:$main_color;}}


.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #content input.button.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page #content input.button.alt, .woocommerce .widget_layered_nav_filters ul li a, .woocommerce-page .widget_layered_nav_filters ul li a, .woocommerce .widget_layered_nav ul li.chosen a, .woocommerce-page .widget_layered_nav ul li.chosen a, .woocommerce span.onsale, .woocommerce-page span.onsale, .woocommerce .woocommerce-message:before, .woocommerce-page .woocommerce-message:before, .woocommerce .woocommerce-info:before, .woocommerce-page .woocommerce-info:before, .woocommerce table.cart a.remove:hover, .woocommerce #content table.cart a.remove:hover, .woocommerce-page table.cart a.remove:hover, .woocommerce-page #content table.cart a.remove:hover, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range, .woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li{background:$main_color;}

.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, .woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page #content input.button:hover, .woocommerce-page #main a.button:hover, .woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li, .woocommerce div.product .woocommerce-tabs ul.tabs .active a:hover, span.posted_in a, span.tagged_as a, .woocommerce h1.page-title, .woocommerce .jumping-posts .star-rating, .woocommerce-page .jumping-posts .star-rating, .amount, #header .cart-contents:hover{color:$main_color;}

.woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message, .woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info{border-top:3px solid $main_color; }

.product_meta, .woocommerce div.product div.summary, .woocommerce #content div.product div.summary, .woocommerce-page div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce #reviews #comments ol.commentlist li .comment-text p, .woocommerce-page #reviews #comments ol.commentlist li .comment-text p, .woocommerce #review_form #respond p, .woocommerce-page #review_form #respond p, .woocommerce div.product .woocommerce-tabs .panel, .woocommerce #content div.product .woocommerce-tabs .panel, .woocommerce-page div.product .woocommerce-tabs .panel, .woocommerce-page #content div.product .woocommerce-tabs .panel, .woocommerce #reviews h3, .woocommerce-page #reviews h3{font-size:$bf_content_font_size;line-height:$bf_content_line_height;}


.widget.buddypress div.item-options a, .widget_display_stats dd{color:$main_color;}
#buddypress div.item-list-tabs ul li a span, #buddypress div.item-list-tabs ul li.current a span, #buddypress div.item-list-tabs ul li.selected a span, .widget.buddypress #bp-login-widget-form #bp-login-widget-submit, span.bp-login-widget-register-link a, button#user-submit, .bbp-login-form .bbp-login-links a, tt button.button.submit.user-submit, input#bbp_search_submit {background:$main_color;}


</style>";

//Slider

	echo
	"<script type='text/javascript'>
	
			var slide_picker = '$slide_picker';
			var widget_fx = '$widget_fx';
			var title_picker = '$bf_title_picker';
			var image_effect = '$image_effect';
	</script>";

}

function customizer_css() {
	echo "
	
	<style type='text/css'>
.customize-section .customize-control-image .preview-thumbnail img {max-width:100% !important;max-height:100% !important;}
#customize-control-bf_logo img{width:222px;max-width:222px;}
#customize-control-bf_apple_touch_icon img{width:98px;}
#customize-control-bf_apple_touch_icon .customize-control-title{line-height:16px;margin-bottom:5px;}
#customize-section-bf_images .customize-control{padding-bottom:20px;}
 
    </style>";
}
//Login page css
function custom_login_css() {
    $login_logo = get_header_image();
	$login_logo_height = get_custom_header()->height.'px';
	$login_logo_width = get_custom_header()->width.'px';
	$main_color = get_option('bf_main_color');
	
	
	echo "
	<style type='text/css'>
body.login {background: #FFF;}
.login *{text-align:center;}
.login label{font-size:18px;font-weight:700;color:#000;}

input#rememberme {float: left;height: 17px;width: 17px;margin-right: 12px;margin-top: 2px;}
.login form .forgetmenot label{font-size:16px;}
.forgetmenot{margin:7px 0;}
.login h1 a {background-image: url($login_logo);background-size: $login_logo_width $login_logo_height;width: $login_logo_width;height: $login_logo_height;}
.interim-login #login{width:320px;}
#login {width: 400px;padding: 8% 0 0;margin: auto;}
input#wp-submit{background-color:$main_color;border:0;border-radius:0;font-size:16px;text-transform:uppercase;font-weight:700;color:#FFF !important;padding: 0 12px;height: 30px;line-height: 28px;}
.login form{margin-top:0;box-shadow:none;-webkit-box-shadow:none;padding:30px 0 60px;}
.login #nav{font-size:0;padding:0;}
p#nav a{background-color:$main_color;border:0;border-radius:0;font-size:16px;text-transform:uppercase;font-weight:700;color:#FFF !important;padding: 5px 0px;margin-right:20px; float: left;text-align: center;margin-bottom: 20px;width:100%;}
.login #backtoblog a{color:$main_color;font-size:20px;font-weight:700;}
 p#nav a:hover, input#wp-submit:hover{background-color:#FFF;color:$main_color !important;box-shadow:inset 0 0 10px $main_color;}
 .login #login_error{border-color:$main_color;}
    </style>";
}
//Fonts

function google_font() {
	$font = get_option('bf_fonts');
	$fontmenu = get_option('bf_menu_font');
	$fontwidget = get_option('bf_widget_font');
	$bf_customfont = str_replace( ' ', '+', $font ) . ':400,600,700,800|' . $font;
	$bf_customfontmenu = str_replace( ' ', '+', $fontmenu ) . ':400,600,700,800|' . $fontmenu;
	$bf_customfontwidget = str_replace( ' ', '+', $fontwidget ) . ':400,600,700,800|' . $fontwidget;
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'google-fonts', "$protocol://fonts.googleapis.com/css?subset=latin,latin-ext,cyrillic,cyrillic-ext&family=".$bf_customfont . " rel='stylesheet' type='text/css" );
	wp_enqueue_style( 'google-menu-fonts', "$protocol://fonts.googleapis.com/css?subset=latin,latin-ext,cyrillic,cyrillic-ext&family=".$bf_customfontmenu . " rel='stylesheet' type='text/css" );
	wp_enqueue_style( 'google-widget-fonts', "$protocol://fonts.googleapis.com/css?subset=latin,latin-ext,cyrillic,cyrillic-ext&family=".$bf_customfontwidget . " rel='stylesheet' type='text/css" );
}
add_action('login_head', 'custom_login_css');
add_action( 'wp_enqueue_scripts', 'google_font' );
add_action( 'wp_head', 'blackflag_head');
add_action( 'customize_controls_print_styles', 'customizer_css' );
?>