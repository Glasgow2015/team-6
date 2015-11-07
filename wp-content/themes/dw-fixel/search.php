<?php 
global $paged, $block_class, $paged;
get_header(); 
?>  
<div class="headline">
    <div class="headline-wrap">
        <header class="entry-header">
            <h2 class="entry-title">
                <?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?>
            </h2>
        </header>
    </div>
</div>
<div id="main" role="main" class="masonry" >
    <?php if( have_posts() ) : ?>
        <?php $first = true; ?>
        <?php  while( have_posts() ) : the_post(); ?>
            <?php 
                $block_class = 'block';
                if( dw_is_featured_post() ) { 
                    $block_class .= ' w2';
                } 
                if ( $first && ! dw_is_featured_post() ) {
                    $first = false;
                    $block_class .= ' grid-sizer';
                }
            ?>
            <?php get_template_part( 'content', get_post_format() ); ?>
        <?php endwhile; ?>
        <?php dw_paging_nav(); ?>
    <?php else : ?>
        <article id="post-0" class="post no-results not-found">
            <header class="entry-header">
                <h1 class="entry-title"><?php _e( 'Nothing Found', 'dw' ); ?></h1>
            </header>
            <div class="entry-content">
                <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'dw' ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </article>
    <?php endif; ?>
</div>
<?php dw_show_more_button(); ?>
<?php get_footer(); ?>