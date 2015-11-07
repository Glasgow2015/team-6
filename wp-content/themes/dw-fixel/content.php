<?php  
global $block_class;
?>
<article id="post-<?php the_ID() ?>" <?php post_class($block_class) ?>>
    <div class="block-inner">
        <?php if( has_post_thumbnail() ) : ?>
            <div class="view-pic">
                <?php the_post_thumbnail() ?>
                <div class="mask">
                <a href="<?php the_permalink(); ?>" data-toggle="modal" data-post-id="<?php the_ID(); ?>" class="info">
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
        <?php else: ?>
            <header class="block-header">
                <h1 class="block-title">
                    <a href="<?php the_permalink(); ?>" data-toggle="modal" data-post-id="<?php the_ID(); ?>"><?php the_title() ?></a>
                </h1>
                <div class="block-meta">
                    <?php printf('<i class="icon-user"></i> <a href="%s" rel="author">%s</a> <span class="date"><i class="icon-time"></i> <a href="%5$s"><time pubdate datetime="%s">%s</time></a></span>',
                        get_author_posts_url( get_the_author_meta('ID')  ),
                        get_the_author(),
                        get_the_time('c'),
                        get_the_date(),
                        get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') )
                    ); ?>
                </div>
            </header>
            <div class="block-content">
                <?php global $more; $more = 0; ?>
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
        <?php do_action( 'dw_block_content_footer' ) ?>
    </div>
</article>