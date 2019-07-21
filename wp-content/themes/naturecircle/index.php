<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Naturecircle_Theme
 * @since Naturecircle 1.0
 */

$naturecircle_opt = get_option( 'naturecircle_opt' );

get_header();

$naturecircle_blogstyle = Naturecircle_Class::naturecircle_show_style_blog();


$naturecircle_bloglayout = 'sidebar';

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
		Naturecircle_Class::naturecircle_post_thumbnail_size('naturecircle-category-thumb');
		break;
	case 'largeimage':
		$naturecircle_blogclass = 'blog-large';
		$naturecircle_blogcolclass = 9;
		Naturecircle_Class::naturecircle_post_thumbnail_size('naturecircle-category-thumb');
		break;
	case 'grid':
		$naturecircle_blogclass = 'grid';
		$naturecircle_blogcolclass = 9;
		Naturecircle_Class::naturecircle_post_thumbnail_size('naturecircle-category-thumb');
		break;
	default:
		$naturecircle_blogclass = 'blog-nosidebar';
		$naturecircle_blogcolclass = 12;
		$naturecircle_blogsidebar = 'none';
		Naturecircle_Class::naturecircle_post_thumbnail_size('naturecircle-post-thumb');
} 

?>

<div class="main-container"> 
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
			<?php if($naturecircle_blogsidebar=='left') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			
			<div class="col-12 <?php if ( is_active_sidebar( 'sidebar-1' ) ) { echo 'col-lg-'.esc_attr($naturecircle_blogcolclass);} ?>">
			
				<div class="page-content blog-page <?php echo esc_attr($naturecircle_blogclass.' '.$naturecircle_blogstyle); if($naturecircle_blogsidebar=='left') {echo ' left-sidebar'; } if($naturecircle_blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if ( have_posts() ) : ?>

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
							
							<?php get_template_part( 'content', get_post_format() ); ?>
							
						<?php endwhile; ?> 
						<div class="pagination">
							<?php Naturecircle_Class::naturecircle_pagination(); ?>
						</div>
					<?php else : ?>

						<article id="post-0" class="post no-results not-found">

						<?php if ( current_user_can( 'edit_posts' ) ) :
							// Show a different message to a logged-in user who can add posts.
						?>
							<header class="entry-header">
								<h1 class="entry-title"><?php esc_html_e( 'No posts to display', 'naturecircle' ); ?></h1>
							</header>

							<div class="entry-content">
								<p><?php printf( wp_kses(__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'naturecircle' ), array('a'=>array('href'=>array()))), admin_url( 'post-new.php' ) ); ?></p>
							</div><!-- .entry-content -->

						<?php else :
							// Show the default message to everyone else.
						?>
							<header class="entry-header">
								<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'naturecircle' ); ?></h1>
							</header>

							<div class="entry-content">
								<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'naturecircle' ); ?></p>
								<?php get_search_form(); ?>
							</div><!-- .entry-content -->
						<?php endif; // end current_user_can() check ?>

						</article><!-- #post-0 -->

					<?php endif; // end have_posts() check ?>
				</div> 
			</div>
			<?php if( $naturecircle_blogsidebar=='right') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</div>
	</div> 
</div>
<?php get_footer(); ?>