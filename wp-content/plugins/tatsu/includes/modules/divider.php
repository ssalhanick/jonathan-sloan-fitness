<?php
// Change separator to divider in parser
if ( ! function_exists( 'tatsu_divider' ) ) {
	function tatsu_divider( $atts ) {
		extract( shortcode_atts( array(
	        'height' => '1',
	        'width' => '20',
	        'units' => '%',
	        'alignment' => '',
	        'color' => '#dedede',
	    ),$atts ) );
		$output = '';
		$style = '';
		$units = (isset($units) && !empty($units) && 'percentage' == $units) ? '%' : $units;
		$style = ( ! empty( $color ) ) ? 'background-color:'.$color.';color:'.$color.';' : $style ;
		$style .= ( ! empty( $height ) ) ? 'height:'.$height.'px;' : '' ;
		$style .= ( ! empty( $width ) ) ? 'width:'.$width.$units.';' : '' ;
		$class = ( !empty( $alignment ) ) ? 'align-'.$alignment: '';
		
		$output .='<hr class="tatsu-module tatsu-divider '.$alignment.'" style="'.$style.'" />'; 
		return $output;
	}
	add_shortcode( 'tatsu_divider', 'tatsu_divider' );
}

// add_action( 'tatsu_register_modules', 'tatsu_register_divider');
// function tatsu_register_divider() {
// 		$controls = array (
// 	        'icon' => '',
// 	        'title' => __('Separator','tatsu'),
// 	        'is_js_dependant' => false,
// 	        'childModule' => '',
// 	        'type' => 'single',
// 			'isInBuilt' => false,
// 	        'atts' => array (
// 	            array (
// 	        		'att_name' => 'height',
// 	        		'type' => 'text',
// 	        		'label' => 'Divider Height',
// 	        		'defaultValue' => '1',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 	        		'att_name' => 'width',
// 	        		'type' => 'text',
// 	        		'label' => 'Divider Width',
// 	        		'defaultValue' => '20',
// 	        		'tooltip' => ''
// 	        	),
// 	        	array (
// 		            'att_name' => 'color',
// 		            'type' => 'colorpicker',
// 		            'label' => 'Divider Color',
// 		            'defaultValue' => '', //sec_border
// 		            'tooltip' => '',
// 	            ),
// 	        ),
// 	    );
// 	tatsu_register_module( 'tatsu_divider', $controls );
// }

?>