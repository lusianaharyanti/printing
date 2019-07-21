<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Naturecircle_Theme
 * @since Naturecircle 1.0
 */

$naturecircle_opt = get_option( 'naturecircle_opt' );
 
$naturecircle_blogsidebar = 'right';
if(isset($naturecircle_opt['sidebarblog_pos']) && $naturecircle_opt['sidebarblog_pos']!=''){
	$naturecircle_blogsidebar = $naturecircle_opt['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$naturecircle_blogsidebar = $_GET['sidebar'];
}
?>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="secondary" class="col-12 col-lg-3">
		<div class="sidebar-inner sidebar-border <?php echo esc_attr($naturecircle_blogsidebar);?>">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</div><!-- #secondary -->
<?php endif; ?>