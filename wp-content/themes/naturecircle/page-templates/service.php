<?php
/**
 * Template Name: Service page
 *
 * Description: Service page template
 *
 * @package WordPress
 * @subpackage Naturecircle_Theme
 * @since Naturecircle 1.0
 */
$naturecircle_opt = get_option( 'naturecircle_opt' );

get_header();
?>
<div class="main-container service-page">
	<div class="title-breadcrumb">
		<div class="container">
			<div class="title-breadcrumb-inner">
				<?php Naturecircle_Class::naturecircle_breadcrumb(); ?>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header> 
			</div>
		</div>
	</div>
	<div class="page-content">
		<div class="service-container">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>