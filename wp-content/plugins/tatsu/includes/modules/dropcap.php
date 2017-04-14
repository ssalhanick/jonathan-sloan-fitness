<?php
if ( ! function_exists( 'tatsu_dropcap' ) ) {
	function tatsu_dropcap( $atts, $content ) {
		extract( shortcode_atts( array(
	        'type'=>'circle',
	        'bg_color' => '',
	        'color'=>'',
	        'size' =>'small',
	        'letter'=>'',
	        'icon'=>'none',
			'animate'=>0,
	        'animation_type'=>'fadeIn',
	    ), $atts ) );
		$output = "";
		$style = "";
		$output .= '<div class="tatsu-module tatsu-clearfix">';
		$letter = ( $icon != '' ) ? '<i class="tatsu-icon '.$icon.'"></i>' : $letter ;
		$animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '' ; 
		
	 	if( 'rounded' == $type || 'circle' == $type ) {
	 		$color = ( !empty( $color ) ) ? 'color:'.$color.';' : '';
	 		$bg_color = ( !empty( $color ) ) ? 'background-color:'.$bg_color.';' : '';
	 		$style = ( !empty( $color ) || !empty( $bg_color ) )? 'style="'.$color.$bg_color.'"' : ''; 
	 		$output .= '<span class="tatsu-dropcap tatsu-dropcap-'.$type.' '.$size.$animate.'" '.$style.' data-animation="'.$animation_type.'">'.$letter.'</span>'.do_shortcode( $content );
	 	}
	 	if( 'letter' == $type) {
	 		$style .= ( !empty( $color ) )? 'style="color:'.$color.';"' : '' ;
			$output .= '<span class="tatsu-dropcap tatsu-dropcap-'.$type.' '.$size.'" '.$style.' data-animation="'.$animation_type.'">'.$letter.'</span>'.do_shortcode( $content );
		}
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'tatsu_dropcap', 'tatsu_dropcap' );
	add_shortcode( 'dropcap', 'tatsu_dropcap' );
}

// function tatsu_register_dropcap() {
	
// 		$animations = tatsu_css_animations();
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __('Dropcap','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'childModule' => '',
// 	        'type' => 'single',
// 	        'atts' => array (
// 	            array (
// 	        		'att_name' => 'letter',
// 	        		'type' => 'text',
// 	        		'label' => 'Letter to be Dropcapped',
// 	        		'defaultValue' => '',
// 	        		'tooltip' => 'Letter to be Dropcapped'
// 	        	),
// 	        	array (
// 	        		'att_name' => 'icon',
// 	        		'type' => 'icon_picker',
// 	        		'label' => 'Icon to be Dropcapped',
// 	        		'options' => '',
// 	        		'defaultValue' => '',
// 	        		'tooltip' => 'Icon will be Prioritized over letter'
// 	        	),
// 	        	array (
// 	        		'att_name' => 'type',
// 	        		'type' => 'select',
// 	        		'label' => 'Dropcap Style',
// 	        		'options' => array (
// 						'Circle' => 'circle',
// 						'Solid Rounded' => 'rounded',
// 						'Letter' => 'letter',
// 					),
// 	        		'defaultValue' => 'circle',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'size',
// 	        		'type' => 'select',
// 	        		'label' => 'Dropcap Size',
// 	        		'options' => array (
// 						'Small' => 'small',
// 						'Big' => 'big',
// 					),
// 	        		'defaultValue' => 'small',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	              'att_name' => 'color',
// 	              'type' => 'colorpicker',
// 	              'label' => 'Dropcap Color',
// 	              'defaultValue' => '',	//color_scheme
// 	              'tooltip' => '',
// 	            ),
// 	        	array (
// 	        		'att_name' => 'editor_content',
// 	        		'type' => 'tinymce',
// 	        		'label' => 'Dropcap Content',
// 	        		'defaultValue' => '',
// 	        		'tooltip' => 'Add/Edit content'
//  	        	),	
// 	        	array (
// 	              'att_name' => 'animate',
// 	              'type' => 'switch',
// 	              'label' => 'Enable CSS Animation',
// 	              'defaultValue' => false,
// 	              'tooltip' => '',
// 	            ),
// 	            array (
// 	              'att_name' => 'animation_type',
// 	              'type' => 'select',
// 	              'label' => 'Animation Type',
// 	              'options' => $animations,
// 	              'defaultValue' => 'fade',
// 	              'tooltip' => 'Animation Type',
// 	              'dependantField' => 'animate'
// 	            ),

// 	        ),
// 	    );
// 	tatsu_register_module( 'tatsu_dropcap', $controls );
// }

?>