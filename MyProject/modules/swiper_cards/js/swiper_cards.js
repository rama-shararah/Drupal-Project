(function($, Drupal, drupalSettings) {
	Drupal.behaviors.swiper_cards = {
		attach: function(context, settings) {
			$(document, context).once('swiper_cards').each(function(element) {

				// layout-1
				var swiperCard = $('.swiper-container-layout-1');
				if (swiperCard.length > 0) {
					var swiper = new Swiper(swiperCard, {
						effect: "coverflow",
						grabCursor: true,
						loop:true,
						centeredSlides: true,
						slidesPerView: "auto",
						coverflowEffect: {
							rotate: 20,
							stretch: 0,
							depth: 350,
							modifier: 1,
							slideShadows: true
						},
						pagination: {
							el: ".swiper-pagination"
						}
					});
				}

				// layout-2
				var agSwiper = $(this);
				if (agSwiper.length > 0) {
					var swiperId = agSwiper.attr('id');
					var swiper = new Swiper('.sc-layout-4', {
						effect: "cards",
						grabCursor: true,
						loop: true,
					});
				}

				// swiper-3
				var agSwiper = $('.swiper-container');
				if (agSwiper.length > 0) {
					var sliderView = 1;
					var ww = $(window).width();
					if (ww >= 1700) sliderView = 7;
					if (ww <= 1700) sliderView = 7;
					if (ww <= 1560) sliderView = 6;
					if (ww <= 1400) sliderView = 5;
					if (ww <= 1060) sliderView = 4;
					if (ww <= 800) sliderView = 3;
					if (ww <= 560) sliderView = 2;
					if (ww <= 400) sliderView = 1;
					var swiper = new Swiper(agSwiper, {
						slidesPerView: sliderView,
						spaceBetween: 0,
						loop: true,
						loopedSlides: 16,
						speed: 900,
						autoplay: true,
						autoplayDisableOnInteraction: true,
						centeredSlides: true
					});
					$(window).resize(function () {
						var ww = $(window).width();
						if (ww >= 1700) swiper.params.slidesPerView = 7;
						if (ww <= 1700) swiper.params.slidesPerView = 7;
						if (ww <= 1560) swiper.params.slidesPerView = 6;
						if (ww <= 1400) swiper.params.slidesPerView = 5;
						if (ww <= 1060) swiper.params.slidesPerView = 4;
						if (ww <= 800) swiper.params.slidesPerView = 3;
						if (ww <= 560) swiper.params.slidesPerView = 2;
						if (ww <= 400) swiper.params.slidesPerView = 1;
					});
					$(window).trigger('resize');
					var swiperContainer = document.querySelector('.swiper-container').swiper;
					agSwiper.mouseenter(function () {
						swiperContainer.autoplay.stop();
						console.log('slider stopped');
					});
					agSwiper.mouseleave(function () {
						swiperContainer.autoplay.start();
						console.log('slider started again');
					});
				}

				// swiper-4
				var agSwiper = $('.swiper-container-l4');
				if (agSwiper.length > 0) {
					var swiper = new Swiper(agSwiper, {
						effect: 'coverflow',
						grabCursor: true,
						centeredSlides: true,
						loop: true,
						slidesPerView: 'auto',
						speed: 900,
						coverflowEffect: {
							rotate: 50,
							stretch: 0,
							depth: 100,
							modifier: 1,
							slideShadows : true,
						},
						pagination: {
							el: '.swiper-pagination',
						},
					});
				}

			});
		}
	}
}(jQuery, Drupal, drupalSettings));