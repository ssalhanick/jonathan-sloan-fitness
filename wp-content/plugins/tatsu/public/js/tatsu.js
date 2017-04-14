;(function($) {
    /**
   * Resize Background Video
   */
    $.fn.tatsuResizeMedia = function() {
        if( this.length > 0 ) {
            this.each(function () {
                var $img = jQuery(this), 
                $section = $img.parent(), 
                windowWidth = $section.width(), 
                windowHeight = $section.outerHeight(), 
                r_w = windowHeight / windowWidth, 
                i_w = $img.width(), 
                i_h = $img.height(), 
                r_i = i_h / i_w, 
                new_w, 
                new_h;
                
                if (r_w > r_i) {
                    new_h = windowHeight;
                    new_w = windowHeight / r_i;
                } else {
                    new_h = windowWidth * r_i;
                    new_w = windowWidth;
                }
                $img.css({
                    width : new_w,
                    height : new_h,
                    left : (windowWidth - new_w) / 2,
                    top : (windowHeight - new_h) / 2,
                    display : 'block'
                });
            });
        }
  };
    
})(jQuery);

;(function($) {
    /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */
    $.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);

;(function($) {
    /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */
    $.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);
(function( $ ) {
    'use strict';

    var vendorScriptsUrl = tatsuFrontendConfig.vendorScriptsUrl,
        maps_api_key = tatsuFrontendConfig.mapsApiKey;

    asyncloader.register( vendorScriptsUrl+'fitvids.js', 'fitvids' );
    asyncloader.register( vendorScriptsUrl+'magnificpopup.js', 'magnificpopup' );
    asyncloader.register( vendorScriptsUrl+'countTo.js', 'count_to' );
    asyncloader.register( 'https://maps.googleapis.com/maps/api/js?key='+maps_api_key, 'google_maps_api' );
    asyncloader.register( vendorScriptsUrl+'tatsuParallax.js', 'parallax' );
    asyncloader.register( vendorScriptsUrl+'imagesloaded.js', 'imagesloaded' );

    var tatsu = (function() {

        var $window = jQuery(window),
            $body = jQuery('body'),
            $html = jQuery('html'),
            $pluginUrl = tatsuFrontendConfig.pluginUrl,
            tatsuCallbacks = {},

        animateButton = function() {
            jQuery(document).on( 'mouseenter.tatsu mouseleave.tatsu', '.tatsu-button', function(e) {
                var $this = jQuery( this ),
                    options = {},
                    shouldApplyBG =  ( $html.hasClass('cssgradients') && ( $this.hasClass('bg-animation-slide-top') || $this.hasClass('bg-animation-slide-left') || $this.hasClass('bg-animation-slide-bottom') || $this.hasClass('bg-animation-slide-right') ) ) ? false: true; 

                options.hoverBorderColor = $this.attr( 'data-hover-border-color' );
                options.hoverColor = $this.attr( 'data-hover-color' );
                options.hoverBgColor = $this.attr( 'data-hover-bg-color' );
                options.bgColor = $this.attr( 'data-bg-color' );
                options.color = $this.attr( 'data-color' );
                options.borderColor = $this.attr( 'data-border-color' );    

                if( 'mouseenter' === e.type ) {
                    $this.css('border-color', options.hoverBorderColor );
                    $this.css('color', options.hoverColor );
                    $this.find('i').css('color', options.hoverColor );
                    if( shouldApplyBG ) {
                        $this.css('background-color', options.hoverBgColor );
                    }          
                } else {
                    $this.css('border-color', options.borderColor );
                    $this.css('color', options.color );
                    $this.find('i').css('color', options.color );
                    if( shouldApplyBG ) {
                        $this.css('background-color', options.bgColor );
                    }           
                }
            });         
        },

        animateIcon = function() {
            jQuery(document).on( 'mouseenter.tatsu mouseleave.tatsu', '.tatsu-icon', function(e) {
                 var $this = jQuery(this),
                    options = {}; 
                options.hoverBorderColor = $this.attr( 'data-hover-border-color' );
                options.hoverColor = $this.attr( 'data-hover-color' );
                options.hoverBgColor = $this.attr( 'data-hover-bg-color' );
                options.bgColor = $this.attr( 'data-bg-color' );
                options.color = $this.attr( 'data-color' );
                options.borderColor = $this.attr( 'data-border-color' );      
                if( 'mouseenter' === e.type ) {
                    $this.css({  
                        'border-color': options.hoverBorderColor,
                        'color': options.hoverColor,
                        'background-color': options.hoverBgColor
                    });
                } else {
                    $this.css({  
                        'border-color': options.borderColor,
                        'color': options.color,
                        'background-color': options.bgColor
                    });           
                }      
            });             
        }, 

        closeNotification = function() {
            jQuery(document).on('click.tatsu', '.tatsu-notification .close', function (e) {
                e.preventDefault();
                jQuery(this).closest('.tatsu-notification').slideUp(500);
            });                     
        },

        animatedNumbers = function() {
            if(jQuery('.tatsu-an.animate').length > 0) {
               asyncloader.require( 'count_to', function() {
                    jQuery('.tatsu-an.animate').each(function (i, el) {
                        var el = jQuery(el);
                        if ( el.visible(true) ) {
                            el.removeClass('animate');
                            var $endval = Number( el.attr( 'data-number' ) );
                            el.countTo({
                                from : 0,
                                to : $endval,
                                speed : 1500,
                                refreshInterval : 30
                            });
                        }
                    });
                });
            }           
        }, 

        cssAnimate = function( shouldUpdate, moduleId ) {
            if( shouldUpdate ) {
                var el = jQuery('.be-pb-observer-'+moduleId );
                if( el.hasClass( 'tatsu-animate' ) || el.hasClass( 'be-animate' ) ) {
                   el.removeClass('animated flipInX flipInY fadeIn fadeInDown fadeInLeft fadeInRight fadeInUp slideInDown slideInLeft slideInRight rollIn rollOut bounce bounceIn bounceInUp bounceInDown bounceInLeft bounceInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig flash flip lightSpeedIn pulse rotateIn rotateInUpLeft rotateInDownLeft rotateInUpRight rotateInDownRight shake swing tada wiggle wobble infiniteJump zoomIn already-visible');
                }else{
                   el = el.find( '.tatsu-animate, .be-animate' ).removeClass('animated flipInX flipInY fadeIn fadeInDown fadeInLeft fadeInRight fadeInUp slideInDown slideInLeft slideInRight rollIn rollOut bounce bounceIn bounceInUp bounceInDown bounceInLeft bounceInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig flash flip lightSpeedIn pulse rotateIn rotateInUpLeft rotateInDownLeft rotateInUpRight rotateInDownRight shake swing tada wiggle wobble infiniteJump zoomIn already-visible');
                }
              if( el.length > 0 ) {
                    jQuery.each( el, function( index, element ) {
                        element = jQuery( element );
                        if ( element.visible( true ) ) {
                            element.addClass("already-visible");
                            element.addClass(element.attr('data-animation'));
                            element.addClass('animated');
                        }                    
                    } );
                }            
            } else {
                 if(jQuery('.tatsu-animate, .be-animate').length > 0) {
                    jQuery('.tatsu-animate:not( .animated ), .be-animate:not( .animated )').each(function (i, el) {
                        var el = jQuery(el);
                        if (el.visible(true)) {
                            el.addClass("already-visible");
                            el.addClass(el.attr('data-animation'));
                            el.addClass('animated');
                        }
                    });
                }                 
            }
                   
        },

        lightbox = function() {
            if (jQuery('.mfp-image').length > 0) {

                asyncloader.require( 'magnificpopup', function() {
                    jQuery('.mfp-image').magnificPopup({
                        mainClass: 'mfp-img-mobile my-mfp-zoom-in',
                        closeOnContentClick: true,
                        gallery: {
                            enabled: true
                        },
                        image: {
                            verticalFit: true,
                            titleSrc: 'title'
                        },
                        zoom: {
                            enabled: false,
                            duration: 300
                        },
                        preloader: true,
                        type: 'inline',
                        overflowY: 'auto',
                        removalDelay: 300,
                        callbacks: {
                            afterClose: function () {
                            },
                            open: function () {
                                jQuery('body').addClass('mfp-active-state');
                            },
                            close: function () {
                                jQuery('body').removeClass('mfp-active-state');
                            }
                        }
                    });
                });
                
            }
            if(jQuery('.mfp-iframe').length > 0) {
                 asyncloader.require( 'magnificpopup', function() {
                    jQuery('.mfp-iframe').magnificPopup({
                        iframe: {  
                            patterns: {
                                youtube: {
                                  index: 'youtube.com/',
                                  id: 'v=', 
                                  src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0&showinfo=0'
                                },
                                vimeo: {
                                  index: 'vimeo.com/',
                                  id: '/',
                                  src: '//player.vimeo.com/video/%id%?autoplay=1'
                                },
                                gmaps: {
                                  index: '//maps.google.',
                                  src: '%id%&output=embed'
                                }                
                            }
                        }
                    });
                });
            }           
        },

        gmaps = function() {
            if(jQuery('.tatsu-gmap').length > 0) {
                 asyncloader.require( 'google_maps_api' , function() {
                    var styles = {
                        black : [{"featureType" : "water", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}]}, {"featureType" : "landscape", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 20}]}, {"featureType" : "road.highway", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}]}, {"featureType" : "road.highway", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 29}, {"weight" : 0.2}]}, {"featureType" : "road.arterial", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 18}]}, {"featureType" : "road.local", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 16}]}, {"featureType" : "poi", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 21}]}, {"elementType" : "labels.text.stroke", "stylers" : [{"visibility" : "on"}, {"color" : "#000000"}, {"lightness" : 16}]}, {"elementType" : "labels.text.fill", "stylers" : [{"saturation" : 36}, {"color" : "#000000"}, {"lightness" : 40}]}, {"elementType" : "labels.icon", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "transit", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 19}]}, {"featureType" : "administrative", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}, {"lightness" : 20}]}, {"featureType" : "administrative", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}, {"weight" : 1.2}]}],
                        greyscale: [{"featureType" : "landscape", "stylers" : [{"saturation" : -100}, {"lightness" : 65}, {"visibility" : "on"}]}, {"featureType" : "poi", "stylers" : [{"saturation" : -100}, {"lightness" : 51}, {"visibility" : "simplified"}]}, {"featureType" : "road.highway", "stylers" : [{"saturation" : -100}, {"visibility" : "simplified"}]}, {"featureType" : "road.arterial", "stylers" : [{"saturation" : -100}, {"lightness" : 30}, {"visibility" : "on"}]}, {"featureType" : "road.local", "stylers" : [{"saturation" : -100}, {"lightness" : 40}, {"visibility" : "on"}]}, {"featureType" : "transit", "stylers" : [{"saturation" : -100}, {"visibility" : "simplified"}]}, {"featureType" : "administrative.province", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "water", "elementType" : "labels", "stylers" : [{"visibility" : "on"}, {"lightness" : -25}, {"saturation" : -100}]}, {"featureType" : "water", "elementType" : "geometry", "stylers" : [{"hue" : "#ffff00"}, {"lightness" : -25}, {"saturation" : -97}]}],
                        midnight: [{"featureType" : "water", "stylers" : [{"color" : "#021019"}]}, {"featureType" : "landscape", "stylers" : [{"color" : "#08304b"}]}, {"featureType" : "poi", "elementType" : "geometry", "stylers" : [{"color" : "#0c4152"}, {"lightness" : 5}]}, {"featureType" : "road.highway", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "road.highway", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#0b434f"}, {"lightness" : 25}]}, {"featureType" : "road.arterial", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "road.arterial", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#0b3d51"}, {"lightness" : 16}]}, {"featureType" : "road.local", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}]}, {"elementType" : "labels.text.fill", "stylers" : [{"color" : "#ffffff"}]}, {"elementType" : "labels.text.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 13}]}, {"featureType" : "transit", "stylers" : [{"color" : "#146474"}]}, {"featureType" : "administrative", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "administrative", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#144b53"}, {"lightness" : 14}, {"weight" : 1.4}]}],
                        standard: [],
                        bluewater: [{"featureType" : "water", "stylers" : [{"color" : "#46bcec"}, {"visibility" : "on"}]}, {"featureType" : "landscape", "stylers" : [{"color" : "#f2f2f2"}]}, {"featureType" : "road", "stylers" : [{"saturation" : -100}, {"lightness" : 45}]}, {"featureType" : "road.highway", "stylers" : [{"visibility" : "simplified"}]}, {"featureType" : "road.arterial", "elementType" : "labels.icon", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "administrative", "elementType" : "labels.text.fill", "stylers" : [{"color" : "#444444"}]}, {"featureType" : "transit", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "poi", "stylers" : [{"visibility" : "off"}]}]
                    };
                    jQuery('.tatsu-gmap').each(function () {
                        var $address = jQuery(this).attr('data-address'), 
                        $zoom = Number( jQuery(this).attr('data-zoom') ), 
                        $lat = jQuery(this).attr('data-latitude'), 
                        $lan = jQuery(this).attr('data-longitude'), 
                        $custom_marker = jQuery(this).attr('data-marker'), 
                        map_style = jQuery(this).attr('data-style'), 
                        mapOptions = {
                            zoom: $zoom,
                            scrollwheel: false,
                            navigationControl: false,
                            mapTypeControl: false,
                            scaleControl: false,
                            streetViewControl: false,
                            center: new google.maps.LatLng(parseFloat($lat), parseFloat($lan)),
                            styles: styles[map_style]
                        }, map = new google.maps.Map(jQuery(this)[0], mapOptions), marker = new google.maps.Marker({
                            position: new google.maps.LatLng(parseFloat($lat), parseFloat($lan)),
                            map: map,
                            title: $address,
                            icon: $custom_marker
                        });
                        marker.setMap(map);
                    });
                });
            }
        },

        backgroundVideo = function() {
          asyncloader.require( 'resizetoparent', function () {
            var bgVideoWrap = jQuery( '.tatsu-bg-video, .be-bg-video' );
            if ( bgVideoWrap.length > 0 ) {
              bgVideoWrap.each( function() {
                jQuery(this).load();
                jQuery(this).on("loadedmetadata", function () { 
                    jQuery(this).css({
                        width: this.videoWidth,
                        height: this.videoHeight
                    });
                    jQuery(this).tatsuResizeMedia();
                    jQuery(this).css('display', 'block');
                });
                //jQuery(this).tatsuResizeMedia();
              });
            }
          });            
        },

        video = function() {
            asyncloader.require( 'fitvids', function() {
                jQuery('body').fitVids();
            });
        },

        tatsuSection = function() {
           parallax();
        },

        registerCallbacks = function() {
            tatsuCallbacks['tatsu_video'] = video;
            tatsuCallbacks['tatsu_gmaps'] = gmaps;
            tatsuCallbacks['tatsu_animated_numbers'] = animatedNumbers;
            tatsuCallbacks[ 'tatsu_section' ] = tatsuSection;
        },

        parallax = function() {
          var parallaxContainer = jQuery('.tatsu-parallax');
          if( parallaxContainer.length > 0 ) {
            asyncloader.require( 'parallax', function() {
              parallaxContainer.tatsuParallax({
                speed: 0.3
              });
            });
          }
        },

        ready = function(){

            video();
            parallax();
            animateButton();
            animateIcon();
            closeNotification();
            animatedNumbers();
            cssAnimate();
            lightbox();
            gmaps();
            backgroundVideo();
            registerCallbacks();

            jQuery(window).on( 'tatsu_update.tatsu', function( e, data )  {
                if( 'trigger_ready' == data.moduleName ) {
                    animatedNumbers();
                    parallax();
                    gmaps();
                    video();
                    backgroundVideo();
                    lightbox();

                } else if( data.moduleName in tatsuCallbacks ) {   
                    tatsuCallbacks[data.moduleName]( data.shouldUpdate );                                         
                } 
                if ( 'csstrigger' === data.type ) {
                  cssAnimate( data.shouldUpdate, data.id );
                }
            });


            jQuery(window).on( 'scroll.tatsu', cssAnimate.bind(null, false, '') );
            jQuery(window).on( 'scroll.tatsu', animatedNumbers ); 
            jQuery(window).on( 'resize.tatsu', function() {
               jQuery( '.tatsu-bg-video, .be-bg-video' ).tatsuResizeMedia(); 
            });
        }
        
        return {
            ready: ready,
            lightbox: lightbox
        }

    })(); 

    window.tatsu = tatsu;
    jQuery( tatsu.ready );

})( jQuery );