<?php  
global $is_edit_block;
?>
<article class="block format-post" id="add-block-container">
    <div class="block-inner">
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a title="New Post" href="#new-post-standard" data-toggle="tab"><i class="icon-pencil"></i></a></li>
            <?php if( is_home() || $is_edit_block ) : ?>
            <li><a title="Facebook" href="#new-post-facebook" data-toggle="tab"><i class="icon-facebook"></i></a></li>
            <li><a title="Twitter" href="#new-post-twitter" data-toggle="tab"><i class="icon-twitter"></i></a></li>
            <li><a title="Instagram" href="#new-post-instagram" data-toggle="tab"><i class="icon-instagram"></i></a></li>
            <li><a title="Flickr" href="#new-post-flickr" data-toggle="tab"><i class="icon-flickr"></i></a></li>
            <li><a title="Google+" href="#new-post-google-plus" data-toggle="tab"><i class="icon-google-plus"></i></a></li>
            <?php endif; ?>
        </ul>
        <form name="publish-new-block-form" id="publish-new-block-form" method="post" action="" >
            <?php wp_nonce_field( '_dw_add_post_nonce' ); ?>
            <input type="hidden" name="action" value="dw-publish-new-block">
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane in active" id="new-post-standard">
                    <input type="hidden" name="type" value="post">
                    <div class="control-group">
                        <div class="controls">
                            <textarea placeholder="<?php _e('Start writing here...','dw') ?>" id="new-post-content" class="new-post-content" name="new-post-content"></textarea>
                        </div>
                    </div>
                    <input type="text" placeholder="<?php _e('Add title...','dw') ?>" class="extra-field" id="new-post-title" name="new-post-title">
                    <div class="icons">
                    <input type="hidden" id="new-post-thumbnail" name="new-post-thumbnail" value="">
                    <a id="new-post-thumbnail-select" href="#" title="Photo"><i class="icon-camera"></i></a>
                    </div>
                </div>
                <?php if( is_home() || $is_edit_block ) : ?>
                <div class="tab-pane setting" id="new-post-facebook">
                    <input type="hidden" name="type" value="social-facebook">
                    <h3><?php _e('Facebook block setting','dw') ?></h3>
                    <label for="username"><?php _e('Facebook Username','dw') ?></label>
                    <input type="text" name="facebook-name" value="<?php echo dw_get_theme_option('facebook-name') ?>">
                </div>
                <div class="tab-pane setting" id="new-post-twitter">
                    <input type="hidden" name="type" value="social-twitter">
                    <h3><?php _e('Twitter block setting','dw') ?></h3>
                    <label for="username"><?php _e('Query search','dw') ?></label>
                    <input type="text" name="twitter-name" value="<?php echo dw_get_theme_option('twitter-name') ?>">
                    <label for="key"><?php _e('Consumer Key','dw') ?></label>
                    <input type="text" name="twitter-consumer-key" value="<?php echo dw_get_theme_option('twitter-consumer-key') ?>">
                    <label for="secret"><?php _e('Consumer Secret','dw') ?></label>
                    <input type="text" name="twitter-consumer-secret"  value="<?php echo dw_get_theme_option('twitter-consumer-secret') ?>">
                </div>
                <div class="tab-pane setting" id="new-post-instagram">
                    <input type="hidden" name="type" value="social-instagram">
                    <h3><?php _e('Instagram block setting','dw') ?></h3>
                    <label for="username"><?php _e('Query search','dw') ?></label>
                    <input type="text" name="instagram-search" value="<?php echo dw_get_theme_option('instagram-search') ?>">
                </div>
                <div class="tab-pane setting" id="new-post-flickr">
                    <input type="hidden" name="type" value="social-flickr">
                    <h3><?php _e('Flickr block setting','dw') ?></h3>
                    <label for="username"><?php _e('Flickr ID','dw') ?></label>
                    <input type="text" name="flickr-id" value="<?php echo dw_get_theme_option('flickr-id') ?>" >
                    <span><?php _e('Flickr ID, your flickr id example : 7801264@N03','dw') ?></span>
                </div>
                <div class="tab-pane setting" id="new-post-google-plus">
                    <input type="hidden" name="type" value="social-google-plus">
                    <h3><?php _e('Google','dw') ?><span style="vertical-align:super;">+</span> <?php _e('block setting','dw') ?></h3>
                    <label for="username"><?php _e('Profile Name','dw') ?></label>
                    <input type="text" name="google-plus-name" value="<?php echo dw_get_theme_option('google-plus-name') ?>" >
                    <label for="ggurl"><?php _e('Profile URL','dw') ?></label>
                    <input type="text" name="google-plus-url"  value="<?php echo dw_get_theme_option('google-plus-url') ?>" >
                </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-small btn-publish-new-block" name="publish-new-block"><?php _e('Save','dw') ?></button>
            </div>
        </form>
    </div>
</article>