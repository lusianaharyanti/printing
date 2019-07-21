<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Naturecircle_Theme
 * @since Naturecircle 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php $naturecircle_opt = get_option( 'naturecircle_opt' ); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>> 
<div class="wrapper <?php if($naturecircle_opt['page_layout']=='box'){echo 'box-layout';} ?>">
	<div class="page-wrapper"> 
		<?php if(isset($naturecircle_opt['header_layout']) && $naturecircle_opt['header_layout']!=''){
			$header_class = str_replace(' ', '-', strtolower($naturecircle_opt['header_layout']));
		} else {
			$header_class = '';
		} ?>
		<div class="header-container <?php echo esc_attr($header_class);?>">
			<div class="header"> 
				<div class="<?php if(isset($naturecircle_opt['sticky_header']) && $naturecircle_opt['sticky_header']) {echo 'header-sticky';} ?> <?php if ( is_admin_bar_showing() ) {echo 'with-admin-bar';} ?>">
					<div class="header-content">
						<?php
						if ( isset($naturecircle_opt['header_layout']) && $naturecircle_opt['header_layout']!="") {
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
									if($jscomposer_template->post_title == $naturecircle_opt['header_layout']){
										echo do_shortcode($jscomposer_template->post_content);
									}
								}
							}
						} else {
							?>
							<div class="header-default">    
								<div class="row">
									<div class="col-12 col-md-5"> 
										<?php if ( has_nav_menu( 'primary' ) ) : ?>
											<div class="nav-container">
												<div class="horizontal-menu visible-large">
													<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'primary-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
												</div>
											</div>  
										<?php endif; ?>
										<?php if ( has_nav_menu( 'mobilemenu' ) ) : ?>
											<div class="visible-small mobile-menu"> 
												<div class="mbmenu-toggler">
													<?php if(isset($naturecircle_opt['mobile_menu_label']) && ($naturecircle_opt['mobile_menu_label'] != '') ) { 
														echo esc_html($naturecircle_opt['mobile_menu_label']); 
													} else { 
														echo esc_html__('menu', 'naturecircle'); 
													}?>
													<span class="mbmenu-icon"><i class="fa fa-bars"></i></span>
												</div>
												<?php wp_nav_menu( array( 'theme_location' => 'mobilemenu', 'container_class' => 'mobile-menu-container', 'menu_class' => 'nav-menu' ) ); ?>
											</div> 
										<?php endif; ?> 
									</div>
									<div class="col-12 col-md-2"> 
										<h1 class="logo site-title"><span class="logo-inner"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1> 
									</div>
									<div class="col-12 col-md-5 box-right">
										<div class="header-search">
											<div class="icons"><span class="icon icon-Search"></span></div>
											<?php get_search_form(); ?>
										</div>
									</div>
								</div>   
							</div>  
							<?php
						} 
						?>
					</div> 
				</div>
			</div>
			<div class="clearfix"></div>
		</div>