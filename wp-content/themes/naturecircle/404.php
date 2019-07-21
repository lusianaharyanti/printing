<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Naturecircle_Theme
 * @since Naturecircle 1.0
 */

$naturecircle_opt = get_option( 'naturecircle_opt' );

get_header();

?>
	<div class="main-container error404">
		<div class="container">
			<div class="search-form-wrapper">
				<h1>404</h1>
				<h2><?php esc_html_e( "PAGE NOT BE FOUND", 'naturecircle' ); ?></h2>
				<p class="home-link"><?php esc_html_e( "Sorry but the page you are looking for does not exist, have been removed, name changed or is temporarity unavailable.", 'naturecircle' ); ?></p>
				<?php get_search_form(); ?>
				<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr__( 'Back to home', 'naturecircle' ); ?>"><?php esc_html_e( 'Back to home page', 'naturecircle' ); ?></a>
			</div>
		</div> 
	</div>
</div>
<?php get_footer(); ?>