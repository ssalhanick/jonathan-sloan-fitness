<?php 

if (!function_exists('tatsu_text')) {
	function tatsu_text( $atts, $content ) {
		extract( shortcode_atts( array (
			'max_width' => 100,
			'wrap_alignment' => 'center',
	        'scroll_to_animate' => 0,
	        'animate' => 0,
	        'animation_type' => 'fadeIn',
	    ),$atts ) );

	    $output = '';
	    $bool = false;
		if( isset( $animate ) && 1 == $animate ) {
			$animate = 'tatsu-animate';
			$bool = true;
		} else {
			$animate = '';
		}
		if( isset( $scroll_to_animate ) && 1 == $scroll_to_animate ) {
	    	$scroll_to_animate = 'scrollToFade';
	    	$bool = true;
	    } else {
			$scroll_to_animate = '';
		}
		
		if($max_width < 100){
			if($wrap_alignment == 'left'){
				$margin = 'margin-right: 0; margin-left:0;';
			}
			if($wrap_alignment == 'center'){
				$margin = 'margin-right:auto; margin-left:auto;';
			}
			if($wrap_alignment == 'right'){
				$margin = 'margin-right: 0;margin-left:auto;';
			}
		}
		else{
			$margin = ''; //'margin-right:auto; margin-left:auto;';
		}

	//	$output .= ( true === $bool ) ? '<div class="tatsu-text-block '.$animate.' '.$scroll_to_animate.'" data-animation="'.$animation_type.'">' : '' ;
		//$output .= (isset($max_width) && !empty($max_width)) ? '<div class="tatsu-text-inner clearfix" style="width: '.$max_width.'%; '.$margin.'">' : '';
		$output .= '<div class="tatsu-module tatsu-text-inner '.$animate.' '.$scroll_to_animate.' clearfix" style="width: '.$max_width.'%; '.$margin.'" data-animation="'.$animation_type.'">';
		$output .= do_shortcode(  $content );
		$output .= '</div>';
		//$output .= (isset($max_width) && !empty($max_width)) ? '</div>' : '';
	   // $output .= ( true ===  $bool ) ? '</div>' : '' ;
	    return $output;
	}
	add_shortcode( 'tatsu_text', 'tatsu_text' );
	add_shortcode( 'text', 'tatsu_text' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_text' );
// function tatsu_register_text() {
// 		$animations = tatsu_css_animations();
// 		$controls =  array (
// 	        'icon' => '',
// 	        'title' => __( 'Text Block', 'tatsu' ),
// 	        'is_js_dependant' => true,
// 	        'child_module' => '',
// 	        'type' => 'single',
// 			'is_built_in' => true,
// 	        'atts' => array (
// 	        	array (
// 	        		'att_name' => 'content',
// 	        		'type' => 'tinymce',
// 	        		'label' => __( 'Content', 'tatsu' ),
// 	        		'default' => '',
// 	        		'tooltip' => ''
//  	        	),	
// 	        	array (
// 	        		'att_name' => 'max_width',
// 	        		'type' => 'slider',
// 	        		'label' => __( 'Content Width', 'tatsu' ),
// 	        		'default' => '100',
// 	        		'tooltip' => ''

// 	        	),
// 	        	array (
// 	        		'att_name' => 'wrap_alignment',
// 	        		'type' => 'button_group',
// 	        		'label' => __( 'Wrap Alignment', 'tatsu' ),
// 	        		'options' => array (
// 	        			'left' => 'Left',
// 	        			'right' => 'Right',
// 	        			'center' => 'Center'
// 	        		),
// 	        		'default' => 'left',
// 	        		'tooltip' => '',
// 	        		'visible' => array( 'max_width', '<', '100' )
// 	        	),
// 	        	array (
// 	        		'att_name' => 'animate',
// 	        		'type' => 'toggle',
// 	        		'label' => __( 'Enable CSS Animation', 'tatsu' ),
// 	        		'default' => 0,
// 	        		'tooltip' => ''
// 	        	),
// 	             array (
// 	              'att_name' => 'animation_type',
// 	              'type' => 'select',
// 	              'label' => __( 'Animation Type', 'tatsu' ),
// 	              'options' => $animations,
// 	              'default' => 'fade',
// 	              'tooltip' => '',
// 	            ),
// 	        ),
// 			'presets' => array(
// 				'default' => array(
// 					'title' => '',
// 					'image' => '',
// 					'preset' => array(
// 						'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
// 						'max_width' => '100'
// 					)
// 				),
// 			),
// 		);
// 	tatsu_register_module( 'tatsu_text', $controls );
// }

?>