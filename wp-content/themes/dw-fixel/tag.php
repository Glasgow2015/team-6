<?php 
global $paged, $block_class, $paged;
get_header();
?>  
<?php if( have_posts() ) : ?>
    <div class="headline">
        <div class="headline-wrap">
            <header class="entry-header">
                <h2 class="entry-title"><?php printf( __( 'Tag : %s', 'dw' ), single_tag_title( '', false ) ); ?></h2>
            </header>
            <?php if( term_description() ) : ?>
            <p><?php echo term_description(); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div id="main" role="main" class="masonry" >
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
    </div>
    <?php dw_show_more_button(); ?>
<?php else: ?>
    <?php get_template_part( 'content', 'none' ) ?>
<?php endif; ?>
<?php get_footer(); ?>