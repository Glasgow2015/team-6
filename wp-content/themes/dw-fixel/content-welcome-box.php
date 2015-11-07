<?php  
global $block_class, $social_wall_settings;
?>
<?php if( !empty($social_wall_settings['heading-1']) || !empty($social_wall_settings['heading-2']) || !empty($social_wall_settings['short-info']) ) :  ?>
<article id="block-welcome-box" class="<?php echo $block_class ?> head">
    <div class="block-inner">
        <h1><?php echo $social_wall_settings['heading-1']; ?></h1>
        <h2><?php echo $social_wall_settings['heading-2']; ?></h2>
        <p><?php echo $social_wall_settings['short-intro']; ?></p>
        <?php do_action( 'dw_block_content_footer' ) ?>
    </div>
</article>
<?php endif; ?>