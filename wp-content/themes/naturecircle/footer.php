<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Naturecircle_Theme
 * @since Naturecircle 1.0
 */
 
$naturecircle_opt = get_option( 'naturecircle_opt' );
?>
			<?php if(isset($naturecircle_opt['footer_layout']) && $naturecircle_opt['footer_layout']!=''){
				$footer_class = str_replace(' ', '-', strtolower($naturecircle_opt['footer_layout']));
			} else {
				$footer_class = '';
			} ?>

			<div class="footer <?php echo esc_attr($footer_class);?>">
				<?php
				if ( isset($naturecircle_opt['footer_layout']) && $naturecircle_opt['footer_layout']!="" ) {

					$jscomposer_templates_args = array(
						'orderby'          => 'title',
						'order'            => 'ASC',
						'post_type'        => 'templatera',
						'post_status'      => 'publish',
						'posts_per_page'   => 30,
					);
					$jscomposer_templates = get_posts( $jscomposer_templates_args );

					if(count($jscomposer_templates) > 0) {
						foreach($jscomposer_templates as $jscomposer_template){
							if($jscomposer_template->post_title == $naturecircle_opt['footer_layout']){
								echo do_shortcode($jscomposer_template->post_content);
							}
						}
					}
				} else { ?>
					<div class="widget-copyright default-copyright">
						<?php esc_html_e( "Copyright", 'naturecircle' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ) ?>"> <?php echo get_bloginfo('name') ?></a> <?php echo date('Y') ?>. <?php esc_html_e( "All Rights Reserved", 'naturecircle' ); ?>
					</div>
				<?php
				}
				?>
			</div>
		</div><!-- .page -->
	</div><!-- .wrapper -->
	<!--<div class="naturecircle_loading"></div>-->
	<?php if ( isset($naturecircle_opt['back_to_top']) && $naturecircle_opt['back_to_top'] ) { ?>
	<div id="back-top" class="hidden-xs hidden-sm hidden-md"></div>
	<?php } ?>
	<?php wp_footer(); ?> 
</body>
</html>