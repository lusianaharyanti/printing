  
		var naturecircle_testipause = 3000,
			naturecircle_testianimate = 2000;
		var naturecircle_testiscroll = false;
							naturecircle_testiscroll = true;
					var naturecircle_catenumber = 6,
			naturecircle_catescrollnumber = 2,
			naturecircle_catepause = 3000,
			naturecircle_cateanimate = 700;
		var naturecircle_catescroll = false;
					var naturecircle_menu_number = 9;
		var naturecircle_sticky_header = false;
							naturecircle_sticky_header = true;
			
		jQuery(document).ready(function(){
			jQuery("#ws").focus(function(){
				if(jQuery(this).val()=="Search product..."){
					jQuery(this).val("");
				}
			});
			jQuery("#ws").focusout(function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("Search product...");
				}
			});
			jQuery("#wsearchsubmit").on('click',function(){
				if(jQuery("#ws").val()=="Search product..." || jQuery("#ws").val()==""){
					jQuery("#ws").focus();
					return false;
				}
			});
			jQuery("#search_input").focus(function(){
				if(jQuery(this).val()=="Search..."){
					jQuery(this).val("");
				}
			});
			jQuery("#search_input").focusout(function(){
				if(jQuery(this).val()==""){
					jQuery(this).val("Search...");
				}
			});
			jQuery("#blogsearchsubmit").on('click',function(){
				if(jQuery("#search_input").val()=="Search..." || jQuery("#search_input").val()==""){
					jQuery("#search_input").focus();
					return false;
				}
			});
		});
		