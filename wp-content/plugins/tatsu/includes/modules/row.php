<?php

if (!function_exists('tatsu_row')) {
	function tatsu_row( $atts, $content ) {
		extract( shortcode_atts( array(
	        'full_width'=>0,
	        'no_margin_bottom'=>0,
	        'equal_height_columns'=>0,
	        'gutter'=> 'medium',
	        'column_spacing'=> '25px',
	        'row_id' => '',
	        'row_class' => '',
	        'hide_in' => '',
	        'layout' => ''
	    ),$atts ) );
	    $row_wrap_flag = 0;
	    $class = '';
	    $row_style = '';

		//if(isset( $column_spacing ) && isset( $no_space_columns ) && $column_spacing != '' && $column_spacing != 0 ){
			//$row_wrapper_start = '';
			//$row_wrapper_end = '</div>';
		//}

		if( empty( $full_width ) ){
			$class .= ' tatsu-wrap';
		} else {
			$class .= ' tatsu-row-full-width';
		}

		if( !empty( $layout ) && '1/1' == $layout ) {
			$class .= ' tatsu_row_one_col';
		}

		if( 'custom' === $gutter ) {
			$column_spacing =  !empty( $column_spacing ) ? intval( $column_spacing ) : 0;
			$column_spacing = intval( $column_spacing / 2 );
			if( !empty( $full_width ) ) {
				$row_style = 'style="margin:0 '.$column_spacing.'px;"';
			} else {
				$row_style = 'style="margin:0 -'.$column_spacing.'px;"';
			}
		}

		//$class = ( isset( $no_wrapper ) &&  1 == $no_wrapper ) ? '' : $class ;
	    $class .= ( isset( $no_margin_bottom ) &&  1 == $no_margin_bottom ) ? ' tatsu-zero-margin' : '' ;
	    $class .= ( isset( $gutter ) ) ? ' tatsu-'.$gutter.'-gutter' : ' tatsu-medium-gutter' ;
	    $class .= ( isset( $equal_height_columns ) &&  1 == $equal_height_columns ) ? ' tatsu-eq-cols' : ' tatsu-reg-cols' ;
	    //$class .= ( isset($hide_mobile) && $hide_mobile == 1) ? ' hide-mobile' : '';

		//Handle Resposive Visibility controls
		if( !empty( $hide_in ) ) {
			$hide_in = explode(',', $hide_in);
			foreach ( $hide_in as $device ) {
				$class .= ' tatsu-hide-'.$device;
			}
		}	    
		
		$row_id = !empty($row_id) ? 'id = "'.$row_id.'"' : '';
		$row_class = !empty($row_class) ? str_replace(',', ' ', $row_class) : '' ;
		
		$output = '<div class="tatsu-row-wrap '.$class.' tatsu-clearfix">';
		$output .= '<div '.$row_id.' class="tatsu-row '.$row_class.'" '.$row_style.'>';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		$output .= '</div>';
		

		return $output;
	}
	add_shortcode( 'row','tatsu_row' );
	add_shortcode( 'tatsu_row','tatsu_row' );
	add_shortcode( 'tatsu_row1','tatsu_row' );
}

?>