<article> 
    <?php if( ! is_page() ) : ?>
    <header class="entry-header">
        <h2 class="entry-title"><?php the_title() ?></h2>
        <div class="entry-meta">
            <i class="icon-user"></i>&nbsp;<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="<?php echo get_the_author_meta( 'display_name' ) ?>"><?php echo get_the_author_meta( 'display_name' ) ?></a>
            <i class="icon-time"></i>&nbsp;<a href="<?php echo get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ) ?>"><time datetime="<?php the_time() ?>"><?php the_date(); ?></time></a>            
            <?php $terms = get_the_category(); ?>
            <?php if( !empty($terms) ) : ?>
                <i class="icon-folder-open"></i>&nbsp;
                <?php $i = 0; ?>
                <?php foreach ( $terms as $term ) : $i++;?>
                <a href="<?php echo get_term_link( $term, 'category' ) ?>"><?php echo trim( $term->name . ( $i < count( $terms ) ? ',' : '' ) ); ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </header>
    <?php endif; ?>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    <div class="clear"></div>
    <footer class="meta-bottom ">
        <?php the_tags('<i class="icon-tags"></i> '); ?>
    </footer>
</article>