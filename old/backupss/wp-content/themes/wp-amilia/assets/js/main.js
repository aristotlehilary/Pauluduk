jQuery(document).ready(function($) {
	"use strict";
	
	/* window */
	var window_width, window_height, scroll_top;
	
	/* admin bar */
	var adminbar = $('#wpadminbar');
	var adminbar_height = 0;
	
	/* header menu */
	var header = $('#cshero-header');
	var header_top = 0;
	
	var trigger_phone = false;

	/* scroll status */
	var scroll_status = '';
	
	/* For Primary menu fixed  */
	if ($('body').hasClass('atop-primary-menu')) {

	} else {
		jQuery('#cshero-header.header-fixed-page').affix({
			offset: { top: 1, }
		});	
	}

	$('.cms-blog-item').fitVids();

	//pie char
	$('.vc_pie_chart').each(function(){
		$(this).waypoint(
			function() {
				$(this).circliful();
			}, {
				offset : '95%',
				triggerOnce : true
		});	
	});

	//equal height
	$('.equal-height').each(function() {
		var row = $(this).parents('.cms-equal-height-wrapper');
		$(row).find('.equal-height').equalHeights();
	})

	/* Set background color over left */
	$('.bg_column_overleft').each(function(i, el) {
		var bg_color = $(el).css('background-color');
		$(el).addClass('bg_column_overleft' + i);
		if (bg_color != 'transparent' && bg_color != 'rgba(0, 0, 0, 0)') {
			$('<style>.bg_column_overleft' + i+':before{background-color: '+ bg_color +'}</style>').appendTo('head');
		}
	});

	if ($('.atop-primary-menu').length) {
		$('.atop-primary-menu #cshero-header').sticky({
			topSpacing: 0
		});
	}
	//test resize trigger after 3s
	setTimeout(function(){
		$(window).resize();
	}, 3000);
	/**
	 * window load event.
	 * 
	 * Bind an event handler to the "load" JavaScript event.
	 * @author Fox
	 */
	$(window).load(function() {
		/* get admin bar height */
		adminbar_height = adminbar.length > 0 ? adminbar.outerHeight(true) : 0 ;
		
		/** current scroll */
		scroll_top = $(window).scrollTop();

		/** current window width */
		window_width = $(window).width();
		
		/** current window height */
		window_height = $(window).height();
		
		/* get top header menu */
		header_top = adminbar_height;
		
		/* check sticky menu. */
		if(CMSOptions.menu_sticky == '1'){
			cms_stiky_menu(scroll_top);
		}
		if(trigger_phone == false) {
			portfolio_filter_onphone();
		}
		
		/* check mobile menu */
		cms_mobile_menu();
		
		/* check back to top */
		if(CMSOptions.back_to_top == '1'){
			/* add html. */
			$('body').append('<div id="back_to_top" class="back_to_top"><span class="go_up"><i style="" class="fa fa-arrow-up"></i></span></div><!-- #back-to-top -->');
			cms_back_to_top();
		}
		
		/* page loading. */
		cms_page_loading();
		
		/* check video size */
		cms_image_carousel();
		cms_lightbox_popup();

		/* Bs init */
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});

		//POPOVER INITIALIZE	
		$(function () {
			$('[data-toggle="popover"]').popover()
		});

		if ( $('.wow').length ) {
		    initWow(); 
		};

		/* Offset shortcode nav */
		var offsetFooter = $('.footer-offset').height() + 40 + $('.newsletter-on-single').height();
		jQuery('.menu-w_shortcodes-container, .menu-w_typography-container').parent().addClass('cms-nav-shortcode-wrap').affix({
			offset: {
				top: 150,
				bottom: offsetFooter		
			}
		});

		if ($('.company-timeline-wrap').length) {
			var data_date = $('.timeline-block.first-item').attr('data-timline-date');
			$('.timeline-start-date').text(data_date);
		} 
	});

	/**
	 * reload event.
	 * 
	 * Bind an event handler to the "navigate".
	 */
	window.onbeforeunload = function(){ cms_page_loading(1); }
	
	/**
	 * resize event.
	 * 
	 * Bind an event handler to the "resize" JavaScript event, or trigger that event on an element.
	 * @author Fox
	 */
	$(window).resize(function(event, ui) {
		/** current window width */
		window_width = $(event.target).width();
		
		/** current window height */
		window_height = $(window).height();
		
		/** current scroll */
		scroll_top = $(window).scrollTop();
		
		/* check sticky menu. */
		if(CMSOptions.menu_sticky == '1'){
			cms_stiky_menu(scroll_top);
		}

		if(trigger_phone == false) {
			portfolio_filter_onphone();
		}
		
		/* check mobile menu */
		cms_mobile_menu();
	});
	
	/**
	 * scroll event.
	 * 
	 * Bind an event handler to the "scroll" JavaScript event, or trigger that event on an element.
	 * @author Fox
	 */
	var lastScrollTop = 0;
	
	$(window).scroll(function() {
		/** current scroll */
		scroll_top = $(window).scrollTop();
		/** check scroll up or down. */
		if(scroll_top < lastScrollTop) {
			/* scroll up. */
			scroll_status = 'up';
		} else {
			/* scroll down. */
			scroll_status = 'down';
		}
		
		lastScrollTop = scroll_top;
		
		/* check sticky menu. */
		if(CMSOptions.menu_sticky == '1'){
			cms_stiky_menu();
		}

		/* check sticky menu fixed page */
		if(CMSOptions.menu_sticky == '0'){
			cms_stiky_menu_fixed_page();
		}
		
		/* check back to top */
		cms_back_to_top();
	});

	/**
	 * Stiky menu
	 * 
	 * Show or hide sticky menu.
	 * @author Fox
	 * @since 1.0.0
	 */
	function cms_stiky_menu() {

		if (header_top < scroll_top) {
			switch (true) {
				case (window_width >= 992):
					header.addClass('header-fixed');
					$('body').addClass('fixed-margin-top');
					break;
				case (window_width < 992):
					header.addClass('header-fixed');
					$('body').addClass('fixed-margin-top');
					break;
			}
		} else {
			header.removeClass('header-fixed');
			$('body').removeClass('fixed-margin-top');
		}
	}
	function cms_stiky_menu_fixed_page() {
		if (header_top < scroll_top) {
			header.addClass('header-fixed-page-trans');
		} else {
			header.removeClass('header-fixed-page-trans');
		}
	}
	
	/**
	 * Mobile menu
	 * 
	 * Show or hide mobile menu.
	 * @author Fox
	 * @since 1.0.0
	 */
	
	$('body').on('click', '#cshero-menu-mobile', function(){
		var navigation = $(this).parent().find('#cshero-header-navigation');
		if(!navigation.hasClass('collapse')){
			navigation.addClass('collapse');
		} else {
			navigation.removeClass('collapse');
		}
	});
	/* check mobile screen. */
	function cms_mobile_menu() {
		var menu = $('#cshero-header-navigation');
		
		/* active mobile menu. */
		switch (true) {
		case (window_width <= 992 && window_width >= 768):
			menu.removeClass('phones-nav').addClass('tablets-nav');
			/* */
			cms_mobile_menu_group(menu);
			break;
		case (window_width <= 768):
			menu.removeClass('tablets-nav').addClass('phones-nav');
			break;
		default:
			menu.removeClass('mobile-nav tablets-nav');
			menu.find('li').removeClass('mobile-group');
			break;
		}	
	}
	/* group sub menu. */
	function cms_mobile_menu_group(nav) {
		nav.each(function(){
			$(this).find('li').each(function(){
				if($(this).find('ul:first').length > 0){
					$(this).addClass('mobile-group');
				}
			});
		});
	}
	
	/**
	 * Parallax.
	 * 
	 * @author Fox
	 * @since 1.0.0
	 */
	var cms_parallax = $('.cms_parallax');
	if(cms_parallax.length > 0 && CMSOptions.paralax == '1') {
		cms_parallax.each(function() {
			"use strict";
			var speed = $(this).attr('data-speed');
			
			speed = (speed != undefined && speed != '') ? speed : 0.1 ;
			
			$(this).parallax("50%", speed);
		});
	}
	
	/**
	 * Page Loading.
	 */
	function cms_page_loading($load) {
		switch ($load) {
		case 1:
			$('#amilia-loading').css('display','block')
			break;
		default:
			$('#amilia-loading').css('display','none')
			break;
		}
	}

	/**
	 * Post Like.
	 * 
	 * @author Fox
	 * @since 1.0.0
	 */
	$('.entry-like').on('click', function (event) {
		/* get post id. */
		var bt_like = $(this);
		
		var post_id = bt_like.attr('data-id');
		
		if(post_id != undefined && post_id != '') {
			/* add like. */
			$.post(ajaxurl, {
				'action' : 'cms_post_like',
				'id' : post_id
			}, function(response) {
				if(response != ''){
					bt_like.find('i').attr('class', 'fa fa-heart')
					bt_like.find('span').html(response);
				}
			});
		}
		event.preventDefault();
	});
	
	/**
	 * Back To Top
	 * 
	 * @author Fox
	 * @since 1.0.0
	 */
	$('body').on('click', '#back_to_top', function () {
        $("html, body").animate({
            scrollTop: 0
        }, 1500);
    });
	
	/* Show or hide buttom  */
	function cms_back_to_top(){
		/* back to top */
        if (scroll_top < window_height) {
        	$('#back_to_top').addClass('off').removeClass('on');
        } else {
        	$('#back_to_top').removeClass('off').addClass('on');
        }
	}

	/* Amilia function custom in here */

	/**
	 * Portfolio Filter on phone
	 * 
	 * @author DuongTung
	 * @since 1.0
	 */
	function portfolio_filter_onphone() {
		trigger_phone = true;
		if ( window_width - 599 <= 0 ) { //On phone
			$('.cms-grid-filter-inphone a').on('click', function(e) {
				var $this = $(this);
				e.preventDefault();
				var wrap = $this.parents('.cms-grid-filter-wrap');
				if ( $('.cms-grid-filter', wrap).hasClass('active') ) {
					$('.cms-grid-filter', wrap).removeClass('active').slideUp();
				} else {
					$('.cms-grid-filter', wrap).addClass('active').slideDown(300);
				}
			});

			$('.cms-grid-filter a').on('click', function() {
				var $this = $(this),
					wrap = $this.parents('.cms-grid-filter-wrap');;
				$('.cms-grid-filter', wrap).removeClass('active').slideUp();
				$('.cms-grid-filter-inphone a').text($this.text());
			});
		}
	}

	/**
	 * Custom Owl Carousel
	 * 
	 * @author DuongTung
	 * @since 1.0.0
	 */
	function cms_image_carousel() {
		if ( $('.cms-carousel-wrapper').length ) {
			$('.cms-carousel-wrapper').each(function(index, el) {

				var id_carousel = $(el).attr('id');
				var wrap = $('#' + id_carousel + ' .cms-owl-carousel');

				var image_carousel_setting = {};
					image_carousel_setting.items = wrap.attr('data-per-view');
					image_carousel_setting.rewind = true;
					image_carousel_setting.margin = 0;
					image_carousel_setting.mouseDrag = true;
					image_carousel_setting.autoplay = (wrap.attr('data-autoplay') === "true");
					image_carousel_setting.autoplaySpeed = 800;
					image_carousel_setting.dots = (wrap.attr('data-pagination') === "true");
					image_carousel_setting.loop = (wrap.attr('data-loop') === "true");
					image_carousel_setting.nav = (wrap.attr('data-nav') === "true");
			        image_carousel_setting.navText = ["prev", "next"];
			        if (wrap.attr('data-per-view') > 4) {
			        	image_carousel_setting.responsive = {
					        1000:{
					            items:5
					        },
					        900:{
					            items:3
					        },
					        470:{
					            items:2
					        }
					    } 
			        }
			        
				//Play
				wrap.owlCarousel(image_carousel_setting);
			});
		}
	}

	/**
	 * Init Wow
	 * 
	 * @author DuongTung
	 * @since 1.0.0
	 */
	function initWow(){
		var wow = new WOW( { mobile: false, } );
		wow.init();
	}

	/**
	 * One page
	 * 
	 * @author Fox
	 */
	if(CMSOptions.one_page == true) {
		
		$('body').on('click', '.onepage', function () {
			$('#cshero-menu-mobile').removeClass('close-open');
			$('#cshero-header-navigation').removeClass('open-menu');
			$('.cshero-menu-close').removeClass('open');
		});
		
		var one_page_options = {'filter' : '.onepage'};
		
		if(CMSOptions.one_page_speed != undefined) one_page_options.speed = parseInt(CMSOptions.one_page_speed);
		if(CMSOptions.one_page_easing != undefined) one_page_options.easing =  CMSOptions.one_page_easing;
		
		$('#cshero-header-navigation, .widget_nav_menu').singlePageNav(one_page_options);

	}

	/**
	 * LightBox
	 * 
	 * @author DuongTung
	 * @since 1.0.0
	 */
	function cms_lightbox_popup() {
		$('.cms-lightbox').magnificPopup({
			// delegate: 'a',
			type: 'image',
			mainClass: 'mfp-3d-unfold',
			removalDelay: 500, //delay removal by X to allow out-animation
			callbacks: {
				beforeOpen: function() {
				// just a hack that adds mfp-anim class to markup 
				this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
				// this.st.mainClass = this.st.el.attr('data-effect');
				}
			},
			closeOnContentClick: true,
			midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
		});

		$('.cms-popup-gallery').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-3d-unfold',
			removalDelay: 500, //delay removal by X to allow out-animation
			callbacks: {
				beforeOpen: function() {
					// just a hack that adds mfp-anim class to markup 
					this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
					// this.st.mainClass = this.st.el.attr('data-effect');
				}
			},
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				/*titleSrc: function(item) {
				return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
				}*/
			}
		});
		$('.cms-video-popup, .cms-lightbox-map').magnificPopup({
			//disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,

			fixedContentPos: false
		});
	}
	/* End function custom */

});

/* Header sticky indent  */
jQuery(document).on("scroll", function($) {
	"use strict";

	setTimeout(function() {
		if (jQuery('.cshero-main-header').hasClass('affix')) {
			jQuery('.page-title').addClass('affix-indent');
		}  else {
			jQuery('.page-title').removeClass('affix-indent');
		};
	},100);
}); 