<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists('Tatsu_Parser')) {
	class Tatsu_Parser {

		private $content;
		private $tatsu_page_content;
		private $post_id; 
		

		public function __construct( $content = '', $post_id = false ) {
			$this->content = $content;
			$this->tatsu_page_content = array();
			$this->tatsu_registered_modules = Tatsu_Module_Options::getInstance()->get_registered_modules();
			$this->post_id = $post_id;
		}

		public function get_tatsu_page_content() { 
			$this->tatsu_page_content = $this->parse( $this->wrap_content( $this->content ) );
			return json_encode( $this->tatsu_page_content );
		}

		public function parse( $content ) {
			global $shortcode_tags;
			if ( empty( $shortcode_tags ) || !is_array( $shortcode_tags ) ) {
				return $this->tatsu_page_content;
			}
			$pattern = get_shortcode_regex();
			
			preg_match_all( "/$pattern/s", $content, $matches );

			if( empty( $matches[0] ) ){
				return array();
			}
			return $this->parse_shortcode( $matches );		
		}



		private function wrap_content( $content ) {
			$pattern = get_shortcode_regex();

			$content_array = preg_split("/$pattern/s", $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_OFFSET_CAPTURE );
			$diff_length = 0;
			for ( $i= 0 ; $i < count($content_array); $i++  ) {
				$old_value = $content_array[$i][0];
				$new_value = '[tatsu_section padding="15px 0px 15px 0px" added_by_parser="1"][tatsu_row layout="1/1"][tatsu_column layout="1/1"][tatsu_text]'.$content_array[$i][0].'[/tatsu_text][/tatsu_column][/tatsu_row][/tatsu_section]';
				$offset = $content_array[$i][1];
				if($i > 0) 
					$diff_length += strlen( $new_value ) - strlen( $old_value );
				if( $offset > 0 ) {
					$offset = $offset + $diff_length;
				}
				$content = substr_replace( $content, $new_value, $offset, strlen( $old_value ) );
			}

			$content = $this->wrap_stray_modules( $content );
			
			return $content;			
		}

		private function wrap_stray_modules( $content ) {
			$pattern = get_shortcode_regex();
			preg_match_all( "/$pattern/s", $content, $matches );
			$content_array = $matches[0];
			if( is_array( $content_array ) ) {
				$count = count( $content_array );
				for ( $i = 0 ; $i < $count; $i++ ) {
					preg_match( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content_array[$i], $match );
					$type = $this->get_module_type( $match[1] );
					if( $type && $type != 'core' ){
						$content_array[$i] = '[tatsu_section padding="15px 0px 15px 0px" added_by_parser="1"][tatsu_row layout="1/1"][tatsu_column layout="1/1"]'.$content_array[$i].'[/tatsu_column][/tatsu_row][/tatsu_section]';
					} elseif ( 'core' ===  $type ) {
						switch ( $match[1] ) {
							case 'tatsu_column':
								$content_array[$i] = '[tatsu_section padding="15px 0px 15px 0px" added_by_parser="1"][tatsu_row layout="1/1"]'.$content_array[$i].'[/tatsu_row][/tatsu_section]';
								break;
							case 'tatsu_row':
								$content_array[$i] = '[tatsu_section padding="15px 0px 15px 0px" added_by_parser="1"]'.$content_array[$i].'[/tatsu_section]';
							default:
								break;
						}
					}
				}
			}
			$content = implode( '', $content_array );
			return $content;
		}


		private function is_post_type_post() {
			if( !$this->post_id ) {
				return false;
			}
			$post_type = get_post_type( $this->post_id );
			if( $post_type && 'post' === $post_type ) {
				return true;
			} else {
				return false;
			}
		}


		private function parse_shortcode( $matches ) {
			$sample = array();
			$pattern = get_shortcode_regex();
			$count = count($matches[0]);
			for($counter = 0;$counter < $count; $counter++ ){
				$tag = $matches[2][$counter];
				$atts = $this->parse_atts( $matches[3][$counter] , $tag, $counter, $count );  // do some processing like combining color & opacity atts. 
				$type = $this->get_module_type( $tag );
				$builder_layout = $this->get_builder_layout( $tag );
				$content = $matches[5][$counter];

				$sample[$counter] = array(
							'name' => $tag,
							'id' => uniqid(),
							'atts' => $atts,
							'type' => $type,
							'builderLayout' => $builder_layout,
						);

				if( $type !== "core" && $type !== 'multi' ) {
					$sample[$counter]['atts']['content'] = wpautop( $content );				
				}				

				if( $type !== "core" ) {
					$tatsu_module = new Tatsu_Module( $tag, $atts, $content );
					$sample[$counter]['shortcode_output'] = $tatsu_module->do_shortcode();					
				}

				if( $type != 'single' && $type != 'sub_module') {
					$sample[$counter]['inner'] = $this->parse( $matches[5][$counter] );
				}

				if( 'tatsu_column' === $tag ) {
					$sample[$counter]['layout'] = $atts['layout'];
				}

				if( 'tatsu_row' === $tag ) {
					$sample[$counter]['columnLayout'] = $atts['layout'];
				}				
			}
			return $sample;
		}

		private function get_module_type( $tag ) {
			return Tatsu_Module_Options::getInstance()->get_module_type( $tag );
		}

		private function get_builder_layout( $tag ) {
			if( 'tatsu_row' == $tag ) {
				return 'column';
			} else {
				return 'list';
			}
		}		

		private function parse_atts( $atts, $tag, $counter, $count ) {
			if( empty($atts) ) {
				return array();
			} else {
				$atts = shortcode_parse_atts( $atts );
				if( !is_array( $atts ) ) {
					$atts = array();
				}
				if( 'tatsu_section' === $tag && !empty( $atts['added_by_parser'] ) ) {
					$is_post = $this->is_post_type_post();
					if( !$is_post && $count === 1 ) {
						$atts['padding'] = '90px 0px 90px 0px';
					} else if ( !$is_post && $count > 1 && $counter === 0 ) {
						$atts['padding'] = '90px 0px 15px 0px';
					} else if( !$is_post && $counter === $count -1 ) {
						$atts['padding'] = '15px 0px 90px 0px';
					}
					unset( $atts['added_by_parser'] );
				}

				if( 'gallery' === $tag ) {
					if( !empty( $atts['images'] ) ) {
						$atts['ids'] = $atts['images'];
					} 
					if( !empty( $atts['col'] ) ) {
						if( $atts['col'] == 'one' ) {
							$atts['columns'] = '1';
						} else if( $atts['col'] == 'two' ){
							$atts['columns'] = '2';
						} else if( $atts['col'] == 'three' ){
							$atts['columns'] = '3';
						} else if( $atts['col'] == 'four' ){
							$atts['columns'] = '4';
						} else if( $atts['col'] == 'five' ){
							$atts['columns'] = '5';
						} else {
							$atts['columns'] = '3';
						}
					} else {
						$atts['columns'] = '3';
					}
					unset( $atts['images'] );
					unset( $atts['col'] );
				}

				return $atts;
			}
		}
	}
}