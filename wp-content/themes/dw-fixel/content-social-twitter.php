<?php  
global $block_class, $social_wall_settings;
?>
<?php if( $social_wall_settings['twitter-query']) : ?>
<article data-post-id="<?php the_ID() ?>" id="block-social-twitter" class="<?php echo $block_class; ?> format-image">
    <div class="block-inner">
        <div class="view-social">
            <img src="<?php echo DW_URI; ?>assets/img/tw.png" />
            <div class="mask tw">
                <div class="social-content"><i class="icon icon-loading"></i></div>
            </div>
        </div>
        <?php do_action( 'dw_block_content_footer' ) ?>
    </div>
</article>
<?php endif; ?>