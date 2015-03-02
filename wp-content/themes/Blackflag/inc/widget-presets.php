<?php

add_action('admin_menu', 'blackflag_one_button_preset');

function blackflag_one_button_preset() {
	add_theme_page('Black flag one button install widgets', 'Black flag Widget Presets', 'read', 'blackflag_one_button','bf_prearange');
	wp_enqueue_style( 'Black flag one button install widgets style', get_template_directory_uri() . '/inc/bf-widget-presets.css' );
	wp_enqueue_script('observer one button install widgets', get_template_directory_uri() . '/js/bf-one-button-install.js', array('jquery'));
}

function bf_prearange(){
	$bloginfo = get_template_directory_uri();

?>

<div id="demo-picker">
	<ul>

		<li>
			<div class="picker-image">
				<img src="<?php echo $bloginfo; ?>/images/widget-presets/bfdemo1.png"/>
			</div>
			<form method="post">
				<input  type="submit" class="button-secondary" name="preset1" value="<?php echo 'Gaming Demo' ?>"/>
			</form>
		</li>
		<li>
			<div class="picker-image">
				<img src="<?php echo $bloginfo; ?>/images/widget-presets/bfdemo2.png"/>
			</div>
			<form method="post">
				<input  type="submit" class="button-secondary" name="preset2" value="<?php echo 'Magazine demo' ?>"/>
			</form>
		</li>
		<li>
			<div class="picker-image">
				<img src="<?php echo $bloginfo; ?>/images/widget-presets/bfdemo3.png"/>
			</div>
			<form method="post">
				<input  type="submit" class="button-secondary" name="preset3" value="<?php echo 'Blog demo' ?>"/>
			</form>
		</li>
		<li>
			<div class="picker-image">
				<img src="<?php echo $bloginfo; ?>/images/widget-presets/bfdemo4.png"/>
			</div>
			<form method="post">
				<input  type="submit" class="button-secondary" name="preset4" value="<?php echo 'News demo' ?>"/>
			</form>
		</li>
		
		
		<form method="post">
			<input  type="submit" class="button-secondary" name="empty" value="<?php echo 'empty - resets sidebars' ?>"/>
		</form>
		<div class="warrning-button">
			<span>Warning!!!!</span>
			 <div class="warning-text">This will reset the widget layout, logo images, and some other options you currently have. Do you understand?</div>
			 <div class="yesido">Yes</div>
			 <div class="noidont">No</div>
		</div>	
		
		
	</ul>
</div>
<?php
if(isset($_POST) && !empty($_POST['empty'])) {
update_option('sidebars_widgets', array ('wp_inactive_widgets' => array ( )));
update_option('bf_display_latest_posts', 'true');
} elseif (isset($_POST) && !empty($_POST['preset1'])){
	
	//homepage widgets
	
	update_option( 'sidebars_widgets', array ( 'Homepage' => array ( 0 => 'slider_widget_bf-1', 1 => 'jumping_posts_bf-1', 2 => 'blog_category_bf-4', 3 => 'embed_vid_widget_bf-1', 4 => 'bf_blog_posts_bf-3', 5 => 'blog_category_bf-5', 6 => 'tv_widget_bf-1', 7 => 'most_commented_widget_bf-1', 8 => 'img_featured_category_bf-1', 9 =>'ad_widget_sizes_bf-1', 10 =>'small_img_category_bf-1', 11 => 'thumbnails_bf-5', 12=> 'carousel_widget_bf-4', 13 => 'blog_category_bf-5', 14 => 'bf_blog_posts_bf-4', 15 => 'ad_widget_sizes_bf-1', 16 => 'slider_widget_bf-5', 17 => 'thumbnails_bf-6',  )));
	
	update_option('bf_display_latest_posts', 'false');
	update_option('bf_menu_background', '#FFFFFF');
	update_option('bf_menu_border_color', '#e0e0e0');
	update_option('bf_menu_color', '#000000');
	update_option('bf_menu_hover_color', '#7a0028');
	update_option('bf_main_color', '#d20045');
	update_option('bf_overlay_color', '#e80055');
	update_option('bf_slider_word_color', '#d20045');
	update_option('bf_menu_font', 'Open Sans');
	update_option('bf_widget_font', 'Open Sans');
	update_option('bf_fonts', 'Open Sans');
	update_option('bf_header_position', 'logo-left');
	
	update_option('bf_menu_logo', $bloginfo.'/images/menu-logo.png');
	set_theme_mod('header_image', $bloginfo.'/images/logo.png');
	set_theme_mod('background_image', '');
	set_theme_mod('background_color', 'efefef');
	update_option('bf_favicon', $bloginfo.'/images/favicon.png');
	update_option('bf_apple_touch_icon', $bloginfo.'/images/apple-touch-icon.png');
	
}elseif (isset($_POST) && !empty($_POST['preset2'])){

	
	update_option( 'sidebars_widgets', array ( 'Homepage' => array ( 0 => 'slider_widget_bf-4', 1 => 'img_featured_category_bf-4', 2 => 'img_featured_category_bf-5', 3 => 'multiple_categories_bf-1', 4 => 'multiple_categories_bf-1', 5 => 'most_commented_widget_bf-1', 6 => 'ad_widget_sizes_bf-1', 7 => 'multiple_categories_bf-2',8 =>'bf_blog_posts_bf-2', 9 =>'small_img_category_bf-1', 10 => 'thumbnails_bf-1', 11 => 'img_featured_category_bf-4', 12 => 'carousel_widget_bf-1', 13 => 'thumbnails_bf-4', 14 => 'embed_vid_widget_bf-2', 15 => 'jumping_posts_bf-1', )));

	update_option('bf_display_latest_posts', 'false');
	update_option('bf_menu_background', '#2b2922');
	update_option('bf_menu_border_color', '#2b2922');
	update_option('bf_menu_color', '#ffffff');
	update_option('bf_menu_hover_color', '#e74d1a');
	update_option('bf_main_color', '#e74d1a');
	update_option('bf_overlay_color', '#a32500');
	update_option('bf_slider_word_color', '#e74d1a');
	update_option('bf_menu_font', 'Viga');
	update_option('bf_widget_font', 'Bitter');
	update_option('bf_fonts', 'Droid Serif');
	update_option('bf_header_position', 'logo-left');

	
	update_option('bf_menu_logo', $bloginfo.'/images/widget-presets/magazine/magazinemenulogo.png');
	set_theme_mod('header_image', $bloginfo.'/images/widget-presets/magazine/magazinelogo.png');
	set_theme_mod('background_image', '0');
	set_theme_mod('background_color', 'efe4bd');
	update_option('bf_favicon', $bloginfo.'/images/widget-presets/magazine/magazinefavicon.png');
	update_option('bf_apple_touch_icon', $bloginfo.'/images/widget-presets/magazine/magazineappletouchicon.png');
	
	
	
}elseif (isset($_POST) && !empty($_POST['preset3'])){
		
	//homepage widgets
	
	update_option( 'sidebars_widgets', array ( 'Homepage' => array ( 0 => 'blog_category_bf-2', 1 => 'thumbnails_bf-2', 2 => 'most_commented_widget_bf-2', 3 => 'ad_widget_sizes_bf-2', 4 => 'archives-2', 5 => 'author_show_bf-2', 6 => 'categories-2', )));
	
	update_option('bf_display_latest_posts', 'false');
	update_option('bf_menu_background', '#FFFFFF');
	update_option('bf_menu_border_color', '#dddddd');
	update_option('bf_menu_color', '#000000');
	update_option('bf_menu_hover_color', '#dd3333');
	update_option('bf_main_color', '#ff007e');
	update_option('bf_overlay_color', '#ff007e');
	update_option('bf_slider_word_color', '#ff007e');
	update_option('bf_menu_font', 'Open Sans');
	update_option('bf_widget_font', 'Open Sans');
	update_option('bf_fonts', 'Shanti');
	update_option('bf_header_position', 'logo-left');
	
	update_option('bf_menu_logo', $bloginfo.'/images/widget-presets/blog/blogmenulogo.png');
	set_theme_mod('header_image', $bloginfo.'/images/widget-presets/blog/bloglogo.png');
	set_theme_mod('background_image', $bloginfo.'/images/widget-presets/blog/blogbackground.jpg');
	update_option('bf_favicon', $bloginfo.'/images/widget-presets/blog/blogfavicon.png');
	update_option('bf_apple_touch_icon', $bloginfo.'/images/widget-presets/blog/blogappletouchicon.png');
	
	
	

}elseif (isset($_POST) && !empty($_POST['preset4'])){

		//homepage widgets
	
	update_option( 'sidebars_widgets', array ( 'Homepage' => array ( 0 => 'blog_category_bf-3', 1 => 'img_featured_category_bf-3', 2 => 'tv_widget_bf-3', 3 => 'blog_category_bf-1', 4 => 'ad_widget_sizes_bf-3', 5 => 'most_commented_widget_bf-3', 6 => 'thumbnails_bf-3', 7 =>  'jumping_posts_bf-3')
	
	
	
	
	));
	
	update_option('bf_menu_background', '#d72517');
	update_option('bf_menu_border_color', '#d72517');
	update_option('bf_menu_color', '#ffffff');
	update_option('bf_menu_hover_color', '#000000');
	update_option('bf_main_color', '#d72517');
	update_option('bf_overlay_color', '#000000');
	update_option('bf_slider_word_color', '#d72517');
	update_option('bf_menu_font', 'Caudex');
	update_option('bf_widget_font', 'Open Sans');
	update_option('bf_fonts', 'Raleway');
	update_option('bf_header_position', 'logo-center');
	

	
	update_option('bf_menu_logo', $bloginfo.'/images/widget-presets/news/newsmenulogo.png');
	set_theme_mod('header_image', $bloginfo.'/images/widget-presets/news/newslogo.png');
	set_theme_mod('background_image', '');
	set_theme_mod('background_color', 'eaeaea');
	update_option('bf_favicon', $bloginfo.'/images/widget-presets/news/newsfavicon.png');
	update_option('bf_apple_touch_icon', $bloginfo.'/images/widget-presets/news/newsappletouchIcon.png');
	
}


//about us widget

update_option( 'widget_about_bf', array ( 
1 => array ( 'title' =>'About us', 'text' =>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
2 => array ( 'title' =>'About us', 'text' =>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
 '_multiwidget' => 1 ) );
 
//archives widget

update_option( 'widget_archives', array ( 
1 => array ( 'title' => 'My Archives' ),
2 => array ( 'title' => 'My Archives' ),
3 => array ( 'title' => 'My Archives' ),
 '_multiwidget' => 1 ) );
 
 //categories widget

update_option( 'widget_categories', array ( 
1 => array ( 'title' => 'My Archives' ),
2 => array ( 'title' => 'My Categories' ),
3 => array ( 'title' => 'My Archives' ),
 '_multiwidget' => 1 ) );

//thumbnails widget

update_option( 'widget_thumbnails_bf', array ( 
1 => array ( 'title' => 'Thumbnails Widget', 'number' => 5, 'widget_size' => 'one-third', 'categories' => 0 ),
2 => array ( 'title' => 'Thumbnails Widget', 'number' => 5, 'widget_size' => 'one-third', 'categories' => 0 ),
3 => array ( 'title' => 'Thumbnails Widget', 'number' => 6, 'widget_size' => 'one-third', 'categories' => 0 ),
4 => array ( 'title' => 'Thumbnails Widget', 'number' =>7, 'widget_size' => 'one-third', 'categories' => 0 ),
5 => array ( 'title' => 'Thumbnails Widget', 'number' =>9, 'widget_size' => 'one-third', 'categories' => 0 ),
6 => array ( 'title' => 'Thumbnails Widget', 'number' =>12, 'widget_size' => 'three-thirds', 'categories' => 0 ),
 '_multiwidget' => 1 ) );
 
 //author widget

update_option( 'widget_author_show_bf', array ( 
1 => array ( 'title' =>'About me', 'display_author' => '1'),
2 => array ( 'title' =>'About me', 'display_author' => '1'),
3 => array ( 'title' =>'About me', 'display_author' => '1'),
 '_multiwidget' => 1 ) );
 
  //Ad widget

update_option( 'widget_ad_widget_sizes_bf', array ( 
1 => array ( 'title' =>'advertisment', 'text' =>'<img src="'.$bloginfo.'/images/336x280.jpg" alt="336x280ad">', 'ad_size' => 'size2'),
2 => array ( 'title' =>'Our Sponsors', 'text' =>'<img src="'.$bloginfo.'/images/336x280.jpg" alt="336x280ad">', 'ad_size' => 'size2'),
3 => array ( 'title' =>'advertisment', 'text' =>'<img src="'.$bloginfo.'/images/336x280.jpg" alt="336x280ad">', 'ad_size' => 'size2'),
 '_multiwidget' => 1 ) );
 
  //featured categories

update_option( 'widget_featured_list_posts_bf', array ( 
1 => array ( 'title' => 'Featured category', 'widget_size' => 'one-third', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0' ),
2 => array ( 'title' => 'Featured category', 'widget_size' => 'one-third', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0' ),
3 => array ( 'title' => 'Featured category', 'widget_size' => 'one-third', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0'),
 '_multiwidget' => 1 ) );
 
  //tabber

update_option( 'widget_Tabs_bf', array ( 
1 => array ( 'latest_title' => 'Latest','popular_title' => 'Popular','comments_title' => 'Commented', 'latest_number' => 3, 'categories' => 0 ),
2 => array ( 'latest_title' => 'Latest','popular_title' => 'Popular','comments_title' => 'Commented', 'latest_number' => 3, 'categories' => 0 ),
3 => array ( 'latest_title' => 'Latest','popular_title' => 'Popular','comments_title' => 'Commented', 'latest_number' => 3, 'categories' => 0),
 '_multiwidget' => 1 ) );
 
   //tv-widget

update_option( 'widget_tv_widget_bf', array ( 
1 => array ( 'title' => 'New on Theme TV', 'widget_size' => 'one-third' ),
2 => array ('title' => 'New on Theme TV', 'widget_size' => 'one-third'),
3 => array ( 'title' => 'New on Theme TV', 'widget_size' => 'one-third'),
 '_multiwidget' => 1 ) );
 
    //embed-widget

update_option( 'widget_embed_vid_widget_bf', array ( 
1 => array ( 'title' =>'Video of the week', 'widget_size' => 'two-thirds', 'link_to_vid' => 'http://vimeo.com/63186969' ),
2 => array ( 'title' =>'Video of the week', 'widget_size' => 'three-thirds', 'link_to_vid' => 'http://vimeo.com/106535324' ),
3 => array ( 'title' =>'Video', 'widget_size' => 'one-third'),
 '_multiwidget' => 1 ) );
 
   //multiple categories

update_option( 'widget_multiple_categories_bf', array ( 
1 => array ( 'title' => 'Multiple Categories', 'more_categories' => 0, 'widget_size' => 'one-third', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0', ),
2 => array (  'title' => '', 'more_categories' => 0, 'widget_size' => 'two-thirds', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0',  ),
3 => array (  'title' => 'Multiple Categories', 'more_categories' => 0, 'widget_size' => 'one-third', 'category_one' => '0', 'category_two' => '0', 'category_three' => '0', ),
 '_multiwidget' => 1 ) );

//jumping posts

update_option( 'widget_jumping_posts_bf', array ( 
1 => array ('title' => 'Jumping posts', 'number' => 4, 'widget_size' => 'three-thirds', 'categories' => 0 ),
2 => array ('title' => 'Jumping posts', 'number' => 4, 'widget_size' => 'one-third', 'categories' => 0 ), 
3 => array ('title' => 'Jumping posts', 'number' => 4, 'widget_size' => 'three-thirds', 'categories' => 0 ), '_multiwidget' => 1 ) );

//most commented

update_option( 'widget_most_commented_widget_bf', array ( 
1 => array ('title' => 'Most commented', 'number' => 2 ),
2 => array ('title' => 'Most commented', 'number' => 2 ), 
3 => array ('title' => 'Most commented', 'number' => 4 ), '_multiwidget' => 1 ) );

//Blogroll 1

update_option( 'widget_blog_category_bf', array ( 
1 => array ( 'title' => '', 'number' => 8, 'widget_size' => 'two-thirds', 'author' => 'on', 'categories' => 'all', 'image_full_width' => '0', 'excerptnumber'=>'90'),
2 => array ( 'title' => '', 'number' => 8, 'widget_size' => 'two-thirds', 'author' => 'on', 'categories' => 'all', 'image_full_width' => 'on', 'excerptnumber'=>'90' ), 
3 => array ( 'title' => '', 'number' => 9, 'widget_size' => 'three-thirds', 'categories' => 'all', 'author' => 'on', 'image_full_width' => '0', 'excerptnumber'=>'90' ),
4 => array ( 'title' => '', 'number' => 6, 'widget_size' => 'two-thirds', 'author' => 'on', 'categories' => 'all', 'image_full_width' => '0', 'excerptnumber'=>'90'),
5 => array ( 'title' => '', 'number' => 2, 'widget_size' => 'two-thirds', 'author' => 'on', 'categories' => 'all', 'image_full_width' => '0', 'excerptnumber'=>'60'), '_multiwidget' => 1 ) );

//Blogroll 2

update_option( 'widget_bf_blog_posts_bf', array ( 
1 => array ( 'title' => 'Blog Posts', 'number' => 4, 'widget_size' => 'two-thirds', 'categories' => 'all', 'author' => 'on' ),
2 => array ( 'title' => 'Latest Articles', 'number' => 10, 'widget_size' => 'two-thirds', 'categories' => 'all', 'author' => 'on' ), 
3 => array ( 'title' => 'Blog Widget', 'number' => 1, 'widget_size' => 'two-thirds', 'categories' => 'all', 'author' => 'on' ),
4 => array ( 'title' => 'Blog Widget', 'number' => 2, 'widget_size' => 'two-thirds', 'categories' => 'all', 'author' => 'on' ), '_multiwidget' => 1 ) );

//small featured image category

update_option( 'widget_small_img_category_bf', array ( 
1 => array (  'title' => 'Small image category', 'number' => 8, 'review' => 0, 'widget_size' => 'one-third', 'categories' => 0  ),
2 => array (  'title' => 'Small image category', 'number' => 8, 'review' => 0, 'widget_size' => 'two-thirds', 'categories' => 0  ),
3 => array (  'title' => 'Small image category', 'number' => 12, 'review' => 0, 'widget_size' => 'three-thirds', 'categories' => 0  ),
 '_multiwidget' => 1 ) );
 
 //big featured image category

update_option( 'widget_img_featured_category_bf', array ( 
1 => array (  'title' => 'Big image category', 'number' => 2, 'review' => 0, 'widget_size' => 'one-third', 'categories' => 0  ),
2 => array (  'title' => 'Big image category', 'number' => 8, 'review' => 0, 'widget_size' => 'two-thirds', 'categories' => 0  ),
3 => array (  'title' => 'Big image category', 'number' => 4, 'review' => 0, 'widget_size' => 'two-thirds', 'categories' => 0  ),
4 => array (  'title' => '', 'number' => 2, 'review' => 0, 'widget_size' => 'one-third', 'categories' => 0  ),
5 => array (  'title' => '', 'number' => 3, 'review' => 0, 'widget_size' => 'three-thirds', 'categories' => 0  ),
 '_multiwidget' => 1 ) );

//carousel

update_option( 'widget_carousel_widget_bf', array ( 
1 => array (  'title' => 'Carousel Widget', 'number' => 10, 'widget_size' => 'one-third', 'tags' => 0, 'img_size' => '0'),
2 => array (  'title' => 'Carousel Widget', 'number' => 10, 'widget_size' => 'two-thirds', 'tags' => 0, 'img_size' => '0'),
3 => array (  'title' => 'Carousel Widget', 'number' => 10, 'widget_size' => 'three-thirds', 'tags' => 0, 'img_size' => '0'),
4 => array (  'title' => 'Carousel Widget', 'number' => 10, 'widget_size' => 'two-thirds', 'tags' => 0, 'img_size' => 'on'),
 '_multiwidget' => 1 ) );

 //slider

 update_option( 'widget_slider_widget_bf', array ( 
1 => array (  'title' => '', 'number' => 5, 'widget_size' => 'three-thirds', 'tags' => 0, 'slider_control' => 'on'),
2 => array (  'title' => 'Slider Widget', 'number' => 10, 'widget_size' => 'two-thirds', 'tags' => 0, 'slider_control' => 'on'),
3 => array (  'title' => 'Slider Widget', 'number' => 10, 'widget_size' => 'three-thirds', 'tags' => 0, 'slider_control' => 'on'),
4 => array (  'title' => '', 'number' => 5, 'widget_size' => 'two-thirds', 'tags' => 0, 'slider_control' => '0'),
5 => array (  'title' => 'Slider Widget', 'number' => 3, 'widget_size' => 'one-third', 'tags' => 0, 'slider_control' => '0'),
 '_multiwidget' => 1 ) );

}		

?>