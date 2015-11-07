<?php
global $block_class;

$post_id = get_the_ID();
$post_content = get_the_content();
$reg = preg_match('/\[gallery[^\]]*ids=\"(.*)\"[^\]]*\]/i', $post_content, $matches );
?>
<?php if( isset( $matches[1] ) ): ?>
    <?php $ids = explode( ',', $matches[1] ); ?>
    <?php  if( ! empty($ids) ) : ?>
        <?php $i = 0; ?>
        <article id="post-<?php the_ID() ?>" <?php post_class($block_class) ?>>
            <div id="carousel-<?php echo $post_id; ?>" class="carousel slide" data-interval="5000">
                <div class="carousel-inner">
                <?php foreach ($ids as $id) : ?>
                    <?php $image = get_post( $id ); ?>
                    <div class="<?php echo $i == 0 ? 'active' : ''; ?> item">
                        <?php echo wp_get_attachment_image( $id, 'post-big-box' ); ?>
                        <div class="carousel-caption">
                            <h4><?php echo $image->post_title ?></h4>
                            <p><?php echo esc_html( $image->post_excerpt ) ?></p>
                        </div>
                    </div>
                    <?php $i ++; ?>
                <?php  endforeach; ?>
                </div>
                <a class="carousel-control left" href="#carousel-<?php echo $post_id; ?>" data-slide="prev"><i class="icon-chevron-left"></i></a>
                <a class="carousel-control right" href="#carousel-<?php echo $post_id; ?>" data-slide="next"><i class="icon-chevron-right"></i></a>
                <?php do_action( 'dw_block_content_footer' ) ?>
            </div>
        </article>
    <?php endif; ?>
<?php else: ?>
    <?php get_template_part( 'content','empty' ) ?>
<?php endif; ?>