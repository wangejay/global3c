<?php 
/**
 * Black flag customizer
**/ 
?>
<?php 
function blackflag_customize( $wp_customize ) {
	//  = Black flag: Sections =
	
	$wp_customize->get_section('title_tagline')->title = 'Site Title, Tagline & Footer copyright text' ;
	$wp_customize->get_section('title_tagline')->priority = '1';

	$wp_customize->get_section('header_image')->title = 'Logo, Favicon, Apple touch icon' ;
	$wp_customize->get_section('header_image')->priority = '2';	
	
	$wp_customize->get_section('colors')->title = 'Theme Colors and Design' ;
	$wp_customize->get_section('colors')->priority = '3';

	$wp_customize->add_section('bf_ticker_section' , array(
			'title' => 'Homepage Latest posts and Ticker',
			'priority' => '4'
	));	

	$wp_customize->add_section('bf_post_page_options' , array(
			'title' => 'Post page option',
			'priority' => '5'
	));
	
	$wp_customize->add_section('bf_category_page_options' , array(
			'title' => 'Category and TV options',
			'priority' => '6'
	));

	$wp_customize->add_section('bf_translate' , array(
			'title' => 'Translate',
			'priority' => '7'
	));
	
	$wp_customize->add_section('bf_social' , array(
			'title' => 'Social settings',
			'priority' => '8'
	));
	
	$wp_customize->add_section('bf_ads_options' , array(
			'title' => 'Ads and tracking',
			'priority' => '9'
	));

	
	//  = Black flag: Colors =
	
	$colors = array();

	$colors[] = array(
			'slug'=>'bf_menu_background',
			'default' => '#FFFFFF',
			'label' => 'Menu background color', 
			'section' => 'colors',
			'priority' => '2'
	);

	$colors[] = array(
			'slug'=>'bf_menu_color',
			'default' => '#000000',
			'label' => 'Menu font color', 
			'section' => 'colors',
			'priority' => '3'
	);
	
	$colors[] = array(
			'slug'=>'bf_menu_hover_color',
			'default' => '#ff6e00',
			'label' => 'Menu hover color', 
			'section' => 'colors',
			'priority' => '3'
	);

	$colors[] = array(
			'slug'=>'bf_main_color',
			'default' => '#ff6e00',
			'label' => 'Main color', 
			'section' => 'colors',
			'priority' => '5'
	);
	
	
	$colors[] = array(
			'slug'=>'bf_slider_word_color',
			'default' => '#ff6e00',
			'label' => 'Slider last words color', 
			'section' => 'colors',
			'priority' => '6'
	);
	
	$colors[] = array(
			'slug'=>'bf_overlay_color',
			'default' => '#ff6e00',
			'label' => 'Overlay images color', 
			'section' => 'colors',
			'priority' => '7'
	);
	
		$colors[] = array(
			'slug'=>'bf_menu_border_color',
			'default' => '#ebebeb',
			'label' => 'Menu border color', 
			'section' => 'colors',
			'priority' => '2'
	);

	foreach( $colors as $color ) {
		$wp_customize->add_setting(
				$color['slug'], array(
						'default' => $color['default'],
						'type' => 'option',
						'capability' =>'edit_theme_options',
						'sanitize_callback' => 'sanitize_hex_color'
				)
		);

		$wp_customize->add_control(
				new WP_Customize_Color_Control(
						$wp_customize,
						$color['slug'],
						array('label' => $color['label'],
								'section' => $color['section'],
								'settings' => $color['slug'],
								'priority' => $color['priority'])
				)
		);
	}
	


		//  = Black flag: Images =

		
		$bfimages = array();
		$bloginfo = get_template_directory_uri();

		
		$bfimages[] = array(
				'slug'=>'bf_apple_touch_icon',
				'default' => $bloginfo.'/images/apple-touch-icon.png',
				'label' => 'Apple touch icon: 129x129 px PNG/JPG image.',
				'priority' => '30'
		);
		
		$bfimages[] = array(
				'slug'=>'bf_favicon',
				'default' => $bloginfo.'/images/favicon.png',
				'label' => 'Favicon: 16x16 px PNG/GIF image.',
				'priority' => '20'
		);
		
		$bfimages[] = array(
				'slug'=>'bf_menu_logo',
				'default' => $bloginfo.'/images/menu-logo.png',
				'label' => 'Flying menu logo 100x36px PNG/GIF/JPG image.',
				'priority' => '20'
		);
		
		foreach( $bfimages as $bfimage ) {		
		
		
		$wp_customize->add_setting($bfimage['slug'], array(
				'capability'        => 'edit_theme_options',
				'type'           => 'option',
				'default' => $bfimage['default'],
				'sanitize_callback' => 'bf_sanitize'
		));
		
		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, $bfimage['slug'], array(
				'label'    => $bfimage['label'],
				'section'  => 'header_image',
				'settings' => $bfimage['slug'],
				'priority' => $bfimage['priority']
		)));
	
	
	
		}
	
	
		//  = Black flag: Text =
		
		
		$bftext = array();
	
		$bftext[] = array(
				'slug'=>'bf_facebook',
				'default' => '',
				'label' => 'Facebook:', 
				'section' => 'bf_social',
				'priority' => '1'
		);
		
		$bftext[] = array(
				'slug'=>'bf_twitter',
				'default' => '',
				'label' => 'Twitter:', 
				'section' => 'bf_social',
				'priority' => '2'
		);
		
		$bftext[] = array(
				'slug'=>'bf_pinterest',
				'default' => '',
				'label' => 'Pinterest:', 
				'section' => 'bf_social',
				'priority' => '3'
		);
		
		$bftext[] = array(
				'slug'=>'bf_google',
				'default' => '',
				'label' => 'Google:', 
				'section' => 'bf_social',
				'priority' => '4'
		);
		
		$bftext[] = array(
				'slug'=>'bf_youtube',
				'default' => '',
				'label' => 'Youtube:', 
				'section' => 'bf_social',
				'priority' => '5'
		);
		
		$bftext[] = array(
				'slug'=>'bf_instagram',
				'default' => '',
				'label' => 'Instagram:', 
				'section' => 'bf_social',
				'priority' => '6'
		);

		$bftext[] = array(
				'slug'=>'bf_word_before_author',
				'default' => 'by',
				'label' => 'Word before author(eg. by, from, posted by)', 
				'section' => 'bf_translate',
				'priority' => '1'
		);
		
		$bftext[] = array(
				'slug'=>'bf_word_before_category',
				'default' => 'Latest in:',
				'label' => 'Category page:Word before Category title', 
				'section' => 'bf_translate',
				'priority' => '1'
		);
			
		
		$bftext[] = array(
				'slug'=>'bf_search_translate',
				'default' => 'Search',
				'label' => 'Search', 
				'section' => 'bf_translate',
				'priority' => '3'
		);
			
		$bftext[] = array(
				'slug'=>'bf_post_tags_title',
				'default' => 'Tags',
				'label' => 'Post page: Tags title', 
				'section' => 'bf_translate',
				'priority' => '4'
		);

		$bftext[] = array(
				'slug'=>'bf_post_category_title',
				'default' => 'Categories',
				'label' => 'Post page: Categories title', 
				'section' => 'bf_translate',
				'priority' => '4'
		);

		$bftext[] = array(
				'slug'=>'bf_share_this_article',
				'default' => 'SHARE THIS ARTICLE',
				'label' => 'Post page: share', 
				'section' => 'bf_translate',
				'priority' => '4'
		);
		
		$bftext[] = array(
				'slug'=>'bf_share_this_video',
				'default' => 'SHARE THIS VIDEO',
				'label' => 'TV page: share', 
				'section' => 'bf_translate',
				'priority' => '4'
		);
		
		$bftext[] = array(
				'slug'=>'bf_older_article',
				'default' => 'OLDER ARTICLE',
				'label' => 'Post page: Older article', 
				'section' => 'bf_translate',
				'priority' => '5'
		);
		
		$bftext[] = array(
				'slug'=>'bf_next_article',
				'default' => 'NEXT ARTICLE',
				'label' => 'Post page: next article', 
				'section' => 'bf_translate',
				'priority' => '6'
		);
		
		
		$bftext[] = array(
				'slug'=>'bf_related_by',
				'default' => 'RELATED BY',
				'label' => 'Post page: related widget title', 
				'section' => 'bf_translate',
				'priority' => '7'
		);

		$bftext[] = array(
				'slug'=>'bf_category_popular_title',
				'default' => 'Popular Posts',
				'label' => 'Category page: Popular posts widget title', 
				'section' => 'bf_translate',
				'priority' => '7'
		);
	
		$bftext[] = array(
				'slug'=>'bf_tv_carousel_title',
				'default' => 'BROWSE MORE VIDEOS',
				'label' => 'Tv title', 
				'section' => 'bf_translate',
				'priority' => '10'
		);
		
		$bftext[] = array(
				'slug'=>'bf_gallery_carousel_title',
				'default' => 'BROWSE MORE GALLERIES',
				'label' => 'Gallery title', 
				'section' => 'bf_translate',
				'priority' => '10'
		);
		
		$bftext[] = array(
				'slug'=>'bf_review_page_title',
				'default' => 'Reviews',
				'label' => 'Reviews title', 
				'section' => 'bf_translate',
				'priority' => '10'
		);
		
			
		$bftext[] = array(
				'slug'=>'bf_comments_post_comment',
				'default' => 'Post comment',
				'label' => 'Comments: Post comment', 
				'section' => 'bf_translate',
				'priority' => '12'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_post_reply',
				'default' => 'Leave a Reply',
				'label' => 'Comments: Leave a Reply', 
				'section' => 'bf_translate',
				'priority' => '13'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_post_reply_to',
				'default' => 'Leave a Reply to',
				'label' => 'Comments: Leave a Reply to', 
				'section' => 'bf_translate',
				'priority' => '14'
		);
		
		
		$bftext[] = array(
				'slug'=>'bf_comments_cancel_reply',
				'default' => 'Cancel reply',
				'label' => 'Comments: Cancel reply', 
				'section' => 'bf_translate',
				'priority' => '15'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_logged_in_as',
				'default' => 'Logged in as',
				'label' => 'Comments: Logged in as', 
				'section' => 'bf_translate',
				'priority' => '15'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_logged_in_as_log_out',
				'default' => 'Log out',
				'label' => 'Comments: Log out', 
				'section' => 'bf_translate',
				'priority' => '15'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_name',
				'default' => 'Name',
				'label' => 'Comments: Name', 
				'section' => 'bf_translate',
				'priority' => '16'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_email',
				'default' => 'Email',
				'label' => 'Comments: Email', 
				'section' => 'bf_translate',
				'priority' => '17'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_website',
				'default' => 'Website',
				'label' => 'Comments: Website', 
				'section' => 'bf_translate',
				'priority' => '18'
		);
				
		$bftext[] = array(
				'slug'=>'bf_comments_no_comment',
				'default' => 'No Comment',
				'label' => 'Comments: No Comment', 
				'section' => 'bf_translate',
				'priority' => '19'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_one_comment',
				'default' => 'One Comment',
				'label' => 'Comments: One Comment', 
				'section' => 'bf_translate',
				'priority' => '20'
		);
		
		$bftext[] = array(
				'slug'=>'bf_comments_number_comments',
				'default' => 'Comments on this post.',
				'label' => 'Comments: Number of comments on this post.(the line after the number)', 
				'section' => 'bf_translate',
				'priority' => '21'
		);
		
		$bftext[] = array(
				'slug'=>'bf_ticker_number',
				'default' => '5',
				'label' => 'Ticker number of posts to display', 
				'section' => 'bf_ticker_section',
				'priority' => '100'
		);	
		
		$bftext[] = array(
				'slug'=>'bf_category_number',
				'default' => '9',
				'label' => 'Number of posts to show', 
				'section' => 'bf_category_page_options',
				'priority' => '100'
		);	
		
		$bftext[] = array(
				'slug'=>'bf_ticktitle',
				'default' => 'Breaking News',
				'label' => 'Ticker title', 
				'section' => 'bf_translate',
				'priority' => '2'
		);			
		
		$bftext[] = array(
				'slug'=>'bf_sign_before_link',
				'default' => '+',
				'label' => 'Symbol before post links', 
				'section' => 'colors',
				'priority' => '100'
		);			
		
		$bftext[] = array(
				'slug'=>'bf_copyright',
				'default' => 'Copyright 2013 Black flag Theme.Powered by Wordpress.',
				'label' => 'Footer copyright text', 
				'section' => 'title_tagline',
				'priority' => '10'
		);
	
		foreach( $bftext as $bf_text ) {
			
			
			$wp_customize->add_setting($bf_text['slug'], array(
					'default'        => $bf_text['default'],
					'capability'     => 'edit_theme_options',
					'type'           => 'option',
					'sanitize_callback' => 'bf_sanitize'
			
			));
			
			$wp_customize->add_control($bf_text['slug'], array(
					'label'      => $bf_text['label'],
					'section'    => $bf_text['section'],
					'settings'   => $bf_text['slug'],
					'priority'   => $bf_text['priority'],
			));
					
		}
		
		
		
		
		
		
		
		//  = Black flag: Dropdown =
		
		$bf_tags = array();
		
		$bf_tags_obj = get_tags('hide_empty=0');
		
		foreach ($bf_tags_obj as $bf_tag) {
		
			$bf_tags[$bf_tag->slug] = $bf_tag->slug;}
		
			$tags_tmp = array_unshift($bf_tags, 'Select a tag:');
			
			
			
			$fonts_list = array(
				'Asap' => 'Asap',
				'Asul' => 'Asul',		
				'Bitter' => 'Bitter',
				'Caudex' => 'Caudex',
				'Droid Sans' => 'Droid Sans',
				'Droid Serif' => 'Droid Serif',
				'Electrolize' => 'Electrolize',
				'Hanuman' => 'Hanuman',
				'Jura' => 'Jura',
				'Kameron' => 'Kameron',
				'Kotta One' => 'Kotta One',
				'Lato' => 'Lato',
				'Lora' => 'Lora',
				'Magra' => 'Magra',
				'Maven Pro' => 'Maven Pro',
				'Metrophobic' => 'Metrophobic',
				'Molengo' => 'Molengo',
				'Open Sans' => 'Open Sans',
				'PT Sans' => 'PT Sans',
				'PT Serif' => 'PT Serif',
				'Play' => 'Play',
				'Podkova' => 'Podkova',
				'Pontano Sans' => 'Pontano Sans',
				'Quattrocento Sans' => 'Quattrocento Sans',
				'Raleway' => 'Raleway',
				'Rosario' => 'Rosario',
				'Shanti' => 'Shanti',
				'Share' => 'Share',
				'Signika' => 'Signika',
				'Telex' => 'Telex',
				'Tinos' => 'Tinos',
				'Ubuntu' => 'Ubuntu',
				'Vidaloka' => 'Vidaloka',
				'Viga' => 'Viga'				
			);
					
			$bf_dropdowns = array();

			$bf_dropdowns[] = array(
					'slug'=>'bf_display_latest_posts',
					'default' => 'true',
					'label' => 'Show homepage latest posts', 
					'section' => 'bf_ticker_section',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
		
					));	
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_ticker_tags',
					'default' => 'Select a tag:',
					'label' => 'Ticker posts tag:', 
					'section' => 'bf_ticker_section',
					'choices' => $bf_tags,
			);
			
			$bf_dropdowns[] = array(
					'slug'=>'bf_display_ticker',
					'default' => 'true',
					'label' => 'Show Ticker and Date', 
					'section' => 'bf_ticker_section',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
		
					));	
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_title_picker',
					'default' => 'style_title1',
					'label' => 'Widget title style', 
					'section' => 'colors',
					'choices'    => array(
							'style_title1' => 'Style 1',
							'style_title2' => 'Style 2',
							'style_title3' => 'Style 3',
							'style_title4' => 'Style 4',
							'style_title5' => 'Style 5',
						
					));		
							
			$bf_dropdowns[] = array(
					'slug'=>'bf_slider_picker',
					'default' => 'slider_fx2',
					'label' => 'Slider transition', 
					'section' => 'colors',
					'choices'    => array(
							'slider_fx1' => 'Slide ',
							'slider_fx2' => 'Fade ',
							'slider_fx3' => 'Pop ',
							'slider_fx4' => 'Move up ',
							'slider_fx5' => 'Drop in',
							'slider_fx6' => 'Rise from bottom',
							'slider_fx7' => 'Clapper',
							'slider_fx8' => 'Zoom',
							'slider_fx9' => 'Black and white',							
					));
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_image_effect',
					'default' => 'image_fx1',
					'label' => 'Image Effect:', 
					'section' => 'colors',
					'choices'    => array(
							'image_fx1' => 'None',
							'image_fx2' => 'Pop',
							'image_fx3' => 'Black and white',
							'image_fx4' => 'Saturation',
							'image_fx5' => 'Opacity',				
					));
							
			$bf_dropdowns[] = array(
					'slug'=>'bf_search_color',
					'default' => '',
					'label' => 'Search Icon Color', 
					'section' => 'colors',
					'choices'    => array(
							'-black' => 'Black',
							'' => 'White',
		
					));
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_fixed_menu',
					'default' => 'show-menu',
					'label' => 'Menu follow with scroll', 
					'section' => 'colors',
					'choices'    => array(
							'show-menu' => 'Show',
							'' => 'Hide',
		
					));
			
			$bf_dropdowns[] = array(
					'slug'=>'bf_fonts',
					'default' => 'Open Sans',
					'label' => 'Main Font', 
					'section' => 'colors',
					'choices'    => $fonts_list
	
					);
			
			$bf_dropdowns[] = array(
					'slug'=>'bf_menu_font',
					'default' => 'Open Sans',
					'label' => 'Menu Font', 
					'section' => 'colors',
					'choices'    => $fonts_list
			
			);
			
			$bf_dropdowns[] = array(
					'slug'=>'bf_menu_font_weight',
					'default' => '400',
					'label' => 'Menu Font Weight', 
					'section' => 'colors',
					'choices'    => array(
							'400' => 'Regular',
							'600' => 'Semi-bold',
							'700' => 'Bold',
			));
			
			$bf_dropdowns[] = array(
					'slug'=>'bf_widget_font',
					'default' => 'Open Sans',
					'label' => 'Widget title font', 
					'section' => 'colors',
					'choices'    => $fonts_list
			
			);
						
			$bf_dropdowns[] = array(
					'slug'=>'bf_widget_fx',
					'default' => 'widgetfx-1',
					'label' => 'Widget load effect', 
					'section' => 'colors',
					'choices'    => array(
							'' => 'no effect',
							'widgetfx-1' => 'Fade in',
							'widgetfx-2' => 'Move up',
							'widgetfx-3' => 'Scale up',
							'widgetfx-4' => 'Rubber band',
							'widgetfx-5' => 'Bounce up',
							'widgetfx-6' => 'Pulse',
							'widgetfx-7' => 'Fade in up',
							'widgetfx-8' => 'Pop up',
							'widgetfx-9' => 'Bounce',
		
					));		
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_header_position',
					'default' => 'logo-left',
					'label' => 'Logo position', 
					'section' => 'header_image',
					'choices'    => array(
							'logo-left' => 'Left',
							'logo-center' => 'Center',
					));		

			$bf_dropdowns[] = array(
					'slug'=>'bf_uppercase_title',
					'default' => 'uppercase',
					'label' => 'Title Uppercase', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'uppercase' => 'On',
							'none' => 'Off',	
					));	
									
											
			$bf_dropdowns[] = array(
					'slug'=>'bf_content_font_size',
					'default' => '13',
					'label' => 'Content font size', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'12' => '12px',
							'13' => '13px',
							'14' => '14px',
							'15' => '15px',
							'16' => '16px',
							'17' => '17px',
							'18' => '18px',

		
					));	

			$bf_dropdowns[] = array(
					'slug'=>'bf_post_media_size',
					'default' => 'true',
					'label' => 'Featured media size', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'true' => 'Full width',
							'false' => '2/3',
							'off' => 'Media off',
		
					));		
	
			$bf_dropdowns[] = array(
					'slug'=>'bf_share_post',
					'default' => 'true',
					'label' => 'Share buttons', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
		
					));			
			
			$bf_dropdowns[] = array(
					'slug'=>'bf_post_tags',
					'default' => 'true',
					'label' => 'Post tags', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
		
					));	
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_post_categories',
					'default' => 'true',
					'label' => 'Post categories', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
		
					));			
	
			$bf_dropdowns[] = array(
					'slug'=>'bf_author_box',
					'default' => 'true',
					'label' => 'Author-box', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
		
					));
			
			$bf_dropdowns[] = array(
					'slug'=>'bf_show_comments',
					'default' => 'true',
					'label' => 'Comments', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
			
					));
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_next_prev_links',
					'default' => 'true',
					'label' => 'Navigation Links', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
			
					));					
			
		
			$bf_dropdowns[] = array(
					'slug'=>'bf_related',
					'default' => 'true',
					'label' => 'Related Posts', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
			
					));
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_popular_widget',
					'default' => 'true',
					'label' => 'Popular Posts', 
					'section' => 'bf_category_page_options',
					'choices'    => array(
							'true' => 'Show',
							'false' => 'Hide',
			
					));
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_related_choice',
					'default' => 'tags',
					'label' => 'Chose related posts', 
					'section' => 'bf_post_page_options',
					'choices'    => array(
							'tags' => 'Tags',
							'category' => 'Category',
							'author' => 'Author',
			
					));					

					
			$bf_dropdowns[] = array(
					'slug'=>'bf_category_post_size',
					'default' => 'one-third',
					'label' => 'Category post size', 
					'section' => 'bf_category_page_options',
					'choices'    => array(
							'one-third' => 'Style 1',
							'two-thirds' => 'Style 2',
							'three-thirds' => 'Fullwidth',
			
					));
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_popular_post',
					'default' => 'forever',
					'label' => 'Popular Posts Time', 
					'section' => 'bf_category_page_options',
					'choices'    => array(
							'week' => 'week',
							'month' => 'month',
							'year' => 'year',
							'forever' => 'forever',
			
					));	
					
			$bf_dropdowns[] = array(
					'slug'=>'bf_tv_widget_style',
					'default' => 'one',
					'label' => 'TV-Widget-Style', 
					'section' => 'bf_category_page_options',
					'choices'    => array(
							'one' => 'Style 1',
							'two' => 'Style 2',
							'three' => 'Style 3',		
					));		
									
			foreach( $bf_dropdowns as $bf_dropdown ) {
					
					
				$wp_customize->add_setting($bf_dropdown['slug'], array(
						'default'        => $bf_dropdown['default'],
						'capability'     => 'edit_theme_options',
						'type'           => 'option',
						'sanitize_callback' => 'bf_sanitize'
							
				));
					
				$wp_customize->add_control($bf_dropdown['slug'], array(
						'label'      => $bf_dropdown['label'],
						'section'    => $bf_dropdown['section'],
						'settings'   => $bf_dropdown['slug'],
						'choices' => $bf_dropdown['choices'],
						'type'    => 'select',
				));
					
			}
		
			
			
			//  = Black flag: Dropdown =
			
			class textarea_control extends WP_Customize_Control {
				public $type = 'textarea';
					
				public function render_content() {
					?>

			<label>
					<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
					</span>
					<textarea rows="5" style="width:100%;" <?php $this->link(); ?>>
			<?php echo esc_textarea( $this->value() ); ?>
			</textarea>
			</label>
<?php
						    }
						}			
			
			
			$bftextareas = array();


			$bftextareas[] = array(
					'slug'=>'bf_header_ad',
					'default' => '<img src="'.$bloginfo.'/images/728x90.jpg" alt="728x90ad">',
					'label' => 'Header ad 728x90',
					'section' => 'bf_ads_options',
			);
			
			$bftextareas[] = array(
					'default' => '',
					'slug'=>'bf_tracking',
					'label' => 'Paste your Google Analytics (or other) tracking code here.',
					'section' => 'bf_ads_options'
			);
			
		foreach( $bftextareas as $bftextarea ) {
			
			$wp_customize->add_setting($bftextarea['slug'], array(
					'default'        => $bftextarea['default'],
					'capability'     => 'edit_theme_options',
					'type'           => 'option',
					'sanitize_callback' => 'bf_sanitize'
			) );
			
			$wp_customize->add_control( new textarea_control( $wp_customize, $bftextarea['slug'], array(
					'label'   => $bftextarea['label'],
					'section' => 'bf_ads_options',
					'settings'   => $bftextarea['slug'],
			) ) );
			
		}
		
function bf_sanitize($input) {return $input;}
	
}
add_action( 'customize_register', 'blackflag_customize' );
?>