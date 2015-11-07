<?php 
global $paged, $block_class, $paged;

get_header(); 
?>  
<?php if( have_posts() ) : ?>
    <div class="headline">
        <div class="headline-wrap">
            <header class="entry-header">
                <h2 class="entry-title">
                    <?php
                        if ( is_day() ) :
                            printf( __( 'Daily Archives: %s', 'dw' ), '<span>' . get_the_date() . '</span>' );
                        elseif ( is_month() ) :
                            printf( __( 'Monthly Archives: %s', 'dw' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'dw' ) ) . '</span>' );
                        elseif ( is_year() ) :
                            printf( __( 'Yearly Archives: %s', 'dw' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'dw' ) ) . '</span>' );
                        else :
                            _e( 'Archives', 'dw' );
                        endif;
                    ?>
                </h2>
            </header>
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