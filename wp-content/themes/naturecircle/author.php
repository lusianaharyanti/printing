<?php
/**
 * The template for displaying Author Archive pages
 *
 * Used to display archive-type pages for posts by an author.
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
		Naturecircle_Class::naturecircle_post_thumbnail_size('naturecircle-category-thumb');
		break;
	case 'largeimage':
		$naturecircle_blogclass = 'blog-large';
		$naturecircle_blogcolclass = 9;
		$naturecircle_postthumb = '';
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

						<?php
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							 *
							 * We reset this later so we can run the loop
							 * properly with a call to rewind_posts().
							 */
							the_post();
						?>

						<header class="archive-header">
							<h1 class="archive-title"><?php printf( esc_html__( 'Author Archives: %s', 'naturecircle' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
						</header><!-- .archive-header -->

						<?php
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();
						?>

						<?php
						// If a user has filled out their description, show a bio on their entries.
						if ( get_the_author_meta( 'description' ) ) : ?>
						<div class="author-info archives">
							<div class="author-avatar">
								<?php
								/**
								 * Filter the author bio avatar size.
								 *
								 * @since Naturecircle 1.0
								 *
								 * @param int $size The height and width of the avatar in pixels.
								 */
								$author_bio_avatar_size = apply_filters( 'naturecircle_author_bio_avatar_size', 68 );
								echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
								?>
							</div><!-- .author-avatar -->
							<div class="author-description">
								<h2><?php printf( esc_html__( 'About %s', 'naturecircle' ), get_the_author() ); ?></h2>
								<p><?php the_author_meta( 'description' ); ?></p>
							</div><!-- .author-description	-->
						</div><!-- .author-info -->
						
						<?php endif; ?>

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'content', get_post_format() ); ?>
						<?php endwhile; ?> 
						<div class="pagination">
							<?php Naturecircle_Class::naturecircle_pagination(); ?>
						</div>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div> 
			</div>
			<?php if( $naturecircle_blogsidebar=='right') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</div>
		
	</div>
 
</div>
<?php get_footer(); ?>