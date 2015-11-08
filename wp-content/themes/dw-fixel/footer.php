<?php  
?>
			<footer class="site-footer" role="contentinfo">
				<small>
				<?php _e('Copyight &copy; 2015 by','dw') ?> <a href="#">Pancreatic Cancer Scotland, a Registered Scottish Charity - number SC041740.</a> 
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