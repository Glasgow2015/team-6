<?php  
/**
 * Template Name: Custom Page
 * The template for displaying custom pages that was build by dw shortcode.
 */
?>
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
		        <article>
		          <div class="entry-content">
		            <?php echo do_shortcode( get_the_content() );?>
		          </div>
		        </article>
          <?php endwhile; ?>
        </div>
    </div>
  </div>
<?php get_footer() ?>