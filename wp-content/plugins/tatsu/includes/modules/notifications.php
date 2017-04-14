<?php
if (!function_exists('tatsu_notifications')) {
	function tatsu_notifications( $atts, $content ) {
		extract(shortcode_atts( array(
	        'bg_color'=>'',
			'animate'=>0,
	        'animation_type'=>'fadeIn',
	    ), $atts ) );
	    $style = '';
	    $animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '' ;
		$style = ( ! empty( $bg_color ) ) ? 'background-color:'.$bg_color.';' : '' ;
		
		return '<div class="tatsu-module tatsu-notification '.$animate.'" style="'.$style.'" data-animation="'.$animation_type.'"><span class="close"><i class="tatsu-icon icon-icon_close"></i></span>'.do_shortcode( $content ).'</div>';
	}
	add_shortcode( 'tatsu_notifications', 'tatsu_notifications' );
	add_shortcode( 'notifications', 'tatsu_notifications' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_notifications');
// function tatsu_register_notifications() {
// 		$animations = tatsu_css_animations();
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __('Notifications','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'childModule' => '',
// 	        'type' => 'single',
// 	        'isInBuilt' => true,
// 	        'atts' => array (
// 	            array (
// 		            'att_name' => 'bg_color',
// 		            'type' => 'colorpicker',
// 		            'label' => __('Background Color of Notification box','tatsu'),
// 		            'defaultValue' => '', //sec_bg
// 		            'tooltip' => '',
// 	            ),
// 	            array (
// 	        		'att_name' => 'content',
// 	        		'type' => 'tinymce',
// 	        		'label' => __('Notification Content','tatsu'),
// 	        		'defaultValue' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
// 	        		'tooltip' => ''
//  	        	),
// 				array (
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
// 	tatsu_register_module( 'tatsu_notifications', $controls );
// }
?>