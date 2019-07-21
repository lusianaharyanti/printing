<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Naturecircle_Theme
 * @since Naturecircle 1.0
 */

$naturecircle_opt = get_option( 'naturecircle_opt' );

get_header();

$naturecircle_blogstyle = Naturecircle_Class::naturecircle_show_style_blog();

$naturecircle_bloglayout = 'nosidebar';
if(isset($naturecircle_opt['blog_layout']) && $naturecircle_opt['blog_layout']!=''){
	$naturecircle_bloglayout = $naturecircle_opt['blog_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$naturecircle_bloglayout = $_GET['layout'];
}
$naturecircle_blogsidebar = 'right';
if(isset($naturecircle_opt['sidebarblog_pos']) && $naturecircle_opt['sidebarblog_pos']!=''){
	$naturecircle_blogsidebar = $naturecircle_opt['sidebarblog_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$naturecircle_blogsidebar = $_GET['sidebar'];
}
switch($naturecircle_bloglayout) {
	case 'sidebar':
		$naturecircle_blogclass = 'blog-sidebar';
		$naturecircle_blogcolclass = 9;
		break;
	default:
		$naturecircle_blogclass = 'blog-nosidebar'; //for both fullwidth and no sidebar
		$naturecircle_blogcolclass = 12;
		$naturecircle_blogsidebar = 'none';
}
 
?>
<div class="main-container page-wrapper">
	<div class="title-breadcrumb">
		<div class="container">
			<div class="title-breadcrumb-inner"> 
				<header class="entry-header">
					<h1 class="entry-title"><?php if(isset($naturecircle_opt)) { echo esc_html($naturecircle_opt['blog_header_text']); } else { esc_html_e('Blog', 'naturecircle');}  ?></h1>
				</header> 
				<?php Naturecircle_Class::naturecircle_breadcrumb(); ?>
			</div>
		</div>
		
	</div>
	<div class="container">
		<div class="row">

			<?php
			$customsidebar = get_post_meta( $post->ID, '_naturecircle_custom_sidebar', true );
			$customsidebar_pos = get_post_meta( $post->ID, '_naturecircle_custom_sidebar_pos', true );

			if($customsidebar != ''){
				if($customsidebar_pos == 'left' && is_active_sidebar( $customsidebar ) ) {
					echo '<div id="secondary" class="col col-lg-3"><div class="sidebar-inner">';
						dynamic_sidebar( $customsidebar );
					echo '</div></div>';
				} 
			} else {
				if($naturecircle_blogsidebar=='left') {
					get_sidebar();
				}
			} ?>
			
			<div class="col-12 <?php echo 'col-lg-'.esc_attr($naturecircle_blogcolclass); ?>">
				<div class="page-content blog-page single <?php echo esc_attr($naturecircle_blogclass.' '.$naturecircle_blogstyle); if($naturecircle_blogsidebar=='left') {echo ' left-sidebar'; } if($naturecircle_blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', get_post_format() ); ?>

						<?php comments_template( '', true ); ?>
						
						<!--<nav class="nav-single">
							<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'naturecircle' ); ?></h3>
							<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'naturecircle' ) . '</span> %title' ); ?></span>
							<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'naturecircle' ) . '</span>' ); ?></span>
						</nav><!-- .nav-single -->
						
					<?php endwhile; // end of the loop. ?>
				</div>
			</div>
			<?php
			if($customsidebar != ''){
				if($customsidebar_pos == 'right' && is_active_sidebar( $customsidebar ) ) {
					echo '<div id="secondary" class="col-12 col-md-3">';
						dynamic_sidebar( $customsidebar );
					echo '</div>';
				} 
			} else {
				if($naturecircle_blogsidebar=='right') {
					get_sidebar();
				}
			} ?>
		</div>
	</div> 
</div>

<?php get_footer(); ?>