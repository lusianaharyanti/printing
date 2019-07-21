<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

global $wp_query, $woocommerce_loop;

$naturecircle_opt = get_option( 'naturecircle_opt' );

$shoplayout = 'sidebar';
if(isset($naturecircle_opt['shop_layout']) && $naturecircle_opt['shop_layout']!=''){
	$shoplayout = $naturecircle_opt['shop_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$shoplayout = $_GET['layout'];
}
$shopsidebar = 'left';
if(isset($naturecircle_opt['sidebarshop_pos']) && $naturecircle_opt['sidebarshop_pos']!=''){
	$shopsidebar = $naturecircle_opt['sidebarshop_pos'];
}
if(isset($_GET['sidebar']) && $_GET['sidebar']!=''){
	$shopsidebar = $_GET['sidebar'];
}
switch($shoplayout) {
	case 'fullwidth':
		Naturecircle_Class::naturecircle_shop_class('shop-fullwidth');
		$shopcolclass = 12;
		$shopsidebar = 'none';
		$productcols = 4;
		break;
	default:
		Naturecircle_Class::naturecircle_shop_class('shop-sidebar');
		$shopcolclass = 9;
		$productcols = 3;
}

$naturecircle_viewmode = Naturecircle_Class::naturecircle_show_view_mode();
?>
<div class="shop-products products row <?php echo esc_attr($naturecircle_viewmode);?> <?php echo esc_attr($shoplayout);?>">