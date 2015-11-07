<div id="post-details" class="modal hide" tabindex="-1" data-backdrop="false" role="dialog">
    <div class="modal-wrap">
        <div class="modal-body">
            <div class="single-detail row-fluid">
                <div class="modal-buttons modal-close">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
                </div>
                <div class="modal-buttons modal-nav">
                    <?php $next = get_next_post();?>
                    <button data-post-id="<?php the_ID(); ?>" <?php echo ! empty($next) ? ' data-href="'.get_permalink( $next->ID ).'" title="'.htmlentities($next->post_title).'"' : ''; ?> type="button" class="left next-post <?php echo empty($next) ? 'hide' : ''; ?>"><i class="icon-chevron-left"></i></button>
                    <?php $prev = get_previous_post(); ?>
                    <button data-post-id="<?php the_ID() ?>" <?php echo ! empty($prev) ? 'data-href="'.get_permalink( $prev->ID ).'"  title="'.htmlentities($prev->post_title).'"' : ''; ?> type="button" class="right prev-post <?php echo empty($prev) ? 'hide' : ''; ?>"><i class="icon-chevron-right"></i></button>
                </div>
                <div class="modal-content">
                    <?php _e('Content loading','dw') ?>  
                </div>
            </div>
        </div>
    </div>
</div>