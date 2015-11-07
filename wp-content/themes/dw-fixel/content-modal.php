<div class="social-bar">
    <ul>
        <?php $url = get_permalink(); ?>
        <li><a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode($url); ?>" title="<?php _e('Share to Facebook','dw') ?>" target='_blank'><i class="icon-facebook"></i><span><?php echo dw_get_facebook_count( $url ) ?></span></a></li>
        <li><a  class="twitter" href="https://twitter.com/intent/tweet?source=webclient&amp;text=<?php echo get_the_title() . rawurlencode( $url ) ?>" title="<?php _e('Share to Twitter','dw') ?>"  target='_blank'><i class="icon-twitter"></i><span><?php echo dw_get_twitter_count( $url ); ?></span></a></li>
        <li><a class="googleplus" href="https://plus.google.com/share?url=<?php echo rawurlencode($url ); ?>" title="<?php _e('Share to Google+','dw') ?>" target='_blank'><i class="icon-google-plus"></i><span><?php echo dw_get_plusones_share_count( $url ) ?></span></a></li>
        <li><a href="#comments" class="comment" title="<?php _e('Comment this post','dw') ?>"><i class="icon-comment"></i><span><?php comments_number( '0', '1', '%') ?></span></a></li>
        <li><a class="email" href="mailto:?Subject=<?php echo rawurlencode( get_the_title() ) ?>" title="<?php _e('Email this post','dw') ?>"><i class="icon-envelope-alt"></i></a></li>
        <li><a  class="print" href="javascript: window.print();" title="<?php _e('Print this post','dw') ?>"><i class="icon-print"></i></a></li>
    </ul>
</div>
<div id="modal-content">
    <div class="scroller">
        <div class="main-content span8">
            <article> 
                <header class="entry-header">
                <h2 class="entry-title"><?php the_title() ?></h2>
                <div class="entry-meta">
                    <i class="icon-user"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="<?php echo get_the_author_meta( 'display_name' ) ?>"><?php echo get_the_author_meta( 'display_name' ) ?></a>&nbsp;
                    <i class="icon-time"></i>&nbsp;<a href="<?php echo get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ) ?>"><time datetime="<?php the_time() ?>"><?php the_date(); ?></time></a>&nbsp;
                    <?php $terms = get_the_category(); ?>
                    <?php if( !empty($terms) ) : ?>
                        <i class="icon-folder-open"></i>
                        <?php $i = 0; ?>
                        <?php foreach ( $terms as $term ) : $i++; ?>
                            <a href="<?php echo get_term_link( $term, 'category' ) ?>"><?php echo trim( $term->name . ( $i < count( $terms ) ? ',' : '' ) ); ?></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                </header>
                <div class="entry-content">
                    <?php global $more; $more = 1; ?>
                    <?php the_content() ?>
                </div>
                <div class="clear"></div>
                <footer class="meta-bottom ">
                    <?php the_tags('<i class="icon-tags"></i> '); ?>
                </footer>
            </article>
            <?php global $withcomments; $withcomments = true; ?>
            <?php comments_template() ?>
        </div>
        <?php get_sidebar(); ?>
    </div> 
</div>