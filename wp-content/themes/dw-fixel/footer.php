<?php  
?>
			<footer class="site-footer" role="contentinfo">
				<small>
				<?php _e('Copyight &copy; 2013 by','dw') ?> <a href="#">DW Fixel.</a> 
				<?php _e('Proudly powered by ','dw') ?>
				<a href="http://wordpress.org/" target="_blank" title="Semantic Personal Publishing Platform">WordPress</a>.
				<br/> <?php _e('Theme DW Fixel by','dw') ?> 
				<a href="http://www.designwall.com/" rel="nofollow" target="_blank">DesignWall</a>.
				</small>
			</footer>
			<?php get_sidebar('top'); ?>
		</div>
	</div>
	<?php if( is_home() || is_archive() || is_search() ) : ?>
		<?php get_template_part('modal') ?>
	<?php endif; ?>
	<a id="back-to-top" class="scrollup" href="#"><i class="icon-chevron-up"></i></a>
	<?php wp_footer(); ?>
</body>
</html>