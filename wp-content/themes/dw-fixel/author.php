<?php 
global $paged, $block_class, $paged;

get_header();   
?>  
<?php if( have_posts() ) : the_post(); ?>
    <div class="headline">
        <div class="headline-wrap">
            <header class="entry-header">
                <h2 class="entry-title"> <?php echo get_the_author(); ?></h2>
            </header>
        </div>
    </div>
    <div id="main" role="main" class="masonry" >
        <?php $first = true; rewind_posts(); ?>
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