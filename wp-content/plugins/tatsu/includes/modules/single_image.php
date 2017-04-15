<?php
/**************************************
	        SINGLE IMAGE
**************************************/
if (!function_exists('tatsu_image')) {
	function tatsu_image( $atts, $content ) {
        extract( shortcode_atts( array (
            'margin'            => '',
            'alignment'         => '',
            'border_width'      => 0,
            'border_color'      => 'transparent',
            'id'                => '',
            'size'              => '',
            'adaptive_image'    => 0,
            'lazy_load'         => '',
            'animate'           => 0,
			'animation_type'    =>'fadeIn',
			'animation_delay'   => 0,
        ), $atts ) );

        $border_width = ( empty( $border_width ) ) ? '0' : $border_width;
        if( empty( $border_color ) ){
            $border_color = 'transparent';
        }
        $border_style = 'border-style: solid; border-width:'.$border_width.'px; border-color: '.$border_color;
        if( !empty( $margin ) ){
            $margin = 'margin : '. $margin . ';';
        }
        if( isset( $animate ) && 1 == $animate && 1 != $lazy_load  ){
            $animate = ' tatsu-animate';
            $data_animations = 'data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'"';
        } else if( isset( $animate ) && 1 == $animate && 1 == $lazy_load ){
            $animate = '';
            $data_animations = 'data-animation="'.$animation_type.'" data-animation-delay="'.$animation_delay.'"';
        } else {
            $animate = '';
            $data_animations = '';
        }
        $id = (int)$id;
        $lazy_load_class = '';
        $img_srcset = '';
        $image_src = '';
        $image = wp_get_attachment_image_src( $id, $size );
        if( !empty( $image ) ){
            $image_src = $image[0];
            $image_width = $image[1];
            $image_height = $image[2];

            if( 1 == $lazy_load ){
                $lazy_load_class = 'tatsu-image-lazyload';
            }

            if( isset( $adaptive_image ) && $adaptive_image == 1 ){
                $img_srcset = wp_get_attachment_image_srcset( $id, $size );
                $img_srcset = 'srcset = "'.$img_srcset.'"';
            }
        }
        // $img_srcset = '';
        $output = '';
        if( $image ) {
            $output .= '<div class="tatsu-single-image tatsu-module align-'. $alignment . ' ' . $lazy_load_class .'" style = "'. $margin . $alignment .'">'; 
            if( empty( $lazy_load ) || 0 == $lazy_load ){
                $output .= '<img src = "'. $image_src .'" class = "'. $animate .'"'. $data_animations .' style = "'. $border_style .'" '. $img_srcset .' />';
            } else if( 1 == $lazy_load ) {
                $output .= '<img data-src = "'. $image_src .'" style = "width : '. $image_width.'px' .' ; height : '. $image_height.'px;' . $border_style .' " '. $data_animations .''. $img_srcset .' />';
            }
            $output .= '</div>';
        }
        return $output;
	}
	add_shortcode( 'tatsu_image', 'tatsu_image' );
}
?>