<?php
if ( ! function_exists( 'tatsu_title_icon' ) ){
	function tatsu_title_icon( $atts, $content ) {
		extract(shortcode_atts(array(
			'icon'=>'none',
			'size' => 'small',
			'alignment'=>'left',	
			'style'=>'circled',
			'icon_bg'=> '',
			'icon_color'=> '',
			'icon_border_color'=> '',
			'animate'=> 0,
			'animation_type'=>'fadeIn',
		),$atts));
		$output ='';
		$background_color = ( $style == 'circled' || $style == 'rounded' ) ? 'background-color:'.$icon_bg.';' : '' ;
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : 0 ;
		$output .= '<div class="tatsu-module tatsu-title-icon">';
		$output .= '<i class="'.$icon.' tatsu-ti '.$style.' '.$size.' '.$animate.' align-'.$alignment.'" style="'.$background_color.'color:'.$icon_color.';border-color: '.$icon_border_color.'" data-animation="'.$animation_type.'"></i>';
		$output .= '<div class="tatsu-tc '.$animate.' '.$size.' '.$style.' align-'.$alignment.'" data-animation="'.$animation_type.'">'.do_shortcode( $content ).'</div>'; 
		$output .= '</div>';   		
		
		return $output; 
	}
	add_shortcode('tatsu_title_icon','tatsu_title_icon');
	add_shortcode('title_icon','tatsu_title_icon');
}

// add_action( 'tatsu_register_modules', 'tatsu_register_title_icon');
// function tatsu_register_title_icon() {
// 		$animations = tatsu_css_animations();
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __( 'Title with Icon', 'tatsu' ),
// 	        'is_js_dependant' => false,
// 	        'child_module' => '',
// 	        'type' => 'single',
// 			'is_built_in' => false,
// 	        'atts' => array (
// 	            array (
// 	        		'att_name' => 'icon',
// 	        		'type' => 'icon_picker',
// 	        		'label' => __( 'Icon', 'tatsu' ),
// 	        		'default' => '',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'size',
// 	        		'type' => 'button_group',
// 	        		'label' => __( 'Size', 'tatsu' ),
// 	        		'options' => array (
// 						'small' => 'Small',
// 						'medium' => 'Medium',
// 						'large' => 'Large',
// 					),
// 	        		'default' => 'small',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'alignment',
// 	        		'type' => 'button_group',
// 	        		'label' => __( 'Alignment', 'tatsu' ),
// 	        		'options' => array (
// 						'left' => 'Left',
// 						'right' => 'Right'
// 					),
// 	        		'default' => 'left',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'style',
// 	        		'type' => 'button_group',
// 	        		'label' => __( 'Style', 'tatsu' ),
// 	        		'options' => array (
// 						'circled' => 'Circled',
// 						'plain' => 'Plain'
// 					),
// 	        		'default' => 'circled',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 		            'att_name' => 'icon_bg',
// 		            'type' => 'color',
// 		            'label' => __( 'Background Color', 'tatsu' ),
// 		            'default' => '',
// 		            'tooltip' => '',
// 	            ),
// 	        	array (
// 		            'att_name' => 'icon_color',
// 		            'type' => 'color',
// 		            'label' => __( 'Icon Color', 'tatsu' ),
// 		            'default' => '',
// 		            'tooltip' => '',
// 	            ),
// 	        	array (
// 		            'att_name' => 'icon_border_color',
// 		            'type' => 'color',
// 		            'label' => __( 'Icon Border Color', 'tatsu' ),
// 		            'default' => '',
// 		            'tooltip' => '',
// 	            ),
// 	            array (
// 	        		'att_name' => 'content',
// 	        		'type' => 'tinymce',
// 	        		'label' => __( 'Content', 'tatsu' ),
// 	        		'default' => '',
// 	        		'tooltip' => ''
//  	        	),	
// 				array (
// 	              	'att_name' => 'animate',
// 	              	'type' => 'switch',
// 	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
// 	              	'default' => 0,
// 	              	'tooltip' => '',
// 	            ),
// 	            array (
// 	              	'att_name' => 'animation_type',
// 	              	'type' => 'select',
// 	              	'label' => __( 'Animation Type', 'tatsu' ),
// 	              	'options' => $animations,
// 	              	'default' => 'fade',
// 	              	'tooltip' => '',
// 	              	'visible' => array( 'animate', '>', '0' )
// 	            ),
// 	        ),
// 			'presets' => array(
// 				'default' => array(
// 					'title' => '',
// 					'image' => '',
// 					'preset' => array(
// 						'icon' => 'icon-icon_book',
// 						'size' => 'medium',
// 						'icon_color' => '#000',
// 						'content' => '<h6>Design</h6> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
// 					)
// 				),
// 			),
// 	    );
// 	tatsu_register_module( 'tatsu_title_icon', $controls );
// }
?>