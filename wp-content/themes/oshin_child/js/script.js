;(function($) {
    jQuery.fn.center = function(parent) {
        if (parent) {
            parent = this.parent();
        } else {
            parent = window;
        }
        this.css({
            "position": "absolute",
            "top": (((jQuery(parent).height() - this.outerHeight()) / 2) + jQuery(parent).scrollTop() + "px"),
            "left": (((jQuery(parent).width() - this.outerWidth()) / 2) + jQuery(parent).scrollLeft() + "px")
        });
        return this;
    }
})(jQuery);

// Custom Side with Fade Animation
;(function($) {
    jQuery.fn.slideFadeToggle  = function(speed, easing, callback) {
        return this.animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, speed, easing, callback);
    };
})();

//Parallax
;(function( $ ) {
	var $window = $(window), update_parallax;
	var windowHeight = $window.height();

	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		//get the starting position of each element to have parallax applied to it
		$this.each(function(){
			firstTop = $this.offset().top;
		});
		if (outerHeight) {
			getHeight = function(jqo) {
			return jqo.outerHeight(true);
		};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}
		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.5;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;
		// function to be called whenever the window is scrolled or resized
		update_parallax = function() {
			var pos = $window.scrollTop();
			$this.each(function() {
				var $element = $(this);
				var top = $element.offset().top;
				var height = getHeight($element);
				// Check if totally above or totally below viewport
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}
				$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
			});
		}
		$window.on('scroll.parallaxscroll', update_parallax);
		$window.on('smartresize.parallaxresize', update_parallax);
		update_parallax();
	};
	jQuery(document).on("update_content", function() {
		if(jQuery(this).find('.be-section.be-bg-parallax').length == 0) {
			$window.off('scroll.parallaxscroll', update_parallax);
			$window.off('scroll.parallaxresize', update_parallax);
		}
    });
})(jQuery);


;(function( $ ) {
    'use strict';

    var vendorScriptsUrl = oshineThemeConfig.vendorScriptsUrl;

	asyncloader.register( vendorScriptsUrl+'fitvids.js', 'fitvids' );
	asyncloader.register( vendorScriptsUrl+'superfish.js', 'superfish' );
	asyncloader.register( vendorScriptsUrl+'hoverintent.js', 'hoverintent' );
	asyncloader.register( vendorScriptsUrl+'imagesloaded.js' , 'imagesloaded' );
	asyncloader.register( vendorScriptsUrl+'horizontalcarousel.js' , 'horizontalcarousel' );
	asyncloader.register( 'https://f.vimeocdn.com/js/froogaloop2.min.js' , 'vimeo' );
	asyncloader.register( vendorScriptsUrl+'resizetoparent.js' , 'resizetoparent' );
	asyncloader.register( vendorScriptsUrl+'mousewheel.js' , 'mousewheel' );
	asyncloader.register( vendorScriptsUrl+'patterncanvas.js' , 'patterncanvas' );
	asyncloader.register( vendorScriptsUrl+'greensock.js' , 'greensock' );
	asyncloader.register( vendorScriptsUrl+'galaxycanvas.js' , 'galaxycanvas' );
	asyncloader.register( vendorScriptsUrl+'waterdropcanvas.js' , 'waterdropcanvas' );
	asyncloader.register( vendorScriptsUrl+'request_animation_frame.js' , 'request_animation_frame' );
	asyncloader.register( vendorScriptsUrl+'transparentheader.js' , 'transparentheader' );
	asyncloader.register( vendorScriptsUrl+'scrolltosections.js' , 'scrolltosections' );
	asyncloader.register( vendorScriptsUrl+'fullscreenheight.js' , 'fullscreenheight' );
	asyncloader.register( vendorScriptsUrl+'flickity.js' , 'flickity' );
	asyncloader.register( vendorScriptsUrl+'backgroundcheck.js' , 'backgroundcheck' );
	//asyncloader.register( vendorScriptsUrl+'scrollbar.js' , 'scrollbar' );
	asyncloader.register( vendorScriptsUrl+'backgroundposition.js' , 'backgroundposition' );
	asyncloader.register( vendorScriptsUrl+'easing.js' , 'easing' );
	asyncloader.register( vendorScriptsUrl+'magnificpopup.js', 'magnificpopup' );

    function Selector_Cache() {
	    var collection = {};

	    function get_from_cache( selector ) {
	        if ( undefined === collection[ selector ] ) {
	            collection[ selector ] = jQuery( selector );
	        }

	        return collection[ selector ];
	    }

	    return { get: get_from_cache };
	}

    jQuery(document).ready( function() {


	    var oshine_scripts = (function() {

	    	var page_loader = jQuery('.page-loader'),
	    	 	 ajax_url = jQuery('#ajax_url').val(),
	    	 	 transition,
	    	 	 exclude_links,
	    	 	 body = jQuery('body'),
	    	 	 html = jQuery('html'),
	    	 	 selectors = new Selector_Cache(),
	    	 	 to_top_button = jQuery('#back-to-top'),
	    	 	 fullscreen_wrap = jQuery('.hero-section-wrap, .full-screen-section, .tatsu-fullscreen'),


	    	resize_gallery_video =  function() {
		        if (jQuery(window).width() < 769) {
		        	var width = jQuery('#gallery-container-wrap').width();
		            jQuery('iframe.gallery').each(function () {
		                jQuery(this).width( width );
		            });
		        } else {
		            jQuery('iframe.gallery').each(function () {
		                jQuery(this).width( ( jQuery(this).height() * 1.77 ) );
		            });
		        }
	    	},

	    	menu_link_animation = function() {
		        var delay_time = 500,
		            index = 0,
		            slidebar_menu = document.getElementById("slidebar-menu").children,
		            child_count = slidebar_menu.length;
		        for( index; index<child_count; index++ ) {
		            jQuery(slidebar_menu[index]).delay(delay_time).addClass("menu-loaded",200);
		            delay_time += 100;
		        }
	    	},

	    	custom_scrollbar = function() {
	    		if( !body.hasClass('tatsu-frame') ) {

		    		//var gallery_content = jQuery('.gallery_content_area, .gallery_content_slide, .fixed-sidebar-content-inner');
		    		var gallery_content = jQuery('.simplebar-content');
				        if ( gallery_content.length > 0 ) {

				            // gallery_content.mCustomScrollbar({
				            //     autoHideScrollbar: true
				            // });

							//gallery_content.nanoScroller();
							//gallery_content.simplebar({ wrapContent: false });
							gallery_content.perfectScrollbar();

				        }
				}
	    	},

	    	single_page_nav = function() {
	    		if ( body.hasClass('single-page-version') && !body.hasClass('section-scroll') ) {
			        var append_section = '',
			            specific_section = jQuery('.tatsu-section'),
			            section_length = specific_section.length,
			            section_id,
			            section_title,
			            index = 0;
			        if( jQuery('.single-page-nav-wrap').length > 0 ){
			            body.find('.single-page-nav-wrap').remove();
			        }

		            if( jQuery('#hero-section').length > 0 ){
		                append_section = '<a class="single-page-nav-link back-to-top" href="#"><span>Home</span></a>';
		            }
		            for ( index; index < section_length; index++ ) {
		                section_id = specific_section.eq(index).attr('id');
		                section_title = specific_section.eq(index).attr('data-title');
		                if( section_id ){
		                    if( section_title ){
		                        section_title = "<span>" + section_title + "</span>";
		                    } else {
		                        section_title = '';
		                    }
		                    append_section += '<a class="single-page-nav-link" href="#'+section_id+'">'+section_title+'</a>';
		                }
		            }
		            body.append('<div class="single-page-nav-wrap clearfix"><div class="single-page-nav-wrap-inner clearfix"><div class="sinle-page-nav-links">'+append_section+'</div></div></div>');
		        }

	    	},

	    	menu_item_update = function() {
		        var header_height = jQuery('#wpadminbar').height() + 1,
		            main_menu_items = jQuery('li.menu-item'),
		            single_page_nav_dots = jQuery('.single-page-nav-link'),  //Should add context after converting single-page-nav-wrap and single-page-nav-links to ID
		            total_sections = jQuery('.tatsu-section'),
		            section_count = total_sections.length,
		            window_height = jQuery(window),
		            header_bottom_bar = jQuery('#header-bottom-bar'),
		            index = 0;
		        if( body.hasClass('top-header') ){
		            header_height += Number( jQuery('#header-wrap').attr('data-default-height') );
		            if( header_bottom_bar.length > 0 ){
		                header_height += header_bottom_bar.height();
		            }
		        }
		        if( body.hasClass('single-page-version') ){
		            main_menu_items.removeClass('current-menu-item');
		            for( index; index < section_count; index++ ) {
		                var current_object = total_sections.eq(index),
		                    current_object_id = current_object.attr('id');
		                if( window_height.scrollTop() + header_height >= current_object.offset().top ){
		                    main_menu_items.removeClass('current-menu-item current-section');
		                    single_page_nav_dots.removeClass('current-section-nav-link');
		                    if( current_object_id ){
		                        main_menu_items.find('a[href$="#'+ current_object_id +'"]').closest('li.menu-item').addClass('current-menu-item current-section');
		                        single_page_nav_dots.filter('a[href$="#' + current_object_id + '"]').addClass('current-section-nav-link');
		                    }
		                }
		            }
		        }
	    	},



	    	open_leftstrip = function() {
		        jQuery('.left-strip-wrapper').removeClass('hide');
		        html = html.removeClass('hide-overflow');
	    	},



	    	animate_scroll = function( element ) {
		        if ( body.hasClass('section-scroll') && ( jQuery(window).width() > 1024 ) && html.hasClass('csstransforms') ) {
		            jQuery.fn.translate(element);
		            return false;
		        }
		        var $scroll_to = 1,
		        $sticky_offset,
		        header_wrap = jQuery('#header-wrap'),
		        header_wrap_default_height = Number( header_wrap.attr('data-default-height') ),
		        header_wrap_sticky_height = Number( header_wrap.attr('data-sticky-height') ),
		        top_bar_height = Number( jQuery('#header-top-bar-wrap').innerHeight() ),
		        bottom_bar_height = Number( jQuery('#header-bottom-bar').innerHeight() ),
		        admin_bar_height = Number( jQuery('#wpadminbar').height() ),
		        hero_section = jQuery('.header-hero-section'),
		        first_pb_section = jQuery( '#page-content div' ).children( '.tatsu-section:nth-child(1)'),
		        bordered_header_layout = jQuery('#main').hasClass('layout-border-header-top');


		        if ( element.length > 0 ) {
		            $scroll_to = Number( element.offset().top ) - admin_bar_height;
		        }

		        if ( jQuery(window).width() > 960 && !( body.hasClass('page-template-page-splitscreen-left')  || body.hasClass('page-template-page-splitscreen-right') ) ) {
		            if ( body.hasClass('sticky-header') || body.hasClass('transparent-sticky') ) {
		                if ( body.hasClass('sticky-header') ) {
		                	//console.log( top_bar_height, bottom_bar_height, header_wrap_sticky_height );
		                    $sticky_offset = jQuery('#header').offset().top + header_wrap_default_height + top_bar_height + bottom_bar_height;
		                }
		                if ( body.hasClass('transparent-sticky') ) {
		                    if( hero_section.length > 0 ){
		                        $sticky_offset = Number( hero_section.offset().top ) + Number( hero_section.height() )  - admin_bar_height;
		                    } else {
		                        $sticky_offset = Number( first_pb_section.offset().top ) + Number( first_pb_section.height() ) - admin_bar_height;
		                    }
		                }
		                if( bordered_header_layout ) {
		                    $scroll_to = $scroll_to - ( header_wrap_default_height + bottom_bar_height );
		                } else {
		                    if ($scroll_to > $sticky_offset) {
		                        $scroll_to = $scroll_to - ( header_wrap_sticky_height + bottom_bar_height );
		                    }
		                    if ($scroll_to < $sticky_offset) {
		                        $scroll_to = $scroll_to - ( header_wrap_default_height + bottom_bar_height );
		                    }
		                    if ($scroll_to === $sticky_offset && jQuery('body').hasClass('transparent-sticky')) {
		                        $scroll_to = $scroll_to - ( header_wrap_sticky_height + bottom_bar_height );
		                    }
		                }
		            } else {
		                if( bordered_header_layout ) {
		                    $scroll_to = $scroll_to - Number( jQuery('#header-inner-wrap' ).innerHeight() );
		                }
		            }
		        }

		        jQuery('body, html').animate({scrollTop: $scroll_to }, 1000, 'easeOutQuart', function () {
		            close_sidebar();
		            open_leftstrip();
		            menu_item_update();
		        });
	    	},

		    sticky_sidebar = function() {
		        var $window = jQuery(window),
		        $sidebar = jQuery( ".floting-sidebar" ),
		        offset = jQuery( '#content-wrap' ).offset(),
		        $scrollHeight = jQuery( "#page-content" ).height(),
		        $scrollOffset = jQuery( "#page-content" ).offset(),
		        $headerHeight = 0,
		        admin_bar_height = Number( jQuery('#wpadminbar').innerHeight() );

		        if ( jQuery(".floting-sidebar").length > 0 && !body.hasClass('tatsu-frame') ) {
		            if ( body.hasClass('sticky-header') || body.hasClass('transparent-sticky')) {
		                $headerHeight = Number( jQuery('#header-inner-wrap').innerHeight() ) + admin_bar_height;
		            } else {
		                $headerHeight = admin_bar_height;
		            }
		            if ( $window.width() > 960 ) {
		                if ( ( $window.scrollTop() + $headerHeight ) > offset.top ) {
		                    if ( $window.scrollTop() + $headerHeight + $sidebar.height() + 50 < $scrollOffset.top + $scrollHeight ) {
		                        $sidebar.stop().animate({
		                            marginTop: ( $window.scrollTop() - offset.top ) + $headerHeight + 30,
		                            paddingTop: 30
		                        });
		                    } else {
		                        $sidebar.stop().animate({
		                            marginTop: ( $scrollHeight - $sidebar.height() - 80 ) + 30,
		                            paddingTop: 30
		                        });
		                    }
		                } else {
		                    $sidebar.stop().animate({
		                        marginTop: 0,
		                        paddingTop: 0
		                    });
		                }
		            } else {
		                $sidebar.css('margin-top', 0);
		            }
		        }
		        if ( jQuery(".fixed-sidebar").length > 0 ) {
		            var $sidebarSelector = jQuery(".fixed-sidebar"),
		            offset = jQuery('#content-wrap').offset(),
		            $scrollHeight = jQuery("#page-content").height(),
		            $scrollOffset = jQuery("#page-content").offset(),
		            $scroll_top = $window.scrollTop(),
		            $footerHeight = jQuery('#footer').outerHeight(),
		            $widgetsHeight = jQuery('#bottom-widgets').outerHeight(),
		            $sidebarHeight = $sidebarSelector.find('.fixed-sidebar-content .be-section').outerHeight(),
		            $headerHeight = Number(jQuery('#header-inner-wrap').height()),// + Number(jQuery('#wpadminbar').height()),
		            $heroSectionHeight = Number(jQuery('.hero-section-wrap').height()),
		            $headerTopPadding = 0,
		            $breakingPoint1 = 0,
		            $breakingPoint2 = 0;

		            // Sticky Default Header
		            if ( body.hasClass('sticky-header') || body.hasClass('transparent-sticky')) {
		                $headerTopPadding = $headerHeight;
		            }

		            // Non Sticky Header
		            if(  body.hasClass('header-transparent') ){ //Transparent
		                if($heroSectionHeight > 0){ //With Hero Section
		                    $breakingPoint1 = $heroSectionHeight;
		                }else{ //Without Hero Section
		                    $breakingPoint1 = 1;
		                }
		            }else{ //Non Transparent
		                if($heroSectionHeight > 0){ //With Hero Section
		                    $breakingPoint1 = $heroSectionHeight + $headerHeight;
		                }else{ //Without Hero Section
		                    $breakingPoint1 = $headerHeight;
		                }
		            }

		            $breakingPoint2 = (jQuery(document).height()) - ($scroll_top +  jQuery(window).height() + $footerHeight + $widgetsHeight);

		            if ($window.width() > 960) {
		                if ($scroll_top < $breakingPoint1) {
		                    $sidebarSelector.removeClass('active-fixed').css('top', 0);
		                    // $sidebarSelector.width('30%');
		                    $sidebarSelector.width($sidebarSelector.parent().outerWidth() * 0.30);
		                }
		                else if($breakingPoint2 <= 0){
		                    var $negative =  ( $breakingPoint2 );
		                    $sidebarSelector.addClass('active-fixed').removeClass('top-animate').css('top', $negative);
		                    $sidebarSelector.width($sidebarSelector.parent().outerWidth() * 0.30);

		                }
		                else if(($scroll_top >= $breakingPoint1) && ($breakingPoint2 > 0)){
		                    $sidebarSelector.addClass('active-fixed  top-animate').css('top', $headerTopPadding);
		                    $sidebarSelector.width($sidebarSelector.parent().outerWidth() * 0.30);
		                }

	                	//jQuery(".fixed-sidebar-content-inner").mCustomScrollbar('update');

		            }
		        }
		    },

		    split_screen = function() {
		        if ( ( jQuery(".page-template-page-splitscreen-left").length > 0 ) || ( jQuery(".page-template-page-splitscreen-right").length > 0 ) ) {
		            var $heroSection = jQuery("#hero-section"),
		            $window = jQuery(window),
		            $scroll_top = $window.scrollTop(),
		            $footerHeight = jQuery('#footer').outerHeight(),
		            $widgetsHeight = jQuery('#bottom-widgets').outerHeight(),
		            $headerHeight = Number(jQuery('#header-inner-wrap').height()),
		            $headerTopPadding = 0,
		            $headerTopPaddingonScroll = 0,
		            $breakingPoint1 = 0,
		            $breakingPoint2 = 0;

		            // Non Sticky Header
		            if(  body.hasClass('header-transparent') ){ //Transparent
		                $breakingPoint1 = 1;
		                $headerTopPadding = 0;
		            }else{ //Non Transparent
		                $breakingPoint1 = $headerHeight;
		                $headerTopPadding = $headerHeight;
		            }

		            $breakingPoint2 = (jQuery(document).height()) - ($scroll_top +  $window.height() + $footerHeight + $widgetsHeight);

		            if ($window.width() > 960) {
		                $heroSection.css('top', $headerTopPadding);
		                if ($scroll_top < $breakingPoint1) {
		                    $heroSection.css('top', $headerTopPadding - ($scroll_top));
		                }
		                else if($breakingPoint2 <= 0){
		                    $heroSection.css('top', $breakingPoint2);
		                }
		                else if(($scroll_top >= $breakingPoint1) && ($breakingPoint2 > 0)){
		                    $heroSection.css('top', 0 );
		                }
		            }
		        }
		    },

		    superfish = function() {
		    	asyncloader.require( [ 'superfish', 'hoverintent' ], function(){
			        var $menu = jQuery('#navigation .menu, #navigation-left-side .menu, #navigation-right-side .menu').children('ul');
			        $menu.superfish({
			            animation: {opacity: 'show'},
			            animationOut: {opacity: 'hide'},
			            speed : 400,
			            delay: 600
			        });
			    });
		    },

		    sliders = function() {
		    	var gallery_wrap = jQuery('#gallery-container-wrap');
		        if ( gallery_wrap.length > 0 ) {
		        	asyncloader.require( [ 'horizontalcarousel', 'fitvids', 'vimeo', 'resizetoparent', 'mousewheel' ], function(){
			            gallery_wrap.fitVids();
			            gallery_wrap.CenteredSlider();
			            //gallery_wrap.thumbnailSlider();
			            resize_gallery_video();
			            jQuery('.be-carousel-thumb').thumbnailSlider();
			        });
		        }
		    },

			carousel_thumb = function() {
		        jQuery(document).on('mouseenter', '.carousel_bar_dots', function () {
		            jQuery(this).parent().find('.carousel_bar_wrap').css('opacity', '0').stop().animate({ opacity: 1, bottom: '0px' }, 500);
		        });
		        jQuery(document).on('mouseleave', '.carousel_bar_area', function () {
		            jQuery(this).find('.carousel_bar_wrap').stop().animate({ opacity: 0, bottom: '-500px' }, 500);
		        });
			},

		    // update_scrollbar = function() {
		    // 	var fixed_sidebar = jQuery('.fixed-sidebar-content-inner');
		    //     if ( fixed_sidebar.length > 0 ) {
		    //     	//asyncloader.require( 'scrollbar', function(){
			   //          if ( fixed_sidebar.hasClass('mCustomScrollbar') ) {
			   //              fixed_sidebar.mCustomScrollbar('update');
			   //          } else {
			   //              fixed_sidebar.mCustomScrollbar({
			   //                  autoHideScrollbar: true,
			   //                  mouseWheelPixels: 300
			   //              });
			   //          }
			   //     // });
		    //     }
		    // },

		    rev_slider_bg_check = function() {

		        if ( !body.hasClass('disable_rev_slider_bg_check') && !body.hasClass('semi') ) {

		        	var rev_slider_wrapper = jQuery('#hero-section').find('.rev_slider_wrapper');

		            if ( body.hasClass('header-transparent') && rev_slider_wrapper.length > 0 ) {
		            	asyncloader.require( 'backgroundcheck', function() {
			                rev_slider_wrapper.each(function () {
			                    var $wrapper = jQuery(this).attr('id'),
			                    $instance = jQuery(this).find('.rev_slider').attr('id'),
			                    be_revapi = $instance.split('_');
			                    window['revapi'+be_revapi[2]].bind("revolution.slide.onchange", function (e, data) {
			                        setTimeout(function () {
			                            BackgroundCheck.init({
			                                targets: '#header #header-inner-wrap',
			                                images: '.active-revslide .tp-bgimg'
			                            });
			                            BackgroundCheck.refresh();
			                        }, 100);
			                    });
			                });
			            });
		            }
		        }
		    },

		    header_search = function() {
		        jQuery(document).on('click', '.header-search-controls .search-button', function () {
		        	var search_box = jQuery('.search-box-wrapper');
		            search_box.fadeToggle().find('.s').focus();
		            if ( search_box.hasClass('style2-header-search-widget') ) {
		                html = html.toggleClass('hide-overflow');
		            }
		        });

		        jQuery(document).on('click', '.header-search-form-close', function (e) {
		            e.preventDefault();
		            close_search_box();
		        });
		    },

		    mobile_menu = function() {
		        jQuery(document).on('click','#mobile-menu li a', function() {
		            if( jQuery(this).attr('href') != '#' && !jQuery(this).closest('li').hasClass('menu-item-has-children') ){
		                close_mobile_menu();
		            }
		        });

		        jQuery(document).on('click', '.mobile-nav-controller-wrap', function () {
		            jQuery('.mobile-menu').slideFadeToggle();
		            jQuery('.mobile-nav-controller .be-mobile-menu-icon').toggleClass('is-clicked');
		        });

		        jQuery(document).on('click', '.mobile-sub-menu-controller', function () {
		            jQuery(this).siblings('.sub-menu').slideFadeToggle();
		            jQuery(this).toggleClass('isClicked');
		        });
		    },

		    falling_menu = function() {
		        jQuery(document).on('click', '.menu-falling-animate-controller', function () {
		            var delay = 1,
		            $this = jQuery(this);

	                jQuery('#menu, #left-menu, #right-menu').children('.menu-item').each(function() {
	                	if( body.hasClass('menu-animate-fall-active') ) {
	                    	jQuery(this).delay(delay).removeClass('return-position', 400);
	                    } else {
	                    	jQuery(this).delay(delay).addClass('return-position', 400);
	                    }
	                    delay += 50;
	                }).promise().done( function(){
	                	if( body.hasClass('menu-animate-fall-active') ) {
	                		body = body.removeClass('menu-animate-fall-active');
	                	} else {
	                		body = body.addClass('menu-animate-fall-active');
	                	}

	                    jQuery('.menu-falling-animate-controller .be-mobile-menu-icon').toggleClass('is-clicked');
	                });

		        });
			},

			sub_menu = function() {
		        jQuery(document).on('click', '.top-overlay-menu .menu-item-has-children a, .left-header .menu-item-has-children a , #mobile-menu .menu-item-has-children a', function () {
		            if(jQuery(this).attr('href') == '#'){
		                jQuery(this).siblings('.sub-menu').slideFadeToggle();
		                jQuery(this).siblings('.mobile-sub-menu-controller').toggleClass('isClicked');
		            }
		        });
			},

			local_scroll = function() {
				asyncloader.require( 'easing', function() {
			        jQuery(document).on('click', 'a[href="#"]', function (e) {
			            e.preventDefault();
			        });
			        jQuery(document).on('click', 'a', function (e) {
			            var $link_to = jQuery(this).attr('href'),
			            url_arr,
			            $element,
			            mobile_menu = jQuery('.mobile-menu'),
			            $path = window.location.href;

			            if (jQuery(this).hasClass('ui-tabs-anchor')) {
			                return false;
			            }

			            if ( $link_to ) {
			                url_arr = $link_to.split('#');
			                if ($link_to.indexOf('#') >= 0 && $path.indexOf(url_arr[0]) >= 0) {
			                    $element = $link_to.substring($link_to.indexOf('#') + 1);
			                    if ($element) {
			                        if (jQuery('#' + $element).length > 0) {
			                            e.preventDefault();
			                            if (jQuery(window).width() < 960 && mobile_menu.length > 0 ) {
			                                mobile_menu.slideUp(500, function () {
			                                    animate_scroll(jQuery('#' + $element));
			                                });
			                            } else {
			                                animate_scroll(jQuery('#' + $element));
			                            }
			                        }
			                    }
			                }
			            }
			        });
			    });
			},

			sliderbar_navigation = function() {
		        jQuery(document).on('click', '.sliderbar-nav-controller-wrap', function () {
		            jQuery('.sb-slidebar').toggleClass('opened');
		            body = body.toggleClass('slider-bar-opened');

		            if( body.hasClass('top-overlay-menu') ) {
		               html = html.toggleClass('hide-overflow');
		                // jQuery('.layout-box-container').fadeOut();
		                if( body.hasClass('be-themes-layout-layout-border-header-top') ){
		                    jQuery('.sliderbar-menu-controller .be-mobile-menu-icon').toggleClass('is-clicked');
		                }
		            } else{
		                jQuery('.sliderbar-menu-controller .be-mobile-menu-icon').toggleClass('is-clicked');
		            }
		        });
			},

			left_strip = function() {
		        jQuery(document).on('click', '#sb-left-strip', function () {
		            var $this = jQuery(this);
		            jQuery('.sb-slidebar').toggleClass('opened');
		            if( $this.hasClass('menu_push_main') ){
		                body = jQuery('body').toggleClass('slider-bar-opened');
		            }
		            if($this.hasClass('overlay')) {
		                html = html.toggleClass('hide-overflow');
		                jQuery('.layout-box-container').fadeOut();
		            }
		            if( $this.hasClass('strip') ) {
		                jQuery('.left-strip-wrapper').toggleClass('hide');
		                jQuery('#main-wrapper').toggleClass('hidden-strip');
		            }
		        });
			},

	    	close_sidebar = function() {
		        if( body.hasClass('top-overlay-menu') || body.hasClass('left-overlay-menu') ){
		            if( body.hasClass('be-themes-layout-layout-border-header-top')){
		                close_slidebar_menu();
		            }
		            jQuery('.layout-box-container').fadeIn();
		            jQuery('#slidebar-menu li').removeClass('menu-loaded');
		        } else {
		            close_slidebar_menu();
		        }
		        jQuery('.sb-slidebar').removeClass('opened');

		        body = body.removeClass( 'slider-bar-opened' );
	    	},

	    	close_slidebar_menu = function() {
		        var be_sidebar_mobile_menu = jQuery('.sliderbar-menu-controller').find('.be-mobile-menu-icon');
		        if( body.hasClass( 'slider-bar-opened') && body.hasClass('top-header' ) ){
		            be_sidebar_mobile_menu.toggleClass('is-clicked');
		        }
	    	},

	    	close_mobile_menu = function() {
	    		var mobile_menu = jQuery('.mobile-menu');
		        if ( mobile_menu.is(":visible") ) {
		            mobile_menu.slideFadeToggle();
		            jQuery('.mobile-nav-controller .be-mobile-menu-icon').toggleClass('is-clicked');
		        }
	    	},

	    	close_search_box = function() {
	    		var search_box = jQuery('.search-box-wrapper');
		        if ( search_box.is(":visible") ) {
		            search_box.fadeOut();
		            html = html.toggleClass('hide-overflow');
		        }
	    	},

			close_overlay_menu = function() {
		        jQuery(document).on('click', '.overlay-menu-close', function () {
		            close_sidebar();
		            open_leftstrip();
		        });
			},

			close_gallery_info_box = function() {
		        jQuery(document).on('click', '.single_portfolio_info_close', function () {
		            jQuery(this).closest('.gallery_content').toggleClass('show');
		            //jQuery(".gallery_content_area").mCustomScrollbar("update");
		        });
			},

			close_popups = function() {
		        jQuery(document).on('mouseup', '.sliderbar-menu-controller, .sb-slidebar, .mobile-nav-controller, .mobile-menu, .header-search-controls .search-button, .search-box-wrapper', function () {
		            if (jQuery(this).hasClass('sliderbar-menu-controller') || jQuery(this).hasClass('sb-slidebar')) {
		                close_mobile_menu();
		                close_search_box();
		            }
		            if (jQuery(this).hasClass('mobile-nav-controller') || jQuery(this).hasClass('mobile-menu')) {
		                close_sidebar();
		                close_search_box();
		            }
		            if (jQuery(this).hasClass('search-button') || jQuery(this).hasClass('search-box-wrapper')) {
		                close_mobile_menu();
		                close_sidebar();
		            }
		            return false;
		        });

		        jQuery(document).on('mouseup', function () {
		            close_sidebar();
		            open_leftstrip();
		            close_mobile_menu();
		            close_search_box();
		        });

		        jQuery(document).on('keyup', function (e) {
		            if (e.keyCode === 27) {
		                close_sidebar();
		                open_leftstrip();
		                close_search_box();
		                if (jQuery('.gallery_content').hasClass('show')) {
		                    jQuery('.gallery_content').removeClass('show');
		                } else {
		                    if (jQuery('.gallery-slider-wrap').hasClass('opened')) {
		                        jQuery('html').removeClass('overflow-hidden');
		                        jQuery('.gallery-slider-wrap').css('left', '100%').css('opacity', 0);
		                        setTimeout(function () {
		                            jQuery('.gallery-slider-wrap').removeClass('opened');
		                            jQuery('.gallery-slider-content').empty();
		                            jQuery('.gallery-slider-wrap').css('left', '-100%');
		                        }, 300);
		                    }
		                }
		            }
		        });
			},

			back_to_top = function() {
		        jQuery(document).on('click', '#back-to-top, .back-to-top', function (e) {
		            e.preventDefault();
		            jQuery('body,html').animate({ scrollTop: 0 }, 1000, 'easeInOutQuint');
		        });
			},

			show_back_to_top_button = function() {
		        if ( jQuery(window).scrollTop() > 10 ) {
		            to_top_button.fadeIn();
		        } else {
		            to_top_button.fadeOut();
		        }
			},

		    flickity_default_header = function(){
		        if(jQuery('.portfolio-sliders').length){
		            if(jQuery('body.header-transparent').length){
		                if(Number(jQuery(window).width()) <= 960){
		                    jQuery('#header-inner-wrap').css('position','relative');
		                }
		                else{
		                    jQuery('#header-inner-wrap').css('position','absolute');
		                }
		            }
		        }
		    },

		    flickity_getHeight = function(){
		        if(jQuery('#content.portfolio-sliders').length){
		            var $this = jQuery('#content.portfolio-sliders'),
		                $gutter_width = Number($this.attr('data-gutter-width')),
		                $slider_type = $this.attr('data-slider-type'),
		                $window_width = Number(jQuery(window).width()) + jQuery.getScrollbarWidth(), //Number(jQuery('#main-wrapper').width()) + jQuery.getScrollbarWidth()
		                $mobile_calculation = true,
		                $full_window_height = Number(jQuery(window).height()),
		                $window_height = $full_window_height-(Number(jQuery('#header').innerHeight())+Number(jQuery('#wpadminbar').innerHeight())+Number(jQuery('#portfolio-title-nav-wrap').innerHeight()));


		            if($this.find('.disable-flickity-mobile').length){
		                $mobile_calculation = false;
		            }
		            if(jQuery('body').hasClass('be-themes-layout-layout-border-header-top')) {
		                var $border_length = 1;
		            }else{
		                var $border_length = 2;
		            }
		            //Calculate Height and Width of Image Wrappers
		            //CONDITION 1 - If Flickity is Disabled for Mobile Devices
		            if($mobile_calculation == false && $window_width <= 960){
		                //Remove Scrollbar in Mobile View
		                var $scrollable_content =  $this.find('.gallery_content_slide');
		                $scrollable_content.height('auto');
		               // if( 'undefined' !== typeof mCustomScrollbar ) {
		                	//$scrollable_content.mCustomScrollbar("disable");
		               // }
		                //Add Image URL to src tag
		                $this.find('.be-flickity .img-wrap').each(function(){
		                    var $this_img_wrap = jQuery(this),
		                        $this_img = $this_img_wrap.find('img'),
		                        $data_source = $this_img.attr('data-flickity-lazyload');

		                    $this_img.removeAttr("data-flickity-lazyload");
		                    $this_img.attr('src',$data_source);
		                    $this_img_wrap.width('100%').height('100%');
		                });
		            }
		            //CONDITION 2 - Calculation for all Desktop Screen Sizes. And for Mobile Screen Size when Flickity is Enabled.
		            if($mobile_calculation == true || $window_width > 960){
		                if($window_width <= 960 ) {
		                    if($window_width >= 480 && $window_width < 640){
		                        $window_height = $full_window_height;
		                    }
		                    $this.find('.img-wrap').width($window_width).height($window_height);
		                    $this.find('.be-flickity').css('padding',0);
		                }else{

		                    if($slider_type == 'be-ribbon-carousel' || $slider_type == 'be-center-carousel'){
		                        if(jQuery('#bottom-widgets').length){
		                            var $footer_height = 0;
		                        }else{
		                            var $footer_height = Number(jQuery('#footer').innerHeight()) ;
		                        }
		                        var $window_height_addl = $window_height-((Number(jQuery('.layout-box-bottom:visible').height())*$border_length)+$footer_height),
		                            $given_slider_height = $this.attr('data-height');

		                        //Set Height and Width according to above Calculations
		                        var $slider_height = Math.round(($window_height_addl/100)*parseInt($given_slider_height)),
		                            $padding = ($window_height_addl-$slider_height)/2;

		                        $this.find('.img-wrap').height($slider_height);
		                        $this.find('.gallery_content_slide').height($slider_height);

		                        $this.find('.be-flickity').css('padding', $padding+'px 0px '+$padding+'px 0px').css('opacity', 1);
		                        $this.find('.be-flickity .img-wrap').each(function(){
		                            var $this_img = jQuery(this),
		                                $img = $this_img.find('img'),
		                                $img_actual_width = $this_img.attr('data-image-width'),
		                                $img_actual_height = $this_img.attr('data-image-height'),
		                                $img_width = Math.round(($img_actual_width * $slider_height)/$img_actual_height);

		                            $this_img.width($img_width);
		                        });

		                    } else if ($slider_type == 'be-centered' || $slider_type == 'be-fullscreen'){

		                        $given_slider_height = $this.attr('data-height');//100;
		                        //Larger Screens
		                        if(jQuery('#bottom-widgets').length){
		                            var $footer_height = 0;
		                        }else{
		                            var $footer_height = Number(jQuery('#footer').innerHeight()) ;
		                        }
		                        var $window_height_addl = $window_height-((Number(jQuery('.layout-box-bottom:visible').height())*$border_length)+$footer_height);

		                        //Set Height and Width according to above Calculations
		                        var $slider_height = (($window_height_addl/100)*parseInt($given_slider_height)),
		                            $padding = ($window_height_addl-$slider_height)/2;

		                        $this.find('.be-flickity').css('padding', $padding+'px 0px '+$padding+'px 0px').css('opacity', 1);
		                        $this.find('.img-wrap').height($slider_height).width('100%');
		                    }
		                }
		            }

		            //Calculation of Thumbnail Position if Flickity is Enabled for Mobile Devices
		            if($mobile_calculation == true){
		                if($window_width <= 960){
		                    var $thumbnail_position =  $window_height+37 - Number(jQuery('#header').innerHeight());
		                    jQuery('.portfolio-sliders .single-portfolio-slider.carousel_bar_area').css('top',$thumbnail_position);
		                }else{
		                    jQuery('.portfolio-sliders .single-portfolio-slider.carousel_bar_area').css('top','initial');
		                }
		            }
		        }
		    },

		    flickity_call = function(){
		        var $flickity_gallery = jQuery('.main-gallery.be-flickity');
		        if( $flickity_gallery.length > 0 ) {
			        var    $slider_type = $flickity_gallery.closest('.portfolio-sliders').attr('data-slider-type'),
			            $nav_arrow = Boolean($flickity_gallery.attr('data-nav-arrow')),
			            $auto_play_time = parseInt($flickity_gallery.attr('data-auto-play')),
			            $free_scroll = Boolean($flickity_gallery.attr('data-free-scroll')),
			            $keyboard_crtl = Boolean($flickity_gallery.attr('data-keyboard-crtl')),
			            $loop_ctrl = Boolean($flickity_gallery.attr('data-loop-crtl')),
			            $cell_align = 'center',
			            $percentPosition = true,
			            $body = jQuery('body');

			        if($auto_play_time <= 0){
			            $auto_play_time = false;
			        }

			        if($slider_type == 'be-ribbon-carousel'){
			            $cell_align = 'left';
			            $percentPosition = false;
			        }
			        if($slider_type == 'be-center-carousel'){
			            $cell_align = 'center';
			            $percentPosition = false;
			        }
			        if((Number(jQuery(window).width()) + jQuery.getScrollbarWidth()) <= 960){
			            $free_scroll = false;
			        }
			        var $flickity_gallery = jQuery('.main-gallery.be-flickity').flickity({
			            lazyLoad: 3,
			            prevNextButtons: $nav_arrow,
			            wrapAround: $loop_ctrl,
			            freeScroll: $free_scroll,
			            accessibility: $keyboard_crtl,
			            autoPlay: $auto_play_time,
			            contain: true,
			            cellAlign: $cell_align,
			            percentPosition:$percentPosition,
			            pageDots: false,
			            watchCSS: true,
			            arrowShape: {
			              x0: 20,
			              x1: 40, y1: 20,
			              x2: 45, y2: 20,
			              x3: 25
			            }
			        });

			        var $flickity_instance = $flickity_gallery.data('flickity');

			        var iframes = $flickity_gallery.find('.img-wrap iframe');
			        if($slider_type == 'be-ribbon-carousel' || $slider_type == 'be-center-carousel'){
			            flickity_resetGutter($flickity_gallery);
			        }
			        $flickity_gallery.on('lazyLoad',function(event, cellElement){
			            var img = event.originalEvent.target;
			            // Resize to Parent
			            if($slider_type != 'be-centered'){
			                if(Number(jQuery(window).width()) > 960){
			                    jQuery(img).resizeToParent();
			                }
			            }

			        })
			        // Apply Fit Vids
			        $flickity_gallery.find('.img-wrap iframe').fitVids();
			        $flickity_gallery.find('.img-wrap iframe').css('opacity',1);
			        $flickity_gallery.find('.img-wrap .img-overlay-wrap').css('display','block');

			        if($slider_type == 'be-fullscreen'){
			            $flickity_gallery.flickity('resize');
			        }

			        $flickity_gallery.on( 'settle', function( event, pointer ){
			            // Pause Video on Slider Movement
			            iframes.each( function() {
			                var iframe_id = jQuery(this).attr('id');
			                if( iframe_id ) {
			                    var iframe = document.getElementById( iframe_id );
			                    var player = $f(iframe);
			                    player.api("pause");
			                }
			            });

			            var $this_img_wrap = jQuery($flickity_instance.selectedElement);
			            // Increment Slider Count
			            jQuery('.current-slide-count').text(($flickity_instance.selectedIndex) + 1);
			            // Remove Overlay Wrapper
			            $flickity_gallery.find('.img-wrap.is-selected').css('z-index','-1');
			            // Background Check
			            if (!($body.hasClass('disable_rev_slider_bg_check')) && !($body.hasClass('semi'))){
			                if($slider_type == 'be-fullscreen' && ($this_img_wrap.find('iframe').length <= 0) ){

			                    BackgroundCheck.init({
			                        targets: '#header #header-inner-wrap, .portfolio-sliders .transparent-nav-bar',
			                        images: '.be-fullscreen .img-wrap.is-selected img'
			                    });

			                    BackgroundCheck.refresh();
			                }
			            }
			        });
				}
		        // BackgroundCheck.destroy();
		    },

		    flickity_resize = function(){
		        var $flickity_gallery = jQuery('.main-gallery.be-flickity'),
		            $slider_type = $flickity_gallery.closest('.portfolio-sliders').attr('data-slider-type');

		        if($slider_type != 'be-centered'){
		            if(Number(jQuery(window).width()) > 960){
		                $flickity_gallery.find('.img-wrap img').resizeToParent();
		            }
		        }
		    },

		    flickity_resetGutter = function(onFlickityGallery){
		        var $flickity_slider = onFlickityGallery.find('.flickity-slider'),
		            $flickity_wrapper = onFlickityGallery.closest('#content'),
		            $gutter_width = $flickity_wrapper.attr('data-gutter-width');

		        if(Number(jQuery(window).width()) <= 960 ) {
		            $flickity_slider.css('left',0);
		        }else{
		            $flickity_slider.css('left',Number($gutter_width));
		        }
		    },

		    flickity_thumb_call = function(){

		        var $flickity_thumb_gallery = jQuery('.be-flickity-thumb').flickity({
		            asNavFor: '.main-gallery',
		            freeScroll: true,
		            contain: true,
		            pageDots: false,
		            prevNextButtons: false
		        });
		    },

		    carousel_thumb_call = function(){

		        var $flickity_thumb_gallery = jQuery('.be-carousel-thumb').flickity({
		            freeScroll: true,
		            contain: true,
		            pageDots: false,
		            prevNextButtons: false
		        });
		    },

		    woocommerce = function() {
				jQuery(document).on( 'mouseenter', '.header-cart-controls', function() {
					if(jQuery(this).find('.cart_list.product_list_widget ').length > 0) {
						jQuery(this).find('.widget_shopping_cart_wrap').stop(true, false).fadeIn();
					}
				});

				jQuery(document).on( 'mouseleave', '.header-cart-controls', function() {
					if(jQuery(this).find('.cart_list.product_list_widget ').length > 0) {
						jQuery(this).find('.widget_shopping_cart_wrap').stop(true, false).fadeOut();
					}
				});

				asyncloader.require( 'magnificpopup', function() {
					jQuery('.product-single-boxed-content .images').magnificPopup({
						delegate: 'a',
						type: 'image',
						tLoading: 'Loading image #%curr%...',
						mainClass: 'mfp-img-mobile',
						gallery: {
							enabled: true,
				            navigateByImgClick: true,
				            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
						},
						image: {
				            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
						}
				    });
				});
		    },

		    heroSectionParallax = function() {
		    	var parallax = jQuery('.be-section.be-bg-parallax');
		        if( parallax.length > 0 ) {
		            parallax.each(function (i, el) {
		                var el = jQuery(el);
		                if (el.visible(true)) {
		                    if(!jQuery(this).hasClass('parallaxed')) {
		                        jQuery(this).parallax("50%", 0.4);
		                        jQuery(this).addClass('parallaxed');
		                    }
		                }
		            });
		        }
		    },

		    tatsuFirstSection = function() {
		    	if( jQuery('#hero-section').length == 0 ) {
		    		jQuery('#header-inner-wrap').addClass( jQuery('.tatsu-section:first-child').attr('data-headerscheme') );
		    	}
		    },

		    ready = function() {

		    	tatsuFirstSection();

		    	jQuery('.component ul li:first-child').addClass('current');

		    	asyncloader.require( 'fitvids' , function(){
	    	        body.find('iframe').not('.rev_slider iframe').each(function () {
	            		jQuery(this).parent().fitVids();
	        		});
	    	    });

		        jQuery( document ).on( 'click', '.top-overlay-menu .sliderbar-nav-controller-wrap, .left-overlay-menu .left-strip-wrapper',  menu_link_animation );

		        //Handle Transparent & Sticky Headers
		        asyncloader.require( [ 'transparentheader' ], function(){
		        	jQuery('#header').Transparent();
		        });

		        //Handle Scroll to Sections
		        if( body.hasClass('section-scroll') && !body.hasClass('tatsu-frame') ) {
		        	asyncloader.require( [ 'scrolltosections', 'mousewheel', 'vimeo' ], function(){
		        		body.SectionScroll();
		        	});
		        }

		        if( jQuery('#galaxy-canvas').length > 0 ) {
		        	asyncloader.require( [ 'greensock', 'request_animation_frame', 'galaxycanvas' ], function(){
		            	galaxy_canvas();
		            });
		        }

		        if( jQuery('#pattern-canvas').length > 0 ) {
		        	asyncloader.require( [ 'greensock', 'request_animation_frame', 'patterncanvas' ], function(){
		            	pattern_canvas();
		          });
		        }

		        if( jQuery('#waterdrops-canvas').length > 0 ) {
		        	asyncloader.require( [ 'greensock', 'request_animation_frame', 'waterdropcanvas' ], function(){
		            	water_drop_canvas();
		            });
		        }

		        if( fullscreen_wrap.length > 0 ) {
					asyncloader.require( [ 'fullscreenheight' ], function(){
						fullscreen_wrap.FullScreen();
					});
		        }


		        custom_scrollbar();
		        close_sidebar();
		        open_leftstrip();
		        menu_item_update();
		        single_page_nav();
		        superfish();
		        sliders();
		        rev_slider_bg_check();
		        woocommerce();
		        heroSectionParallax();

		        //Handle Click Events
		        close_overlay_menu();
		        close_gallery_info_box();
		        close_popups();
		        back_to_top();
		        left_strip();
		        sliderbar_navigation();
		        local_scroll();
		        sub_menu();
		        falling_menu();
		        mobile_menu();
		        header_search();

		        //Handle Mouseover events
		        carousel_thumb();

		        //Flickity
		        if( jQuery('.main-gallery.be-flickity').length > 0 ) {
			        asyncloader.require(['flickity', 'backgroundcheck', 'resizetoparent' ], function() {
				        flickity_default_header();
		        		flickity_getHeight();
		        		flickity_call();
		        		flickity_thumb_call();

			        });
			    }

			    if( jQuery('.be-carousel-thumb').length > 0 ) {
			    	asyncloader.require('flickity', function() {
						carousel_thumb_call();
			    	});
			    }
       			//

		    },

		    run = function() {

		    	ready();

		    	//On Window Scroll Event
		    	jQuery(window).on('scroll.oshine', function () {
		    		show_back_to_top_button();
		    		menu_item_update();
		    		sticky_sidebar();
		    		split_screen();
		    	});


		    	//On Window Resize Event
		    	jQuery(window).on( 'resize.oshine', function() {
		    		sticky_sidebar();
		    		split_screen();
		    		//close_mobile_menu();
		    		menu_item_update();
			        if (jQuery(window).width() > 960) {
			            jQuery('.mobile-menu').slideUp();
			        }

	        	 	//jQuery(".gallery_content_area, .ps-content-inner, .gallery_content_slide").mCustomScrollbar("update");


					if( jQuery('.main-gallery.be-flickity').length > 0 ) {
						asyncloader.require( ['flickity', 'backgroundcheck', 'resizetoparent'], function() {
						    flickity_default_header();
						    flickity_getHeight();
						    var $flickity_gallery = jQuery('.main-gallery.be-flickity');

						    if(jQuery(window).width() > 960){
						        $flickity_gallery.find('.img-wrap').each(function(){
						            var $this_img = jQuery(this),
						                $img = $this_img.find('img');
						            //Reassign Img Source Attribute to Enable Lazyload in Larger Screen Sizes
						            if( ($img.attr('src') ) && !($img.hasClass('flickity-lazyloaded') ) ) {
						            var $data_source = $img.attr('src');
						                $img.removeAttr("src");
						                $img.attr('data-flickity-lazyload',$data_source);
						            }
						        });
						    }
						    $flickity_gallery.flickity('reloadCells');
						    // Resize to Parent
						    flickity_resize();
						    flickity_resetGutter($flickity_gallery);
						    flickity_thumb_call();
						});
					}

				    if( jQuery('.be-carousel-thumb').length > 0 ) {
				    	asyncloader.require( 'flickity', function() {
							carousel_thumb_call();
				    	});
				    }
		    	});

		    	// On Window Load Event
				jQuery(window).load(function () {
				        var $hash = window.location.hash;
				        if ($hash) {
				            if (jQuery($hash).length > 0) {
				                animate_scroll( jQuery($hash) );
				            }
				        }
				        setTimeout(function () {
				        	asyncloader.require( 'imagesloaded' , function(){
					            body.imagesLoaded(function () {
					                sticky_sidebar();
					                split_screen();
					            });
					        });
				        }, 200);
				        custom_scrollbar();
				});
		    }


			return {
				run: run
			}

	    })();

	    oshine_scripts.run();

	});

})( jQuery );

//Homepage Background Slideshow

//var slide = [
//   {url:"https://www.fillmurray.com/1920/1080"},
//   {url:"https://www.fillmurray.com/1150/809"},
//   {url:"https://www.fillmurray.com/1409/980"},
//];

//for (var i=0; i<slide.length; i++){
//   console.log(slide[i].url);
//}

//$('#container--homepage-image').css('backgroundImage','url(' + slide[i] + ')');


//var list = [
//    { caste:"Banda",id:4},
//    { caste:"Bestha",id:6},
//];

//for (var i=0; i<list.length; i++) {
//    alert(list[i].caste);
//}
