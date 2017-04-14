    /***  post message listener ***/
;(function($) { 

    window.addEventListener("message",tatsu_scripts_trigger,false);
    function tatsu_scripts_trigger(event) {
     
          var jsonTest = function isJson( str ) {
                                try {
                                    JSON.parse(str);
                                } catch (e) {
                                    return false;
                                }
                                return true;
                           },
                data = event.data;
           
            if( jsonTest( data ) ) {

                    var parsedData = JSON.parse( data );
                    jQuery( 'p:empty' ).remove();
                    jQuery( window ).trigger( 'tatsu_update', parsedData );
            }else if( data.split( ',' )[0] === 'addSelection' ) {
                var idString = '.be-pb-observer-'+data.split( ',' )[1] + ' >div',
                    element = jQuery( idString );
                jQuery( '.tatsu-module-select' ).css({'display' : 'inline-block','top' : element.offset().top, 'left' : element.offset().left, 'height' : element.innerHeight(), 'width' : element.outerWidth() });
            }else if( data.split( ',' )[0] === 'removeSelection' ) {
                jQuery( '.tatsu-module-select' ).css('display','none');
            }     
            else if( event.data.split(',')[0] === 'hover_set') {
             var id = event.data.split(',')[1],
                 selector = '.be-pb-observer-'+id,
                 element  = jQuery( selector );
             jQuery('.tatsu-observer').css({'display' : 'inline-block','top' : element.offset().top, 'left' : element.offset().left, 'height' : element.innerHeight(), 'width' : element.outerWidth() });
             jQuery('.tatsu-observer-tooltip').text( event.data.split(',')[2] );
             if( event.data.split(',')[2] != 'Section' ){
                jQuery( '.tatsu-observer-tooltip' ).addClass('out')
             }
            }else if( 'add_selection' === data.split( ',' )[0] ) {
                var dataArray = data.split( ',' ),
                    selector = '.be-pb-observer-' + dataArray[1],
                    element = jQuery( selector );
                jQuery( selector ).css( 'outline', '1px solid #20cbd4' );

            }else if( data.split( ',' )[0] === 'drag_set' ) {
                var dataArray = data.split( ',' ),
                    id = dataArray[1],
                    height = 0,
                    position = dataArray[2],
                    selector = '.be-pb-observer-'+id,
                    element = jQuery( selector );
                if( 'top' === position ) {
                    jQuery( '.tatsu-drag-observer' ).css({ display : 'inline-block', 'top' : ( element.offset().top ), 'left' : element.offset().left, 'width' : element.innerWidth()  });
                }else{
                    height = element.innerHeight();
                    jQuery( '.tatsu-drag-observer' ).css({ display : 'inline-block', 'top' : ( element.offset().top + height ), 'left' : element.offset().left, 'width' : element.innerWidth() });
                }
            }else if( data.split( ',' )[0] === 'reset_drag' ) {
                jQuery( '.tatsu-drag-observer' ).css( 'display', 'none' );
            }
            else {
                jQuery('.tatsu-observer').css('display','none');
                if( jQuery('.tatsu-observer-tooltip').hasClass('out') ){
                    jQuery('.tatsu-observer-tooltip').removeClass('out');
                } 
            }
             
    }

    jQuery(document).ready( function() {
        jQuery(document).on( 'click', '.tatsu-frame a',  function(e) {
            e.preventDefault();
        });
        jQuery('form').on( 'submit', function(e) {
            e.preventDefault();
        });        
    });
})(jQuery); 