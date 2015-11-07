<?php if ( post_password_required() ) { return; } ?>
<div id="comments">        
    <?php if ( have_comments() ) : ?>
    <div class="comments-area">
        <h4 class="comments-count">
            <?php printf( _n( 'One comment', '%1$s comments', get_comments_number(), 'dw' ), number_format_i18n( get_comments_number() ) ); ?>
        </h4>
        <ul id="comment-list" class="post-list">
            <?php
                if( ! get_query_var( 'comments_per_page' ) ) {
                    $per_page = get_option('comments_per_page');
                } else {
                    $per_page = get_query_var( 'comments_per_page' );
                }
                wp_list_comments( array(
                    'callback'  => 'dw_comment',
                    'per_page'  => $per_page
                ) );
            ?>
        </ul>
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav id="comment-nav-below" class="navigation" role="navigation">
            <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'dw' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'dw' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'dw' ) ); ?></div>
        </nav>
        <?php endif; ?>
        <?php
        if ( ! comments_open() && get_comments_number() ) : ?>
        <p class="nocomments"><?php _e( 'Comments are closed.' , 'dw' ); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if( comments_open() ) : ?>
    <div class="comment-form">
        <?php 
            comment_form( array(
                'id_form'       => 'comment',
                'id_submit'     => 'submit',
                'title_reply'   => __('Leave a reply','dw'),
                'comment_field' => '<textarea name="comment" id="comment"></textarea>',
                'comment_notes_after' => '',
                'fields'        => apply_filters( 'comment_form_default_fields', array(
                    'author' =>
                        '<p class="comment-form-author"><label for="author">' . __( 'Your Name', 'dw' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                        '" size="30"  /></p>',

                    'email' =>
                        '<p class="comment-form-email"><label for="email">' . __( 'Your Email', 'dw' ) . ( $req ? '<span class="required">*</span>' : '' ) .'</label> ' . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                        '" size="30"  /></p>'
                ) ),
                'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment *', 'noun', 'dw' ). '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',
            ) ); 
        ?>
    </div>
    <?php endif; ?>
</div>