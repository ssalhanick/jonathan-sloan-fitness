/**Transparent and Sticky Header**/

;(function( $ ) {
	var $window = $(window), update_transparent;
    $.fn.Transparent = function() {
		var $this = $(this);
		update_transparent = function() {
			var $border_length = 2;
			if(jQuery('body').hasClass('be-themes-layout-layout-border-header-top')) {
				$border_length = 1;
			}
            if(jQuery('#main').hasClass('layout-border-header-top')) {
            	var $header_inner_height = jQuery('#header-inner-wrap').innerHeight();
            	jQuery('#header').height($header_inner_height);
				jQuery('#header-inner-wrap').addClass('no-transparent').removeClass('transparent');
				jQuery('.style2-header-search-widget').css('padding-top', $header_inner_height+jQuery('#wpadminbar').height());
				jQuery('.overlay-menu-close, .header-search-form-close').css('top', $header_inner_height);
            } else {
            	if(jQuery('body').hasClass('header-transparent')) {
					var $animate_position =  ( jQuery('.header-hero-section').length > 0 ) ? ( (Number( jQuery('.header-hero-section').offset().top ) + Number( jQuery('.header-hero-section').height() ) ) - ( Number( jQuery('#wpadminbar').innerHeight() ) + Number( jQuery('#header-wrap').attr('data-default-height') ) + jQuery('#header-bottom-bar').innerHeight() + Number( jQuery('#header-top-bar-wrap').innerHeight() ) ) ) : 0;
					if($animate_position <= 0) {
						$animate_position = jQuery('#header-inner-wrap').height();
					}
					if($animate_position <= jQuery(window).scrollTop() && jQuery('body').hasClass('transparent-sticky')) {
						jQuery('#header-inner-wrap').addClass('no-transparent').removeClass('transparent');
						setTimeout(function() {
							jQuery('#header-inner-wrap').addClass('top-animate');
						}, 10);
					} else {
						jQuery('#header-inner-wrap').removeClass('no-transparent').addClass('transparent').delay(20000).removeClass('top-animate');
					}
				}
				if (jQuery('body').hasClass('sticky-header')) {
	               	var $animate_position = ((Number(jQuery('#header').offset().top)+Number(jQuery('#header-wrap').attr('data-default-height'))+Number(jQuery('#header-top-bar-wrap').innerHeight())+Number(jQuery('#header-bottom-bar').innerHeight()))-(jQuery('#wpadminbar').height()+jQuery('.layout-box-bottom').innerHeight()));
					if($animate_position <= 0) {
						$animate_position = (Number(jQuery('#header-wrap').attr('data-default-height'))+Number(jQuery('#header-top-bar-wrap').innerHeight())+Number(jQuery('#header-bottom-bar').innerHeight()));
					}
					if($animate_position <= jQuery(window).scrollTop() && jQuery('body').hasClass('sticky-header')) {
						jQuery('#header').height(Number(jQuery('#header-wrap').attr('data-default-height'))+Number(jQuery('#header-top-bar-wrap').innerHeight())+Number(jQuery('#header-bottom-bar').innerHeight()));
						jQuery('#header-inner-wrap').addClass('no-transparent').removeClass('transparent');
	                    setTimeout(function () {
	                        jQuery('#header-inner-wrap').addClass('top-animate');
	                    }, 10);
					} else {
						jQuery('#header-inner-wrap').removeClass('no-transparent').delay(20000).removeClass('top-animate');
						jQuery('#header').height('auto');
					}
	            }
            }
		}
		$window.on('scroll.transparent', update_transparent);
		$window.on('resize', update_transparent);
		update_transparent();
    };
    jQuery(document).on("update_content", function() {
		if(jQuery('body').hasClass('no-section-scroll')) {
			$window.off('scroll.transparent', update_transparent);
		}
    });
}( jQuery ));