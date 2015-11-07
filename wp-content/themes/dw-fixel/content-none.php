<div class="headline">
    <div class="headline-wrap">
        <header class="entry-header">
            <h2 class="entry-title"> <?php _e('Nothing Found','dw') ?></h2>
        </header>
    </div>
</div>
<div id="main" role="main" class="masonry" >
    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
        <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'dw' ), admin_url( 'post-new.php' ) ); ?></p>
    <?php elseif ( is_search() ) : ?>
        <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'dw' ); ?></p>
    <?php get_search_form(); ?>
    <?php else : ?>
        <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'dw' ); ?></p>
        <?php get_search_form(); ?>
    <?php endif; ?>
</div>