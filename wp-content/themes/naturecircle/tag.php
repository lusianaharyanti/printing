<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
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
			
			<?php if($naturecircle_blogsidebar=='left') : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			
			<div class="col-12 <?php if ( is_active_sidebar( 'sidebar-1' ) ) { echo 'col-lg-'.esc_attr($naturecircle_blogcolclass);} ?>">
			
				<div class="page-content blog-page <?php echo esc_attr($naturecircle_blogclass.' '.$naturecircle_blogstyle); if($naturecircle_blogsidebar=='left') {echo ' left-sidebar'; } if($naturecircle_blogsidebar=='right') {echo ' right-sidebar'; } ?>">
					<?php if ( have_posts() ) : ?>
						<header class="archive-header">
							<h1 class="archive-title"><?php printf( wp_kses(__( 'Tag Archives: %s', 'naturecircle' ), array('span'=>array())), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

						<?php if ( tag_description() ) : // Show an optional tag description ?>
							<div class="archive-meta"><?php echo tag_description(); ?></div>
						<?php endif; ?>
						</header><!-- .archive-header -->

						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the post format-specific template for the content. If you want to
							 * this in a child theme then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );

						endwhile;
						?>
						
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