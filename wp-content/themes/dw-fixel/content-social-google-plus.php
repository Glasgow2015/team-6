<?php  
global $block_class, $social_wall_settings;
?>
<?php if( $social_wall_settings['google-plus-url'] || $social_wall_settings['google-plus-name'] ) : ?>
<article id="block-social-google-plus" class="<?php echo $block_class ?> format-image">
    <div class="block-inner">
        <div class="view view-social">
            <img src="<?php echo DW_URI; ?>assets/img/gg.png" />
            <div class="mask gg">
                <div class="social-content">
                    <p><span>+1</span> <?php echo $social_wall_settings['google-plus-name'] ?> on <span><?php _e('Google','dw') ?></span><span style="vertical-align:super;">+</span></p>
                    <div class="g-follow" data-href="<?php echo $social_wall_settings['google-plus-url'] ?>" ></div>
                </div>
            </div>
        </div>
        <?php do_action( 'dw_block_content_footer' ) ?>
    </div>
</article>
<?php endif; ?>