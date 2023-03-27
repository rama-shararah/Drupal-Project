(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {

		// iPad and iPod detection	
			var isiPad = function(){
				return (navigator.platform.indexOf("iPad") != -1);
			};
			var isiPhone = function(){
			    return (
					(navigator.platform.indexOf("iPhone") != -1) || 
					(navigator.platform.indexOf("iPod") != -1)
			    );
			};
			// Main Menu Superfish
			var mainMenu = function() {
				$('#fh5co-primary-menu').superfish({
					delay: 0,
					animation: {
						opacity: 'show'
					},
					speed: 'fast',
					cssArrows: true,
					disableHI: true
				});
			};
		// Parallax
			var parallax = function() {
				$(window).stellar();
			};
			// Offcanvas and cloning of the main menu
			var offcanvas = function() {
				var $clone = $('#fh5co-menu-wrap').clone();
				$clone.attr({
					'id' : 'offcanvas-menu'
				});
				$clone.find('> ul').attr({
					'class' : '',
					'id' : ''
				});
				$('#fh5co-page').prepend($clone);
				// click the burger
				$('.js-fh5co-nav-toggle').on('click', function(){

					if ( $('body').hasClass('fh5co-offcanvas') ) {
						$('body').removeClass('fh5co-offcanvas');
					} else {
						$('body').addClass('fh5co-offcanvas');
					}
					// $('body').toggleClass('fh5co-offcanvas');
				});
				$('#offcanvas-menu').css('height', $(window).height());

				$(window).resize(function(){
					var w = $(window);
					$('#offcanvas-menu').css('height', w.height());

					if ( w.width() > 769 ) {
						if ( $('body').hasClass('fh5co-offcanvas') ) {
							$('body').removeClass('fh5co-offcanvas');
						}
					}
				});	

			}
		// Carousel
		  $('.testimonial-owl-carousel').owlCarousel({
			    loop: true,
			    margin: 10,
			    responsiveClass: true,
			    dots: false,
			    center: false,
			    smartSpeed: 500,
			    responsive: {
			      0:{
			          items:1
			      },
			      600:{
			          items:2
			      },
			      1000:{
			          items:3
			      }    
			    }
			  });  
		    $( ".owl-prev").html('<i class="fa fa-chevron-left"></i>');
			$( ".owl-next").html('<i class="fa fa-chevron-right"></i>');
		// Click outside of the Mobile Menu
			var mobileMenuOutsideClick = function() {
				$(document).click(function (e) {
			    var container = $("#offcanvas-menu, .js-fh5co-nav-toggle");
			    if (!container.is(e.target) && container.has(e.target).length === 0) {
			      if ( $('body').hasClass('fh5co-offcanvas') ) {
						$('body').removeClass('fh5co-offcanvas');
					}
			    }
				});
			};

		// Animations
			var contentWayPoint = function() {
				var i = 0;
				$('.animate-box').waypoint( function( direction ) {
					if( direction === 'down' && !$(this.element).hasClass('animated') ) {
						i++;
						$(this.element).addClass('item-animate');
						setTimeout(function(){

							$('body .animate-box.item-animate').each(function(k){
								var el = $(this);
								setTimeout( function () {
									el.addClass('fadeInUp animated');
									el.removeClass('item-animate');
								},  k * 200, 'easeInOutExpo' );
							});
							
						}, 100);				
					}
				} , { offset: '85%' } );
			};

			// bannertitle
			var bannertitle = function() {
				var h3 = $('#banner-title');
				var text = h3.text().split(' ');
				$.each(text,function(i,val) {
				    if( i % 3) {
				        if(i == 2){
				        	text[i] = '<strong>' + val + '</strong>';
				    	}
				    }
				});
				h3.html(text.join(' '));
			};	

		// var NewburgerMenu = function() {
		// 	$('#offcanvas-menu').on('click', '.js-fh5co-nav-toggle', function(){
		// 		$('body').toggleClass('fh5co-offcanvas');
		// 		$('body').toggleClass('fh5co-offcanvas');		
		// 	});
		// };
		// Youtube Popup	
		jQuery(document).ready(function( $ ) {
         $('.popup-youtube').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
          }); 
        });

		// Document on load.
			$(function(){
				bannertitle();
				mainMenu();
				parallax();
				offcanvas();
				mobileMenuOutsideClick();
				contentWayPoint();	
				// NewburgerMenu();	
			});

		
		// jQuery(document).ready(function( $ ) {

		// });

		
    }
  };
})(jQuery, Drupal);