<?php

if( ! function_exists( 'naturecircle_get_slider_setting' ) ) {
	function naturecircle_get_slider_setting() {
		$status_opt = array(
			'',
			__( 'Yes', 'naturecircle' ) => true,
			__( 'No', 'naturecircle' ) => false,
		);
		
		$effect_opt = array(
			'',
			__( 'Fade', 'naturecircle' ) => 'fade',
			__( 'Slide', 'naturecircle' ) => 'slide',
		);
	 
		return array( 
			array(
				'type' => 'checkbox',
				'heading' => __( 'Enable slider', 'naturecircle' ),
				'param_name' => 'enable_slider',
				'value' => true,
				'save_always' => true, 
				'group' => __( 'Slider Options', 'naturecircle' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Items Default', 'naturecircle' ),
				'param_name' => 'items',
				'group' => __( 'Slider Options', 'naturecircle' ),
				'value' => 5,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Item Desktop', 'naturecircle' ),
				'param_name' => 'item_desktop',
				'group' => __( 'Slider Options', 'naturecircle' ),
				'value' => 4,
			), 
			array(
				'type' => 'textfield',
				'heading' => __( 'Item Small', 'naturecircle' ),
				'param_name' => 'item_small',
				'group' => __( 'Slider Options', 'naturecircle' ),
				'value' => 3,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Item Tablet', 'naturecircle' ),
				'param_name' => 'item_tablet',
				'group' => __( 'Slider Options', 'naturecircle' ),
				'value' => 2,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Item Mobile', 'naturecircle' ),
				'param_name' => 'item_mobile',
				'group' => __( 'Slider Options', 'naturecircle' ),
				'value' => 1,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Navigation', 'naturecircle' ),
				'param_name' => 'navigation',
				'value' => $status_opt,
				'save_always' => true,
				'group' => __( 'Slider Options', 'naturecircle' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Pagination', 'naturecircle' ),
				'param_name' => 'pagination',
				'value' => $status_opt,
				'save_always' => true,
				'group' => __( 'Slider Options', 'naturecircle' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Speed sider', 'naturecircle' ),
				'param_name' => 'speed',
				'value' => '500',
				'save_always' => true,
				'group' => __( 'Slider Options', 'naturecircle' )
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Slider Auto', 'naturecircle' ),
				'param_name' => 'auto',
				'value' => false, 
				'group' => __( 'Slider Options', 'naturecircle' )
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Slider loop', 'naturecircle' ),
				'param_name' => 'loop',
				'value' => false, 
				'group' => __( 'Slider Options', 'naturecircle' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Effects', 'naturecircle' ),
				'param_name' => 'effect',
				'value' => $effect_opt,
				'save_always' => true,
				'group' => __( 'Slider Options', 'naturecircle' )
			), 
		);
	}
}
//Shortcodes for Visual Composer

add_action( 'vc_before_init', 'naturecircle_vc_shortcodes' );
function naturecircle_vc_shortcodes() { 

	//Main Menu
	vc_map( array(
		'name' => esc_html__( 'Main Menu', 'naturecircle'),
		'base' => 'roadmainmenu',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'), 
		'params' => array()
	) );

	//Categories Menu
	vc_map( array(
		'name' => esc_html__( 'Categories Menu', 'naturecircle'),
		'base' => 'roadcategoriesmenu',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
		)
	) );
  

	//Mini Cart
	vc_map( array(
		'name' => esc_html__( 'Mini Cart', 'naturecircle'),
		'base' => 'roadminicart',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
		)
	) );

	//Products Search
	vc_map( array(
		'name' => esc_html__( 'Product Search', 'naturecircle'),
		'base' => 'roadproductssearch',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
		)
	) );
 
	//Brand logos
	vc_map( array(
		'name' => esc_html__( 'Brand Logos', 'naturecircle' ),
		'base' => 'ourbrands',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array_merge( 
			array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Number of columns', 'naturecircle' ),
					'param_name' => 'colsnumber',
					'value' => esc_html__( '6', 'naturecircle' ),
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Number of rows', 'naturecircle' ),
					'param_name' => 'rowsnumber',
					'value' => array(
							'1'	=> '1',
							'2'	=> '2',
							'3'	=> '3',
							'4'	=> '4',
						),
				),
			),naturecircle_get_slider_setting()
		)

	) );
 

	//Categories carousel
	vc_map( array(
		'name' => esc_html__( 'Categories Carousel', 'naturecircle' ),
		'base' => 'categoriescarousel',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array_merge(
			array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Number of columns', 'naturecircle' ),
					'param_name' => 'colsnumber',
					'value' => esc_html__( '6', 'naturecircle' ),
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Number of rows', 'naturecircle' ),
					'param_name' => 'rowsnumber',
					'value' => array(
							'1'	=> '1',
							'2'	=> '2',
							'3'	=> '3',
							'4'	=> '4',
						),
				),
			), naturecircle_get_slider_setting() 
		)
	) );
 
	
	//MailPoet Newsletter Form
	vc_map( array(
		'name' => esc_html__( 'Newsletter Form (MailPoet)', 'naturecircle' ),
		'base' => 'wysija_form',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Form ID', 'naturecircle' ),
				'param_name' => 'id',
				'value' => '',
				'description' => esc_html__( 'Enter form ID here', 'naturecircle' ),
			),
		)
	) );

	//Timesale
	vc_map( array(
		'name' => esc_html__( 'Time Sale', 'naturecircle' ),
		'base' => 'timesale',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array( 
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Date Sale', 'naturecircle' ),
				'description' => esc_html__( 'Date Sale M-D-Y. example: 06-16-2030', 'naturecircle' ),
				'param_name' => 'date', 
			),
			array(
			  "type" => "attach_image",
			  "class" => "",
			  "heading" => __( "The image", "naturecircle" ),
			  "param_name" => "image",
			  "value" => '',
			  "description" => __( "Enter description.", "naturecircle" )
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'naturecircle' ),
				'param_name' => 'description', 
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'URL', 'naturecircle' ),
				'description' => esc_html__( 'Link go to sale page', 'naturecircle' ),
				'param_name' => 'url', 
			), 
		)
	) );
	
	//Latest posts
	vc_map( array(
		'name' => esc_html__( 'Latest posts', 'naturecircle' ),
		'base' => 'latestposts',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' =>  array_merge(array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of posts', 'naturecircle' ),
				'param_name' => 'posts_per_page',
				'value' => esc_html__( '5', 'naturecircle' ),
			),
			  
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Excerpt length', 'naturecircle' ),
				'param_name' => 'length',
				'value' => esc_html__( '20', 'naturecircle' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of columns', 'naturecircle' ),
				'param_name' => 'colsnumber',
				'value' => esc_html__( '4', 'naturecircle' ),
			), 
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'naturecircle' ),
				'param_name' => 'rowsnumber',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
			), 
		),naturecircle_get_slider_setting() )
	) );
	
	//Testimonials
	vc_map( array(
		'name' => esc_html__( 'Testimonials', 'naturecircle' ),
		'base' => 'woothemes_testimonials',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of testimonial', 'naturecircle' ),
				'param_name' => 'limit',
				'value' => esc_html__( '10', 'naturecircle' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Display Author', 'naturecircle' ),
				'param_name' => 'display_author',
				'value' => array(
					'Yes'	=> 'true',
					'No'	=> 'false',
				),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Display Avatar', 'naturecircle' ),
				'param_name' => 'display_avatar',
				'value' => array(
					'Yes'	=> 'true',
					'No'	=> 'false',
				),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Avatar image size', 'naturecircle' ),
				'param_name' => 'size',
				'value' => '',
				'description' => esc_html__( 'Avatar image size in pixels. Default is 50', 'naturecircle' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Display URL', 'naturecircle' ),
				'param_name' => 'display_url',
				'value' => array(
					'Yes'	=> 'true',
					'No'	=> 'false',
				),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Category', 'naturecircle' ),
				'param_name' => 'category',
				'value' => esc_html__( '0', 'naturecircle' ),
				'description' => esc_html__( 'ID/slug of the category. Default is 0', 'naturecircle' ),
			),
		)
	) );
	
	
	//Rotating tweets
	vc_map( array(
		'name' => esc_html__( 'Rotating tweets', 'naturecircle' ),
		'base' => 'rotatingtweets',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Twitter user name', 'naturecircle' ),
				'param_name' => 'screen_name',
				'value' => '',
			),
		)
	) );

	//Twitter feed
	vc_map( array(
		'name' => esc_html__( 'Twitter feed', 'naturecircle' ),
		'base' => 'AIGetTwitterFeeds',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Your Twitter Name(Without the "@" symbol)', 'naturecircle' ),
				'param_name' => 'ai_username',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number Of Tweets', 'naturecircle' ),
				'param_name' => 'ai_numberoftweets',
				'value' => '',
			),
			// array(
			// 	'type' => 'textfield',
			// 	'holder' => 'div',
			// 	'class' => '',
			// 	'heading' => esc_html__( 'Your Title', 'naturecircle' ),
			// 	'param_name' => 'ai_tweet_title',
			// 	'value' => '',
			// ),
		)
	) );
	
	//Google map
	vc_map( array(
		'name' => esc_html__( 'Google map', 'naturecircle' ),
		'base' => 'naturecircle_map',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Map Height', 'naturecircle' ),
				'param_name' => 'map_height',
				'value' => esc_html__( '400', 'naturecircle' ),
				'description' => esc_html__( 'Map height in pixels. Default is 400', 'naturecircle' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Map Zoom', 'naturecircle' ),
				'param_name' => 'map_zoom',
				'value' => esc_html__( '17', 'naturecircle' ),
				'description' => esc_html__( 'Map zoom level, min 0, max 21. Default is 17', 'naturecircle' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Latitude', 'naturecircle' ),
				'param_name' => 'lat1',
				'value' => '',
				'group' => 'Marker 1'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Longtitude', 'naturecircle' ),
				'param_name' => 'long1',
				'value' => '',
				'group' => 'Marker 1'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Address', 'naturecircle' ),
				'param_name' => 'address1',
				'value' => '',
				'description' => esc_html__( 'If you donot enter coordinate, enter address here', 'naturecircle' ),
				'group' => 'Marker 1'
			),
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Marker image', 'naturecircle' ),
				'param_name' => 'marker1',
				'value' => '',
				'description' => esc_html__( 'Upload marker image, image size: 40x46 px', 'naturecircle' ),
				'group' => 'Marker 1'
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Description', 'naturecircle' ),
				'param_name' => 'description1',
				'value' => '',
				'description' => esc_html__( 'Allowed HTML tags: a, i, em, br, strong, h1, h2, h3', 'naturecircle' ),
				'group' => 'Marker 1'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Latitude', 'naturecircle' ),
				'param_name' => 'lat2',
				'value' => '',
				'group' => 'Marker 2'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Longtitude', 'naturecircle' ),
				'param_name' => 'long2',
				'value' => '',
				'group' => 'Marker 2'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Address', 'naturecircle' ),
				'param_name' => 'address2',
				'value' => '',
				'description' => esc_html__( 'If you donot enter coordinate, enter address here', 'naturecircle' ),
				'group' => 'Marker 2'
			),
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Marker image', 'naturecircle' ),
				'param_name' => 'marker2',
				'value' => '',
				'description' => esc_html__( 'Upload marker image', 'naturecircle' ),
				'group' => 'Marker 2'
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Description', 'naturecircle' ),
				'param_name' => 'description2',
				'value' => '',
				'description' => esc_html__( 'Allowed HTML tags: a, i, em, br, strong, p, h2, h2, h3', 'naturecircle' ),
				'group' => 'Marker 2'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Latitude', 'naturecircle' ),
				'param_name' => 'lat3',
				'value' => '',
				'group' => 'Marker 3'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Longtitude', 'naturecircle' ),
				'param_name' => 'long3',
				'value' => '',
				'group' => 'Marker 3'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Address', 'naturecircle' ),
				'param_name' => 'address3',
				'value' => '',
				'description' => esc_html__( 'If you donot enter coordinate, enter address here', 'naturecircle' ),
				'group' => 'Marker 3'
			),
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Marker image', 'naturecircle' ),
				'param_name' => 'marker3',
				'value' => '',
				'description' => esc_html__( 'Upload marker image', 'naturecircle' ),
				'group' => 'Marker 3'
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Description', 'naturecircle' ),
				'param_name' => 'description3',
				'value' => '',
				'description' => esc_html__( 'Allowed HTML tags: a, i, em, br, strong, p, h3, h3, h3', 'naturecircle' ),
				'group' => 'Marker 3'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Latitude', 'naturecircle' ),
				'param_name' => 'lat4',
				'value' => '',
				'group' => 'Marker 4'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Longtitude', 'naturecircle' ),
				'param_name' => 'long4',
				'value' => '',
				'group' => 'Marker 4'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Address', 'naturecircle' ),
				'param_name' => 'address4',
				'value' => '',
				'description' => esc_html__( 'If you donot enter coordinate, enter address here', 'naturecircle' ),
				'group' => 'Marker 4'
			),
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Marker image', 'naturecircle' ),
				'param_name' => 'marker4',
				'value' => '',
				'description' => esc_html__( 'Upload marker image', 'naturecircle' ),
				'group' => 'Marker 4'
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Description', 'naturecircle' ),
				'param_name' => 'description4',
				'value' => '',
				'description' => esc_html__( 'Allowed HTML tags: a, i, em, br, strong, p, h4, h4, h4', 'naturecircle' ),
				'group' => 'Marker 4'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Latitude', 'naturecircle' ),
				'param_name' => 'lat5',
				'value' => '',
				'group' => 'Marker 5'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Longtitude', 'naturecircle' ),
				'param_name' => 'long5',
				'value' => '',
				'group' => 'Marker 5'
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Address', 'naturecircle' ),
				'param_name' => 'address5',
				'value' => '',
				'description' => esc_html__( 'If you donot enter coordinate, enter address here', 'naturecircle' ),
				'group' => 'Marker 5'
			),
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Marker image', 'naturecircle' ),
				'param_name' => 'marker5',
				'value' => '',
				'description' => esc_html__( 'Upload marker image', 'naturecircle' ),
				'group' => 'Marker 5'
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Description', 'naturecircle' ),
				'param_name' => 'description5',
				'value' => '',
				'description' => esc_html__( 'Allowed HTML tags: a, i, em, br, strong, p, h5, h5, h5', 'naturecircle' ),
				'group' => 'Marker 5'
			),
		)
	) );
	
	//Counter
	vc_map( array(
		'name' => esc_html__( 'Counter', 'naturecircle' ),
		'base' => 'naturecircle_counter',
		'class' => '',
		'category' => esc_html__( 'Theme', 'naturecircle'),
		'params' => array(
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Image icon', 'naturecircle' ),
				'param_name' => 'image',
				'value' => '',
				'description' => esc_html__( 'Upload icon image', 'naturecircle' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number', 'naturecircle' ),
				'param_name' => 'number',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Text', 'naturecircle' ),
				'param_name' => 'text',
				'value' => '',
			),
		)
	) );
}
?>