<?php 
/**
 * Black flag meta-fields
**/ 
?>
<?php

//============Video link meta field=================

add_action ( 'load-post.php', 'blackflagmetabox' );
add_action ( 'load-post-new.php', 'blackflagmetabox' );

// Meta box setup function.

function blackflagmetabox() {
	add_action ( 'add_meta_boxes', 'blackflag_add_post_meta' );
	add_action ( 'save_post', 'blackflag_save_post_meta', 10, 2 );
}

//Display meta box.

function blackflag_add_post_meta() {
	add_meta_box ( 'blackflag-video-link', 'Featured Video', 'blackflag_video_link_box', 'post', 'normal', 'high' );
}

function blackflag_video_link_box($object, $box) {wp_nonce_field( basename( __FILE__ ), 'blackflag_video_link_nonce' ); ?>

<p>
	<label for="blackflag-video-link">
		<?php echo "Paste a link from Vimeo or Youtube, it will be embeded in the post."; ?>
	</label>
	<input class="widefat" type="text" name="blackflag-video-link" id="blackflag-video-link" value="<?php echo get_post_meta( $object->ID, 'blackflag_video_link', true ); ?>"size="30" />
</p>

<?php
}

//Save the metabox value.

function blackflag_save_post_meta($post_id, $post) {
	if (! isset ( $_POST ['blackflag_video_link_nonce'] ) || ! wp_verify_nonce ( $_POST ['blackflag_video_link_nonce'], basename ( __FILE__ ) ))
		return $post_id;
	$post_type = get_post_type_object ( $post->post_type );
	if (! current_user_can ( $post_type->cap->edit_post, $post_id ))
		return $post_id;
	$new_meta_value = (isset ( $_POST ['blackflag-video-link'] ) ? balanceTags ( $_POST ['blackflag-video-link'] ) : '');
	$meta_key = 'blackflag_video_link';
	$meta_value = get_post_meta ( $post_id, $meta_key, true );
	if ($new_meta_value && '' == $meta_value)
		add_post_meta ( $post_id, $meta_key, $new_meta_value, true );
	elseif ($new_meta_value && $new_meta_value != $meta_value)
		update_post_meta ( $post_id, $meta_key, $new_meta_value );
	elseif ('' == $new_meta_value && $meta_value)
		delete_post_meta ( $post_id, $meta_key, $meta_value );
}


function user_social_profile_fields($user) {
	
//================Author social links=================
	
	?>
<h3>
	<?php 'Social Profiles'; ?>
</h3>
<table class="form-table">
	<tr>
		<th><label for="twitter">
				<?php echo 'Twitter'; ?>
			</label></th>
		<td><input type="text" name="twitter" id="twitter"value="<?php echo get_the_author_meta( 'twitter', $user->ID ); ?>"class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="facebook">
				<?php echo 'Facebook'; ?>
			</label></th>
		<td><input type="text" name="facebook" id="facebook"value="<?php echo get_the_author_meta( 'facebook', $user->ID  ); ?>"class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="google">
				<?php echo 'Google+'; ?>
			</label></th>
		<td><input type="text" name="google" id="google"value="<?php echo get_the_author_meta( 'google', $user->ID  ); ?>"class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="pinterest">
				<?php echo 'Pinterest'; ?>
			</label></th>
		<td><input type="text" name="pinterest" id="pinterest"value="<?php echo get_the_author_meta( 'pinterest', $user->ID ); ?>"class="regular-text" /></td>
	</tr>
	<tr>
		<th><label for="instagram">
				<?php echo 'Instagram'; ?>
			</label></th>
		<td><input type="text" name="instagram" id="instagram" value="<?php echo get_the_author_meta( 'instagram', $user->ID  ); ?>"class="regular-text" /></td>
	</tr>
</table>
<?php
}
function save_user_social_profile_fields($user_id) {
	
//Save the metabox value.

	if (! current_user_can ( 'edit_user', $user_id ))
		return false;
	
	update_user_meta ( $user_id, 'twitter', $_POST ['twitter'] );
	update_user_meta ( $user_id, 'facebook', $_POST ['facebook'] );
	update_user_meta ( $user_id, 'google', $_POST ['google'] );
	update_user_meta ( $user_id, 'pinterest', $_POST ['pinterest'] );
	update_user_meta ( $user_id, 'instagram', $_POST ['instagram'] );
}
add_action ( 'show_user_profile', 'user_social_profile_fields' );
add_action ( 'edit_user_profile', 'user_social_profile_fields' );

add_action ( 'personal_options_update', 'save_user_social_profile_fields' );
add_action ( 'edit_user_profile_update', 'save_user_social_profile_fields' );

//==================Subtitle====================

    add_action( 'edit_form_after_title', 'bf_subtitle_meta_box' );
    add_action( 'save_post', 'bf_save_subtitle_meta_box', 10, 2 );

function bf_subtitle_meta_box( $object ) { ?>
    <div id="bf_subtitle">
    <p>
    
        <label>(optional)Please enter sub title or favorite quote from the text:</label>
        <input name="bf_sub_title" id="sw_title" style="width: 100%;" value="<?php echo esc_html( get_post_meta( $object->ID, 'bf_sub_title', true ), 1 ); ?>" />
        <input type="hidden" name="my_meta_box_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
    </p>
    </div>
<?php }

function bf_save_subtitle_meta_box( $post_id, $post ) {

    if (! isset ( $_POST ['my_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['my_meta_box_nonce'] , basename( __FILE__ ) ) )
        return $post_id;

    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;

    //Saving 1st Data
    
    $meta_value = get_post_meta( $post_id, 'bf_sub_title', true );
    $new_meta_value = stripslashes( $_POST['bf_sub_title'] );

    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, 'bf_sub_title', $new_meta_value, true );

    elseif ( $new_meta_value != $meta_value )
        update_post_meta( $post_id, 'bf_sub_title', $new_meta_value );

    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, 'bf_sub_title', $meta_value ); 
}
function bf_subtitle() {
		global $post;
		echo get_post_meta($post->ID, 'bf_sub_title', true);
}



//=======Review metabox===========

// Adds a box to the Posts edit screens. 
add_action( 'add_meta_boxes_post', 'bf_review_add_meta_boxes' );

// Saves the meta box custom data. 
add_action( 'save_post', 'bf_review_save_postdata', 10, 2 );

//Adds a box to the Post edit screens.
function bf_review_add_meta_boxes() {
    $post_types = get_post_types( array('public' => true), 'names' );
    $excluded_post_types = array('attachment');
    
    foreach ($post_types as $post_type) {
        if (!in_array($post_type, $excluded_post_types)) {
		
        	add_meta_box(
        		'bf-review-metabox',
        		'Review Item',
        		'bf_review_render_meta_box',
        		$post_type,
        		'normal',
        		'high'
        	);
        }
    }
}


//Render the meta box.

 
function bf_review_render_meta_box( $post ) {
	
// Retrieve an existing value from the database.
	$heading = get_post_meta( $post->ID, 'bf_review_heading', true );
	$image = get_post_meta( $post->ID, 'bf_review_image', true );
	
	
	
	
	
	$good = get_post_meta( $post->ID, 'bf_review_good', true );
	
	$goodCriteria = apply_filters('bf_review_good_criteria', array());
    $goodItems = array();
    foreach ($goodCriteria as $item) {
        $goodItems[] = array( 'bf_review_good' => $item);
    }
		
	$bad = get_post_meta( $post->ID, 'bf_review_bad', true );

	$badCriteria = apply_filters('bf_review_bad_criteria', array());
    $badItems = array();
    foreach ($badCriteria as $item) {
        $badItems[] = array( 'bf_review_bad' => $item);
    }

	$defaultCriteria = apply_filters('bf_review_default_criteria', array());
    $defaultItems = array();
    foreach ($defaultCriteria as $item) {
        $defaultItems[] = array( 'bf_review_item_title' => $item, 'bf_review_item_score' => '');
    }
	$items     = get_post_meta( $post->ID, 'bf_review_item', true );
	
	
	
	
	if ( $items == '' ) $items = $defaultItems; 
    
// Add an nonce field so we can check for it later.
	wp_nonce_field( basename( __FILE__ ), 'bf-review-item-nonce' );
	wp_nonce_field( basename( __FILE__ ), 'bf-review-heading-nonce' );
	wp_nonce_field( basename( __FILE__ ), 'bf-review-image-nonce' );
	wp_nonce_field( basename( __FILE__ ), 'bf-review-bad-nonce' );
	wp_nonce_field( basename( __FILE__ ), 'bf-review-good-nonce' );
	
?>
<p class="bf-review-field">
    <div id="post-review-title"><?php echo 'Review Item Title'; ?></div>
    <input type="text" name="bf_review_heading" id="bf_review_heading" value="<?php echo $heading; ?>" />
</p>
<p class="bf-image-field">
<div id="bf-image-preview-title"><?php echo 'Image Selection'; ?></div>
<input type="text" name="bf_review_image" id="bf_review_image" value="<?php echo $image; ?>"/>
<input type= "button" class="button" name="image_button" id="image_button" value="Choose Image" />
</p>


<div class="bf-image-preview-wrapper">
    <div id="bf-image-preview-title"><?php echo 'Preview Image'; ?></div>
	<img class="bf-image-preview" src="<?php echo $image; ?>" width="100%">
</div>



<div class="bf-good-wrapper">
<!-- Start repeater field good -->
<table id="bf-review-good" class="bf-review-good" width="100%">
  <thead>
    <tr>
      <th width="100%"><?php echo 'Good'; ?></th>
    </tr>
  </thead>
  <tbody>
    <?php if ( !empty($good) ) : ?>
    <?php foreach ( $good as $item ) { ?>
    <tr>
      <td><input type="text" class="widefat" name="bf_review_good[]" value="<?php if( !empty( $item['bf_review_good'] ) ) echo $item['bf_review_good'] ; ?>" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
    <?php } ?>
    <?php else : ?>
    <tr>
      <td><input type="text" class="widefat" name="bf_review_good[]" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
    <?php endif; ?>
    
    <!-- empty hidden -->
    <tr class="empty-row screen-reader-text good">
      <td><input type="text" class="widefat" name="bf_review_good[]" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
  </tbody>
</table>
<table width="40%">
  <tr>
    <td width="80%"><a id="add-row-good" class="button" href="#">
      <?php echo 'Add another'; ?>
      </a></td>
  </tr>
</table>
</div>

<div class="bf-bad-wrapper">
<!-- Start repeater field bad -->
<table id="bf-review-bad" class="bf-review-bad" width="100%">
  <thead>
    <tr>
      <th width="100%"><?php echo 'bad'; ?></th>
    </tr>
  </thead>
  <tbody>
    <?php if ( !empty($bad) ) : ?>
    <?php foreach ( $bad as $item ) { ?>
    <tr>
      <td><input type="text" class="widefat" name="bf_review_bad[]" value="<?php if( !empty( $item['bf_review_bad'] ) ) echo $item['bf_review_bad'] ; ?>" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
    <?php } ?>
    <?php else : ?>
    <tr>
      <td><input type="text" class="widefat" name="bf_review_bad[]" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
    <?php endif; ?>
    
    <!-- empty hidden -->
    <tr class="empty-row screen-reader-text bad">
      <td><input type="text" class="widefat" name="bf_review_bad[]" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
  </tbody>
</table>
<table width="100%">
  <tr>
    <td width="80%"><a id="add-row-bad" class="button" href="#">
      <?php echo 'Add another'; ?>
      </a></td>
  </tr>
</table>
</div>

<!-- Start repeater field -->
<table id="bf-review-item" class="bf-review-item" width="100%">
  <thead>
    <tr>
      <th width="80%"><?php echo 'Feature Name'; ?></th>
      <th width="10%" class="dynamic-text"><?php echo 'Score (1-10)'; ?></th>
      <th width="10%"></th>
    </tr>
  </thead>
  <tbody>
    <?php if ( !empty($items) ) : ?>
    <?php foreach ( $items as $item ) { ?>
    <tr>
      <td><input type="text" class="widefat" name="bf_review_item_title[]" value="<?php if( !empty( $item['bf_review_item_title'] ) ) echo $item['bf_review_item_title'] ; ?>" /></td>
      <td><input type="text" min="1" step="1" autocomplete="off" class="widefat review-score" name="bf_review_item_score[]" value="<?php if ( !empty ($item['bf_review_item_score'] ) ) echo $item['bf_review_item_score']; ?>" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
    <?php } ?>
    <?php else : ?>
    <tr>
      <td><input type="text" class="widefat" name="bf_review_item_title[]" /></td>
      <td><input type="text" min="1" step="1" autocomplete="off" class="widefat review-score" name="bf_review_item_score[]" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
    <?php endif; ?>
    
    <!-- empty hidden -->
    <tr class="empty-row screen-reader-text scores">
      <td><input type="text" class="widefat" name="bf_review_item_title[]" /></td>
      <td><input type="text" min="1" step="1" autocomplete="off" class="widefat" name="bf_review_item_score[]" /></td>
      <td><a class="button remove-row" href="#">
        <?php echo 'Delete'; ?>
        </a></td>
    </tr>
  </tbody>
</table>
<table width="100%">
  <tr>
    <td width="80%"><a id="add-row" class="button" href="#">
      <?php echo 'Add another'; ?>
      </a></td>
    <td width="10%"><input type="text" class="widefat bf-review-total" name="bf_review_total" value="<?php echo get_post_meta( $post->ID, 'bf_review_total', true ); ?>" readonly /></td>
    <td width="10%"><?php echo'Total'; ?></td>
  </tr>
</table>

<?php
}


	// Saves the meta box.

function bf_review_save_postdata( $post_id, $post ) {

	if ( !isset( $_POST['bf-review-item-nonce'] ) || !wp_verify_nonce( $_POST['bf-review-item-nonce'], basename( __FILE__ ) ) )
		return;

	if ( !isset( $_POST['bf-review-heading-nonce'] ) || !wp_verify_nonce( $_POST['bf-review-heading-nonce'], basename( __FILE__ ) ) )
		return;
		
	if ( !isset( $_POST['bf-review-image-nonce'] ) || !wp_verify_nonce( $_POST['bf-review-image-nonce'], basename( __FILE__ ) ) )
		return;
		
	if ( !isset( $_POST['bf-review-good-nonce'] ) || !wp_verify_nonce( $_POST['bf-review-good-nonce'], basename( __FILE__ ) ) )
		return;
		
	if ( !isset( $_POST['bf-review-bad-nonce'] ) || !wp_verify_nonce( $_POST['bf-review-bad-nonce'], basename( __FILE__ ) ) )
		return;

	// If this is an autosave, our form has not been submitted, so we don't want to do anything. 
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	// Check the user's permissions.
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	$meta = array(

		'bf_review_total'    => $_POST['bf_review_total'],
		'bf_review_heading'     => $_POST['bf_review_heading'],
		'bf_review_image'     => $_POST['bf_review_image'],
	);

	foreach ( $meta as $meta_key => $new_meta_value ) {

		// Get the meta value of the custom field key. 4
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		//If there is no new meta value but an old value exists, delete it.
		if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );

		// If a new meta value was added and there was no previous value, add it. 
		elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		// If the new meta value does not match the old value, update it. 
		elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );
	}

	// Repeatable update and delete meta fields method.
	$title = $_POST['bf_review_item_title'];
	$score  = $_POST['bf_review_item_score'];

	$old   = get_post_meta( $post_id, 'bf_review_item', true );
	$new   = array();

	$count = count( $title );
	
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $title[$i] != '' )
			$new[$i]['bf_review_item_title'] = sanitize_text_field( $title[$i] );
		if ( $score[$i] != '' )
			$new[$i]['bf_review_item_score'] = sanitize_text_field( $score[$i] );
	}

	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'bf_review_item', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'bf_review_item', $old );
		
		
	// Repeatable field Good.
	$good = $_POST['bf_review_good'];
	$old   = get_post_meta( $post_id, 'bf_review_good', true );
	$new   = array();

	$count = count( $good );
	
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $good[$i] != '' )
			$new[$i]['bf_review_good'] = sanitize_text_field( $good[$i] );
	}

	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'bf_review_good', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'bf_review_good', $old );
		
		
	//Repeatable field Bad.
	$bad = $_POST['bf_review_bad'];
	$old   = get_post_meta( $post_id, 'bf_review_bad', true );
	$new   = array();

	$count = count( $bad );
	
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $bad[$i] != '' )
			$new[$i]['bf_review_bad'] = sanitize_text_field( $bad[$i] );
	}

	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'bf_review_bad', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'bf_review_bad', $old );

}

function review_scripts($hook) {
	if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
			wp_enqueue_script('bfreview', get_template_directory_uri() . '/js/bf-post.js', array('jquery'));
			wp_enqueue_style( 'bf-review-style', get_template_directory_uri() . '/inc/bf-post-style.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'review_scripts' );