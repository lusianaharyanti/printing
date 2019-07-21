"use strict";
// product-magnifier var
	var naturecircle_magnifier_vars;
	var yith_magnifier_options = {
		
		sliderOptions: {
			responsive: naturecircle_magnifier_vars.responsive,
			circular: naturecircle_magnifier_vars.circular,
			infinite: naturecircle_magnifier_vars.infinite,
			direction: 'left',
            debug: false,
            auto: false,
            align: 'left',
            height: 'auto',
            //height: "100%", //turn vertical
            //width: 100,  
			prev    : {
				button  : "#slider-prev",
				key     : "left"
			},
			next    : {
				button  : "#slider-next",
				key     : "right"
			},
			scroll : {
				items     : 1,
				pauseOnHover: true
			},
			items   : {
				visible: Number(naturecircle_magnifier_vars.visible),
			},
			swipe : {
				onTouch:    true,
				onMouse:    true
			},
			mousewheel : {
				items: 1
			}
		},
		
		showTitle: false,
		zoomWidth: naturecircle_magnifier_vars.zoomWidth,
		zoomHeight: naturecircle_magnifier_vars.zoomHeight,
		position: naturecircle_magnifier_vars.position,
		lensOpacity: naturecircle_magnifier_vars.lensOpacity,
		softFocus: naturecircle_magnifier_vars.softFocus,
		adjustY: 0,
		disableRightClick: false,
		phoneBehavior: naturecircle_magnifier_vars.phoneBehavior,
		loadingLabel: naturecircle_magnifier_vars.loadingLabel,
	};