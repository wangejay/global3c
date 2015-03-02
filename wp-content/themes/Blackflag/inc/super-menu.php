<?php 
/**
 * Black flag super menu
**/ 
?>
<?php
class bf_super_menu extends Walker_Nav_Menu {
	
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "\n<ul class=\"menu-links inside-menu\">\n";
	}
	
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "</ul>\n";
	}
	
	function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
		global $wp_query;
		$cat = $item->object_id;
		$indent = ($depth) ? str_repeat ( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes = empty ( $item->classes ) ? array () : ( array ) $item->classes;
		$class_names = join ( ' ', apply_filters ( 'nav_menu_css_class', array_filter ( $classes ), $item ) );
		$class_names = ' class="' . esc_attr ( $class_names ) .'"';
		
		$output .= $indent . '<li id="menu-item-bf' . $item->ID . '"' . $value . $class_names . '>';
		$attributes = ! empty ( $item->attr_title ) ? ' title="' . esc_attr ( $item->attr_title ) . '"' : '';
		$attributes .= ! empty ( $item->target ) ? ' target="' . esc_attr ( $item->target ) . '"' : '';
		$attributes .= ! empty ( $item->xfn ) ? ' rel="' . esc_attr ( $item->xfn ) . '"' : '';
		$attributes .= ! empty ( $item->url ) ? ' href="' . esc_attr ( $item->url ) . '"' : '';
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . ' title="'.$item->title.'" class="menu-link">';
		$item_output .= $args->link_before . apply_filters ( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';	
		
		$parent_tax = get_post_meta( $item->menu_item_parent, '_menu_item_object', true );
		$children = get_posts ( array (
				'post_type' => 'nav_menu_item',
				'nopaging' => true,
				'numberposts' => 1,
				'meta_key' => '_menu_item_menu_item_parent',
				'meta_value' => $item->ID ,
		) );		
				
		if ($depth == 0 && $item->object == 'category' && ! empty ( $children )) {
			$item_output .= '<div class="sub-menu-wrapper">';
		} elseif (! empty ( $children )) {
			$item_output .= '<div class="sub-meni">';
		} elseif ($depth == 0 && $item->object == 'category' && empty ( $children )) {
		} elseif ($depth == 1 && $item->object == 'category' && ! empty ( $children ) && $parent_tax == 'category') {
		}
		$item_output .= $args->after;				
		if ($depth == 0 && empty ( $children ) && $item->object == 'category' ) {
		} 
	
		elseif ($depth < 2 && $item->object == 'category' )  {
				  if ($parent_tax == 'category' || $parent_tax == ''){
						$cat = $item->object_id;		
						$sign_before_link = get_option('bf_sign_before_link'); 
						$item_output .= '<div class="sub-menu img-featured-category"><ul class="menu-thumb img-featured">';		
						global $post;
						$menuposts = get_posts ( array('numberposts' => 1, 'offset' => 0, 'cat' => $cat ));			
						foreach ( $menuposts as $post ) :
							setup_postdata ( $post );			
							$post_title = wp_trim_words( get_the_title(), 10 );
							$post_link = get_permalink ();
							$post_image = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), "big-cat-thumb" );				
							$menu_post_image = '<img src="' . $post_image [0] . '" alt="' . $post_title . '">';			
							$item_output .= '
							<li>
								<a href="' . $post_link . '" title="' . $post_title . '">' . $menu_post_image . '</a>
								<div class="img-featured-title">
									<h2>
										<a href="' . $post_link . '" class="blog-post-title">' . $post_title . '</a>
									</h2>
								</div><!--img-featured-title-->
							</li>';
						endforeach;
						wp_reset_query ();			
						$item_output .= '</ul>';
			
			
			
						$item_output .= '<ul class="menu-thumbs-small">';		
						global $post;
						$menuposts = get_posts ( array('numberposts' => 4, 'offset' => 1, 'cat' => $cat ));			
						foreach ( $menuposts as $post ) :
							setup_postdata ( $post );			
							$post_title = wp_trim_words( get_the_title(), 10 );
							$category = get_the_category( $post );
							$post_link = get_permalink ();
							$post_image = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), "small-thumb" );
							$post_date = get_the_date();	
							$menu_post_image = '<img src="' . $post_image [0] . '" alt="' . $post_title . '">';			
							$item_output .= '<li>
								<div class="featured-posts-image">				
								<a href="' . $post_link . '" title="' . $post_title . '">' . $menu_post_image . '</a>
								</div><!--featured-posts-image-->
									<div class="featured-posts-text">
										<span class="category-icon"><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></span>
										<div class="featured-posts-title"><h2><a href="' . $post_link . '" >' . $post_title . '</a></h2>
										</div><!--featured-posts-title-->
										<div class="post-date"> 
											' . $post_date . '
                       					 </div><!--post-date-->
									</div><!--featured-posts-text-->
							</li>';
						endforeach;
						wp_reset_query ();			
		
						$item_output .= '</ul></div>';
						
				  
				  }
			  } 
		elseif ($depth == 0 && $item->object != 'category') {
		}	

		$output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	function end_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
		$children = get_posts ( array (
				'post_type' => 'nav_menu_item',
				'nopaging' => true,
				'numberposts' => 1,
				'meta_key' => '_menu_item_menu_item_parent',
				'meta_value' => $item->ID ,
		) );
		if (! empty ( $children )) {$output .= '</div>';}
		$output .= "</li>\n";
	}
}