<?php  
global $block_class, $social_wall_settings;
?>
<?php if( $social_wall_settings['facebook-name']) : ?>
<article id="block-social-facebook" class="<?php echo $block_class ?> format-image">
    <div class="block-inner">
        <div class="view-social">
            <img src="<?php echo DW_URI ?>assets/img/fb.png" />
            <div class="mask fb"><div class="social-content"><i class="icon icon-loading"></i></div></div>
        </div>
        <?php do_action( 'dw_block_content_footer' ) ?>
    </div>
</article>
<?php endif; ?>