<?php 
/**
 * Black flag review posts
**/ 
?>
<?php

function bf_review() {

	global $post;
	$heading = get_post_meta( $post->ID, 'bf_review_heading', true );
	$image_meta = get_post_meta( $post->ID, 'bf_review_image', true );
	$total_score = get_post_meta( $post->ID, 'bf_review_total', true );
	$good = get_post_meta( $post->ID, 'bf_review_good', true );
	$bad = get_post_meta( $post->ID, 'bf_review_bad', true );
	function get_attachment_id_from_src ($image_meta) {
		global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_meta'";
		$id = $wpdb->get_var($query);
		return $id;
		}
	$image = wp_get_attachment_image_src(get_attachment_id_from_src ($image_meta), 'review-img');
	$items       = get_post_meta( $post->ID, 'bf_review_item', true );
	echo '<div id="review-wrapper">';
	echo '<div class="review-image"><img src="'.$image[0].'"><div class="total-score">'.$total_score.'</div></div>';
	echo '<div class="review-wrapper-title-good-bad"><div class="review-title">'.$heading.'</div>'	;

				if ( $good ) {
					echo '<div class="review-good"><div class="good-title">The Good</div><ul>';						
						foreach( $good as $item ) {	
						echo '<li>';
						echo '<div class="good-text">'.$item['bf_review_good'].'</div>';
 						echo '</li>';	
						}
					echo '</ul></div>';
				}

				if ( $bad ) {
					echo '<div class="review-bad"><div class="bad-title">The Bad</div><ul>';		
						foreach( $bad as $item ) {	
						echo '<li>';
						echo '<div class="bad-text">'.$item['bf_review_bad'].'</div>';
 						echo '</li>';	
						}						
					echo '</ul></div>';
				}
				echo '</div>';
				
				if ( $items ) {
					echo '<div class="review-title-scores"><ul>'	;
						foreach( $items as $item ) {
							$result = 'width:'.$item['bf_review_item_score'] *10..'%';
						  echo '<li>';
 						  echo '<div class="review-item-title">'.$item['bf_review_item_title'].'</div><div class="review-item-score">'. $item['bf_review_item_score'].'</div>';
						  echo '<div class="score-line"><div class="score-width" style="'.$result.'";></div></div>';
						  echo '</li>';
					}
					echo '</ul></div>';
				}
		
		echo '</div>';
}
?>