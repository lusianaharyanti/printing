<?php
/**
 * Template Name: About page
 *
 * Description: About page template
 *
 * @package WordPress
 * @subpackage Naturecircle_Theme
 * @since Naturecircle 1.0
 */
$naturecircle_opt = get_option( 'naturecircle_opt' );

get_header();
?>
<div class="main-container about-page">
	<div class="title-breadcrumb">
		<div class="container">
			<div class="title-breadcrumb-inner"> 
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header> 
				<?php Naturecircle_Class::naturecircle_breadcrumb(); ?>
			</div>
		</div>
	</div>
	<div class="page-content">
		<div class="about-container">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>