<?php
/**
* 主題函式庫
*
* @file 		 theme-functions.php
* @package	 StartPress Business
* @author	 StartPress Team - Carrie
* @copyright	 2014 StartPress Studio
* @version	 1.0.1
* @link		 http://startpress.cc
*/

/*-----------------------------------------------------------------------------------*/
# 獲取主題選項
/*-----------------------------------------------------------------------------------*/
function stf_get_option( $name ) {
	$get_options = get_option( 'stf_options' );
	
	if( !empty( $get_options[$name] ))
		return $get_options[$name];
		
	return false ;
}

/*-----------------------------------------------------------------------------------*/
# 設定主題
/*-----------------------------------------------------------------------------------*/
add_action( 'after_setup_theme', 'stf_setup' );
function stf_setup() {

	add_theme_support( 'automatic-feed-links' );

	add_filter( 'enable_post_format_ui', '__return_false' );

	register_nav_menus( array(
		'top-menu' => '頂端選單導航',
		'primary' => '主要選單導航'
	) );
	
}

/*-----------------------------------------------------------------------------------*/
# 文章縮略圖
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) 
	add_theme_support( 'post-thumbnails' );


if ( function_exists( 'add_image_size' ) && !stf_get_option( 'timthumb' ) ){
	add_image_size( 'stf-small', 55, 55, true );
	add_image_size( 'stf-medium', 272, 125, true );
	add_image_size( 'stf-large', 290, 195, true );
	add_image_size( 'slider', 660, 330, true );
	add_image_size( 'big-slider', 995, 498, true );
}


/*-----------------------------------------------------------------------------------*/
# 如果選單不存在
/*-----------------------------------------------------------------------------------*/
function stf_nav_fallback(){
	echo '<div class="menu-alert">'.'你可以使用 WordPress 選單產生器來建立選單'.'</div>';
}


/*-----------------------------------------------------------------------------------*/
# 手機選單
/*-----------------------------------------------------------------------------------*/
function stf_alternate_menu( $args = array() ) {			
	$output = '';
		
	@extract($args);						
			
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {	
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );						
		$menu_items = wp_get_nav_menu_items( $menu->term_id );				
		$output = "<select id='". $id. "'>";
		$output .= "<option value='' selected='selected'>" . '前往...' . "</option>";
		foreach ( (array) $menu_items as $key => $menu_item ) {
		    $title = $menu_item->title;
		    $url = $menu_item->url;
				    
		    if ( $menu_item->menu_item_parent ) {
				$title = ' - ' . $title;
		    }
		    $output .= "<option value='" . $url . "'>" . $title . '</option>';
		}
		$output .= '</select>';
	}
	return $output;							
}
	
	
/*-----------------------------------------------------------------------------------*/
# 自訂控制台登入頁面的 logo 圖片
/*-----------------------------------------------------------------------------------*/
function stf_login_logo(){
	if( stf_get_option('dashboard_logo') )
    echo '<style  type="text/css"> .login h1 a {  background-image:url('.stf_get_option('dashboard_logo').')  !important; background-size: 274px 63px; width: 326px; height: 67px; } </style>';  
}  
add_action('login_head',  'stf_login_logo'); 

function stf_login_logo_url() {
   	 return stf_get_option('dashboard_logo_url');
}
if( stf_get_option('dashboard_logo_url') )
add_filter( 'login_headerurl', 'stf_login_logo_url' );

/*-----------------------------------------------------------------------------------*/
# 自訂 Gravatar 大頭貼
/*-----------------------------------------------------------------------------------*/
function stf_custom_gravatar ($avatar) {
	$stf_gravatar = stf_get_option( 'gravatar' );
	if($stf_gravatar){
		$custom_avatar = stf_get_option( 'gravatar' );
		$avatar[$custom_avatar] = "自定顯示大頭貼( Gravatar )";
	}
	return $avatar;
}
add_filter( 'avatar_defaults', 'stf_custom_gravatar' ); 


/*-----------------------------------------------------------------------------------*/
# 自訂 Favicon 圖示
/*-----------------------------------------------------------------------------------*/
function stf_favicon() {
	$default_favicon = get_template_directory_uri()."/favicon.ico";
	$custom_favicon = stf_get_option('favicon');
	$favicon = (empty($custom_favicon)) ? $default_favicon : $custom_favicon;
	echo '<link rel="shortcut icon" href="'.$favicon.'" title="Favicon 圖示" />';
}
add_action('wp_head', 'stf_favicon');


/*-----------------------------------------------------------------------------------*/
# 獲取首頁分類目錄的區塊
/*-----------------------------------------------------------------------------------*/
function stf_get_home_cats($cat_data){

	switch( $cat_data['type'] ){
	
		case 'n':
			get_home_cats( $cat_data );
			break;
		
		case 's':
			get_home_scroll( $cat_data );
			break;
			
		case 'news-pic':
			get_home_news_pic( $cat_data );
			break;
			
		case 'videos':
			get_home_news_videos( $cat_data );
			break;	
			
		case 'recent':
			get_home_recent( $cat_data );
			break;	
			
		case 'divider': ?>
			<div class="divider" style="height:<?php if( !empty($cat_data['height']) ) echo $cat_data['height'] ?>px"></div>
			<div class="clear"></div>
		<?php
			break;
			
		case 'ads': ?>
			<div class="home-ads">
			<?php
				if( !empty($cat_data['text']) ){
					if( function_exists('icl_t') ) $custom_text = icl_t( theme_name , $cat_data['boxid'] , $cat_data['text']); else $custom_text = $cat_data['text'];
					echo do_shortcode( htmlspecialchars_decode(stripslashes ( $custom_text ) ));
				}?>
			</div>
			<div class="clear"></div>
		<?php
			break;
	}
}



/*-----------------------------------------------------------------------------------*/
# 在搜尋結果頁中排除網站頁面
/*-----------------------------------------------------------------------------------*/
function stf_Search_Filter($query) {
	if( $query->is_search ){
		if ( stf_get_option( 'search_exclude_pages' ) && !is_admin() ){
			$post_types = get_post_types(array( 'public' => true, 'exclude_from_search' => false ));
			unset($post_types['page']);
			$query->set('post_type', $post_types );
		}
		if ( stf_get_option( 'search_cats' ))
			$query->set( 'cat', stf_get_option( 'search_cats' ) && !is_admin() );
	}
	return $query;
}
add_filter('pre_get_posts','stf_Search_Filter');


/*-----------------------------------------------------------------------------------*/
#作者區塊
/*-----------------------------------------------------------------------------------*/
function stf_author_box($avatar = true , $social = true ){
	if( $avatar ) : ?>
	<div class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'MFW_author_bio_avatar_size', 60 ) ); ?>
	</div><!-- #author-avatar -->
	<?php endif; ?>
		<div class="author-description">
			<?php the_author_meta( 'description' ); ?>
		</div><!-- #author-description -->
	<?php  if( $social ) :	?>	
		<div class="author-social">
			<?php if ( get_the_author_meta( 'url' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'url' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的網站"><img src="<?php echo get_template_directory_uri(); ?>/images/author_site.png" width="18" height="18" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'twitter' ) ) : ?>
			<a class="ttip" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的 Twitter"><img src="<?php echo get_template_directory_uri(); ?>/images/author_twitter.png" width="18" height="18" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'facebook' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'facebook' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的 Facebook"><img src="<?php echo get_template_directory_uri(); ?>/images/author_facebook.png" width="18" height="18" alt="" /></a>
			<?php endif ?>
			<?php if ( get_the_author_meta( 'google' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'google' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的 Google+"><img src="<?php echo get_template_directory_uri(); ?>/images/author_google.png" width="18" height="18" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'linkedin' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'linkedin' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的 Linkedin"><img src="<?php echo get_template_directory_uri(); ?>/images/author_linkedin.png" width="18" height="18" alt="" /></a>
			<?php endif ?>				
			<?php if ( get_the_author_meta( 'flickr' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'flickr' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的 Flickr"><img src="<?php echo get_template_directory_uri(); ?>/images/author_flickr.png" width="18" height="18" alt="" /></a>
			<?php endif ?>	
			<?php if ( get_the_author_meta( 'youtube' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'youtube' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的 YouTube"><img src="<?php echo get_template_directory_uri(); ?>/images/author_youtube.png" width="18" height="18" alt="" /></a>
			<?php endif ?>
			<?php if ( get_the_author_meta( 'pinterest' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'pinterest' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的 Pinterest"><img src="<?php echo get_template_directory_uri(); ?>/images/author_pinterest.png" width="18" height="18" alt="" /></a>
			<?php endif ?>
			<?php if ( get_the_author_meta( 'instagram' ) ) : ?>
			<a class="ttip" href="<?php the_author_meta( 'instagram' ); ?>" title="<?php the_author_meta( 'display_name' ); ?> 的 Instagram"><img src="<?php echo get_template_directory_uri(); ?>/images/author_instagram.png" width="18" height="18" alt="" /></a>
			<?php endif ?>	
		</div>
	<?php endif; ?>
	<div class="clear"></div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
# 社交網站 
/*-----------------------------------------------------------------------------------*/
function stf_get_social($newtab='yes', $icon_size='32', $tooltip='ttip'){
	$social = stf_get_option('social');
	@extract($social);
		
	if ($newtab == 'yes') $newtab = "target=\"_blank\"";
	else $newtab = '';
		
	$icons_path =  get_template_directory_uri().'/images';
		
		?>
		<div class="social-icons icon_<?php echo $icon_size; ?>">
		<?php
		// RSS
		if ( !stf_get_option('rss_icon') ){
		if ( stf_get_option('rss_url') != '' && stf_get_option('rss_url') != ' ' ) $rss = stf_get_option('rss_url') ;
		else $rss = get_bloginfo('rss2_url'); 
			?><a class="<?php echo $tooltip; ?>" title="RSS 訂閱" href="<?php echo $rss ; ?>" <?php echo $newtab; ?>><i class="stficon-rss"></i></a><?php 
		}
		// Google+
		if ( !empty($google_plus) && $google_plus != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Google+" href="<?php echo $google_plus; ?>" <?php echo $newtab; ?>><i class="stficon-gplus"></i></a><?php 
		}
		// Facebook
		if ( !empty($facebook) && $facebook != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="加入我們的 Facebook" href="<?php echo $facebook; ?>" <?php echo $newtab; ?>><i class="stficon-facebook"></i></a><?php 
		}
		// Twitter
		if ( !empty($twitter) && $twitter != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="追蹤我們的 Twitter" href="<?php echo $twitter; ?>" <?php echo $newtab; ?>><i class="stficon-twitter"></i></a><?php
		}		
		// Pinterest
		if ( !empty($Pinterest) && $Pinterest != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="關注我們的 Pinterest" href="<?php echo $Pinterest; ?>" <?php echo $newtab; ?>><i class="stficon-pinterest-circled"></i></a><?php
		}
		// LinkedIN
		if ( !empty($linkedin) && $linkedin != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="瀏覽我們的 LinkedIn" href="<?php echo $linkedin; ?>" <?php echo $newtab; ?>><i class="stficon-linkedin"></i></a><?php
		}
		// evernote
		if ( !empty($evernote) && $evernote != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="瀏覽我們的 Evernote" href="<?php echo $evernote; ?>" <?php echo $newtab; ?>><i class="stficon-evernote"></i></a><?php
		}
		// Flickr
		if ( !empty($flickr) && $flickr != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="瀏覽我們的 Flickr" href="<?php echo $flickr; ?>" <?php echo $newtab; ?>><i class="stficon-flickr"></i></a><?php
		}
		// Picasa
		if ( !empty($picasa) && $picasa != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="瀏覽我們的 Picasa" href="<?php echo $picasa; ?>" <?php echo $newtab; ?>><i class="stficon-picasa"></i></a><?php
		}
		// YouTube
		if ( !empty($youtube) && $youtube != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="訂閱我們的 Youtube" href="<?php echo $youtube; ?>" <?php echo $newtab; ?>><i class="stficon-youtube"></i></a><?php
		}
		// Skype
		if ( !empty($skype) && $skype != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="加入我們的 Skype" href="<?php echo $skype; ?>" <?php echo $newtab; ?>><i class="stficon-skype"></i></a><?php
		}
		// Digg
		if ( !empty($digg) && $digg != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="關注我們的 Digg" href="<?php echo $digg; ?>" <?php echo $newtab; ?>><i class="stficon-digg"></i></a><?php
		}
		// Vimeo
		if ( !empty($vimeo) && $vimeo != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="訂閱我們的 Vimeo" href="<?php echo $vimeo; ?>" <?php echo $newtab; ?>><i class="stficon-vimeo"></i></a><?php
		}
		// Blogger
		if ( !empty($blogger) && $blogger != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="觀看我們的 Blogger" href="<?php echo $blogger; ?>" <?php echo $newtab; ?>><i class="stficon-blogger"></i></a><?php
		}
		// Wordpress
		if ( !empty($wordpress) && $wordpress != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="觀看我們的 WordPress" href="<?php echo $wordpress; ?>" <?php echo $newtab; ?>><i class="stficon-wordpress"></i></a><?php
		}
		// dropbox
		if ( !empty($dropbox) && $dropbox != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="觀看我們的 Dropbox" href="<?php echo $dropbox; ?>" <?php echo $newtab; ?>><i class="stficon-dropbox"></i></a><?php
		}
		// Apple
		if ( !empty($apple) && $apple != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="觀看我們的 Apple" href="<?php echo $apple; ?>" <?php echo $newtab; ?>><i class="stficon-apple"></i></a><?php
		}
		// foursquare
		if ( !empty($foursquare) && $foursquare != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="關注我們的 Foursquare" href="<?php echo $foursquare; ?>" <?php echo $newtab; ?>><i class="stficon-foursquare"></i></a><?php
		}
		// github
		if ( !empty($github) && $github != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="關注我們的 Github" href="<?php echo $github; ?>" <?php echo $newtab; ?>><i class="stficon-github"></i></a><?php
		}
		// soundcloud
		if ( !empty($soundcloud) && $soundcloud != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="訂閱我們的 SoundCloud" href="<?php echo $soundcloud; ?>" <?php echo $newtab; ?>><i class="stficon-soundcloud"></i></a><?php
		}
		// instagram
		if ( !empty( $instagram ) && $instagram != '' && $instagram != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="關注我們的 instagram" href="<?php echo $instagram; ?>" <?php echo $newtab; ?>><i class="stficon-instagram"></i></a><?php
		}
		// paypal
		if ( !empty( $paypal ) && $paypal != '' && $paypal != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="paypal" href="<?php echo $paypal; ?>" <?php echo $newtab; ?>><i class="stficon-paypal"></i></a><?php
		}
		// spotify
		if ( !empty( $spotify ) && $spotify != '' && $spotify != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="訂閱我們的 Spotify" href="<?php echo $spotify; ?>" <?php echo $newtab; ?>><i class="stficon-spotify"></i></a><?php
		}
		// viadeo
		if ( !empty( $viadeo ) && $viadeo != '' && $viadeo != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="訂閱我們的 Viadeo" href="<?php echo $viadeo; ?>" <?php echo $newtab; ?>><i class="stficon-viadeo"></i></a><?php
		}
		// Google Play
		if ( !empty( $google_play ) && $google_play != '' && $google_play != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="瀏覽我們的 Google Play" href="<?php echo $google_play; ?>" <?php echo $newtab; ?>><i class="stficon-googleplay"></i></a><?php
		}
		// 500PX
		if ( !empty($px500) && $px500 != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="瀏覽我們的 500px" href="<?php echo $px500; ?>" <?php echo $newtab; ?>><i class="stficon-fivehundredpx"></i></a><?php
		} ?>
	</div>

<?php
}

/*-----------------------------------------------------------------------------------*/
# 更換 WordPress 預設摘要字數長度
/*-----------------------------------------------------------------------------------*/
function stf_excerpt_global_length( $length ) {
	if( stf_get_option( 'exc_length' ) )
		return stf_get_option( 'exc_length' );
	else return 60;
}

function stf_excerpt_home_length( $length ) {
	if( stf_get_option( 'home_exc_length' ) )
		return stf_get_option( 'home_exc_length' );
	else return 16;
}

function stf_excerpt(){
	add_filter( 'excerpt_length', 'stf_excerpt_global_length', 999 );
	echo get_the_excerpt();
}

function stf_excerpt_home(){
	add_filter( 'excerpt_length', 'stf_excerpt_home_length', 999 );
	echo get_the_excerpt();
}


/*-----------------------------------------------------------------------------------*/
# 繼續閱讀的函式
/*-----------------------------------------------------------------------------------*/
function stf_remove_excerpt( $more ) {
	return ' ...';
}
add_filter('excerpt_more', 'stf_remove_excerpt');


/*-----------------------------------------------------------------------------------*/
# 分頁導航
/*-----------------------------------------------------------------------------------*/
function stf_pagenavi( $query = false, $num = false ){
	?>
	<div class="pagination">
		<?php stf_get_pagenavi( $query, $num ) ?>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
# 獲取文章音訊檔  
/*-----------------------------------------------------------------------------------*/
function stf_audio(){
	global $post;
	$get_meta = get_post_custom($post->ID);
	$mp3 = $get_meta["stf_audio_mp3"][0] ;
	$m4a = $get_meta["stf_audio_m4a"][0] ;
	$oga = $get_meta["stf_audio_oga"][0] ;
	echo do_shortcode('[audio mp3="'.$mp3.'" ogg="'.$oga.'" m4a="'.$m4a.'"]');
}

/*-----------------------------------------------------------------------------------*/
# 獲取文章影片檔  
/*-----------------------------------------------------------------------------------*/
function stf_video(){
 $wp_embed = new WP_Embed();
	global $post;
	$get_meta = get_post_custom($post->ID);
	if( !empty( $get_meta["stf_video_url"][0] ) ){
		$video_url = $get_meta["stf_video_url"][0];
		$video_url = str_replace ( 'https://', 'http://', $video_url );
		$video_output = $wp_embed->run_shortcode('[embed width="660" height="380"]'.$video_url.'[/embed]');
		if( $video_output == '<a href="'.$video_url.'">'.$video_url.'</a>' ){
			$width  = '100%' ;
			$height = '380';
			$video_link = @parse_url($video_url);
			if ( $video_link['host'] == 'www.youtube.com' || $video_link['host']  == 'youtube.com' ) {
				parse_str( @parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
				$video =  $my_array_of_vars['v'] ;
				$video_output ='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0&wmode=opaque" frameborder="0" allowfullscreen></iframe>';
			}
			elseif( $video_link['host'] == 'www.youtu.be' || $video_link['host']  == 'youtu.be' ){
				$video = substr(@parse_url($video_url, PHP_URL_PATH), 1);
				$video_output ='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0&wmode=opaque" frameborder="0" allowfullscreen></iframe>';
			}elseif( $video_link['host'] == 'www.vimeo.com' || $video_link['host']  == 'vimeo.com' ){
				$video = (int) substr(@parse_url($video_url, PHP_URL_PATH), 1);
				$video_output='<iframe src="http://player.vimeo.com/video/'.$video.'?wmode=opaque" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			}
			elseif( $video_link['host'] == 'www.dailymotion.com' || $video_link['host']  == 'dailymotion.com' ){
				$video = substr(@parse_url($video_url, PHP_URL_PATH), 7);
				$video_id = strtok($video, '_');
				$video_output='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
			}
		}
	}
	elseif( !empty( $get_meta["stf_embed_code"][0] ) ){
		$embed_code = $get_meta["stf_embed_code"][0];
		$embed_code = htmlspecialchars_decode( $embed_code);
		$width = 'width="100%"';
		$height = 'height="400"';
		$embed_code = preg_replace('/width="([3-9][0-9]{2,}|[1-9][0-9]{3,})"/',$width,$embed_code);
		$video_output = preg_replace( '/height="([0-9]*)"/' , $height , $embed_code );
	}
	if( !empty($video_output) ) echo $video_output; ?>
<?php
}

/*-----------------------------------------------------------------------------------*/
# 摘要函式
/*-----------------------------------------------------------------------------------*/
function stf_content_limit($text, $chars = 120) {
	$text = $text." ";
	$text = mb_substr( $text , 0 , $chars , 'UTF-8');
	$text = $text."...";
	return $text;
}


/*-----------------------------------------------------------------------------------*/
# 佇列留言回覆的 JS
/*-----------------------------------------------------------------------------------*/
function comments_queue_js(){
if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
  wp_enqueue_script( 'comment-reply' );
}
add_action('wp_print_scripts', 'comments_queue_js');


/*-----------------------------------------------------------------------------------*/
# 移除最新留言的樣式
/*-----------------------------------------------------------------------------------*/
function stf_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'stf_remove_recent_comments_style' );


/*-----------------------------------------------------------------------------------*/
# 獲取文章縮略圖
/*-----------------------------------------------------------------------------------*/
function get_post_thumb(){
	global $post ;
	if ( has_post_thumbnail($post->ID) ){
		$image_id = get_post_thumbnail_id($post->ID);  
		$image_url = wp_get_attachment_image_src($image_id,'large');  
		$image_url = $image_url[0];
		return $ap_image_url = str_replace(get_option('siteurl'),'', $image_url);
	}
}

/*-----------------------------------------------------------------------------------*/
# stf 縮略圖
/*-----------------------------------------------------------------------------------*/
function stf_thumb( $size = 'stf-small' ){
	global $post;
	if( stf_get_option( 'timthumb') ){
		
		if( $size == 'stf-medium' ){$width = 272; $height = 125;}
		elseif( $size == 'stf-large' ){$width = 290;	$height = 195;}
		elseif( $size == 'slider' ){	$width 	= 660;$height = 330;}
		elseif( $size == 'big-slider' ){$width = 995; $height = 498;}
		else{ $width = 55; $height = 55;}
		
		$img = get_post_thumb(); 
		if(!empty($img)){ ?>
			<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo $img ?>&amp;h=<?php echo $height ?>&amp;w=<?php echo $width ?>&amp;a=c" alt="<?php the_title(); ?>" />
	<?php 
		}
	}else{
		$image_id = get_post_thumbnail_id($post->ID);  
		$image_url = wp_get_attachment_image($image_id, $size , false, array( 'alt'   => get_the_title() ,'title' =>  get_the_title()  ));  
		echo $image_url;
	}
}


/*-----------------------------------------------------------------------------------*/
# stf 縮略圖 SRC
/*-----------------------------------------------------------------------------------*/
function stf_thumb_src( $size = 'stf-small' ){
	global $post;

	if( stf_get_option( 'timthumb') ){
	
		if( $size == 'stf-medium' ){$width = 272; $height = 125;}
		elseif( $size == 'stf-large' ){$width = 290;	$height = 195;}
		elseif( $size == 'slider' ){	$width 	= 660;$height = 330;}
		elseif( $size == 'big-slider' ){$width = 995; $height = 498;}
		else{ $width = 55; $height = 55;}
		
		$img = get_post_thumb();
		if( !empty($img) ){
			return $img_src = get_template_directory_uri()."/timthumb.php?src=". $img ."&amp;h=". $height ."&amp;w=". $width ."amp;a=c";
		}
	}else{
		$image_id = get_post_thumbnail_id($post->ID);  
		$image_url = wp_get_attachment_image_src($image_id, $size );  
		return $image_url[0];
	}
}


/*-----------------------------------------------------------------------------------*/
# stf 縮略圖函式
/*-----------------------------------------------------------------------------------*/
function stf_slider_img_src( $image_id , $size ){
	global $post;
	if( stf_get_option( 'timthumb') ){
	
		if( $size == 'stf-medium' ){$width = 272; $height = 125;}
		elseif( $size == 'stf-large' ){$width = 290;	$height = 195;}
		elseif( $size == 'slider' ){	$width 	= 660;$height = 330;}
		elseif( $size == 'big-slider' ){$width = 995; $height = 498;}
		else{ $width = 55; $height = 55;}
		
		$img =  wp_get_attachment_image_src( $image_id , 'full' );	
		if( !empty($img) ){
			return $img_src = get_template_directory_uri()."/timthumb.php?src=". $img[0] ."&amp;h=".$height ."&amp;w=". $width ."&amp;a=c";
		}
	}else{
		$image_url = wp_get_attachment_image_src($image_id, $size );  
		return $image_url[0];
	}
}

/*-----------------------------------------------------------------------------------*/
# 新增使用者的社交網站帳號
/*-----------------------------------------------------------------------------------*/
add_action( 'show_user_profile', 'stf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'stf_show_extra_profile_fields' );
function stf_show_extra_profile_fields( $user ) { ?>
	<h3>自訂作者資訊小工具 widget</h3>
	<table class="form-table">
		<tr>
			<th><label for="author_widget_content">自訂作者資訊小工具 widget 內容</label></th>
			<td>
				<textarea name="author_widget_content" id="author_widget_content" rows="5" cols="30"><?php echo esc_attr( get_the_author_meta( 'author_widget_content', $user->ID ) ); ?></textarea>
				<br /><span class="description">支援 HTML 和短代碼（Shortcodes）。</span>
			</td>
		</tr>
	</table>
	<h3>社交網絡</h3>
	<table class="form-table">
		<tr>
			<th><label for="google">Google+ 網址</label></th>
			<td>
				<input type="text" name="google" id="google" value="<?php echo esc_attr( get_the_author_meta( 'google', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="twitter">Twitter 帳號</label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="facebook">FaceBook 網址</label></th>
			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="linkedin">linkedIn 網址</label></th>
			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="flickr">Flickr 網址</label></th>
			<td>
				<input type="text" name="flickr" id="flickr" value="<?php echo esc_attr( get_the_author_meta( 'flickr', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="youtube">YouTube 網址</label></th>
			<td>
				<input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="pinterest">Pinterest 網址</label></th>
			<td>
				<input type="text" name="pinterest" id="pinterest" value="<?php echo esc_attr( get_the_author_meta( 'pinterest', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="instagram">Instagram 網址</label></th>
			<td>
				<input type="text" name="instagram" id="instagram" value="<?php echo esc_attr( get_the_author_meta( 'instagram', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>

	</table>
<?php }

## 儲存使用者的社交網站帳號
add_action( 'personal_options_update', 'stf_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'stf_save_extra_profile_fields' );
function stf_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;
	update_user_meta( $user_id, 'author_widget_content', $_POST['author_widget_content'] );
	update_user_meta( $user_id, 'google', $_POST['google'] );	
	update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_user_meta( $user_id, 'flickr', $_POST['flickr'] );	
	update_user_meta( $user_id, 'youtube', $_POST['youtube'] );
	update_user_meta( $user_id, 'instagram', $_POST['instagram'] );
}


/*-----------------------------------------------------------------------------------*/
# 獲取 RSS Feeds 
/*-----------------------------------------------------------------------------------*/
function stf_get_feeds( $feed , $number = 10 ){
	include_once(ABSPATH . WPINC . '/feed.php');

	$rss = @fetch_feed( $feed );
	if (!is_wp_error( $rss ) ){
		$maxitems = $rss->get_item_quantity($number); 
		$rss_items = $rss->get_items(0, $maxitems); 
	}
	if ($maxitems == 0) {
		$out = "<ul><li>". '尚無資料。'."</li></ul>";
	}else{
		$out = "<ul>";
		
		foreach ( $rss_items as $item ) : 
			$out .= '<li><a target="_blank" href="'. esc_url( $item->get_permalink() ) .'" title="'.  _( "發表於 " ).$item->get_date("j F Y | g:i a").'">'. esc_html( $item->get_title() ) .'</a></li>';
		endforeach;
		$out .='</ul>';
	}
	
	return $out;
}


/*-----------------------------------------------------------------------------------*/
# Wp Footer
/*-----------------------------------------------------------------------------------*/
add_action('wp_footer', 'stf_wp_footer');
function stf_wp_footer() { 
	if ( stf_get_option('footer_code')) echo htmlspecialchars_decode( stripslashes(stf_get_option('footer_code') )); 
} 


/*-----------------------------------------------------------------------------------*/
# 圖片新聞
/*-----------------------------------------------------------------------------------*/
function stf_last_news_pic($order , $numberOfPosts = 12 , $cats = 1 ){
	global $post;
	$orig_post = $post;
	
	if( $order == 'random')
		$lastPosts = get_posts(	$args = array('numberposts' => $numberOfPosts, 'suppress_filters' => 0, 'orderby' => 'rand', 'no_found_rows' => 1, 'category' => $cats ));
	else
		$lastPosts = get_posts(	$args = array('numberposts' => $numberOfPosts, 'suppress_filters' => 0, 'no_found_rows' => 1, 'category' => $cats ));
	
		foreach($lastPosts as $post): setup_postdata($post); ?>

		<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) : ?>
			<div class="post-thumbnail">
				<a class="ttip" title="<?php the_title();?>" href="<?php the_permalink(); ?>" ><?php stf_thumb(); ?></a>
			</div><!-- post-thumbnail /-->
		<?php endif; ?>

	<?php endforeach;
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
# 獲取最新文章數量
/*-----------------------------------------------------------------------------------*/
function stf_last_posts($numberOfPosts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;
	
	$lastPosts = get_posts('no_found_rows=1&suppress_filters=0&numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li <?php stf_post_class(); ?>>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title();?>的永久鏈結" rel="bookmark"><?php stf_thumb(); ?><span class="overlay-icon"></span></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<?php stf_get_score(); ?> <span class="date"><?php stf_get_time(); ?></span>
</li>
<?php endforeach; 
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
# 獲取來自分類目錄的最新文章數量
/*-----------------------------------------------------------------------------------*/
function stf_last_posts_cat($numberOfPosts = 5 , $thumb = true , $cats = 1){
	global $post;
	$orig_post = $post;

	$lastPosts = get_posts('category='.$cats.'&no_found_rows=1&suppress_filters=0&numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li <?php stf_post_class(); ?>>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title();?>的永久鏈結" rel="bookmark"><?php stf_thumb(); ?><span class="overlay-icon"></span></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<?php stf_get_score(); ?> <span class="date"><?php stf_get_time() ?></span>
</li>
<?php endforeach;
	$post = $orig_post;
}

/*-----------------------------------------------------------------------------------*/
# 獲取作者來自分類目錄的最新文章數量
/*-----------------------------------------------------------------------------------*/
function stf_last_posts_cat_authors($numberOfPosts = 5 , $thumb = true , $cats = 1){
	global $post;
	$orig_post = $post;

	$lastPosts = get_posts('category='.$cats.'&no_found_rows=1&suppress_filters=0&numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title="<?php sprintf( esc_attr_( '觀看 %s 的所有文章' ), get_the_author() ) ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'MFW_author_bio_avatar_size', 50 ) ); ?></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
	<strong><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title="<?php sprintf( esc_attr_( '觀看 %s 的所有文章' ), get_the_author() ) ?>"><?php echo get_the_author() ?> </a></strong>
</li>
<?php endforeach;
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
# 獲取隨機文章
/*-----------------------------------------------------------------------------------*/
function stf_random_posts($numberOfPosts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;

	$lastPosts = get_posts('orderby=rand&no_found_rows=1&suppress_filters=0&numberposts='.$numberOfPosts);
	foreach($lastPosts as $post): setup_postdata($post);
?>
<li <?php stf_post_class(); ?>>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>的永久鏈結" rel="bookmark"><?php stf_thumb(); ?><span class="overlay-icon"></span></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<?php stf_get_score(); ?> <span class="date"><?php stf_get_time(); ?></span>
</li>
<?php endforeach;
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
# 獲取熱門文章 
/*-----------------------------------------------------------------------------------*/
function stf_popular_posts($pop_posts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;
	
	$popularposts = new WP_Query( array( 'orderby' => 'comment_count', 'order' => 'DESC', 'posts_per_page' => $pop_posts, 'post_status' => 'publish', 'no_found_rows' => 1, 'ignore_sticky_posts' => 1  ) );
	while ( $popularposts->have_posts() ) : $popularposts->the_post()?>
			<li <?php stf_post_class(); ?>>
			<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
				<div class="post-thumbnail">
					<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php the_title(); ?>" rel="bookmark"><?php stf_thumb(); ?><span class="overlay-icon"></span></a>
				</div><!-- post-thumbnail /-->
			<?php endif; ?>
				<h3><a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo the_title(); ?>"><?php echo the_title(); ?></a></h3>
				<?php stf_get_score(); ?> <span class="date"><?php stf_get_time(); ?></span>
			</li>
	<?php 
	endwhile;
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
# 獲取留言最多的文章 
/*-----------------------------------------------------------------------------------*/
function stf_most_commented($comment_posts = 5 , $avatar_size = 50){
$comments = get_comments('status=approve&number='.$comment_posts);
foreach ($comments as $comment) { ?>
	<li>
		<div class="post-thumbnail">
			<?php echo get_avatar( $comment, $avatar_size ); ?>
		</div>
		<a href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">
		<?php echo strip_tags($comment->comment_author); ?>: <?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>... </a>
	</li>
<?php } 
}

/*-----------------------------------------------------------------------------------*/
# 獲取評分最高的文章
/*-----------------------------------------------------------------------------------*/
function stf_best_reviews_posts($pop_posts = 5 , $thumb = true){
	global $post;
	$orig_post = $post;

	$cat_query1 = new WP_Query(array('posts_per_page' => $pop_posts, 'orderby' => 'meta_value_num' ,  'meta_key' => 'stf_review_score', 'post_status' => 'publish', 'no_found_rows' => 1 ));
	while ( $cat_query1->have_posts() ) : $cat_query1->the_post()?>
<li <?php stf_post_class(); ?>>
	<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() && $thumb ) : ?>			
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php stf_thumb(); ?><span class="overlay-icon"></span></a>
		</div><!-- post-thumbnail /-->
	<?php endif; ?>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<?php stf_get_score(); ?> <span class="date"><?php stf_get_time(); ?></span>
</li>
<?php endwhile;
	$post = $orig_post;
}


/*-----------------------------------------------------------------------------------*/
# 獲取社交網站的追蹤數
/*-----------------------------------------------------------------------------------*/
function stf_remote_get( $url ) {
	$request = wp_remote_retrieve_body( wp_remote_get( $url , array( 'timeout' => 18 , 'sslverify' => false ) ) );
	return $request;
}

function stf_followers_count() {
	$twitter_username 		= stf_get_option('twitter_username');
	$twitter['page_url'] = 'http://www.twitter.com/'.$twitter_username;
	$twitter['followers_count'] = get_transient('twitter_count');
	if( empty( $twitter['followers_count']) ){
		try {
		
			$data = @json_decode(stf_remote_get("https://twitter.com/users/$twitter_username.json") , true);
			$twitter['followers_count'] = (int) $data['followers_count'];	
			
			$consumerKey 			= stf_get_option('twitter_consumer_key');
			$consumerSecret			= stf_get_option('twitter_consumer_secret');

			$token = get_option('stf_TwitterToken');
		 
			// 獲取新的不記名驗證（如果尚未取得）
			if(!$token) {
				// 準備認證
				$credentials = $consumerKey . ':' . $consumerSecret;
				$toSend = base64_encode($credentials);
		 
				// http post 參數
				$args = array(
					'method' => 'POST',
					'httpversion' => '1.1',
					'blocking' => true,
					'headers' => array(
						'Authorization' => 'Basic ' . $toSend,
						'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body' => array( 'grant_type' => 'client_credentials' )
				);
		 
				add_filter('https_ssl_verify', '__return_false');
				$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);
		 
				$keys = json_decode(wp_remote_retrieve_body($response));
		 
				if($keys) {
					// 儲存憑證在 wp_options 資料表中
					update_option('stf_TwitterToken', $keys->access_token);
					$token = $keys->access_token;
				}
			}
			
			// 我們已經從 API 或選項獲得了使用者憑證
			$args = array(
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array(
					'Authorization' => "Bearer $token"
				)
			);
		 
			add_filter('https_ssl_verify', '__return_false');
			$api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=$twitter_username";
			$response = wp_remote_get($api_url, $args);
		 
			if (!is_wp_error($response)) {
				$followers = json_decode(wp_remote_retrieve_body($response));
				$twitter['followers_count'] = $followers->followers_count;
			} 
			
		} catch (Exception $e) {
			$twitter['followers_count'] = 0;
		}
		if( !empty( $twitter['followers_count'] ) ){
			set_transient( 'twitter_count' , $twitter['followers_count'] , 1200);
			if( get_option( 'followers_count') != $twitter['followers_count'] ) 
				update_option( 'followers_count' , $twitter['followers_count'] );
		}
			
		if( $twitter['followers_count'] == 0 && get_option( 'followers_count') )
			$twitter['followers_count'] = get_option( 'followers_count');
				
		elseif( $twitter['followers_count'] == 0 && !get_option( 'followers_count') )
			$twitter['followers_count'] = 0;
	}
	return $twitter;
}

function stf_facebook_fans( $page_link ){
	$face_link = @parse_url($page_link);

	if( $face_link['host'] == 'www.facebook.com' || $face_link['host']  == 'facebook.com' ){
		$fans = get_transient('fans_count');
		if( empty( $fans ) ){
			try {
				$data = @json_decode(stf_remote_get("http://graph.facebook.com/".$page_link));
				$fans = $data->likes;
			} catch (Exception $e) {
				$fans = 0;
			}
				
			if( !empty($fans) ){
				set_transient( 'fans_count' , $fans , 1200);
				if ( get_option( 'fans_count') != $fans )
					update_option( 'fans_count' , $fans );
			}
				
			if( $fans == 0 && get_option( 'fans_count') )
				$fans = get_option( 'fans_count');
					
			elseif( $fans == 0 && !get_option( 'fans_count') )
				$fans = 0;
		}	
		return $fans;
	}
}


function stf_youtube_subs( $channel_link ){
	$youtube_link = @parse_url($channel_link);

	if( $youtube_link['host'] == 'www.youtube.com' || $youtube_link['host']  == 'youtube.com' ){
		$subs = get_transient('youtube_count');
		if( empty( $subs ) ){
			try {
				if (strpos( strtolower($channel_link) , "channel") === false)
					$youtube_name = substr(@parse_url($channel_link, PHP_URL_PATH), 6);
				else
					$youtube_name = substr(@parse_url($channel_link, PHP_URL_PATH), 9);

				$json = @stf_remote_get("http://gdata.youtube.com/feeds/api/users/".$youtube_name."?alt=json");
				$data = json_decode($json, true); 
				$subs = $data['entry']['yt$statistics']['subscriberCount']; 
			} catch (Exception $e) {
				$subs = 0;
			}
			
			if( !empty($subs) ){
				set_transient( 'youtube_count' , $subs , 1200);
				if( get_option( 'youtube_count') != $subs )
					update_option( 'youtube_count' , $subs );
			}
				
			if( $subs == 0 && get_option( 'youtube_count') )
				$subs = get_option( 'youtube_count');
					
			elseif( $subs == 0 && !get_option( 'youtube_count') )
				$subs = 0;
		}
		return $subs;
	}
}


function stf_vimeo_count( $page_link ) {
	$vimeo_link = @parse_url($page_link);

	if( $vimeo_link['host'] == 'www.vimeo.com' || $vimeo_link['host']  == 'vimeo.com' ){
		$vimeo = get_transient('vimeo_count');
		if( empty( $vimeo ) ){
			try {
				$page_name = substr(@parse_url($page_link, PHP_URL_PATH), 10);
				@$data = @json_decode(stf_remote_get( 'http://vimeo.com/api/v2/channel/' . $page_name  .'/info.json'));
			
				$vimeo = $data->total_subscribers;
			} catch (Exception $e) {
				$vimeo = 0;
			}

			if( !empty($vimeo) ){
				set_transient( 'vimeo_count' , $vimeo , 1200);
				if( get_option( 'vimeo_count') != $vimeo )
					update_option( 'vimeo_count' , $vimeo );
			}
				
			if( $vimeo == 0 && get_option( 'vimeo_count') )
				$vimeo = get_option( 'vimeo_count');
			elseif( $vimeo == 0 && !get_option( 'vimeo_count') )
				$vimeo = 0;
		}
		return $vimeo;
	}
}

function stf_soundcloud_count( $page_link , $api ) {
	$soundcloud_link = @parse_url($page_link);
	if( $soundcloud_link['host'] == 'www.soundcloud.com' || $soundcloud_link['host']  == 'soundcloud.com' ){
		$soundcloud = get_transient('soundcloud_count');
		if( empty( $soundcloud ) ){
			try {
				$username = substr( $soundcloud_link['path'] , 1);
				$data = @json_decode(stf_remote_get("http://api.soundcloud.com/users/$username.json?consumer_key=$api") , true );
				$soundcloud = (int) $data['followers_count'];
			
			} catch (Exception $e) {
				$soundcloud = 0;
			}

			if( !empty($soundcloud) ){
				set_transient( 'soundcloud_count' , $soundcloud , 1200);
				if( get_option( 'soundcloud_count') != $soundcloud )
					update_option( 'soundcloud_count' , $soundcloud );
			}
			
			if( $soundcloud == 0 && get_option( 'soundcloud_count') )
				$soundcloud = get_option( 'soundcloud_count');
			elseif( $soundcloud == 0 && !get_option( 'soundcloud_count') )
				$soundcloud = 0;
		}
		return $soundcloud;
	}	
}

function stf_instagram_count( $page_link , $api ) {
	$instagram_link = @parse_url($page_link);
	if( $instagram_link['host'] == 'www.instagram.com' || $instagram_link['host']  == 'instagram.com' ){
		$instagram = get_transient('instagram_count');
		if( empty( $instagram ) ){
			try {
				$username = explode(".", $api);
				$data = @json_decode( stf_remote_get("https://api.instagram.com/v1/users/$username[0]/?access_token=$api") , true );
				$instagram = (int) $data['data']['counts']['followed_by'];	
			
			} catch (Exception $e) {
				$instagram = 0;
			}

			if( !empty($instagram) ){
				set_transient( 'instagram_count' , $instagram , 1200);
				if( get_option( 'instagram_count') != $instagram )
					update_option( 'instagram_count' , $instagram );
			}
			
			if( $instagram == 0 && get_option( 'instagram_count') )
				$instagram = get_option( 'instagram_count');
			elseif( $instagram == 0 && !get_option( 'instagram_count') )
				$instagram = 0;
		}
		return $instagram;
	}	
}

/*-----------------------------------------------------------------------------------*/
# Google 地圖函式
/*-----------------------------------------------------------------------------------*/
function stf_google_maps($src , $width = 610 , $height = 440 , $class="") {
	return '<div class="google-map '.$class.'"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&amp;output=embed"></iframe></div>';
}	

/*-----------------------------------------------------------------------------------*/
# SoundCloud 函數
/*-----------------------------------------------------------------------------------*/
function stf_soundcloud($url , $autoplay = 'false' ) {
	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true"></iframe>';
}			

/*-----------------------------------------------------------------------------------*/
# 登入表單
/*-----------------------------------------------------------------------------------*/
function stf_login_form( $login_only  = 0 ) {
	global $user_ID, $user_identity, $user_level;
	
	if ( $user_ID ) : ?>
		<?php if( empty( $login_only ) ): ?>
		<div id="user-login">
			<p class="welcome-text"> 歡迎 <strong><?php echo $user_identity ?></strong> 登入</p>
			<span class="author-avatar"><?php echo get_avatar( $user_ID, $size = '85'); ?></span>
			<ul>
				<li><a href="<?php echo home_url() ?>/wp-admin/"> 控制台 </a></li>
				<li><a href="<?php echo home_url() ?>/wp-admin/profile.php"> 個人資料 </a></li>
				<li><a href="<?php echo wp_logout_url(); ?>"> 登出 </a></li>
			</ul>
			<div class="author-social">
				<?php if ( get_the_author_meta( 'url' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'url' , $user_ID); ?>" title="<?php echo $user_identity ?> 的網站"><img src="<?php echo get_template_directory_uri(); ?>/images/author_site.png" width="18" height="18" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'twitter' , $user_ID) ) : ?>
				<a class="ttip" href="http://twitter.com/<?php the_author_meta( 'twitter' ); ?>" title="<?php echo $user_identity ?>的 Twitter"><img src="<?php echo get_template_directory_uri(); ?>/images/author_twitter.png" width="18" height="18" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'facebook' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'facebook' ); ?>" title="<?php echo $user_identity ?>的 Facebook"><img src="<?php echo get_template_directory_uri(); ?>/images/author_facebook.png" width="18" height="18" alt="" /></a>
				<?php endif ?>
				<?php if ( get_the_author_meta( 'google' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'google' ); ?>" title="<?php echo $user_identity ?>的 Google+"><img src="<?php echo get_template_directory_uri(); ?>/images/author_google.png" width="18" height="18" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'linkedin' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'linkedin' , $user_ID); ?>" title="<?php echo $user_identity ?>的 Linkedin"><img src="<?php echo get_template_directory_uri(); ?>/images/author_linkedin.png" width="18" height="18" alt="" /></a>
				<?php endif ?>				
				<?php if ( get_the_author_meta( 'flickr' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'flickr' , $user_ID); ?>" title="<?php echo $user_identity ?>的 Flickr"><img src="<?php echo get_template_directory_uri(); ?>/images/author_flickr.png" width="18" height="18" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'youtube' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'youtube' , $user_ID); ?>" title="<?php echo $user_identity ?>的 YouTube"><img src="<?php echo get_template_directory_uri(); ?>/images/author_youtube.png" width="18" height="18" alt="" /></a>
				<?php endif ?>
				<?php if ( get_the_author_meta( 'pinterest' , $user_ID) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'pinterest' , $user_ID); ?>" title="<?php echo $user_identity ?>的 Pinterest"><img src="<?php echo get_template_directory_uri(); ?>/images/author_pinterest.png" width="18" height="18" alt="" /></a>
				<?php endif ?>	
				<?php if ( get_the_author_meta( 'instagram' , $user_ID ) ) : ?>
				<a class="ttip" href="<?php the_author_meta( 'instagram' ); ?>" title="<?php echo $user_identity ?>的 Instagram"><img src="<?php echo get_template_directory_uri(); ?>/images/author_instagram.png" width="18" height="18" alt="" /></a>
				<?php endif ?>	
			</div>
			<div class="clear"></div>
		</div>
		<?php endif; ?>
	<?php else: ?>
		<div id="login-form">
			<form name="loginform" id="loginform" action="<?php echo home_url() ?>/wp-login.php" method="post">
				<p id="log-username"><input type="text" name="log" id="log" value="帳號" onfocus="if (this.value == '帳號') {this.value = '';}" onblur="if (this.value == '') {this.value = '帳號';}"  size="33" /></p>
				<p id="log-pass"><input type="password" name="pwd" id="pwd" value="密碼" onfocus="if (this.value == '密碼') {this.value = '';}" onblur="if (this.value == '') {this.value = '密碼';}" size="33" /></p>
				<input type="submit" name="submit" value="登入" class="login-button" />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> 記住我</label>
				<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
			</form>
			<ul class="login-links">
				<?php if ( get_option('users_can_register') ) : ?><?php echo wp_register() ?><?php endif; ?>
				<li><a href="<?php echo home_url() ?>/wp-login.php?action=lostpassword">忘記密碼？</a></li>
			</ul>
		</div>
	<?php endif;
}


/*-----------------------------------------------------------------------------------*/
# 文章的 OG 資訊
/*-----------------------------------------------------------------------------------*/
function stf_og_data() {
	global $post ;
	
	if ( function_exists("has_post_thumbnail") && has_post_thumbnail() )
		$post_thumb = stf_thumb_src( 'slider' ) ;
	else{
		$get_meta = get_post_custom($post->ID);
		if( !empty( $get_meta["stf_video_url"][0] ) ){
			$video_url = $get_meta["stf_video_url"][0];
			$video_link = @parse_url($video_url);
			if ( $video_link['host'] == 'www.youtube.com' || $video_link['host']  == 'youtube.com' ) {
				parse_str( @parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
				$video =  $my_array_of_vars['v'] ;
				$post_thumb ='http://img.youtube.com/vi/'.$video.'/0.jpg';
			}
			elseif( $video_link['host'] == 'www.vimeo.com' || $video_link['host']  == 'vimeo.com' ){
				$video = (int) substr(@parse_url($video_url, PHP_URL_PATH), 1);
				$url = 'http://vimeo.com/api/v2/video/'.$video.'.php';;
				$contents = @file_get_contents($url);
				$thumb = @unserialize(trim($contents));
				$post_thumb = $thumb[0][thumbnail_large];
			}
		}
	}
	//呼叫 $post->post_content;
$description = htmlspecialchars(strip_tags(strip_shortcodes($post->post_content)));
?>
<meta property="og:title" content="<?php the_title(); ?>"/>
<meta property="og:type" content="article"/>
<meta property="og:description" content="<?php echo stf_content_limit($description , 100 ); ?>"/>
<meta property="og:url" content="<?php the_permalink(); ?>"/>
<meta property="og:site_name" content="<?php echo get_bloginfo( 'name' ) ?>"/>
<?php
if( !empty($post_thumb) )
	echo '<meta property="og:image" content="'. $post_thumb .'" />'."\n";
}


/*-----------------------------------------------------------------------------------*/
# 給空白小工具 Widgets 的標題 
/*-----------------------------------------------------------------------------------*/
function stf_widget_title($title){
	if( empty( $title ) )
		return ' ';
	else return $title;
}
add_filter('widget_title', 'stf_widget_title');


/*-----------------------------------------------------------------------------------*/
# 獲取評分框的函式 
/*-----------------------------------------------------------------------------------*/
$stf_reviews_attr = array(
	'review'		=>		'itemprop="review" itemscope itemtype="http://schema.org/Review" ',
	'name'			=>		'itemprop="name"'
);
function stf_get_review( $position = "review-top" ){
	global $post ;
	if( function_exists('bp_current_component') && bp_current_component() ) $current_id = get_queried_object_id();
	else $current_id = $post->ID;
	$get_meta = get_post_custom( $current_id );

	$criterias = unserialize( $get_meta['stf_review_criteria'][0] );
	$summary = $get_meta['stf_review_summary'][0] ;
	$short_summary = $get_meta['stf_review_total'][0] ;
	$style = $get_meta['stf_review_style'][0];
	$total_counter = $score = 0;
	$users_rate = $post_description = '';
	$users_rate = stf_get_user_rate();
	$post_description = wp_trim_words(  $post->post_content , 100 );
	if( $style == 'percentage' ) $review_class = ' review-percentage'; elseif( $style == 'points' ) $review_class = ' review-percentage'; else $review_class = ' review-stars';
	$output = '
	<meta itemprop="datePublished" content="'. get_the_time( 'Y-m-d' ).'" />
	<div style="display:none" itemprop="reviewBody">'. strip_shortcodes(htmlspecialchars(strip_tags(( $post_description )))).'</div>
	<div class="review-box '.$position.$review_class.'">
		<h2 class="review-box-header">'. _( "評分總覽" ) .'</h2>' ;

	if( !empty($criterias) && is_array($criterias) ){
		foreach( $criterias as $criteria){ 
		if( $criteria['name'] ){
			if( $criteria['score'] > 100 ) $criteria['score'] = 100;
			if( $criteria['score'] < 0 || empty($criteria['score']) || !is_numeric( $criteria['score']) ) $criteria['score'] = 0;
				
		$score += $criteria['score'];
		$total_counter ++;
		
		if( $style == 'percentage' ):
		$output .= ' <div class="review-item">
			<h5>'.$criteria['name'] .' - '. $criteria['score'] .'%</h5>
			<span><span style="width:'. $criteria['score'] .'%"></span></span>
		</div>';
		elseif( $style == 'points' ):   $point =  $criteria['score']/10;
		$output .='<div class="review-item">
			<h5>'. $criteria['name'] .' - '. $point .'</h5>
			<span><span style="width:'. $criteria['score'] .'%"></span></span>
		</div>';
		else:
		$output .= '<div class="review-item">
			<h5>'. $criteria['name'] .'</h5>
			<span class="stars-large"><span style="width:'. $criteria['score'] .'%"></span></span>
		</div>';
		endif;
		}
		}
	}
		if( !empty( $score ) && !empty( $total_counter ) )
			$total_score =  $score / $total_counter ;

		if( empty($total_score) ) $total_score = 0;

		$output .= '<div class="review-summary" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
		<meta itemprop="worstRating" content = "1" />
		<meta itemprop="bestRating" content = "100" />
		<span class="rating points" style="display:none"><span class="rating points" itemprop="ratingValue">'. round($total_score) .'</span></span>';
		if( $style == 'percentage' ):
			$output .= '<div class="review-final-score">
				<h3>'. round($total_score) .'<span>%</span></h3>
				<h4>'.$short_summary.'</h4>
			</div>';
		elseif( $style == 'points' ): $total_score = $total_score/10 ;
			$output .= '<div class="review-final-score">
				<h3>'. round($total_score,1) .'</h3>
				<h4>'. $short_summary .'</h4>
			</div>';
		else:
			$output .= '<div class="review-final-score">
				<span title="'. $short_summary .'" class="stars-large"><span style="width:'. $total_score .'%"></span></span>
				<h4>'. $short_summary .'</h4>
			</div>';
		endif;
			if( !empty( $summary ) ){
			$output .= '<div class="review-short-summary" itemprop="description">
				<p><strong>'. _( "總評分 :" ) .' </strong> '. htmlspecialchars_decode($summary) .'</p>
			</div>';
			}
		$output .= '</div>'.$users_rate.'
		<span style="display:none" itemprop="reviewRating">'.round($total_score) .'</span>
	</div>';
	return $output ;
}


/*-----------------------------------------------------------------------------------*/
# 獲取評分總成績
/*-----------------------------------------------------------------------------------*/
function stf_get_score( $size = 'small' ){
	global $post ;
	$summary = 0;
	$get_meta = get_post_custom($post->ID);
	if( !empty( $get_meta['stf_review_position'][0] ) ){
	$criterias = unserialize( $get_meta['stf_review_criteria'][0] );
	$short_summary = $get_meta['stf_review_total'][0] ;
	$total_score = $get_meta['stf_review_score'][0];
	if( empty($total_score) ) $total_score = 0;
	$style = $get_meta['stf_review_style'][0];
	?>
	<span title="<?php echo $short_summary ?>" class="stars-<?php echo $size; ?>"><span style="width:<?php echo $total_score ?>%"></span></span>
	<?php 
	}
}

/*-----------------------------------------------------------------------------------*/
# 會員文章評分函式
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_nopriv_stf_rate_post', 'stf_rate_post');
add_action('wp_ajax_stf_rate_post', 'stf_rate_post');
function stf_rate_post(){
	global $user_ID;
	
	if( stf_get_option('allowtorate') == 'none' || ( !empty($user_ID) && stf_get_option('allowtorate') == 'guests' ) ||	( empty($user_ID) && stf_get_option('allowtorate') == 'users' ) ){ 
		return false ;
	}else{	
		$count = $rating = $rate = 0;
		$postID = $_REQUEST['post'];
		$rate = abs($_REQUEST['value']);
		if($rate > 5 ) $rate = 5;
		
		if( is_numeric( $postID ) ){
			$rating = get_post_meta($postID, 'stf_user_rate' , true);
			$count = get_post_meta($postID, 'stf_users_num' , true);
			if( empty($count) || $count == '' ) $count = 0;
			
			$count++;
			$total_rate = $rating + $rate;
			$total = round($total_rate/$count , 2);
			if ( $user_ID ) {
				$user_rated = get_the_author_meta( 'stf_rated', $user_ID  );

				if( empty($user_rated) ){
					$user_rated[$postID] = $rate;
					
					update_user_meta( $user_ID, 'stf_rated', $user_rated );
					update_post_meta( $postID, 'stf_user_rate', $total_rate );
					update_post_meta( $postID, 'stf_users_num', $count );
					
					echo $total;
				}
				else{
					if( !array_key_exists($postID , $user_rated) ){
						$user_rated[$postID] = $rate;
						update_user_meta( $user_ID, 'stf_rated', $user_rated );
						update_post_meta( $postID, 'stf_user_rate', $total_rate );
						update_post_meta( $postID, 'stf_users_num', $count );
						
						echo $total;
					}
				}
			}else{
				$user_rated = $_COOKIE["stf_rate_".$postID];
				if( empty($user_rated) ){
					setcookie( 'stf_rate_'.$postID , $rate , time()+31104000 , '/');
					update_post_meta( $postID, 'stf_user_rate', $total_rate );
					update_post_meta( $postID, 'stf_users_num', $count );
				}
			}
		}
	}
    die;
}

/*-----------------------------------------------------------------------------------*/
# 獲取會員評分結果
/*-----------------------------------------------------------------------------------*/
function stf_get_user_rate(){
	global $post , $user_ID; 
	$disable_rate = false ;

	if( stf_get_option('allowtorate') == 'none' )
		return false;
		
	if( ( !empty($user_ID) && stf_get_option('allowtorate') == 'guests' ) || ( empty($user_ID) && stf_get_option('allowtorate') == 'users' ) ) 
		$disable_rate = true ;
		
	if( !empty($disable_rate) ){
		$no_rate_text = '尚無人評分 !';
		$rate_active = false ;
	}
	else{
		$no_rate_text = '當第一位評分者 !' ;
		$rate_active = ' user-rate-active' ;
	}
		
	$image_style ='stars';
	
	$rate = get_post_meta( $post->ID , 'stf_user_rate', true );
	$count = get_post_meta( $post->ID , 'stf_users_num', true );
	if( !empty($rate) && !empty($count)){
		$total = (($rate/$count)/5)*100;
		$totla_users_score = round($rate/$count,2);
	}else{
		$totla_users_score = $total = $count = 0;
	}
	
	if ( $user_ID ) {
		$user_rated = get_the_author_meta( 'stf_rated' , $user_ID ) ;
		if( !empty($user_rated) && is_array($user_rated) && array_key_exists($post->ID , $user_rated) ){
			$user_rate = round( ($user_rated[$post->ID]*100)/5 , 2);
			return $output = '<div class="user-rate-wrap"><span class="user-rating-text"><strong>'. "您的評分:" .' </strong> <span class="taq-score">'.$user_rated[$post->ID].'</span> <small>( <span class="taq-count">'.$count.'</span> '. "投票" .')</small> </span><div data-rate="'. $user_rate .'" class="rate-post-'.$post->ID.' user-rate rated-done" title=""><span class="user-rate-image post-large-rate '.$image_style.'-large"><span style="width:'. $user_rate .'%"></span></span></div><div class="taq-clear"></div></div>';
		}
	}else{
		$user_rate = $_COOKIE["stf_rate_".$post->ID] ;
		
		if( !empty($user_rate) ){
			return $output = '<div class="user-rate-wrap"><span class="user-rating-text"><strong>'. "您的評分:" .' </strong> <span class="taq-score">'.$user_rate.'</span> <small>( <span class="taq-count">'.$count.'</span> '. "投票" .')</small> </span><div class="rate-post-'.$post->ID.' user-rate rated-done" title=""><span class="user-rate-image post-large-rate '.$image_style.'-large"><span style="width:'. (($user_rate*100)/5) .'%"></span></span></div><div class="taq-clear"></div></div>';
		}
		
	}
	if( $total == 0 && $count == 0)
		return $output = '<div class="user-rate-wrap"><span class="user-rating-text"><strong>'. "會員評分:" .' </strong> <span class="taq-score"></span> <small>'.$no_rate_text.'</small> </span><div data-rate="'. $total .'" data-id="'.$post->ID.'" class="rate-post-'.$post->ID.' user-rate'.$rate_active.'"><span class="user-rate-image post-large-rate '.$image_style.'-large"><span style="width:'. $total .'%"></span></span></div><div class="taq-clear"></div></div>';
	else
		return $output = '<div class="user-rate-wrap"><span class="user-rating-text"><strong>'. "會員評分:" .' </strong> <span class="taq-score">'.$totla_users_score.'</span> <small>( <span class="taq-count">'.$count.'</span> '. "投票" .')</small> </span><div data-rate="'. $total .'" data-id="'.$post->ID.'" class="rate-post-'.$post->ID.' user-rate'.$rate_active.'"><span class="user-rate-image post-large-rate '.$image_style.'-large"><span style="width:'. $total .'%"></span></span></div><div class="taq-clear"></div></div>';
}

/*-----------------------------------------------------------------------------------*/
# 獲取文章發表時間
/*-----------------------------------------------------------------------------------*/
function stf_get_time(){
	global $post ;
	if( stf_get_option( 'time_format' ) == 'none' ){
		return false;
	}elseif( stf_get_option( 'time_format' ) == 'modern' ){	
		$to = current_time('timestamp'); //time();
		$from = get_the_time('U') ;
		
		$diff = (int) abs($to - $from);
		if ($diff <= 3600) {
			$mins = round($diff / 60);
			if ($mins <= 1) {
				$mins = 1;
			}
			$since = sprintf(_n('%s min', '%s mins', $mins), $mins) .' '. '之前';
		}
		else if (($diff <= 86400) && ($diff > 3600)) {
			$hours = round($diff / 3600);
			if ($hours <= 1) {
				$hours = 1;
			}
			$since = sprintf(_n('%s hour', '%s hours', $hours), $hours) .' '. '之前';
		}
		elseif ($diff >= 86400) {
			$days = round($diff / 86400);
			if ($days <= 1) {
				$days = 1;
				$since = sprintf(_n('%s day', '%s days', $days), $days) .' '. '之前';
			}
			elseif( $days > 29){
				$since = get_the_time(get_option('date_format'));
			}
			else{
				$since = sprintf(_n('%s day', '%s days', $days), $days) .' '. '之前';
			}
		}
	}else{
		$since = get_the_time(get_option('date_format'));
	}
	echo '<span>'.$since.'</span>';
}

/*-----------------------------------------------------------------------------------*/
# 新增 "深色背景" 給全站
/*-----------------------------------------------------------------------------------*/
add_filter('body_class','stf_body_class_dark');
function stf_body_class_dark($classes) {
	if( stf_get_option('dark_skin') )
		$classes[] = 'dark-skin';
	return $classes;
}

/*-----------------------------------------------------------------------------------*/
# 針對燈箱效果（lightbox）新增類別（Class）給 Gallery shortcode
/*-----------------------------------------------------------------------------------*/
if( !stf_get_option( 'disable_gallery_shortcode' ) )
add_filter( 'post_gallery', 'stf_post_gallery', 10, 2 );

function stf_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";
	
	$images_class ='';
	if( isset($attr['link']) && 'file' == $attr['link'] )
		$images_class = "gallery-images";
	
    $output = apply_filters('gallery_style', "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;           }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div id='$selector' class='$images_class gallery galleryid-{$id}'>");

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
            <br style='clear: both;' />
        </div>\n";

    return $output;
}

/*-----------------------------------------------------------------------------------*/
# 針對輸出模式建立良好格式和更具體的標題元素文字
/*-----------------------------------------------------------------------------------*/
function stf_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// 新增網站名稱
	$title .= get_bloginfo( 'name' );

	// 給首頁新增網站描述
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// 如果有需要就新增頁數
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( _( '第 %s 頁' ), max( $paged, $page ) );

	return $title;
}
if ( !class_exists( 'All_in_One_SEO_Pack' ) && !function_exists( 'wpseo_get_value' ) ) 
add_filter( 'wp_title', 'stf_wp_title', 10, 2 );

/*-----------------------------------------------------------------------------------*/
# 修正 Shortcodes
/*-----------------------------------------------------------------------------------*/
function stf_fix_shortcodes($content){   
    $array = array (
        '[raw]' => '', 
        '[/raw]' => '', 
        '<p>[raw]' => '', 
        '[/raw]</p>' => '', 
        '[/raw]<br />' => '', 
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'stf_fix_shortcodes');

/*-----------------------------------------------------------------------------------*/
# 如果目前頁面是 wp-login.php 或 wp-register.php 就檢查
/*-----------------------------------------------------------------------------------*/
function stf_is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

/*-----------------------------------------------------------------------------------*/
# 分類目錄的 Mega 選單（下拉顯示選單效果）
/*-----------------------------------------------------------------------------------*/
class stf_mega_menu_walker extends Walker_Nav_Menu {
	private $curItem, $megaMenu;
	function stf_mega_start(){
		$sub_class = $last ='';
		$count = 0;
		if($this->curItem->object == 'category' && empty($this->curItem->menu_item_parent)){ 
			$cat_id = $this->curItem->object_id;
			$cat_options = get_option( "stf_cat_$cat_id");
			if( !empty( $cat_options['cat_mega_menu'] )){
				@$output .= "\n<div class=\"mega-menu-block\"><div class=\"mega-menu-content\">\n";
				$cat_query = new WP_Query('cat='.$cat_id.'&no_found_rows=1&posts_per_page=3'); 
				while ( $cat_query->have_posts() ) { $count++;
					if( $count == 3 ) $last = 'last-column';
					$cat_query->the_post();
					$output .= '<div class="mega-menu-item '.$last.'">';
					if ( function_exists("has_post_thumbnail") && has_post_thumbnail() )
					$output .= '<a class="mega-menu-link" href="'. get_permalink().'" title="'.get_the_title().'"><img width="272" height="125" src="'.stf_thumb_src( 'stf-medium' ).'" /></a>';
					$output .= '<h3 class="post-box-title"><a class="mega-menu-link" href="'. get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h3></div>';
				}
				return $output .= "\n</div>\n";
			}
		}
	}
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= $this->stf_mega_start();
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul> <!--End Sub Menu-->\n";
		if($this->megaMenu == 'y' && $depth == 0){
			$output .= "\n</div><!-- .mega-menu-block --> \n";
		}
	}
	function start_el(&$output, $item, $depth = 0 , $args = array() , $id = 0) {
		global $wp_query;
		$this->curItem = $item;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = $mega = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		if($item->object == 'category' && empty($item->menu_item_parent)){
			$cat_id = $this->curItem->object_id;
			$cat_options = get_option( "stf_cat_$cat_id");
			if( !empty( $cat_options['cat_mega_menu'] )){
				$this->megaMenu = 'y';
				$mega = 'mega-menu';
				if ( empty($args->has_children) ) $mega .= ' full-mega-menu';
			}
		}
		if( empty($item->menu_item_parent) && empty($mega) ) $this->megaMenu = 'n';
		
		$class_names = join( " $mega ", apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		if( !empty($mega) && empty($args->has_children) ){	
			$item_output .= $this->stf_mega_start();
			$item_output .= "\n</div><!-- .mega-menu-block --> \n";
		}

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}

/*-----------------------------------------------------------------------------------*/
# 文章類別（Classes）
/*-----------------------------------------------------------------------------------*/
function stf_post_format_class($classes) {
    global $post;
	
	$post_format = get_post_meta($post->ID, 'stf_post_head', true);
	if( !empty($post_format) )
		$classes[] = 'stf_'.$post_format;
		
	return $classes;
}
add_filter('post_class', 'stf_post_format_class');


function stf_post_class( $classes = false ) {
    global $post;
	
	$post_format = get_post_meta($post->ID, 'stf_post_head', true);
	if( !empty($post_format) ){
		if( !empty($classes) ) $classes .= ' ';
		$classes .= 'stf_'.$post_format;
	}
	if( !empty($classes) )	
		echo 'class="'.$classes.'"';
}


/*-----------------------------------------------------------------------------------*/
# 語系切換功能
/*-----------------------------------------------------------------------------------*/
function stf_language_selector_flags(){
	if( function_exists( 'icl_get_languages' )){
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			echo '<div id="stf_lang_switcher">';
			foreach($languages as $l){
				if(!$l['active']) echo '<a href="'.$l['url'].'">';
					echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
				if(!$l['active']) echo '</a>';
			}
			echo '</div>';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
# 使用首頁產生器顯示最新文章區塊
/*-----------------------------------------------------------------------------------*/
$option_posts_per_page = get_option( 'posts_per_page' );
add_action( 'init', 'stf_modify_posts_per_page', 0);
function stf_modify_posts_per_page() {
    add_filter( 'option_posts_per_page', 'stf_option_posts_per_page' );
}
function stf_option_posts_per_page( $value ) {
 
    global $option_posts_per_page;
    if ( is_home() && stf_get_option('on_home') == 'boxes' ) {
        return 1;
    } else {
        return $option_posts_per_page;
    }
}

/*-----------------------------------------------------------------------------------*/
# 在文章摘要顯示文章段落首字大寫下沉效果和高亮 shortcodes 效果
/*-----------------------------------------------------------------------------------*/
function stf_remove_shortcodes($text = '') {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = str_replace("[dropcap]","",$text);
		$text = str_replace("[/dropcap]","",$text);
		$text = str_replace("[highlight]","",$text);
		$text = str_replace("[/highlight]","",$text);

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$excerpt_length = apply_filters('excerpt_length', 56);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[&hellip;]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
add_filter( 'get_the_excerpt', 'stf_remove_shortcodes', 1);
	
/*-----------------------------------------------------------------------------------*/
# 針對 WP 3.6.0
/*-----------------------------------------------------------------------------------*/
// 給舊版本的影片 shortcode
function stf_video_fix_shortcodes($content){   
	$v = '/(\[(video)\s?.*?\])(.+?)(\[(\/video)\])/';
	$content = preg_replace( $v , '[embed]$3[/embed]' , $content);
    return $content;
}
add_filter('the_content', 'stf_video_fix_shortcodes', 0);

// 為了防止 wordpress 匯入媒體元素的 CSS 檔案
function stf_audio_video_shortcode(){
	if( !is_admin()){
		wp_enqueue_script( 'wp-mediaelement' );
		return false;
	}
}
add_filter('wp_audio_shortcode_library', 'stf_audio_video_shortcode');
add_filter('wp_video_shortcode_library', 'stf_audio_video_shortcode');

// Responsive 影片
function stf_video_width_shortcode( $html ){
	$width1 = 'width: 100%';
	return preg_replace('/width: ([0-9]*)px/',$width1,$html);
}
add_filter('wp_video_shortcode', 'stf_video_width_shortcode');
?>