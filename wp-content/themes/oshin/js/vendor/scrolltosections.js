/***	 Scroll to Sections 	***/

;(function( $ ) {
	var $window = $(window), move, pause_vimeo_video;
    $.fn.SectionScroll = function() {
    	if(jQuery('body').hasClass('section-scroll')) {
			var $this = $(this), $current = 0, $scrolled = false, scrollTimeout, $num_moves = jQuery('#page-content').find('.tatsu-section').length;
			if(jQuery('.header-hero-section').length == 0 ) {
				$num_moves--;
			}
			move = function() {
				var $border_length = 2;
				if(jQuery('body').hasClass('be-themes-layout-layout-border-header-top')) {
					$border_length = 1;
				}
				var $moveto = ( ( $window.height() - ( jQuery('#wpadminbar').height() + jQuery('#header').height() + ( jQuery('.layout-box-bottom').height() * $border_length) ) ) * $current );
				jQuery('#content').css({
				    '-webkit-transform' : 'translatey(-'+$moveto+'px)',
				    '-moz-transform' : 'translatey(-'+$moveto+'px)',
				    '-o-transform' : 'translatey(-'+$moveto+'px)',
				    '-ms-transform' : 'translatey(-'+$moveto+'px)',
				    'transform' : 'translatey(-'+$moveto+'px)'
				});
				jQuery('li.fullscreen-nav-item, div.fullscreen-nav-item-hero-section').removeClass('current-item');
				if(jQuery('body').hasClass('header-transparent')) {
					jQuery('#header-inner-wrap').removeClass('background--dark').removeClass('background--light');
				}
				if(jQuery('.header-hero-section').length == 0 ) {
					jQuery('li.fullscreen-nav-item:nth-child('+($current+1)+')').addClass('current-item');
					if(jQuery('body').hasClass('header-transparent')) {
						jQuery('#header-inner-wrap').addClass(function() {
							return jQuery('#page-content div').children('.tatsu-section:nth-child('+($current+1)+')').attr('data-headerscheme');
						});
					}
				} else {
					if($current == 0) {
						jQuery('div.fullscreen-nav-item-hero-section').addClass('current-item');
						if(jQuery('body').hasClass('header-transparent')) {
							jQuery('#header-inner-wrap').addClass(function(){
								return jQuery('#header-inner-wrap').attr('data-headerscheme');
							});
						}
					} else {
						jQuery('li.fullscreen-nav-item:nth-child('+$current+')').addClass('current-item');
						if(jQuery('body').hasClass('header-transparent')) {
							jQuery('#header-inner-wrap').addClass(function(){
								return jQuery('#page-content div').children('.tatsu-section:nth-child('+$current+')').attr('data-headerscheme');
							});
						}
					}
				}
			}
			pause_vimeo_video = function() {

				//var prev_index = current-1;
				var iframes = jQuery('.tatsu-section.tatsu-fullscreen').find('.tatsu-vimeo-video');
				
				iframes.each( function() {
					var iframe_id = jQuery(this).attr('id');
					if( iframe_id ) {
						var iframe = document.getElementById( iframe_id );
						var player = $f(iframe);
						player.api("pause");
					}
				});
			}			
			jQuery.fn.translate = function(element) {
				jQuery('html, body').scrollTop(0);
    			var index = jQuery("div.tatsu-section").index(element);
		    	$current = index;
		    	if(jQuery('.header-hero-section').length > 0 ) {
		    		$current = index + 1;
		    	}
		    	if(index == -1) {
		    		jQuery('.fullscreen-nav-item-hero-section').trigger('click');
		    		return false;
		    	}
		    	pause_vimeo_video();
		    	move();
		    	re_size();
			};
			function re_size() {
				setTimeout(function() {
					jQuery(window).trigger('resize');
				}, 800);
			}


			$window.on('scroll.sectionscroll', move);
			$window.on('resize.sectionresize', move);
			move();
			re_size();
			jQuery(document).on('mousewheel', 'body.section-scroll', function (event) {
				if(jQuery(window).width() > 960 && jQuery('html').hasClass('csstransforms')) {
					event.preventDefault();
					if(!$scrolled) {
						$scrolled = true;
						// replaced event.originalEvent.wheelDelta with event.deltaY
						if (event.deltaY > 0 || event.originalEvent.detail < 0) {
				            if($current > 0) {
				            	$current--;
				            }
				            pause_vimeo_video();
				            move();
				            re_size();
				    	}
				    	else {
				    		if($current < $num_moves) {
				            	$current++;
				            }
				            pause_vimeo_video();
				            move();
				            re_size();
				    	}
				    	clearTimeout(scrollTimeout);
						scrollTimeout = setTimeout(function() {
							$scrolled = false;
						}, 1000);
					}
				}
		    });
		    jQuery(document).on('click', '.fullscreen-nav-item', function() {
		    	var index = jQuery("li.fullscreen-nav-item").index(this);
		    	if(jQuery('.header-hero-section').length > 0 ) {
					$current = index+1;
				} else {
					$current = index;
				}
				pause_vimeo_video();
		    	move();
		    	re_size();
		    });
		    jQuery(document).on('click', '.fullscreen-nav-item-hero-section', function() {
		    	$current = 0;
		    	pause_vimeo_video();
		    	move();
		    	re_size();
		    });
		    jQuery('html').addClass('section-scroll');
		    if(jQuery('body').find('.fullscreen-nav-wrap').length > 0) {
		    	jQuery('body').find('.fullscreen-nav-wrap').remove();
		    }
		    jQuery('body').append('<div class="fullscreen-nav-wrap clearfix"><div class="fullscreen-nav-wrap-inner clearfix"><ul class="fullscreen-nav"></ul></div></div>');
		    if(jQuery('.header-hero-section').length > 0 ) {
				jQuery('.fullscreen-nav-wrap-inner').prepend('<div class="fullscreen-nav-item-hero-section"></div>');
			}
			jQuery('.fullscreen-nav').empty();
		    jQuery('#page-content div').children('.tatsu-section').each(function() {
  				jQuery('.fullscreen-nav').append('<li class="fullscreen-nav-item"></li>');
			});
			jQuery('#content').css('opacity', 1);
		} else {
		if(jQuery('body').hasClass('header-transparent')) {
			if(jQuery('#hero-section').length == 0 ) {
					jQuery('#header-inner-wrap').removeClass('background--dark').removeClass('background--light');
					
					jQuery('#header-inner-wrap').addClass(function() {
						return jQuery('#page-content div').children('.tatsu-section:nth-child(1)').attr('data-headerscheme');
					});
				}
			}
			$window.off('scroll.sectionscroll', move);
			$window.off('resize.sectionresize', move);
			jQuery('#content').removeAttr('style');
		}
    };
    jQuery(document).on("update_content", function() {
		if(jQuery('body').hasClass('no-section-scroll')) {
			$window.off('scroll.sectionscroll', move);
			$window.off('resize.sectionresize', move);
			jQuery('#content').removeAttr('style');
		}
    });
}( jQuery ));