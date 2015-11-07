<?php get_header() ?>
<div class="headline">
  <div class="headline-wrap">
    <header class="entry-header">
      <h2 class="entry-title"><?php the_title(); ?></h2>
    </header>
  </div>
</div>
<div id="main" role="main">
  <div class="single-page row-fluid">
      <div class="main-content span12">
        <?php while( have_posts() ) : the_post(); ?>
          <?php get_template_part('content','page') ?>
          <?php comments_template( '', true ); ?>
        <?php endwhile; ?>
      </div>
  </div>
</div>
<?php get_footer() ?>