(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	var i,
	 bt_posts = be_to_tatsu_config.post_ids.split(','),
	 bt_total = bt_posts.length,
	 bt_count = 1,
	 bt_percent = 0,
	 bt_successes = 0,
	 bt_errors = 0,
	 bt_failedlist = '',
	 bt_resulttext = '',
	 bt_timestart = new Date().getTime(),
	 bt_timeend = 0,
	 bt_totaltime = 0,
	 bt_continue = true,
     progressbar = $( "#progressbar" ),
     progressLabel = $( ".progress-label" );


	//console.log(bt_total);

	$("#number-of-posts").html(bt_total);

    // progressbar.progressbar({
    //   value: false,
    //   change: function() {
    //     progressLabel.text( progressbar.progressbar( "value" ) + "%" );
    //   },
    //   complete: function() {
    //     progressLabel.text( "Complete!" );
    //   }
    // });	

    function progress(percent, $element) {
    	var progressBarWidth = percent * $element.width() / 100;
    	$element.find('div').animate({ width: progressBarWidth }, 500).html(percent + "% ");
	}

			
	function be_to_tatsu_update_status( id, success, response ) {
		var progressPercent = ( bt_count / bt_total ) * 100; 
		progress( progressPercent.toFixed(2) , $('#progressBar'));
		//progressbar.progressbar( "value", ( bt_count / bt_total ) * 100 );
		//$("#regenthumbs-bar-percent").html( Math.round( ( bt_count / bt_total ) * 1000 ) / 10 + "%" );
		bt_count = bt_count + 1;

		if ( success ) {
			bt_successes = bt_successes + 1;
			$("#bt-debug-successcount").html(bt_successes);
			$("#bt-debuglist").append("<li>" + response.data.type+" named "+response.data.title+" converted successfully</li>");
		}
		else {
			bt_errors = bt_errors + 1;
			bt_failedlist = bt_failedlist + ',' + id;
			$("#bt-debug-failurecount").html(bt_errors);
			$("#bt-debuglist").append("<li> Could not convert" + response.data.type+" named "+response.data.title + "</li>");
		}
	}

	
	function be_to_tatsu_complete() {
		bt_timeend = new Date().getTime();
		bt_totaltime = Math.round( ( bt_timeend - bt_timestart ) / 1000 );

	//	$('#regenthumbs-stop').hide();

		$("#progressBarWrap").css('display','none');
		progress( 0 , $('#progressBar'));
	}

	
	function be_to_tatsu_convert( id ) {
		$.ajax({
			type: 'POST',
			dataType:'json',
			url: be_to_tatsu_config.restapiurl+'convert/',
			data: "post_id="+id,
			success: function( response ) {
				if ( response !== Object( response ) || ( typeof response.success === "undefined" && typeof response.error === "undefined" ) ) {
					response = new Object;
					response.success = false;
					response.error = "Could not convert post with ID"+id;
				}

				if ( response.success ) {
					be_to_tatsu_update_status( id, true, response );
				}
				else {
					be_to_tatsu_update_status( id, false, response );
				}

				if ( bt_posts.length && bt_continue ) {
					be_to_tatsu_convert( bt_posts.shift() );
				}
				else {
				  	be_to_tatsu_complete();
				}
			},
			error: function( response ) {
				be_to_tatsu_update_status( id, false, response );

				if ( bt_posts.length && bt_continue ) {
					be_to_tatsu_convert( bt_posts.shift() );
				}
				else {
					be_to_tatsu_complete();
				}
			}
		});
	}

 

 
 
    // setTimeout( progress, 2000 );

    $('#tatsu-convert').on('click', function(){
    	var $id = bt_posts.shift();
    	if( $id ) {
    		$('#bt-debuglist, #bt-debug-successcount, #bt-debug-failurecount').html('');
    		$("#status-counts").css('display','block');
    		$("#progressBarWrap").css('display','block'); 		
    		be_to_tatsu_convert( $id );
    	}
    });

	


})( jQuery );