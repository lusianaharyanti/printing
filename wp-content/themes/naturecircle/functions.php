<?php
/**
 * naturecircle functions and definitions
 */

/**
* Require files
*/
	//TGM-Plugin-Activation
require_once( get_template_directory().'/class-tgm-plugin-activation.php' );
	//Init the Redux Framework
if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) && file_exists( get_template_directory().'/theme-config.php' ) ) {
	require_once( get_template_directory().'/theme-config.php' );
}
	// Theme files
if ( !class_exists( 'naturecircle_widgets' ) && file_exists( get_template_directory().'/include/naturecirclewidgets.php' ) ) {
	require_once( get_template_directory().'/include/naturecirclewidgets.php' );
}

if ( !class_exists( 'vertical_menu_widgets' ) && file_exists( get_template_directory().'/include/vertical_menu_widgets.php' ) ) {
	require_once( get_template_directory().'/include/vertical_menu_widgets.php' );
}
if ( file_exists( get_template_directory().'/include/wooajax.php' ) ) {
	require_once( get_template_directory().'/include/wooajax.php' );
}
if ( file_exists( get_template_directory().'/include/map_shortcodes.php' ) ) {
	require_once( get_template_directory().'/include/map_shortcodes.php' );
}
if ( file_exists( get_template_directory().'/include/shortcodes.php' ) ) {
	require_once( get_template_directory().'/include/shortcodes.php' );
} 
Class Naturecircle_Class {
	
	/**
	* Global values
	*/
	static function naturecircle_post_odd_event(){
		global $wp_session;
		
		if(!isset($wp_session["naturecircle_postcount"])){
			$wp_session["naturecircle_postcount"] = 0;
		}
		
		$wp_session["naturecircle_postcount"] = 1 - $wp_session["naturecircle_postcount"];
		
		return $wp_session["naturecircle_postcount"];
	}
	static function naturecircle_post_thumbnail_size($size){
		global $wp_session;
		
		if($size!=''){
			$wp_session["naturecircle_postthumb"] = $size;
		}
		
		return $wp_session["naturecircle_postthumb"];
	}
	static function naturecircle_shop_class($class){
		global $wp_session;
		
		if($class!=''){
			$wp_session["naturecircle_shopclass"] = $class;
		}
		
		return $wp_session["naturecircle_shopclass"];
	}
	static function naturecircle_show_view_mode(){

		$naturecircle_opt = get_option( 'naturecircle_opt' );
		
		$naturecircle_viewmode = 'grid-view'; //default value
		
		if(isset($naturecircle_opt['default_view'])) {
			$naturecircle_viewmode = $naturecircle_opt['default_view'];
		}
		if(isset($_GET['view']) && $_GET['view']!=''){
			$naturecircle_viewmode = $_GET['view'];
		}
		
		return $naturecircle_viewmode;
	}
	static function naturecircle_show_style_blog () {
		$devita_opt = get_option( 'devita_opt' );
		$devita_blogstyle = 'style_v1';
		if(isset($devita_opt['blog_style']) && $devita_opt['blog_style']!=''){
			$devita_blogstyle = $devita_opt['blog_style'];
		}
		if(isset($_GET['blog_style']) && $_GET['blog_style']!=''){
			$devita_blogstyle = $_GET['blog_style'];
		}
		return $devita_blogstyle;
	}
	static function naturecircle_shortcode_products_count(){
		global $wp_session;
		
		$naturecircle_productsfound = 0;
		if(isset($wp_session["naturecircle_productsfound"])){
			$naturecircle_productsfound = $wp_session["naturecircle_productsfound"];
		}
		
		return $naturecircle_productsfound;
	}
	
	static function naturecircle_products_count() {
		global $wp_query;

		$naturecircle_opt = get_option( 'naturecircle_opt' );
		$perp = $naturecircle_opt['product_per_page'];
		$max_page = $wp_query->max_num_pages;
		$total = naturecircle_total_product_count();
		$number_products_page = (($perp*$max_page) - $total );
		$current_page = max( 1, get_query_var( 'paged' ) );
		$naturecircle_products_count =0;
		if ($current_page == $max_page) {
			
			$naturecircle_products_count = $perp - $number_products_page;
		}
		if ( wc_get_loop_prop( 'total' ) <= $perp || -1 === $perp ) {  $naturecircle_products_count = wc_get_loop_prop( 'total' ); }
		return $naturecircle_products_count;
	}
	/**
	* Constructor
	*/
	function __construct() {
		// Register action/filter callbacks
		
			//WooCommerce - action/filter
		add_theme_support( 'woocommerce' );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		add_filter( 'get_product_search_form', array($this, 'naturecircle_woo_search_form'));
		add_filter( 'woocommerce_shortcode_products_query', array($this, 'naturecircle_woocommerce_shortcode_count'));
		add_action( 'woocommerce_share', array($this, 'naturecircle_woocommerce_social_share'), 35 );
		add_action( 'woocommerce_archive_description', array($this, 'naturecircle_woocommerce_category_image'), 2 );
		
			//move message to top
		remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
		add_action( 'woocommerce_show_message', 'wc_print_notices', 10 ); 

			//remove cart total under cross sell
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
		add_action( 'cart_totals', 'woocommerce_cart_totals', 5 );

		//remove add to cart button after item
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
		
			//Single product organize   
		
		
			//WooProjects - Project organize
		remove_action( 'projects_before_single_project_summary', 'projects_template_single_title', 10 );
		add_action( 'projects_single_project_summary', 'projects_template_single_title', 5 );
		remove_action( 'projects_before_single_project_summary', 'projects_template_single_short_description', 20 );
		remove_action( 'projects_before_single_project_summary', 'projects_template_single_gallery', 40 );
		add_action( 'projects_single_project_gallery', 'projects_template_single_gallery', 40 );
		
			//WooProjects - projects list
		remove_action( 'projects_loop_item', 'projects_template_loop_project_title', 20 );
		
			//Theme actions
		add_action( 'after_setup_theme', array($this, 'naturecircle_setup'));
		add_action( 'tgmpa_register', array($this, 'naturecircle_register_required_plugins')); 
		add_action( 'widgets_init', array($this, 'naturecircle_override_woocommerce_widgets'), 15 );
		
		add_action( 'wp_enqueue_scripts', array($this, 'naturecircle_scripts_styles') );
		add_action( 'wp_head', array($this, 'naturecircle_custom_code_header'));
		add_action( 'widgets_init', array($this, 'naturecircle_widgets_init'));
		
		
		add_action('comment_form_before_fields', array($this, 'naturecircle_before_comment_fields'));
		add_action('comment_form_after_fields', array($this, 'naturecircle_after_comment_fields'));
		add_action( 'customize_register', array($this, 'naturecircle_customize_register'));
		add_action( 'customize_preview_init', array($this, 'naturecircle_customize_preview_js')); 
		add_action('admin_enqueue_scripts', array($this, 'naturecircle_admin_style'));
		
			//Theme filters 
		add_filter( 'loop_shop_per_page', array($this, 'naturecircle_woo_change_per_page'), 20 );
		add_filter( 'woocommerce_output_related_products_args', array($this, 'naturecircle_woo_related_products_limit'));
		add_filter( 'get_search_form', array($this, 'naturecircle_search_form'));
		add_filter('excerpt_more', array($this, 'naturecircle_new_excerpt_more'));
		add_filter( 'excerpt_length', array($this, 'naturecircle_change_excerpt_length'), 999 );
		add_filter('wp_nav_menu_objects', array($this, 'naturecircle_first_and_last_menu_class'));
		add_filter( 'wp_page_menu_args', array($this, 'naturecircle_page_menu_args'));
		add_filter('dynamic_sidebar_params', array($this, 'naturecircle_widget_first_last_class'));
		add_filter('dynamic_sidebar_params', array($this, 'naturecircle_mega_menu_widget_change'));
		add_filter( 'dynamic_sidebar_params', array($this, 'naturecircle_put_widget_content'));
		
		//Adding theme support
		if ( ! isset( $content_width ) ) {
			$content_width = 625;
		}
	}
	
	/**
	* Filter callbacks
	* ----------------
	*/
	 
	// Change products per page
	function naturecircle_woo_change_per_page() {
		$naturecircle_opt = get_option( 'naturecircle_opt' );
		
		return $naturecircle_opt['product_per_page'];
	}
	//Change number of related products on product page. Set your own value for 'posts_per_page'
	function naturecircle_woo_related_products_limit( $args ) {
		global $product;

		$naturecircle_opt = get_option( 'naturecircle_opt' );

		$args['posts_per_page'] = $naturecircle_opt['related_amount'];

		return $args;
	}
	// Count number of products from shortcode
	function naturecircle_woocommerce_shortcode_count( $args ) {
		$naturecircle_productsfound = new WP_Query($args);
		$naturecircle_productsfound = $naturecircle_productsfound->post_count;
		
		global $wp_session;
		
		$wp_session["naturecircle_productsfound"] = $naturecircle_productsfound;
		
		return $args;
	}
	//Change search form
	function naturecircle_search_form( $form ) {
		if(get_search_query()!=''){
			$search_str = get_search_query();
		} else {
			$search_str = esc_html__( 'Search...', 'naturecircle' );
		}
		
		$form = '<form role="search" method="get" id="blogsearchform" class="searchform" action="' . esc_url(home_url( '/' ) ). '" >
		<div class="form-input">
			<input class="input_text" type="text" value="'.esc_attr($search_str).'" name="s" id="search_input" />
			<button class="button" type="submit" id="blogsearchsubmit">'.esc_html__('search','naturecircle').'</button>
			</div>
		</form>';
		 
		return $form;
	}
	//Change woocommerce search form
	function naturecircle_woo_search_form( $form ) {
		global $wpdb;
		
		if(get_search_query()!=''){
			$search_str = get_search_query();
		} else {
			$search_str = esc_html__( 'Search product...', 'naturecircle' );
		}
		
		$form = '<form role="search" method="get" id="searchform" action="'.esc_url( home_url( '/'  ) ).'">';
			$form .= '<div class="form-input">';
				$form .= '<input type="text" value="'.esc_attr($search_str).'" name="s" id="ws" placeholder="'.esc_attr($search_str).'" />';
				$form .= '<button class="btn btn-primary" type="submit" id="wsearchsubmit">'.esc_html__('search','naturecircle').'</button>';
				$form .= '<input type="hidden" name="post_type" value="product" />';
			$form .= '</div>';
		$form .= '</form>';
		  
		return $form;
	}
	// Replaces the excerpt "more" text by a link
	function naturecircle_new_excerpt_more($more) {
		return '';
	}
	//Change excerpt length
	function naturecircle_change_excerpt_length( $length ) {
		$naturecircle_opt = get_option( 'naturecircle_opt' );
		
		if(isset($naturecircle_opt['excerpt_length'])){
			return $naturecircle_opt['excerpt_length'];
		}
		
		return 22;
	}
	//Add 'first, last' class to menu
	function naturecircle_first_and_last_menu_class($items) {
		$items[1]->classes[] = 'first';
		$items[count($items)]->classes[] = 'last';
		return $items;
	}
	/**
	 * Filter the page menu arguments.
	 *
	 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
	 *
	 * @since Naturecircle 1.0
	 */
	function naturecircle_page_menu_args( $args ) {
		if ( ! isset( $args['show_home'] ) )
			$args['show_home'] = true;
		return $args;
	}
	//Add first, last class to widgets
	function naturecircle_widget_first_last_class($params) {
		global $my_widget_num;
		
		$class = '';
		
		$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
		$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

		if(!$my_widget_num) {// If the counter array doesn't exist, create it
			$my_widget_num = array();
		}

		if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
			return $params; // No widgets in this sidebar... bail early.
		}

		if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
			$my_widget_num[$this_id] ++;
		} else { // If not, create it starting with 1
			$my_widget_num[$this_id] = 1;
		}

		if($my_widget_num[$this_id] == 1) { // If this is the first widget
			$class .= ' widget-first ';
		} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
			$class .= ' widget-last ';
		}
		
		$params[0]['before_widget'] = str_replace('first_last', ' '.$class.' ', $params[0]['before_widget']);
		
		return $params;
	}
	//Change mega menu widget from div to li tag
	function naturecircle_mega_menu_widget_change($params) {
		
		$sidebar_id = $params[0]['id'];
		
		$pos = strpos($sidebar_id, '_menu_widgets_area_');
		
		if ( !$pos == false ) {
			$params[0]['before_widget'] = '<li class="widget_mega_menu">'.$params[0]['before_widget'];
			$params[0]['after_widget'] = $params[0]['after_widget'].'</li>';
		}
		
		return $params;
	}
	// Push sidebar widget content into a div
	function naturecircle_put_widget_content( $params ) {
		global $wp_registered_widgets;

		if( $params[0]['id']=='sidebar-category' ){
			$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
			$settings = $settings_getter->get_settings();
			$settings = $settings[ $params[1]['number'] ];
			
			if($params[0]['widget_name']=="Text" && isset($settings['title']) && $settings['text']=="") { // if text widget and no content => don't push content
				return $params;
			}
			if( isset($settings['title']) && $settings['title']!='' ){
				$params[0][ 'after_title' ] .= '<div class="widget_content">';
				$params[0][ 'after_widget' ] = '</div>'.$params[0][ 'after_widget' ];
			} else {
				$params[0][ 'before_widget' ] .= '<div class="widget_content">';
				$params[0][ 'after_widget' ] = '</div>'.$params[0][ 'after_widget' ];
			}
		}
		
		return $params;
	}
	
	/**
	* Action hooks
	* ----------------
	*/
	/**
	 * naturecircle setup.
	 *
	 * Sets up theme defaults and registers the various WordPress features that
	 * naturecircle supports.
	 *
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_editor_style() To add a Visual Editor stylesheet.
	 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
	 * 	custom background, and post formats.
	 * @uses register_nav_menu() To add support for navigation menus.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since Naturecircle 1.0
	 */
	function naturecircle_setup() {
		/*
		 * Makes naturecircle available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on naturecircle, use a find and replace
		 * to change 'naturecircle' to the name of your theme in all the template files.
		 */
		$naturecircle_opt = get_option( 'naturecircle_opt' );

		load_theme_textdomain( 'naturecircle', get_template_directory() . '/languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// This theme supports a variety of post formats.
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );

		// Register menus  
		register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'naturecircle' ) );
		register_nav_menu( 'mobilemenu', esc_html__( 'Mobile Menu', 'naturecircle' ) );
		register_nav_menu( 'topmenu', esc_html__( 'Top Menu', 'naturecircle' ) ); 
		register_nav_menu( 'categories', esc_html__( 'Categories Menu', 'naturecircle' ) );  

		/*
		 * This theme supports custom background color and image,
		 * and here we also set up the default background color.
		 */
		add_theme_support( 'custom-background', array(
			'default-color' => 'e6e6e6',
		) );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		
		// This theme uses a custom image size for featured images, displayed on "standard" posts. 
		$width_image = "";
		if(isset($naturecircle_opt['width_thumb']) && ($naturecircle_opt['width_thumb'] != "" )) {
			$width_image = $naturecircle_opt['width_thumb']; 
		} else {
			$width_image = 370;
		}
		$height_image ="";
		if(isset($naturecircle_opt['height_thumb']) && ($naturecircle_opt['height_thumb'] != "" )) {
			$height_image = $naturecircle_opt['height_thumb'];
		} else {
			$width_image = 270;
		}
		$width_cate_image ="";
		if(isset($naturecircle_opt['width_cate_thumb']) && ($naturecircle_opt['width_cate_thumb'] != "" )) {
			$width_cate_image = $naturecircle_opt['width_cate_thumb'];
		} else {
			$width_image = 1170;
		}
		$height_cate_image ="";
		if(isset($naturecircle_opt['height_cate_thumb']) && ($naturecircle_opt['height_cate_thumb'] != "" )) {
			$height_cate_image = $naturecircle_opt['height_cate_thumb'];
		}  else {
			$width_image = 700;
		}
		
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 1170, 9999 ); // Unlimited height, soft crop
		add_image_size( 'naturecircle-category-thumb', $width_cate_image, $height_cate_image, true ); // (cropped)
		add_image_size( 'naturecircle-post-thumb', $width_image, $height_image, true ); // (cropped) 
	}
	//Override woocommerce widgets
	function naturecircle_override_woocommerce_widgets() {
		//Show mini cart on all pages
		if ( class_exists( 'WC_Widget_Cart' ) ) {
			unregister_widget( 'WC_Widget_Cart' ); 
			include_once( get_template_directory().'/woocommerce/class-wc-widget-cart.php' );
			register_widget( 'Custom_WC_Widget_Cart' );
		}
	}
	// Add image to category description
	function naturecircle_woocommerce_category_image() {
		if ( is_product_category() ){
			global $wp_query;
			
			$cat = $wp_query->get_queried_object();
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image = wp_get_attachment_url( $thumbnail_id );
			
			if ( $image ) {
				echo '<p class="category-image-desc"><img src="' . esc_url($image) . '" alt="1" /></p>';
			}
		}
	}
	//Display social sharing on product page
	function naturecircle_woocommerce_social_share(){
		$naturecircle_opt = get_option( 'naturecircle_opt' );
	?>
		<div class="share_buttons">
			<?php if ($naturecircle_opt['share_code']!='') {
				echo wp_kses($naturecircle_opt['share_code'], array(
					'div' => array(
						'class' => array()
					),
					'span' => array(
						'class' => array(),
						'displayText' => array()
					),
				));
			} ?>
		</div>
	<?php
	}
 

	/**
	 * Enqueue scripts and styles for front-end.
	 *
	 * @since Naturecircle 1.0
	 */
	function naturecircle_scripts_styles() {
		global $wp_styles, $wp_scripts;

		$naturecircle_opt = get_option( 'naturecircle_opt' );
		
		/*
		 * Adds JavaScript to pages with the comment form to support
		 * sites with threaded comments (when in use).
		*/
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' ); 
 
		// Load bootstrap css
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.1.0' );
		// Add Bootstrap JavaScript
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.1.0', true ); 
 

		// Add owl-carousel file
		wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '2.3.4', true ); 
		wp_enqueue_script( 'owl-carousel-2', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '2.3.4', true );
		
		// Add Fancybox
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js', array('jquery'), '2.1.5', true );
		wp_enqueue_script( 'fancybox-buttons', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-buttons.js', array('jquery'), '1.0.5', true );
		wp_enqueue_script( 'fancybox-media', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-media.js', array('jquery'), '1.0.6', true );
		wp_enqueue_script( 'fancybox-thumbs', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-thumbs.js', array('jquery'), '1.0.7', true );

	 
		//Superfish
		wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish/superfish.min.js', array('jquery'), '1.3.15', true );
		
		//Add Shuffle js
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.min.js', array('jquery'), '2.6.2', true );
		wp_enqueue_script( 'shuffle', get_template_directory_uri() . '/js/jquery.shuffle.min.js', array('jquery'), '3.0.0', true );

		//Add mousewheel
		wp_enqueue_script( 'mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', array('jquery'), '3.1.12', true );
		
		// Add jQuery countdown file
		wp_enqueue_script( 'countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), '2.0.4', true );
		
		// Add jQuery counter files 
		wp_enqueue_script( 'counterup', get_template_directory_uri() . '/js/jquery.counterup.min.js', array('jquery'), '1.0', true );   
		// Add variables.js file
		wp_enqueue_script( 'variables', get_template_directory_uri() . '/js/variables.js', array('jquery'), '20140826', true );
		
		// Add naturecircle-theme.js file
		wp_enqueue_script( 'naturecircle-theme', get_template_directory_uri() . '/js/naturecircle-theme.js', array('jquery'), '20140826', true );


		$font_url = $this->naturecircle_get_font_url();
		if ( ! empty( $font_url ) )
			wp_enqueue_style( 'naturecircle-fonts', esc_url_raw( $font_url ), array(), null );
		
		// Loads our main stylesheet.
		wp_enqueue_style( 'naturecircle-style', get_stylesheet_uri() ); 
		
		// Mega Main Menu
		wp_enqueue_style( 'megamenu-style', get_template_directory_uri() . '/css/megamenu_style.css', array(), '2.0.4' );
	
		// Load fontawesome css
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fontawesome.css', array(), '5.1.0' );

		// Load animate css
		wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array());
 
		// Load stroke-gap-icons css
		wp_enqueue_style( 'stroke-gap-icons', get_template_directory_uri() . '/css/stroke-gap-icons.css', array()); 

		// Load owl-carousel css
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), '2.3.4');   
		
		// Add Fancybox Css
		wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css', array(), '2.1.5' );
		wp_enqueue_style( 'fancybox-buttons', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-buttons.css', array(), '1.0.5' );
		wp_enqueue_style( 'fancybox-thumbs', get_template_directory_uri() . '/js/fancybox/helpers/jquery.fancybox-thumbs.css', array(), '1.0.7' );   
		// Compile Less to CSS
		$previewpreset = (isset($_REQUEST['preset']) ? $_REQUEST['preset'] : null);
			//get preset from url (only for demo/preview)
		if($previewpreset){
			$_SESSION["preset"] = $previewpreset;
		}
		$presetopt = 1;
		if(!isset($_SESSION["preset"])){
			$_SESSION["preset"] = 1;
		}
		if($_SESSION["preset"] != 1) {
			$presetopt = $_SESSION["preset"];
		} else { /* if no preset varialbe found in url, use from theme options */
			if(isset($naturecircle_opt['preset_option'])){
				$presetopt = $naturecircle_opt['preset_option'];
			}
		}
		if(!isset($presetopt)) $presetopt = 1; /* in case first time install theme, no options found */
		
		if(isset($naturecircle_opt['enable_less'])){
			if($naturecircle_opt['enable_less']){
				$themevariables = array(
					'body_font'=> $naturecircle_opt['bodyfont']['font-family'],
					'text_color'=> $naturecircle_opt['bodyfont']['color'],
					'text_selected_bg' => $naturecircle_opt['text_selected_bg'],
					'text_selected_color' => $naturecircle_opt['text_selected_color'],
					'text_size'=> $naturecircle_opt['bodyfont']['font-size'],
					'border_color'=> $naturecircle_opt['border_color']['border-color'],
					'background_opt'=> $naturecircle_opt['background_opt']['background-color'],
					
					'heading_font'=> $naturecircle_opt['headingfont']['font-family'],
					'heading_color'=> $naturecircle_opt['headingfont']['color'],
					'heading_font_weight'=> $naturecircle_opt['headingfont']['font-weight'],
					
					'menu_font'=> $naturecircle_opt['menufont']['font-family'],
					'menu_color'=> $naturecircle_opt['menufont']['color'],
					'menu_font_size'=> $naturecircle_opt['menufont']['font-size'],
					'menu_font_weight'=> $naturecircle_opt['menufont']['font-weight'],
					'sub_menu_bg' => $naturecircle_opt['sub_menu_bg'],
					'sub_menu_color' => $naturecircle_opt['sub_menu_color'],
					'vsub_menu_bg' => $naturecircle_opt['vsub_menu_bg'],
					
					'link_color' => $naturecircle_opt['link_color']['regular'],
					'link_hover_color' => $naturecircle_opt['link_color']['hover'],
					'link_active_color' => $naturecircle_opt['link_color']['active'],
					
					'primary_color' => $naturecircle_opt['primary_color'],
					
					'sale_color' => $naturecircle_opt['sale_color'],
					'saletext_color' => $naturecircle_opt['saletext_color'],
					'rate_color' => $naturecircle_opt['rate_color'], 

					'header_color' => $naturecircle_opt['header_color'],
					'header_link_color' => $naturecircle_opt['header_link_color']['regular'],
					'header_link_hover_color' => $naturecircle_opt['header_link_color']['hover'],
					'header_link_active_color' => $naturecircle_opt['header_link_color']['active'], 
 
					'price_font'=> $naturecircle_opt['pricefont']['font-family'],
					'price_color'=> $naturecircle_opt['pricefont']['color'], 
					'price_size'=> $naturecircle_opt['pricefont']['font-size'],
					'price_font_weight'=> $naturecircle_opt['pricefont']['font-weight'],

					'footer_color' => $naturecircle_opt['footer_color'],
					'footer_link_color' => $naturecircle_opt['footer_link_color']['regular'],
					'footer_link_hover_color' => $naturecircle_opt['footer_link_color']['hover'],
					'footer_link_active_color' => $naturecircle_opt['footer_link_color']['active'],
				);
				
				if(isset($naturecircle_opt['header_sticky_bg']['rgba']) && $naturecircle_opt['header_sticky_bg']['rgba']!="") {
					$themevariables['header_sticky_bg'] = $naturecircle_opt['header_sticky_bg']['rgba'];
				} else {
					$themevariables['header_sticky_bg'] = 'rgba(68,68,68,0.95)';
				}
				if(isset($naturecircle_opt['header_bg']['background-color']) && $naturecircle_opt['header_bg']['background-color']!="") {
					$themevariables['header_bg'] = $naturecircle_opt['header_bg']['background-color'];
				} else {
					$themevariables['header_bg'] = '#fff';
				} 
				if(isset($naturecircle_opt['header_bg']['background-image']) && $naturecircle_opt['header_bg']['background-image']!="") {
					$themevariables['header_bg_image'] = $naturecircle_opt['header_bg']['background-image']; 
				} else {
					$themevariables['header_bg_image'] = 'none';
				} 
 				 
				if(isset($naturecircle_opt['page_content_background']['background-color']) && $naturecircle_opt['page_content_background']['background-color']!="") {
					$themevariables['page_content_background'] = $naturecircle_opt['page_content_background']['background-color'];
				} else {
					$themevariables['page_content_background'] = '#fff';
				}
				if(isset($naturecircle_opt['footer_bg']['background-color']) && $naturecircle_opt['footer_bg']['background-color']!="") {
					$themevariables['footer_bg'] = $naturecircle_opt['footer_bg']['background-color'];
				} else {
					$themevariables['footer_bg'] = '#282727';
				}
				switch ($presetopt) { 
					case 2:   
						$themevariables['header_sticky_bg'] = 'rgba(0,0,0,0.8)'; 
						$themevariables['header_color'] = '#ffffff';  
						$themevariables['header_link_color'] = '#ffffff'; 
						$themevariables['menu_color'] = '#ffffff';    
					break;  
				}

				if(function_exists('compileLessFile')){ 
					compileLessFile('theme.less', 'theme'.$presetopt.'.css', $themevariables);
				}
			}
		}
		
		// Load main theme css style files
		wp_enqueue_style( 'naturecircle-theme-style', get_template_directory_uri() . '/css/theme'.$presetopt.'.css', array('bootstrap'), '1.0.0' ); 
		 wp_enqueue_style( 'naturecircle-custom', get_template_directory_uri() . '/css/opt_css.css', array('naturecircle-theme-style'), '1.0.0' );
		
		if(function_exists('WP_Filesystem')){
			if ( ! WP_Filesystem() ) {
				$url = wp_nonce_url();
				request_filesystem_credentials($url, '', true, false, null);
			}
			
			global $wp_filesystem;
			//add custom css, sharing code to header
			if($wp_filesystem->exists(get_template_directory(). '/css/opt_css.css')){
				$customcss = $wp_filesystem->get_contents(get_template_directory(). '/css/opt_css.css');
				
				if(isset($naturecircle_opt['custom_css']) && $customcss!=$naturecircle_opt['custom_css']){ //if new update, write file content
					$wp_filesystem->put_contents(
						get_template_directory(). '/css/opt_css.css',
						$naturecircle_opt['custom_css'],
						FS_CHMOD_FILE // predefined mode settings for WP files
					);
				}
			} else {
				$wp_filesystem->put_contents(
					get_template_directory(). '/css/opt_css.css',
					$naturecircle_opt['custom_css'],
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
		
		//add javascript variables
		ob_start(); ?>  
		var naturecircle_testipause = <?php if(isset($naturecircle_opt['testipause'])) { echo esc_js($naturecircle_opt['testipause']); } else { echo '3000'; } ?>,
			naturecircle_testianimate = <?php if(isset($naturecircle_opt['testianimate'])) { echo esc_js($naturecircle_opt['testianimate']); } else { echo '700'; } ?>;
		var naturecircle_testiscroll = false;
			<?php if(isset($naturecircle_opt['testiscroll'])){ ?>
				naturecircle_testiscroll = <?php echo esc_js($naturecircle_opt['testiscroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var naturecircle_catenumber = <?php if(isset($naturecircle_opt['catenumber'])) { echo esc_js($naturecircle_opt['catenumber']); } else { echo '6'; } ?>,
			naturecircle_catescrollnumber = <?php if(isset($naturecircle_opt['catescrollnumber'])) { echo esc_js($naturecircle_opt['catescrollnumber']); } else { echo '2';} ?>,
			naturecircle_catepause = <?php if(isset($naturecircle_opt['catepause'])) { echo esc_js($naturecircle_opt['catepause']); } else { echo '3000'; } ?>,
			naturecircle_cateanimate = <?php if(isset($naturecircle_opt['cateanimate'])) { echo esc_js($naturecircle_opt['cateanimate']); } else { echo '700';} ?>;
		var naturecircle_catescroll = false;
			<?php if(isset($naturecircle_opt['catescroll'])){ ?>
				naturecircle_catescroll = <?php echo esc_js($naturecircle_opt['catescroll'])==1 ? 'true': 'false'; ?>;
			<?php } ?>
		var naturecircle_menu_number = <?php if(isset($naturecircle_opt['categories_menu_items'])) { echo esc_js((int)$naturecircle_opt['categories_menu_items']+1); } else { echo '9';} ?>;
		var naturecircle_sticky_header = false;
			<?php if(isset($naturecircle_opt['sticky_header'])){ ?>
				naturecircle_sticky_header = <?php echo esc_js($naturecircle_opt['sticky_header'])==1 ? 'true': 'false'; ?>;
			<?php } ?>

		jQuery(document).ready(function(){
			jQuery("#ws").focus(function(){
				if(jQuery(this).val()=="<?php echo esc_html__( 'Search product...', 'naturecircle' )?>"){
					jQuery(this).val("");
				}
			});
			jQuery("#ws").focusout(function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("<?php echo esc_html__( 'Search product...', 'naturecircle' )?>");
				}
			});
			jQuery("#wsearchsubmit").on('click',function(){
				if(jQuery("#ws").val()=="<?php echo esc_html__( 'Search product...', 'naturecircle' )?>" || jQuery("#ws").val()==""){
					jQuery("#ws").focus();
					return false;
				}
			});
			jQuery("#search_input").focus(function(){
				if(jQuery(this).val()=="<?php echo esc_html__( 'Search...', 'naturecircle' )?>"){
					jQuery(this).val("");
				}
			});
			jQuery("#search_input").focusout(function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("<?php echo esc_html__( 'Search...', 'naturecircle' )?>");
				}
			});
			jQuery("#blogsearchsubmit").on('click',function(){
				if(jQuery("#search_input").val()=="<?php echo esc_html__( 'Search...', 'naturecircle' )?>" || jQuery("#search_input").val()==""){
					jQuery("#search_input").focus();
					return false;
				}
			});
		});
		<?php
		$jsvars = ob_get_contents();
		ob_end_clean();
		
		if(function_exists('WP_Filesystem')){
			if($wp_filesystem->exists(get_template_directory(). '/js/variables.js')){
				$jsvariables = $wp_filesystem->get_contents(get_template_directory(). '/js/variables.js');
				
				if($jsvars!=$jsvariables){ //if new update, write file content
					$wp_filesystem->put_contents(
						get_template_directory(). '/js/variables.js',
						$jsvars,
						FS_CHMOD_FILE // predefined mode settings for WP files
					);
				}
			} else {
				$wp_filesystem->put_contents(
					get_template_directory(). '/js/variables.js',
					$jsvars,
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
		//add css for footer, header templates
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
				if($jscomposer_template->post_title == $naturecircle_opt['header_layout'] || $jscomposer_template->post_title == $naturecircle_opt['footer_layout']){
					$jscomposer_template_css = get_post_meta ( $jscomposer_template->ID, '_wpb_shortcodes_custom_css', false );
					if(isset($jscomposer_template_css[0])) {
						wp_add_inline_style( 'naturecircle-custom', $jscomposer_template_css[0] );
					} 
				}
			}
		}
		
		//page width
		wp_add_inline_style( 'naturecircle-custom', '.wrapper.box-layout, .wrapper.box-layout .container, .wrapper.box-layout .row-container {max-width: '.$naturecircle_opt['box_layout_width'].'px;}' );
	}
	 
	//add sharing code to header
	function naturecircle_custom_code_header() {
		global $naturecircle_opt;

		if ( isset($naturecircle_opt['share_head_code']) && $naturecircle_opt['share_head_code']!='') {
			echo wp_kses($naturecircle_opt['share_head_code'], array(
				'script' => array(
					'type' => array(),
					'src' => array(),
					'async' => array()
				),
			));
		}
	}
	/**
	 * Register sidebars.
	 *
	 * Registers our main widget area and the front page widget areas.
	 *
	 * @since Naturecircle 1.0
	 */
	function naturecircle_widgets_init() {
		$naturecircle_opt = get_option( 'naturecircle_opt' );
		
		register_sidebar( array(
			'name' => esc_html__( 'Blog Sidebar', 'naturecircle' ),
			'id' => 'sidebar-1',
			'description' => esc_html__( 'Sidebar on blog page', 'naturecircle' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
		
		register_sidebar( array(
			'name' => esc_html__( 'Shop Sidebar', 'naturecircle' ),
			'id' => 'sidebar-shop',
			'description' => esc_html__( 'Sidebar on shop page (only sidebar shop layout)', 'naturecircle' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );

		register_sidebar( array(
			'name' => esc_html__( 'Pages Sidebar', 'naturecircle' ),
			'id' => 'sidebar-page',
			'description' => esc_html__( 'Sidebar on content pages', 'naturecircle' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>',
		) );
		
		if(isset($naturecircle_opt['custom-sidebars']) && $naturecircle_opt['custom-sidebars']!=""){
			foreach($naturecircle_opt['custom-sidebars'] as $sidebar){
				$sidebar_id = str_replace(' ', '-', strtolower($sidebar));
				
				if($sidebar_id!='') {
					register_sidebar( array(
						'name' => $sidebar,
						'id' => $sidebar_id,
						'description' => $sidebar,
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget' => '</aside>',
						'before_title' => '<h3 class="widget-title"><span>',
						'after_title' => '</span></h3>',
					) );
				}
			}
		}
	} 
	//Change comment form
	function naturecircle_before_comment_fields() {
		echo '<div class="comment-input">';
	}
	function naturecircle_after_comment_fields() {
		echo '</div>';
	}
	/**
	 * Register postMessage support.
	 *
	 * Add postMessage support for site title and description for the Customizer.
	 *
	 * @since Naturecircle 1.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	function naturecircle_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
	/**
	 * Enqueue Javascript postMessage handlers for the Customizer.
	 *
	 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
	 *
	 * @since Naturecircle 1.0
	 */
	function naturecircle_customize_preview_js() {
		wp_enqueue_script( 'naturecircle-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
	}
	 
	function naturecircle_admin_style() {
	  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
	}
	/**
	* Utility methods
	* ---------------
	*/
	
	//Add breadcrumbs
	static function naturecircle_breadcrumb() {
		global $post;

		$naturecircle_opt = get_option( 'naturecircle_opt' );
		
		$brseparator = '<span class="separator">/</span>';
		if (!is_home()) {
			echo '<div class="breadcrumbs">';
			
			echo '<a href="';
			echo esc_url( home_url( '/' ));
			echo '">';
			echo esc_html__('Home', 'naturecircle');
			echo '</a>'.$brseparator;
			if (is_category() && is_single()) {
				the_category($brseparator);
				echo ''.$brseparator;
				the_title();  
			} elseif (is_single()) {
				if (is_single()) { 
					the_title();
				}  
			} elseif (is_category()) {
				the_category($brseparator); 
			} elseif (is_page()) {
				if($post->post_parent){
					$anc = get_post_ancestors( $post->ID );
					$title = get_the_title();
					foreach ( $anc as $ancestor ) {
						$output = '<a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a>'.$brseparator;
					}
					echo wp_kses($output, array(
							'a'=>array(
								'href' => array(),
								'title' => array()
							),
							'span'=>array(
								'class'=>array()
							)
						)
					);
					echo '<span title="'.$title.'"> '.$title.'</span>';
				} else {
					echo '<span> '.get_the_title().'</span>';
				} 
			}

			elseif (is_tag()) {single_tag_title();}
			elseif (is_day()) {printf( esc_html__( 'Archive for: %s', 'naturecircle' ), '<span>' . get_the_date() . '</span>' );}
			elseif (is_month()) {printf( esc_html__( 'Archive for: %s', 'naturecircle' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'naturecircle' ) ) . '</span>' );}
			elseif (is_year()) {printf( esc_html__( 'Archive for: %s', 'naturecircle' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'naturecircle' ) ) . '</span>' );}
			elseif (is_author()) {echo "<span>".esc_html__('Archive for','naturecircle'); echo'</span>';}
			elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>".esc_html__('Blog Archives','naturecircle'); echo'</span>';}
			elseif (is_search()) {echo "<span>".esc_html__('Search Results','naturecircle'); echo'</span>';}
			
			echo '</div>';
		} else {
			echo '<div class="breadcrumbs">';
			
			echo '<a href="';
			echo esc_url( home_url( '/' ) );
			echo '">';
			echo esc_html__('Home', 'naturecircle');
			echo '</a>'.$brseparator;
			
			if(isset($naturecircle_opt['blog_header_text']) && $naturecircle_opt['blog_header_text']!=""){
				echo esc_html($naturecircle_opt['blog_header_text']);
			} else {
				echo esc_html__('Blog', 'naturecircle');
			}
			
			echo '</div>';
		}
	}
	static function naturecircle_limitStringByWord ($string, $maxlength, $suffix = '') {

		if(function_exists( 'mb_strlen' )) {
			// use multibyte functions by Iysov
			if(mb_strlen( $string )<=$maxlength) return $string;
			$string = mb_substr( $string, 0, $maxlength );
			$index = mb_strrpos( $string, ' ' );
			if($index === FALSE) {
				return $string;
			} else {
				return mb_substr( $string, 0, $index ).$suffix;
			}
		} else { // original code here
			if(strlen( $string )<=$maxlength) return $string;
			$string = substr( $string, 0, $maxlength );
			$index = strrpos( $string, ' ' );
			if($index === FALSE) {
				return $string;
			} else {
				return substr( $string, 0, $index ).$suffix;
			}
		}
	}
	static function naturecircle_excerpt_by_id($post, $length = 10, $tags = '<a><em><strong>') {
 
		if(is_int($post)) {
			// get the post object of the passed ID
			$post = get_post($post);
		} elseif(!is_object($post)) {
			return false;
		}
	 
		if(has_excerpt($post->ID)) {
			$the_excerpt = $post->post_excerpt;
			return apply_filters('the_content', $the_excerpt);
		} else {
			$the_excerpt = $post->post_content;
		}
	 
		$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
		$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
		$excerpt_waste = array_pop($the_excerpt);
		$the_excerpt = implode($the_excerpt);
	 
		return apply_filters('the_content', $the_excerpt);
	}
	/**
	 * Return the Google font stylesheet URL if available.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * @since naturecircle 1.2
	 *
	 * @return string Font stylesheet or empty string if disabled.
	 */
	function naturecircle_get_font_url() {
		$fonts_url = '';
		 
		/* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$open_sans = _x( 'on', 'Open Sans font: on or off', 'naturecircle' );
		 
		if ( 'off' !== $open_sans ) {
			$font_families = array();

			if ( 'off' !== $open_sans ) {
				$font_families[] = 'Poppins:200,300,400,500,600,700';
			}
			
			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			 
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}
		 
		return esc_url_raw( $fonts_url );
	}
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Naturecircle 1.0
	 */
	static function naturecircle_content_nav( $html_id ) {
		global $wp_query;

		$html_id = esc_attr( $html_id );

		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="<?php echo esc_attr($html_id); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php esc_html_e( 'Post navigation', 'naturecircle' ); ?></h3>
				<div class="nav-previous"><?php next_posts_link( wp_kses(__( '<span class="meta-nav">&larr;</span> Older posts', 'naturecircle' ),array('span'=>array('class'=>array())) )); ?></div>
				<div class="nav-next"><?php previous_posts_link( wp_kses(__( 'Newer posts <span class="meta-nav">&rarr;</span>', 'naturecircle' ), array('span'=>array('class'=>array())) )); ?></div>
			</nav>
		<?php endif;
	}
	/* Pagination */
	static function naturecircle_pagination() {
		global $wp_query;

		$big = 999999999; // need an unlikely integer
		if($wp_query->max_num_pages > 1) {
			echo '<div class="pagination-inner">';
		}
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'prev_text'    => esc_html__('Previous', 'naturecircle'),
				'next_text'    =>esc_html__('Next', 'naturecircle'),
			) );
		if($wp_query->max_num_pages > 1) {
			echo '</div>';
		}
	}
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own naturecircle_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Naturecircle 1.0
	 */
	static function naturecircle_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php esc_html_e( 'Pingback:', 'naturecircle' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'naturecircle' ), '<span class="edit-link">', '</span>' ); ?></p>
		<?php
				break;
			default :
			// Proceed with normal comments.
			global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 50 ); ?>
				</div>
				<div class="comment-info">
					<header class="comment-meta comment-author vcard">
						<?php
							
							printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
								get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author', 'naturecircle' ) . '</span>' : ''
							);
							printf( '<time datetime="%1$s">%2$s</time>',
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( esc_html__( '%1$s at %2$s', 'naturecircle' ), get_comment_date(), get_comment_time() )
							);
						?>
						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'naturecircle' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->
					</header><!-- .comment-meta -->
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'naturecircle' ); ?></p>
					<?php endif; ?>

					<section class="comment-content comment">
						<?php comment_text(); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'naturecircle' ), '<p class="edit-link">', '</p>' ); ?>
					</section><!-- .comment-content -->
				</div>
			</article><!-- #comment-## -->
		<?php
			break;
		endswitch; // end comment_type check
	}
	/**
	 * Set up post entry meta.
	 *
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own naturecircle_entry_meta() to override in a child theme.
	 *
	 * @since Naturecircle 1.0
	 */
	static function naturecircle_entry_meta() {
		
		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', ', ' );

		$num_comments = (int)get_comments_number();
		$write_comments = '';
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = esc_html__('0 comments', 'naturecircle');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . esc_html__(' comments', 'naturecircle');
			} else {
				$comments = esc_html__('1 comment', 'naturecircle');
			}
			$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		}

		$utility_text = null;
		if ( ( post_password_required() || !comments_open() ) && ($tag_list!=false && isset($tag_list) ) ) {
			$utility_text = esc_html__( 'Tags: %2$s', 'naturecircle' );
		} elseif($tag_list!=false && isset($tag_list) && $num_comments !=0 ){
			$utility_text = esc_html__( '%1$s / Tags: %2$s', 'naturecircle' );
		} elseif ( ($num_comments ==0 || !isset($num_comments) ) && $tag_list==true ) {
			$utility_text = esc_html__( 'Tags: %2$s', 'naturecircle' );
		} else {
			$utility_text = esc_html__( '%1$s', 'naturecircle' );
		}

		printf( $utility_text, $write_comments, $tag_list);
	}
	static function naturecircle_entry_meta_small() {
		
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list(', ');

		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( wp_kses(__( 'View all posts by %s', 'naturecircle' ), array('a'=>array())), get_the_author() ) ),
			get_the_author()
		);
		
		$utility_text = esc_html__( 'Posted by %1$s  %2$s', 'naturecircle' );

		printf( $utility_text, $author, $categories_list );
		
	}
	static function naturecircle_entry_comments() {
		
		$date = sprintf( '<time class="entry-date" datetime="%3$s">%4$s</time>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$num_comments = (int)get_comments_number();
		$write_comments = '';
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = wp_kses(__('<span>0</span> comments', 'naturecircle'), array('span'=>array()));
			} elseif ( $num_comments > 1 ) {
				$comments = '<span>'.$num_comments .'</span>'. esc_html__(' comments', 'naturecircle');
			} else {
				$comments = wp_kses(__('<span>1</span> comment', 'naturecircle'), array('span'=>array()));
			}
			$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		}
		
		$utility_text = esc_html__( '%1$s', 'naturecircle' );
		
		printf( $utility_text, $write_comments );
	}
	/**
	* TGM-Plugin-Activation
	*/
	function naturecircle_register_required_plugins() {

		$plugins = array(
			array(
				'name'               => esc_html__('Plazathemes Helper', 'naturecircle'),
				'slug'               => 'roadthemes-helper',
				'source'             => get_template_directory() . '/plugins/roadthemes-helper.zip',
				'required'           => true,
				'version'            => '1.0.0',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Mega Main Menu', 'naturecircle'),
				'slug'               => 'mega_main_menu',
				'source'             => get_template_directory() . '/plugins/mega_main_menu.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Revolution Slider', 'naturecircle'),
				'slug'               => 'revslider',
				'source'             => get_template_directory() . '/plugins/revslider.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => 'Import Sample Data',
				'slug'               => 'road-importdata',
				'source'             => get_template_directory() . '/plugins/road-importdata.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Visual Composer', 'naturecircle'),
				'slug'               => 'js_composer',
				'source'             => get_template_directory() . '/plugins/js_composer.zip',
				'required'           => true,
				'external_url'       => '',
			),
			array(
				'name'               => esc_html__('Templatera', 'naturecircle'),
				'slug'               => 'templatera',
				'source'             => get_template_directory() . '/plugins/templatera.zip',
				'required'           => true,
				'external_url'       => '',
			),
			 
			 
			// Plugins from the WordPress Plugin Repository.
			array(
				'name'               => esc_html__('Redux Framework', 'naturecircle'),
				'slug'               => 'redux-framework',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
			),
			array(
				'name'      => esc_html__('Contact Form 7', 'naturecircle'),
				'slug'      => 'contact-form-7',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('Instagram Feed', 'naturecircle'),
				'slug'      => 'instagram-feed',
				'required'  => true,
			),
			  
			array(
				'name'      => esc_html__('MailChimp for WordPress', 'naturecircle'),
				'slug'      => 'mailchimp-for-wp',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('Shortcodes Ultimate', 'naturecircle'),
				'slug'      => 'shortcodes-ultimate',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('Simple Local Avatars', 'naturecircle'),
				'slug'      => 'simple-local-avatars',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Testimonials', 'naturecircle'),
				'slug'      => 'testimonials-by-woothemes',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('TinyMCE Advanced', 'naturecircle'),
				'slug'      => 'tinymce-advanced',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('Widget Importer & Exporter', 'naturecircle'),
				'slug'      => 'widget-importer-exporter',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('WooCommerce', 'naturecircle'),
				'slug'      => 'woocommerce',
				'required'  => true,
			),
			array(
				'name'      => esc_html__('YITH WooCommerce Compare', 'naturecircle'),
				'slug'      => 'yith-woocommerce-compare',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('YITH WooCommerce Wishlist', 'naturecircle'),
				'slug'      => 'yith-woocommerce-wishlist',
				'required'  => false,
			),
			array(
				'name'      => esc_html__('YITH WooCommerce Zoom Magnifier', 'naturecircle'),
				'slug'      => 'yith-woocommerce-zoom-magnifier',
				'required'  => false,
			),
		);

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'naturecircle' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'naturecircle' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'naturecircle' ), // %s = plugin name.
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'naturecircle' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'naturecircle' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'naturecircle' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'naturecircle' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'naturecircle' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'naturecircle' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'naturecircle' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'naturecircle' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'naturecircle' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'naturecircle' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'naturecircle' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'naturecircle' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'naturecircle' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'naturecircle' ), // %s = dashboard link.
				'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);

		tgmpa( $plugins, $config );

	}
}

// Instantiate theme
$Naturecircle_Class = new Naturecircle_Class();

//Fix duplicate id of mega menu
function naturecircle_mega_menu_id_change($params) {
	ob_start('naturecircle_mega_menu_id_change_call_back');
}
function naturecircle_mega_menu_id_change_call_back($html){
	//$html = preg_replace('/id="primary"/', 'id="mega_main_menu_first"', $html, 1);
	//$html = preg_replace('/id="main_ul-primary"/', 'id="mega_main_menu_ul_first"', $html, 1);
	
	return $html;
}
function naturecircle_total_product_count() {
    $args = array( 'post_type' => 'product', 'posts_per_page' => -1 );

    $products = new WP_Query( $args );

    return $products->found_posts;
}
add_action('wp_loaded', 'naturecircle_mega_menu_id_change');

function naturecircle_prefix_enqueue_script() {
  	wp_add_inline_script( 'naturecircle-theme', 'var ajaxurl = "'.admin_url('admin-ajax.php').'";' ); 
}
add_action( 'wp_enqueue_scripts', 'naturecircle_prefix_enqueue_script' ); 