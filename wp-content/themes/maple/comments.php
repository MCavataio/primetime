<?php
//display comment
if ( post_password_required() ) {
    return false;
}
?>
<div id="comments" class="comments-area single-el">
    <?php if ( have_comments() ) : ?>
        <div class="comment-title widget-title block-title-wrap">
            <h3>
                <?php comments_number( esc_html__('No Comment', 'tn'), esc_html__('1 Comment', 'tn' ), esc_html__('% Comments', 'tn') ); ?>
            </h3>
        </div>
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php  esc_html_e( 'Comment navigation', 'tn' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'tn' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'tn' ) ); ?></div>
            </nav><!-- #comment-nav-above -->
        <?php endif; ?>

        <ol class="comment-list entry">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' =>75,
            ));
            ?>
        </ol><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-below" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php  esc_html_e( 'Comment navigation', 'tn' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'tn' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'tn' ) ); ?></div>
            </nav><!-- #comment-nav-below -->
        <?php endif; // check for comment navigation ?>
    <?php endif; // have_comments() ?>

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php  esc_html_e( 'Comments are closed.', 'tn' ); ?></p>
    <?php endif; ?>
    <?php
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    if ( is_user_logged_in() ) {
	    $current_user = wp_get_current_user();
	    $args         = array(
		    'title_reply'          => esc_html__( 'Leave a Response', 'tn' ),
		    'comment_notes_before' => '',
		    'comment_notes_after'  => '',
		    'comment_field'        => '<p class="comment-form-comment"><label for="comment" >' . esc_html__( 'Comment', 'tn' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . _x( 'Message...', 'noun', 'tn' ) . '"></textarea></p>',
		    'fields'               => apply_filters( 'comment_form_default_fields', array(
			    'author' => '<p class="comment-form-author col-xs-12"><label for="author" >' . esc_html__( 'Name', 'tn' ) . '</label><input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name', 'tn' ) . $aria_req . ' /></p>',
			    'email'  => '<p class="comment-form-email col-xs-12"><label for="email" >' . esc_html__( 'Email', 'tn' ) . '</label><input id="email" name="email" type="text" placeholder="' . esc_html__( 'Email', 'tn' ) . '..." ' . $aria_req . ' /></p>',
			    'url'    => '<p class="comment-form-url col-xs-12"><label for="url">' . esc_html__( 'Website', 'tn' ) . '</label>' . '<input id="url" name="url" type="text" placeholder="' . esc_html__( 'Website', 'tn' ) . '..." ' . $aria_req . ' /></p>'
		    ) ),
		    'id_submit'            => 'comment-submit',
		    'label_submit'         => esc_html__( 'Post Comment', 'tn' )
	    );
    } else {
	    $args = array(
		    'title_reply'          => esc_html__( 'Leave a Response', 'tn' ),
		    'comment_notes_before' => '',
		    'comment_notes_after'  => '',
		    'comment_field'        => '<p class="comment-form-comment"><label for="comment" >' . esc_html__( 'Comment', 'tn' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . _x( 'Message', 'noun', 'tn' ) . '"></textarea></p>',
		    'fields'               => apply_filters( 'comment_form_default_fields', array(
			    'author' => '<p class="comment-form-author col-xs-12"><label for="author" >' . esc_html__( 'Name', 'tn' ) . '</label><input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name', 'tn' ) . '..." size="30" ' . $aria_req . ' /></p>',
			    'email'  => '<p class="comment-form-email col-xs-12"><label for="email" >' . esc_html__( 'Email', 'tn' ) . '</label><input id="email" name="email" size="30" type="text" placeholder="' . esc_html__( 'Email', 'tn' ) . '..." ' . $aria_req . ' /></p>',
			    'url'    => '<p class="comment-form-url col-xs-12"><label for="url">' . esc_html__( 'Website', 'tn' ) . '</label>' . '<input id="url" name="url" type="text" placeholder="' . esc_html__( 'Website', 'tn' ) . '..." ' . $aria_req . ' /></p>'
		    ) ),
		    'id_submit'            => 'comment-submit',
		    'label_submit'         => esc_html__( 'Post Comment', 'tn' )
	    );
    };
    ?>
    <?php
    comment_form($args);
    ?>

</div><!-- #comments -->
