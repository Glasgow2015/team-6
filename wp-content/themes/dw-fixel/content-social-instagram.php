<?php  
global $block_class, $social_wall_settings;
?>
<?php $query = $social_wall_settings['instagram-search']; ?>
<?php if( $query ) : ?>
<article id="block-social-instagram" class="<?php echo $block_class ?> format-gallery" >
    <div class="block-inner">
        <?php $instagram = getInstagramItems( $query, 20); ?>
        <?php if( ! empty($instagram) ) : ?>
        <div id="carousel-instagram" class="carousel slide">
            <div class="carousel-inner">
                <?php $i = 0; ?>
                <?php foreach ($instagram as $img) : ?>
                <div class="<?php echo $i == 0 ? 'active' : ''; ?> item">
                    <a target="_blank" href="http://instagram.com/<?php echo $img->author ?>"><img src="<?php echo $img->image; ?>" alt="<?php echo $img->title ?>"></a>
                    <div class="carousel-caption">
                        <p><?php echo wp_trim_words( $img->title, 55, ' <a href="http://instagram.com/'.$img->author.'">...</a>' ); ?></p>
                        <p><?php echo $img->desc ?></p>
                    </div>
                </div>
                <?php $i ++; ?>
                <?php  endforeach; ?>
            </div>
            <a class="carousel-control left" href="#carousel-instagram" data-slide="prev"><i class="icon-chevron-left"></i></a>
            <a class="carousel-control right" href="#carousel-instagram" data-slide="next"><i class="icon-chevron-right"></i></a>
        </div>
        <?php endif; ?>
        <?php do_action( 'dw_block_content_footer' ) ?>
    </div>
</article>
<?php endif; ?>