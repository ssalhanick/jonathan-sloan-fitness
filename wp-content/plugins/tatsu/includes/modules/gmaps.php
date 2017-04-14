<?php
if ( ! function_exists( 'tatsu_gmaps' ) ) {
	function tatsu_gmaps( $atts, $content ) {
		extract( shortcode_atts( array(
			//'api_key' =>'',
			'address'=>'',
			'latitude'=>'',
			'longitude'=>'',
			'height'=>'300',
			'zoom'=>'14',
			'style'=>'default',
			'marker' => '',
			'animate'=>0,
			'animation_type'=>'fadeIn',
		), $atts ) );
		$output = '';
		$animate = ( isset( $animate ) && 1 == $animate ) ? 'be-animate' : '' ;
		$maps_api_key = Tatsu_Config::getInstance()->get_google_maps_api_key();
		if( !empty( $maps_api_key ) ) {
			if(!empty($latitude) && !empty($longitude)) {
				$map_error = false;
			} 
			else if( ! empty( $address ) ) { //&& !empty($api_key) ) {
				$map_error = false;
				$transient_var = generateSlug($address, 10);
				$transient_result = get_transient( $transient_var );
				if(!$transient_result ) {
					//$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true');
					$response = wp_remote_get('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) );//. '&key='.urlencode( $api_key ) );
					if ( is_wp_error( $response ) ) {
						$map_error = true;
						delete_transient( $transient_var );
					} else {
						$coordinates = wp_remote_retrieve_body( $response );
						if ( is_wp_error( $coordinates ) ) {
							$map_error = true;
							delete_transient( $transient_var );
						} else {
							$coordinates_check = json_decode($coordinates);
							if( $coordinates_check->status == 'OK' ) {					
								$latitude = $coordinates_check->results[0]->geometry->location->lat;
								$longitude = $coordinates_check->results[0]->geometry->location->lng;
								set_transient( $transient_var, $coordinates, 24 * HOUR_IN_SECONDS );
								
							} else {
								$map_error = true;
								delete_transient( $transient_var );
							}
						}
					}
				} else {
					$coordinates_check = json_decode($transient_result);
					$latitude = $coordinates_check->results[0]->geometry->location->lat;
					$longitude = $coordinates_check->results[0]->geometry->location->lng;
				}
				
			} else {
				$map_error = true;
			}

			if(  true === $map_error ) {
				$output .= '<div class="tatsu-module tatsu-notification error">'.__('Your Server is Unable to connect to the Google Geocoding API, kindly visit <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">THIS LINK </a>, find out the latitude and longitude of your address and enter it manually in the Google Maps Module of the Page Builder ', 'tatsu').'</div>';
			} else {
				$output .= '<div class="tatsu-module tatsu-gmap-wrapper '.$animate.'" style="height:'.$height.'px;" data-animation="'.$animation_type.'"><div class="tatsu-gmap map_960" data-address="'.$address.'" data-zoom="'.$zoom.'" data-latitude="'.$latitude.'" data-longitude="'.$longitude.'" data-marker="'.$marker.'" data-style="'.$style.'"></div></div>';
			}
		} else {
			$output = '<div class="tatsu-module tatsu-notification tatsu-error">'.__( 'Google Maps API KEY is missing', 'tatsu' ).'</div>';
		}	
		
		return $output;
	}
	add_shortcode( 'tatsu_gmaps', 'tatsu_gmaps' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_gmaps');
// function tatsu_register_gmaps() {
// 		$animations = tatsu_css_animations();
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __('Google Map','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'childModule' => '',
// 	        'type' => 'single',
// 	        'isInBuilt' => true,
// 	        'atts' => array (
// 	            array (
// 	        		'att_name' => 'address',
// 	        		'type' => 'text',
// 	        		'label' => __('Address','tatsu'),
// 	        		'defaultValue' => '',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'latitude',
// 	        		'type' => 'text',
// 	        		'label' => __('Latitude','tatsu'),
// 	        		'defaultValue' => '',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'longitude',
// 	        		'type' => 'text',
// 	        		'label' => __('Longitude','tatsu'),
// 	        		'defaultValue' => '',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'height',
// 	        		'type' => 'text',
// 	        		'label' => __('Height in px (only numbers)','tatsu'),
// 	        		'defaultValue' => '300',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'zoom',
// 	        		'type' => 'text',
// 	        		'label' => __('Zoom Value','tatsu'),
// 	        		'defaultValue' => '14',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'style',
// 	        		'type' => 'select',
// 	        		'label' => __('Style','tatsu'),
// 	        		'options' => array (
// 						'Standard' => 'standard',
// 						'Greyscale' => 'greyscale', 
// 						'Bluewater' => 'bluewater', 
// 						'Midnight' => 'midnight',
// 						'Black' => 'black'
// 					),
// 	        		'defaultValue' => 'standard',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	              	'att_name' => 'marker',
// 	              	'type' => 'singleimagepicker',
// 	              	'label' => __('Custom Marker Pin','tatsu'),
// 	              	'defaultValue' => array (
// 		                'attachmentid' => '',
// 		                'attachmenturl' => '',
// 	              	),
// 	              	'tooltip' => '',
// 	            ),
// 	            array (
// 	              	'att_name' => 'animate',
// 	              	'type' => 'switch',
// 	              	'label' => __('Enable CSS Animation','tatsu'),
// 	              	'defaultValue' => false,
// 	              	'tooltip' => '',
// 	            ),
// 	            array (
// 	              	'att_name' => 'animation_type',
// 	              	'type' => 'select',
// 	              	'label' => __('Animation Type','tatsu'),
// 	              	'options' => $animations,
// 	              	'defaultValue' => 'fade',
// 	              	'tooltip' => '',
// 	              	'dependantField' => 'animate'
// 	            ),
// 	        ),
// 	    );
// 	tatsu_register_module( 'tatsu_gmaps', $controls );
// }
?>