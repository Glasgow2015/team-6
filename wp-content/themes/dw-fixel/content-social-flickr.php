<?php 
global $block_class, $social_wall_settings;
?>
<?php  $flickr_id = $social_wall_settings['flickr-id']; ?>
<?php if( $flickr_id ) : ?>
    <?php $flickrs = get_flickrs( $flickr_id ); $i = 0; ?>
    <article id="block-social-flickr" class="<?php echo $block_class ?> format-gallery">
        <div class="block-inner">
            <div id="carousel-flickr" class="carousel slide">
                <div class="carousel-inner">
                    <?php if( ! empty($flickrs) ) : ?>
                        <?php foreach ( $flickrs as $flickr ) : ?>
                        <div class="<?php echo $i == 0 ? 'active' : '' ?> item">
                            <a target="_blank" href="<?php echo $flickr['url'] ?>" ><img src="<?php echo $flickr['photo_url']; ?>" /></a>
                            <div class="carousel-caption">
                                <h4><a href="<?php echo $flickr['url'] ?>" ><?php echo $flickr['title'] ?></a></h4>
                                <p><?php echo strip_tags( $flickr['description'] ) ?></p>
                            </div>
                        </div>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <a class="carousel-control left" href="#carousel-flickr" data-slide="prev"><i class="icon-chevron-left"></i></a>
                <a class="carousel-control right" href="#carousel-flickr" data-slide="next"><i class="icon-chevron-right"></i></a>
            </div>
            <?php do_action( 'dw_block_content_footer' ) ?>
        </div>
    </article>
<?php endif; ?>