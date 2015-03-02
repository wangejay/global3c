<?php 
/**
 * Black flag comments
**/ 
?>
<?php
$commenter = wp_get_current_commenter ();
$req = get_option ( 'require_name_email' );
$aria_req = ($req ? " aria-required='true'" : '');

$bf_comments_name = get_option('bf_comments_name');
$bf_comments_email = get_option('bf_comments_email');
$bf_comments_website = get_option('bf_comments_website');
$fields = array (
		'author' => '<p class="comment-author">' . '<label for="author">' . $bf_comments_name . '</label> ' . ($req ? '<span class="required">*</span>' : '') . '<input id="author" name="author" type="text" value="' . esc_attr ( $commenter ['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		
		'email' => '<p class="comment-email"><label for="email">' . 'Email' . '</label> ' . ($req ? '<span class="required">*</span>' : '') . '<input id="email" name="email" type="text" value="' . esc_attr ( $commenter ['comment_author_email'] ) . '"  size="30"' . $aria_req . ' /></p>',
		
		'url'    => '<p class="comment-url"><label for="url">' . 'Website'  . '</label>' .
		'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"/></p>'
);


$bf_comments_post_comment = get_option('bf_comments_post_comment');
$bf_comments_post_reply = get_option('bf_comments_post_reply');
$bf_comments_post_reply_to = get_option('bf_comments_post_reply_to');
$bf_comments_cancel_reply = get_option('bf_comments_cancel_reply');
$bf_comments_logged_in_as = '<p class="logged-in-as">' . sprintf( __( get_option('bf_comments_logged_in_as') .' <a href="%1$s">%2$s</a>. <a href="%3$s" title="'.get_option('bf_comments_logged_in_as_log_out').'">'.get_option('bf_comments_logged_in_as_log_out').'</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>';




$comments_args = array (
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" height="310" width="630" aria-required="true"></textarea></p>',
		'comment_notes_after' => '',
		'comment_notes_before' => '',
		'title_reply' =>'Leave a Reply',
		'label_submit' => $bf_comments_post_comment,
		'id_submit'            => 'submit',
		'logged_in_as'		=> $bf_comments_logged_in_as,
		'title_reply'          => $bf_comments_post_reply,
    	'title_reply_to'       => $bf_comments_post_reply_to,
    	'cancel_reply_link'    => $bf_comments_cancel_reply,
		'fields' => $fields 
);




function bf_discussion($comment, $args, $depth) {
	$bf_comments_post_reply = get_option('bf_comments_post_reply');
	$GLOBALS ['comment'] = $comment;
	
	?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div class="gravatar-comment">
		<?php echo get_avatar( get_comment_author_email(), '60' ); ?>
	</div>
	<!--gravatar-comment-->
	<div class="comment-author-name">
		<?php comment_author(); ?>
	</div>
	<!--comment-author-name-->
	<div class="comment-date-time">
		<?php comment_date('j F Y'); ?>
		at
		<?php comment_time(); ?>
	</div>
	<!--comment-date-time-->
	<article id="comment-<?php comment_ID(); ?>" class="comment">
		<div class="comment-content content">
			<?php comment_text(); ?>
		</div>
	<?php comment_reply_link( array_merge( $args, array( 'reply_text' =>  $bf_comments_post_reply, 'depth' => $depth) ) ); ?>
	</article>
	<!--comment-->
</li>
<?php } ?>
<div class="comment-count">
	<?php 
	$bf_comments_no_comment = get_option('bf_comments_no_comment');
	$bf_comments_one_comment = get_option('bf_comments_one_comment');
	$bf_comments_number_comments = get_option('bf_comments_number_comments');

	comments_number( $bf_comments_no_comment, $bf_comments_one_comment, '% '.$bf_comments_number_comments ); 
	
	?>
</div>
<!--comment-count-->
<?php comment_form( $comments_args ); ?>
<div class="discussion">
	<?php wp_list_comments( array (
		'callback' => 'bf_discussion'
		));
	?>
	<div class="comment-pagination">
		<?php paginate_comments_links(); ?>
	</div>
	<!--comment-pagination-->
</div>
<!--discussion-->