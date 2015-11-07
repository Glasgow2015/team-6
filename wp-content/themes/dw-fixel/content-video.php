<?php   
global $block_class;
?>
<article id="post-<?php the_ID() ?>" <?php post_class( $block_class ) ?>>
    <div class="block-inner">
        <div class="view-video">
            <img src="<?php echo dw_content_video_thumbnail(); ?>" alt="">
            <div class="mask">
                <a href="<?php the_permalink(); ?>" data-toggle="modal" data-post-id="<?php the_ID(); ?>" class="info">
                    <i class="icon-play-circle"></i>
                    <div class="mask-content">
                        <h1 class="block-title"><?php the_title(); ?></h1>
                        <span class="line"></span>
                        <div class="block-meta">
                        <?php printf(' <span class="date"><i class="icon-time"></i> <time pubdate datetime="%s">%s</time></span>',
                            get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ),
                            get_the_date()
                        ); ?>
                        </div>
                    </div>
                </a>
          </div>
        </div>
        <?php do_action( 'dw_block_content_footer' ) ?>
    </div>
</article>