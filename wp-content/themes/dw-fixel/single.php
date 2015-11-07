<?php  get_header(); ?>
<?php while( have_posts() ) : the_post(); ?>
<div id="main" role="main">
    <div class="single-page row-fluid">
        <div class="modal-buttons modal-nav">
            <?php $next = get_next_post();?>
            <button data-post-id="<?php the_ID(); ?>" <?php echo ! empty($next) ? ' data-href="'.get_permalink( $next->ID ).'" title="'.htmlentities($next->post_title).'"' : ''; ?> type="button" class="left next-post <?php echo empty($next) ? 'hide' : ''; ?>"><i class="icon-chevron-left"></i></button>
            <?php $prev = get_previous_post(); ?>
            <button data-post-id="<?php the_ID() ?>" <?php echo ! empty($prev) ? 'data-href="'.get_permalink( $prev->ID ).'"  title="'.htmlentities($prev->post_title).'"' : ''; ?> type="button" class="right prev-post <?php echo empty($prev) ? 'hide' : ''; ?>"><i class="icon-chevron-right"></i></button>
        </div>
        <div class="social-bar">
            <ul>
                <?php $url = get_permalink(); ?>
                <li><a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode($url); ?>" title="<?php _e('Share to Facebook','dw') ?>" target='_blank'><i class="icon-facebook"></i><span><?php echo dw_get_facebook_count( $url ) ?></span></a></li>
                <li><a  class="twitter" href="https://twitter.com/intent/tweet?source=webclient&amp;text=<?php echo get_the_title() . rawurlencode( $url ) ?>" title="<?php _e('Share to Twitter','dw') ?>"  target='_blank'><i class="icon-twitter"></i><span><?php echo dw_get_twitter_count( $url ); ?></span></a></li>
                <li><a  class="googleplus" href="https://plus.google.com/share?url=<?php echo rawurlencode($url ); ?>" title="<?php _e('Share to Google+','dw') ?>" target='_blank'><i class="icon-google-plus"></i><span><?php echo dw_get_plusones_share_count( $url ) ?></span></a></li>
                <li><a href="#comments" class="comment" title="<?php _e('Comment this post','dw') ?>"><i class="icon-comment"></i><span><?php comments_number( '0', '1', '%') ?></span></a></li>
                <li><a class="email" href="mailto:?Subject=<?php echo rawurlencode( get_the_title() ) ?>" title="<?php _e('Email this post','dw') ?>"><i class="icon-envelope-alt"></i></a></li>
                <li><a  class="print" href="javascript: window.print();" title="<?php _e('Print this post','dw') ?>"><i class="icon-print"></i></a></li>
            </ul>
        </div>
        <div class="single-detail">
            <div class="scroller">
                <div class="main-content span8">
                    <?php get_template_part('content','single'); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'dw' ), 'after' => '</div>' ) ); ?>
                    <?php comments_template(); ?>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php get_footer(); ?>