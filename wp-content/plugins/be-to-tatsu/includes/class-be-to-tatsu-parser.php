<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_To_Tatsu_Parser {

	private $content;
	private $tatsu_page_content; 
	private static $core_modules = array( 'section', 'row', 'one_col', 'one_half', 'one_third', 'one_fourth', 'one_fifth', 'two_third', 'three_fourth', 'tatsu_section', 'tatsu_column', 'tatsu_row');
	private static $tatsu_modules = array( 
		'section' => '',
		'row' => '',
		'column' => '',	
		'text' => '', 
		'icon' => '',
		'icon_group' => '', 
		'lists' => '',
		'list' => '', 
		'notifications' => '', 
		'title_icon' => '', 
		'animated_numbers' => '',
		'dropcap' => '',
		'linebreak' => 'empty_space',
		'separator' => 'divider',
		'button' => '',
		'button_group' => '',
		'gmaps' => '',
		'video' => '',
		'shortcode_modules' => 'text_with_shortcodes',
		'call_to_action' => '',
		'bubble_testimonial' => 'testimonial',
	);

	private static $multi_level_modules = array(
		'tabs' => 'tab',
		'accordion' => 'toggle',
		'skills' => 'skill',
		'clients' => 'client',
		'lists' => 'list', 
		'flex_slider' => 'flex_slide',
		'testimonials' => 'testimonial', 
		'content_slides' => 'content_slide', 
		'grids' =>  'grid_content', 
		'pricing_column' => 'pricing_feature', 
		'services' => 'service', 
		'animate_icons_style1' => 'animate_icon_style1', 
		'animate_icons_style2'=> 'animate_icon_style2', 
		'be_slider' => 'be_slide', 
		'process_style1' => 'process_col',
		'rotates' => 'rotate',
		'typed' => 'type',
		'button_group' => 'button',
		'icon_group' => 'icon'
	);

	private static $oshine_modules_to_prefix = array(
		'gallery' => '',
	);

	private static $column_layouts = array(
		'one_col' => '1/1',
		'one_half' => '1/2',
		'one_third' => '1/3',
		'one_fourth' => '1/4',
		'one_fifth' => '1/5',
		'two_third' => '2/3',
		'three_fourth' => '3/4', 
	);

	public function __construct( $content = '' ) {
		$this->content = $content;
		$this->tatsu_page_content = array();
	}

	public function get_tatsu_page_content() {
		$this->tatsu_page_content = $this->parse( $this->content );
		return json_encode( $this->tatsu_page_content );
	}

	public function parse( $content, $parent_atts = array() ) {
		global $shortcode_tags;
		if (empty($shortcode_tags) || !is_array($shortcode_tags)) {
			return $this->tatsu_page_content;
		}
		$pattern = get_shortcode_regex();
		
		preg_match_all( "/$pattern/s", $content, $matches );
		if(empty($matches[0])){
			return array();
		}
		return $this->parse_shortcode( $matches, $parent_atts );		
	}

	private function parse_shortcode( $matches, $parent_atts = array() ) {
		$sample = array();
		$pattern = get_shortcode_regex();
		for($counter = 0;$counter < count($matches[0]); $counter++ ){
			$tag = $matches[2][$counter];
			$atts = $this->parse_atts( $matches[3][$counter] , $tag, $parent_atts );  // do some processing like combining color & opacity atts. 
			$type = $this->get_module_type( $tag );
			$builder_layout = $this->get_builder_layout( $tag );
			$content = $matches[5][$counter];

			$sample[$counter] = array (
				'type' => $type,
				'id' => uniqid(),
				'atts' => $atts,
			);
			
			$sample[$counter]['inner'] = array();

			if( $type !="core" ) {
				$sample[$counter]['atts']['content'] = $content;
			}
			if( $this->is_column( $tag ) ) {
				$sample[$counter]['atts']['layout'] = self::$column_layouts[$tag];				
			}
			if( 'row' == $tag ) {
				$row_layout = array();
				preg_match_all( "/$pattern/s", $matches[5][$counter] , $column_matches );
				foreach ( $column_matches[2] as $column ) {
					array_push( $row_layout, self::$column_layouts[$column] );	
				}
				$sample[$counter]['atts']['layout'] = implode('+', $row_layout );
			}
	
			if( $type != 'single' && $type != 'sub_module') {
				$sample[$counter]['inner'] = $this->parse( $matches[5][$counter], $atts );
			}


			if( $this->is_column( $tag ) ) {
				$tag = 'column';
			} 

			// CHANGE SHORTCODE NAME AND PREFIX THEM

			if( array_key_exists( $tag, self::$tatsu_modules ) ) {
				if(  !empty( self::$tatsu_modules[$tag] ) ) {
					$tag = 'tatsu_'.self::$tatsu_modules[$tag];
				} else {
					$tag = 'tatsu_'.$tag;
				}
			} 



			if( array_key_exists( $tag, self::$oshine_modules_to_prefix ) ) {
				if(  !empty( self::$oshine_modules_to_prefix[$tag] ) ) {
					$tag = 'oshine_'.self::$oshine_modules_to_prefix[$tag];
				} else {
					$tag = 'oshine_'.$tag;
				}
			} 


			$sample[$counter]['name'] = $tag;				
		}
		return $sample;
	}



	private function parse_atts( $atts, $tag, $parent_atts ) {
		if( empty($atts) ) {
			if( $this->is_column( $tag ) ) {
				return array('layout' => self::$column_layouts[$tag] );
			} else {
				return array();
			}
		} else {
			$atts = shortcode_parse_atts( $atts );

			// Combine Padding Values and change animation and BG Size atts.

			if( 'section' == $tag ) {
				if( array_key_exists( 'padding_edge' , $atts ) && !empty( $atts['padding_edge'] ) ) {
					$padding_left_right = $atts['padding_edge'];	
				} else {
					$padding_left_right = '0';
				}
				if( array_key_exists('padding_top', $atts ) && !empty( $atts['padding_top'] ) ) {
					$padding_top = $atts['padding_top'];
				} else {
					$padding_top = '0';
				}
				if( array_key_exists('padding_bottom', $atts ) && !empty( $atts['padding_bottom'] ) ) {
					$padding_bottom = $atts['padding_bottom'];
				} else {
					$padding_bottom = '0';
				}
				$atts['padding'] = $padding_top.'px '.$padding_left_right.'% '.$padding_bottom.'px '.$padding_left_right.'%';

				if( array_key_exists('bg_stretch', $atts ) && '1' == $atts['bg_stretch'] ) {
					$atts['bg_size'] = 'cover';
				}

				if( array_key_exists('bg_animation', $atts ) ) {
					if ( 'be-bg-parallax' == $atts['bg_animation'] ) {
						$atts['bg_animation'] = 'tatsu-parallax';
					} elseif ( 'be-bg-mousemove-parallax' == $atts['bg_animation'] ) {
						$atts['bg_animation'] = 'tatsu-mousemove-parallax';
					}
				}

				if( array_key_exists( 'border_size' , $atts ) ) {
					$atts['border'] = '0px 0px '.$atts['border_size'].'px 0px';
				} 

				if( !empty( $atts['offset_section'] ) ) {
					$atts['offset_value'] = $atts['padding_top'];
				}

				if( !empty( $atts['bg_animation'] ) ) {
					if( 'background-vertical-animation' === $atts['bg_animation'] ) {
						$atts['bg_animation'] = 'tatsu-bg-vertical-animation';
					} elseif ( 'background-horizontal-animation' === $atts['bg_animation'] ) {
						$atts['bg_animation'] = 'tatsu-bg-horizontal-animation';
					}
				}

				unset( $atts['padding_edge'] );
				unset( $atts['padding_top'] );
				unset( $atts['padding_bottom'] );
				unset( $atts['border_size'] );				
			}

			// Change No Space Between Columns and Columns Spacing options of Row. New Gutter Option and Equal Height Columns setting. 

			if( 'row' == $tag ) {
				$atts['equal_height_columns'] = "0";
				$atts['full_width'] = "0";
				if( !empty( $atts['no_wrapper'] ) && 1 == $atts['no_wrapper'] ) {
					$atts['full_width'] = "1";
				}
				$atts['gutter'] = 'medium';
				if( !empty( $atts['no_space_columns'] ) && 1 == $atts['no_space_columns'] ) {
					$atts['equal_height_columns'] = "1";
					if( !empty( $atts['column_spacing'] ) ) {
						$atts['column_spacing'] = $atts['column_spacing'];
						$atts['gutter'] = 'custom';
					} else {
						$atts['gutter'] = 'no';
					}
				}
				unset( $atts['no_space_columns'] );
				unset( $atts['no_wrapper'] );
			}

			// Combine Padding and Margin values of Column Shortcodes

			if( $this->is_column( $tag ) ) {

				$apply_padding = ( array_key_exists('center_pad', $atts) &&  $atts['center_pad'] == '1' ) ? true : false;
				$padding_value = ( array_key_exists('padding_value', $atts ) ) ? $atts['padding_value'] : '%';
				$padding_top = ( array_key_exists('top_pad', $atts ) && !empty( $atts['top_pad'] ) && $apply_padding  ) ? $atts['top_pad'] : '0';
				$padding_bottom = ( array_key_exists('bottom_pad', $atts ) && !empty( $atts['bottom_pad'] ) && $apply_padding ) ? $atts['bottom_pad'] : '0'; 	
				$padding_right = ( array_key_exists('right_pad', $atts ) && !empty( $atts['right_pad'] ) && $apply_padding ) ? $atts['right_pad'] : '0';
				$padding_left = ( array_key_exists('left_pad', $atts ) && !empty( $atts['left_pad'] ) && $apply_padding ) ? $atts['left_pad'] : '0';

				$atts['padding'] = $padding_top.$padding_value.' '.$padding_right.$padding_value.' '.$padding_bottom.$padding_value.' '.$padding_left.$padding_value;

				$bottom_margin = ( array_key_exists('bottom_margin', $atts) ) ? $atts['bottom_margin'] : '0px';

				$atts['margin'] = '0px 0px '.$bottom_margin.' 0px';
				$atts['layout'] = self::$column_layouts[$tag];
				if( array_key_exists('bg_stretch', $atts ) && '1' == $atts['bg_stretch'] ) {
					$atts['bg_size'] = 'cover';
				}

				if( !empty( $parent_atts['equal_height_columns'] ) && 1 == $parent_atts['equal_height_columns'] ) {
					if( !empty( $parent_atts['column_spacing'] ) ) {
						$atts['column_spacing'] = $parent_atts['column_spacing'];
						$atts['gutter'] = 'custom';
					}
					$atts['vertical_align'] = 'middle';
				}
				
				

				if( array_key_exists( 'col_id' , $atts ) ) {
					$atts['column_id'] = $atts['col_id'];
				}

				if( ( array_key_exists( 'bottom_margin', $atts ) && !empty( $atts['bottom_margin'] ) && 50 != $atts['bottom_margin'] ) || '0' === $atts['bottom_margin'] ) {
					$atts['custom_margin'] = '1';
					$atts['margin'] = '0px 0px '.intval( $atts['bottom_margin'] ).'px 0px';
				}

				unset( $atts['padding_value'] );
				unset( $atts['center_pad'] );
				unset( $atts['col_id'] );
				unset( $atts['bottom_margin'] );	
				unset( $atts['top_pad'] );	
				unset( $atts['bottom_pad'] );
				unset( $atts['right_pad'] );
				unset( $atts['left_pad'] );					
			}

			// If Lightbox image is set create a new att for Enabling Lightbox and save Video to the button link att. 

			if( 'button' == $tag || 'call_to_action' == $tag || 'icon' == $tag ) {
				$atts['lightbox'] = 0;
				if( !empty( $atts['image'] ) ) {
					$atts['lightbox'] = 1;
					$video_url = get_post_meta( $atts['image'], 'be_themes_featured_video_url', true );
					if( !empty( $video_url ) ) {
						$atts['video_url'] = $video_url;	
					} else {
						$attachment_info = wp_get_attachment_image_src( $atts['image'], 'full' );
						if( !empty( $attachment_info ) ) {
							$atts['image'] = $attachment_info[0];
						}
					}					
				}
			}

			// Change new_tab att to 1 / 0 format.

			if( 'button' == $tag || 'call_to_action' == $tag ) {
				if( !empty( $atts['new_tab'] ) ) {
					if( 'yes' == $atts['new_tab'] ) {
						$atts['new_tab'] = 1;
					} else {
						$atts['new_tab'] = 0;
					}
				}
			}


			//  Combine Overlay Color and Overlay Opacity Fields

			if( 'section' === $tag || $this->is_column( $tag ) ) {
				$atts = $this->combine_overlay( $atts, 'overlay_color', 'overlay_opacity' );
				unset( $atts['overlay_opacity'] );
			}

			if( 'team' === $tag ) {
				if( !empty( $atts['overlay_transparent'] ) ) {
					$atts['overlay_opacity'] = 0;
				}
				$atts = $this->combine_overlay( $atts, 'overlay_color', 'overlay_opacity' );
				unset( $atts['overlay_opacity'] );
				unset( $atts['overlay_transparent'] );					
			}

			if( 'gallery' === $tag || 'portfolio' === $tag || 'portfolio_carousel' === $tag || 'justified_gallery' === $tag ) {
				$atts = $this->combine_overlay( $atts, 'overlay_color', 'overlay_opacity' , 85 );
				$atts = $this->combine_overlay( $atts, 'gradient_color', 'overlay_opacity', 85 );
				unset( $atts['overlay_opacity'] );					
			}

			if( 'gallery' === $tag ) {
				if( !empty( $atts['images'] ) ) {
					$atts['ids'] = $atts['images'];
				} 
				if( !empty( $atts['col'] ) ) {
					$atts['columns'] = $atts['col'];
				}
				unset( $atts['images'] );
				unset( $atts['col'] );
			}				

			if( 'animate_icon_style1' === $tag ) {
				$atts = $this->combine_overlay( $atts, 'overlay_color', 'overlay_opacity' );
				$atts = $this->combine_overlay( $atts, 'hover_overlay_color', 'hover_overlay_opacity' );

				unset( $atts['overlay_opacity'] );
				unset( $atts['hover_overlay_opacity'] );
			}

			//  Convert Image ID att to Image URL. 

			if( 'section' === $tag || $this->is_column( $tag ) || 'animate_icon_style1' === $tag ) {
				$atts = $this->image_id_to_url( $atts, 'bg_image' );
			}

			if( 'be_slide' === $tag || 'flex_slide' === $tag || 'client' === $tag || 'team' === $tag || 'lightbox_image' === $tag   ) {
				$atts = $this->image_id_to_url( $atts, 'image' );
			}

			if( 'testimonial' === $tag || $this->is_column( $tag ) || 'bubble_testimonial' === $tag ) {
				$atts = $this->image_id_to_url( $atts, 'author_image' );
			}	


			if( 'gmaps' === $tag ) {
				$atts = $this->image_id_to_url( $atts, 'marker' );
			}

			//  Unify Enable Slideshow attribute as slide_show and use 1 or 0 values instead of yes / no

			if( 'tweets' === $tag ) {
				if( array_key_exists('autoplay', $atts ) && !empty( $atts['autoplay'] ) ) {
					$atts['slide_show'] = 1;
					$atts['slide_show_speed'] = $atts['autoplay'];
				} else {
					$atts['slide_show'] = 0;
				}
				unset( $atts['autoplay'] );
			}

			if( 'flex_slider' === $tag ) {
				if( array_key_exists('auto_slide', $atts ) &&  'yes' === $atts['auto_slide'] ) {
					$atts['slide_show'] = 1;
					$atts['slide_show_speed'] = $atts['slide_interval'];
				} else {
					$atts['slide_show'] = 0;
				}
				unset( $atts['auto_slide'] );
				unset( $atts['slide_interval'] );
			}

			if( 'testimonials' === $tag || 'clients' === $tag || 'content_slides' === $tag  ){
				if( array_key_exists('slide_show', $atts ) &&  'yes' === $atts['slide_show'] ) {
					$atts['slide_show'] = 1;
				} else {
					$atts['slide_show'] = 0;
				}					
			}

			if( 'special_heading' === $tag ) {
				if( array_key_exists('default_icon', $atts ) && !empty( $atts['default_icon'] ) ) {
					$atts['icon_name'] = 'oshine_diamond';
				}
				if( !empty( $atts['separator_style'] ) &&  'with-icon' == $atts['separator_style'] ) {
					$atts['separator_style'] = '1';
				} else {
					$atts['separator_style'] = '0';
				}
				unset( $atts['default_icon'] );
			}


			if( 'special_heading2' === $tag ) {
				$padding_value = ( array_key_exists( 'padding_value', $atts ) ) ? $atts['padding_value'] : 'px';
				$padding_top = ( array_key_exists( 'title_padding_vertical', $atts ) ) ? $atts['title_padding_vertical'] : '20';
				$padding_bottom = ( array_key_exists( 'title_padding_vertical', $atts ) ) ? $atts['title_padding_vertical'] : '20'; 	
				$padding_right = ( array_key_exists( 'title_padding_horizontal', $atts ) ) ? $atts['title_padding_horizontal'] : '20';
				$padding_left = ( array_key_exists( 'title_padding_horizontal', $atts ) ) ? $atts['title_padding_horizontal'] : '20';

				$atts['padding'] = $padding_top.$padding_value.' '.$padding_right.$padding_value.' '.$padding_bottom.$padding_value.' '.$padding_left.$padding_value;
				unset( $atts['padding_value'] );
				unset( $atts['title_padding_vertical'] );
				unset( $atts['title_padding_horizontal'] );					
			}

			if( 'special_heading5' === $tag ) {
				$atts = $this->combine_overlay( $atts, 'title_color', 'title_opacity' );
				unset( $atts['title_opacity'] );
			}

			if( 'separator' === $tag ) {
				$atts['units'] = '%';
			}

			if( !empty( $atts['hide_mobile'] ) && 1 == $atts['hide_mobile'] ) {
				$atts['hide_in'] = 'hide-mobile';
				unset( $atts['hide_mobile'] );
			}

			if( 'dropcap' === $tag ) {
				if( !empty( $atts['type'] ) && 'letter' !== $atts['type'] ) {
					$atts['bg_color'] = $atts['color'];
					$atts['color'] = 'rgba(255,255,255,1)';
				}
			}

			if( 'portfolio' === $tag ) {
				if( !empty( $atts['show_filters'] ) && 'yes' === $atts['show_filters'] ) {
					$atts['show_filters'] = '1';
				} else {
					$atts['show_filters'] = '0';
				}
			}

			return $atts; 
		}
	}

	private function get_module_type( $tag ) {
		if( in_array( $tag, self::$core_modules ) ) {
			return 'core';
		} elseif( in_array( $tag, array_keys( self::$multi_level_modules ) ) ) {
			return 'multi';
		} elseif( in_array( $tag, array_values( self::$multi_level_modules ) ) ) {
			return 'sub_module';
		} else {
			return 'single';
		}
	}
	
	private function is_column( $tag ) {
		if( array_key_exists( $tag, self::$column_layouts ) ) {
			return true;
		} 
		return false;
	}

	private function get_builder_layout( $tag ) {
		if( 'row' == $tag ) {
			return 'column';
		} else {
			return 'list';
		}
	}

	private function hex_to_rgba( $hex, $opacity = 100 ) {
		list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
		$opacity = $opacity / 100;
		return 'rgba('.$r.','.$g.','.$b.','.$opacity.')';
	}

	private function combine_overlay( $atts, $overlay_color, $overlay_opacity, $default_opacity = 100 ) {
				// Move to a loop or write a function
		if( array_key_exists($overlay_color, $atts ) && !empty( $atts[$overlay_color] ) ) {
			$opacity = $default_opacity;
			if( array_key_exists($overlay_opacity, $atts ) && !empty( $atts[$overlay_opacity] ) ) {
				$opacity = intval( $atts[$overlay_opacity] );
			} 
			$atts[$overlay_color] = $this->hex_to_rgba( $atts[$overlay_color], $opacity );
		}
		return $atts;				
	}

	private function image_id_to_url( $atts, $image_att ) {
		if( array_key_exists( $image_att, $atts ) && !empty( $atts[$image_att] ) ) {
			$attachment_url = '';
			$attachment_info=wp_get_attachment_image_src( $atts[$image_att] ,'full');
			$attachment_url = $attachment_info[0];
			$atts[$image_att] = $attachment_url;
		}
		return $atts;			
	}

}