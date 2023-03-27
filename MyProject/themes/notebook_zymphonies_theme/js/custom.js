
/** 
	* Filename:     custom.js
	* Version:      1.0.0 (9 Nov 2021)
	* Website:      https://www.zymphonies.com
	* Description:  Global Script
	* Author:		Zymphonies Team
					info@zymphonies.com
**/

function themeMenu(){

	// Main menu
	jQuery('#main-menu').smartmenus();
	
	// Mobile menu toggle
	jQuery('.navbar-toggle').click(function(){
		jQuery('.region-primary-menu').addClass('expand');
	});
	jQuery('.navbar-toggle-close').click(function(){
		jQuery('.region-primary-menu').removeClass('expand');
	});

	// Mobile dropdown menu
	if ( jQuery(window).width() < 767) {
		jQuery(".region-primary-menu li a:not(.has-submenu)").click(function () {
			jQuery('.region-primary-menu').hide();
	    });
	}

}

function themeHome(){
	jQuery('.flexslider').flexslider({
    	animation: "slide"	
    });
}

function themeMasonry(){
	var $container = jQuery('.path-frontpage .main-content .views-element-container >div, .path-taxonomy .main-content .views-element-container >div');
	$container.imagesLoaded( function(){
		$container.masonry({
			itemSelector: '.views-row',
			transitionDuration: '0.5s',
			isOriginLeft: true,
			percentPosition: true,
			gutter: 10
		});
	});	
}

jQuery(document).ready(function($){
	themeMenu();
	themeHome();
	themeMasonry();
});