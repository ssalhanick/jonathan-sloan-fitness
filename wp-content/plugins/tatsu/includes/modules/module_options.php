<?php

add_action( 'tatsu_register_modules', 'tatsu_register_section' );
function tatsu_register_section() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Section', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'row',
	        'type' => 'core',
			'is_built_in' => true,
	        'atts' => array (
	             array (
	              'att_name' => 'bg_color',
	              'type' => 'color',
	              'label' => __( 'Background Color', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'bg_image',
	              'type' => 'single_image_picker',
	              'label' => 'Background Image',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'bg_repeat',
	              'type' => 'select',
	              'label' => __( 'Background Repeat', 'tatsu'),
	              'options' => array (
	                'repeat' => 'Repeat Horizontally & Vertically',
	                'repeat-x' => 'Repeat Horizontally',
	                'repeat-y' => 'Repeat Vertically',
	                'no-repeat' => 'Don\'t Repeat',
	              ),
	              'default' => 'no-repeat',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	             array (
	              'att_name' => 'bg_attachment',
	              'type' => 'button_group',
	              'label' => __( 'Background Attachment', 'tatsu' ),
	              'options' => array (
	                'scroll' => 'Scroll',
	                'fixed' => 'Fixed'
	              ),
	              'default' => 'scroll',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	             array (
	              'att_name' => 'bg_position',
	              'type' => 'select',
	              'label' => __( 'Background Position', 'tatsu' ),
	              'options' => array (
	                'top left' => 'Top Left',
	                'top right' => 'Top Right',
	                'top center' => 'Top Center', 
	                'center left' => 'Center Left', 
	                'center right' => 'Center Right', 
	                'center center' => 'Center Center',
	                'bottom left' => 'Bottom Left',
	                'bottom right' => 'Bottom Right',
	                'bottom center' => 'Bottom Center'
	              ),
	              'default' => 'top left',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	             array (
	              'att_name' => 'bg_size',
	              'type' => 'select',
	              'label' => __( 'Background Size', 'tatsu' ),
	              'options' => array (
	              	'cover' => 'Cover',
	              	'contain' => 'Contain',
	              	'initial' => 'Initial',
	              	'inherit' => 'Inherit'
	              ),
	              'default' => 'cover',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	             array (
	              'att_name' => 'bg_animation',
	              'type' => 'select',
	              'label' => __( 'Background Image Animation', 'tatsu' ),
	              'options' => array (
	                'none' => 'None',
					'tatsu-parallax' => 'Parallax',
					'tatsu-3d-rotate' => '3D Hover',
					'tatsu-bg-horizontal-animation' => 'Horizontal Loop Animation',
					'tatsu-bg-vertical-animation' => 'Vertical Loop Animation',
	              ),
	              'default' => 'none',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	            array (
	              'att_name' => 'padding',
	              'type' => 'input_group',
	              'label' => __( 'Padding', 'tatsu' ),
	              'default' => '90px 0px 90px 0px',
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'margin',
	              'type' => 'input_group',
	              'label' => __( 'Margin', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
	              'tooltip' => '',
	            ),		            	             
	            array (
	              'att_name' => 'border',
	              'type' => 'input_group',
	              'label' => __( 'Border Thickness', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'border_color',
	              'type' => 'color',
	              'label' => __( 'Border Color', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),	             
		            
	            array (
	              'att_name' => 'bg_video',
	              'type' => 'switch',
	              'label' => __( 'Enable Background Video', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	             	'att_name' => 'bg_video_mp4_src',
	             	'type' => 'text',
	             	'label' => __( '.MP4 Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),
	             ),
	             array (
	             	'att_name' => 'bg_video_ogg_src',
	             	'type' => 'text',
	             	'label' => __( '.OGG Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),             	
	             ),
	             array (
	             	'att_name' => 'bg_video_webm_src',
	             	'type' => 'text',
	             	'label' => __( '.WEBM Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),             	
	             ),
	             array (
	              'att_name' => 'bg_overlay',
	              'type' => 'switch',
	              'label' => __( 'Enable Background Overlay', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'overlay_color',
	              'type' => 'color',
	              'label' => __( 'Section Overlay', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	              'visible' => array( 'bg_overlay', '=', '1' ),
	            ),
	             array (
	              'att_name' => 'full_screen',
	              'type' => 'switch',
	              'label' => __( 'Enable Full Screen Section', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),             
	             array (
	              'att_name' => 'section_id',
	              'type' => 'text',
	              'label' => __( 'Section Id', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'section_class',
	              'type' => 'text',
	              'label' => __( 'Section Class', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'section_title',
	              'type' => 'text',
	              'label' => __( 'Section Title', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'offset_section',
	              'type' => 'switch',
	              'label' => __( 'Offset Section', 'tatsu' ),
	              'default' => false,
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'offset_value',
	              'type' => 'number',
	              'label' => __( 'Offset Top By', 'tatsu' ),
	              'options' => array(
	              	'unit' => 'px',
	              	'add_unit_to_value' => true,
	              ),
	              'default' => '0',
	              'tooltip' => '',
	              'hidden' => array( 'offset_section', '=', '0' ),
	            ),		             
	             array (
	              'att_name' => 'full_screen_header_scheme',
	              'type' => 'button_group',
	              'label' => __( 'Header Color Scheme', 'tatsu' ),
	              'options' => array (
	                'background--light' => 'Dark',
					'background--dark' => 'Light', 
	              ),
	              'default' => 'background--dark',
	              'tooltip' => '',
	              //'visible' => array( 'full_screen', '=', '1' ),
	            ),
	             array (
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	        ),
	    );
	tatsu_register_module( 'tatsu_section', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_row' );
function tatsu_register_row() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'Row', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'column',
	        'type' => 'core',
	        'builder_layout' => 'column',
			'is_built_in' => true,
	        'atts' => array (
	             array (
	              'att_name' => 'full_width',
	              'type' => 'switch',
	              'label' => __( 'Full Width Row', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'no_margin_bottom',
	              'type' => 'switch',
	              'label' => __( 'Set margin bottom of all columns to zero', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'equal_height_columns',
	              'type' => 'switch',
	              'label' => __( 'Set all columns to be of equal height', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	        	array (
	        		'att_name' => 'gutter',
	        		'type' => 'select',
	        		'label' => __( 'Spacing between columns', 'tatsu' ),
	        		'options' => array(
	        			'tiny' => 'Tiny',
	        			'small' => 'Small',
	        			'medium' => 'Medium',
	        			'large' => 'Large',
	        			'no' => 'Zero',
	        			'custom' => 'Custom',
	        		),
	        		'default' => 'medium',
	        		'tooltip' => ''
	        	),	             
	             array (
	              'att_name' => 'column_spacing',
	              'type' => 'number',
	              'label' => __( 'Column Spacing', 'tatsu' ),
	              'options' => array(
	              	'unit' => 'px',
	              	'add_unit_to_value' => true,
	              ),
	              'default' => '',
	              'tooltip' => '',
	              'visible' => array( 'gutter', '=', 'custom' ),
	            ),
	             array (
	              'att_name' => 'row_id',
	              'type' => 'text',
	              'label' => __( 'Row Id', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'row_class',
	              'type' => 'text',
	              'label' => __( 'Row Class', 'tatsu' ),
	              'default' => '',
	              'tooltip' => 'Use this to add a css class identifier to this Row. Separate multiple classes using Comma',
	            ),
	             array (
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	        ),
	    );
	tatsu_register_module( 'tatsu_row', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_column' );
function tatsu_register_column() {

		$controls = array (
	        'icon' => '',
	        'title' => __( 'Column', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'module',
	        'type' => 'core',
			'is_built_in' => true,
	        'atts' => array (
	             array (
	              'att_name' => 'bg_color',
	              'type' => 'color',
	              'label' => __( 'Background Color', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'bg_image',
	              'type' => 'single_image_picker',
	              'label' => __( 'Background Image', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'bg_repeat',
	              'type' => 'select',
	              'label' => __( 'Background Repeat', 'tatsu' ),
	              'options' => array (
	                'repeat' => 'Repeat Horizontally & Vertically',
	                'repeat-x' => 'Repeat Horizontally',
	                'repeat-y' => 'Repeat Vertically',
	                'no-repeat' => 'Don\'t Repeat',
	              ),
	              'default' => 'no-repeat',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	             array (
	              'att_name' => 'bg_attachment',
	              'type' => 'select',
	              'label' => __( 'Background Attachment', 'tatsu' ),
	              'options' => array (
	                'scroll' => 'Scroll',
	                'fixed' => 'Fixed'
	              ),
	              'default' => 'scroll',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	             array (
	              'att_name' => 'bg_position',
	              'type' => 'select',
	              'label' => __( 'Background Position', 'tatsu' ),
	              'options' => array (
	                'top left' => 'Top Left',
	                'top right' => 'Top Right',
	                'top center' => 'Top Center', 
	                'center left' => 'Center Left', 
	                'center right' => 'Center Right', 
	                'center center' => 'Center Center',
	                'bottom left' => 'Bottom Left',
	                'bottom right' => 'Bottom Right',
	                'bottom center' => 'Bottom Center'
	              ),
	              'default' => 'top left',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	             array (
	              'att_name' => 'bg_size',
	              'type' => 'select',
	              'label' => __( 'Enable Background Cover Property', 'tatsu' ),
	              'options' => array (
	              	'cover' => 'Cover',
	              	'contain' => 'Contain',
	              	'initial' => 'Initial',
	              	'inherit' => 'Inherit'
	              ),
	              'default' => 'cover',
	              'tooltip' => '',
	              'hidden' => array( 'bg_image', '=', '' ),
	            ),
	            array (
	              'att_name' => 'padding',
	              'type' => 'input_group',
	              'label' => __( 'Padding', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'custom_margin',
	              'type' => 'switch',
	              'label' => __( 'Custom Margin ?', 'tatsu' ),
	              'default' => '0',
	              'tooltip' => '',
	            ),	            
	             array (
	              'att_name' => 'margin',
	              'type' => 'input_group',
	              'label' => __( 'Margin', 'tatsu' ),
	              'default' => '0px 0px 0px 0px',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'bg_video',
	              'type' => 'switch',
	              'label' => __( 'Enable Background Video', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	             	'att_name' => 'bg_video_mp4_src',
	             	'type' => 'text',
	             	'label' => __( '.MP4 Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),
	             ),
	             array (
	             	'att_name' => 'bg_video_ogg_src',
	             	'type' => 'text',
	             	'label' => __( '.OGG Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),             	
	             ),
	             array (
	             	'att_name' => 'bg_video_webm_src',
	             	'type' => 'text',
	             	'label' => __( '.WEBM Source', 'tatsu' ),
	             	'default' => '',
	             	'visible' => array( 'bg_video', '=', '1' ),             	
	             ),
	             array (
	              'att_name' => 'bg_overlay',
	              'type' => 'switch',
	              'label' => __( 'Enable Background Overlay', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'overlay_color',
	              'type' => 'color',
	              'label' => __( 'Column Overlay', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	              'visible' => array( 'bg_overlay', '=', '1' ),
	            ),
	             array (
	              'att_name' => 'animate_overlay',
	              'type' => 'select',
	              'label' => __( 'Animate Column Overlay', 'tatsu' ),
	              'options' => array (
	                'none' => 'None', 
	                'hide' => 'Hidden by default and Show on Hover', 
	                'show' => 'Shown by default and Hide on Hover', 
	              ),
	              'default' => 'none',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'link_overlay',
	              'type' => 'text',
	              'label' => __( 'Link Overlay/Column URL', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	              'visible' => array( 'bg_overlay', '=', '1' ),
	            ),
	             array (
	              'att_name' => 'vertical_align',
	              'type' => 'button_group',
	              'label' => __( 'Vertical Alignment', 'tatsu' ),
	              'options' => array (
	                'none' => 'None',
	                'top' => 'Top', 
	                'middle' => 'Middle', 
	                'bottom' => 'Bottom',
	                // 'baseline' => 'Baseline',
	                // 'stretch' => 'Stretch',
	              ),
	              'default' => 'none',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'animate',
	              'type' => 'switch',
	              'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              'default' => '0',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'animation_type',
	              'type' => 'select',
	              'label' => __( 'Animation Type', 'tatsu' ),
	              'options' => tatsu_css_animations(),
	              'default' => 'fadeIn',
	              'tooltip' => '',
	              'visible' => array( 'animate', '=', '1' ),
	            ),
	             array (
	              'att_name' => 'col_id',
	              'type' => 'text',
	              'label' => __( 'Column Id', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'column_class',
	              'type' => 'text',
	              'label' => __( 'Column Class', 'tatsu' ),
	              'default' => '',
	              'tooltip' => '',
	            ),
	             array (
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	        ),
	    );
	tatsu_register_module( 'tatsu_column', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_text' );
function tatsu_register_text() {
		$controls =  array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#text',
	        'title' => __( 'Text Block', 'tatsu' ),
	        'is_js_dependant' => true,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	        	array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
	        	array (
	        		'att_name' => 'max_width',
	        		'type' => 'slider',
	        		'label' => __( 'Content Width', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),		        		
	        		'default' => '100',
	        		'tooltip' => ''

	        	),
	        	array (
	        		'att_name' => 'wrap_alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Wrap Alignment', 'tatsu' ),
	        		'options' => array (
	        			'left' => 'Left',
	        			'center' => 'Center',	        			
	        			'right' => 'Right',
	        		),
	        		'default' => 'center',
	        		'tooltip' => '',
	        		'visible' => array( 'max_width', '<', '100' ),
	        	),
	        	array (
	        		'att_name' => 'animate',
	        		'type' => 'switch',
	        		'label' => __( 'Enable CSS Animation', 'tatsu' ),
	        		'default Value' => 0,
	        		'tooltip' => ''
	        	),
	             array (
	              'att_name' => 'animation_type',
	              'type' => 'select',
	              'label' => __( 'Animation Type', 'tatsu' ),
	              'options' => tatsu_css_animations(),
	              'default' => 'fadeIn',
	              'tooltip' => '',
	              'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
	        		),
	        	)
	        ),
		);
	tatsu_register_module( 'tatsu_text', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_animated_numbers' );
function tatsu_register_animated_numbers() {	
		$controls =  array(
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#animated_numbers',
	        'title' => __( 'Animated Numbers', 'tatsu' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => true,
	        'should_destroy' => true,
	        'atts' => array(
	        	array(
	        		'att_name' => 'number',
	        		'type' => 'text',
	        		'label' => __( 'Number', 'tatsu' ),
	        		'tooltip' => ''
 	        	),		        	
	        	array(
	        		'att_name' => 'caption',
	        		'type' => 'text',
	        		'label' => __( 'Caption', 'tatsu' ),
	        		'tooltip' => ''
 	        	),	
	        	array(
	        		'att_name' => 'number_size',
	        		'type' => 'number',
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'label' => __( 'Font Size of Number', 'tatsu' ),
	        		'tooltip' => ''
	        	),
	        	array(
	        		'att_name' => 'caption_size',
	        		'type' => 'number',
	        		'options' => array(
	        			'unit' => 'px',
	        		),	        		
	        		'label' => __( 'Font Size of Caption', 'tatsu' ),
	        		'tooltip' => ''
	        	),
	             array(
	              'att_name' => 'number_color',
	              'type' => 'color',
	              'label' => __( 'Number Color', 'tatsu' ),
	              'tooltip' => '',
	            ),
	             array(
	              'att_name' => 'caption_color',
	              'type' => 'color',
	              'label' => __( 'Caption Color', 'tatsu' ),
	              'tooltip' => '',
	            ),
	        	array(
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',	        			
	        			'right' => 'Right',
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'number' => '27',
						'caption' => 'Demos',
						'number_size' => '45',
						'caption_size' => '13',
						'number_color' => '#141414',
						'caption_color' => '#141414',
	        		),
	        	)
	        ),
		);
	tatsu_register_module( 'tatsu_animated_numbers', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_button' );
function tatsu_register_button() {

		$controls = array (
			'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#button',
	        'title' => __( 'Button', 'tatsu' ),
			'is_js_dependant' => false,
			'child_module' => '',
			'inline' => true,
			'type' => 'single',
			'is_built_in' => true,
			'atts' => array (
				array (
					'att_name' => 'button_text',
					'type' => 'text',
					'label' => __( 'Button Text', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
				),
				array (
					'att_name' => 'url',
					'type' => 'text',
					'label' => __( 'URL to be linked', 'tatsu' ),
					'default' => '',
					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'new_tab',
 					'type' => 'switch',
 					'label' => __( 'Open in a new tab', 'tatsu' ),
 					'default' => '0',
 					'tooltip' => '',
 					'visible' => array( 'url', '!=', '' ),
 				),
 				array (
 					'att_name' => 'type',
 					'type' => 'button_group',
 					'label' => __( 'Button Size', 'tatsu' ),
 					'options' => array (
 						'small' => 'Small',
 						'medium' => 'Medium',
 						'large' => 'Large',
 						'block' => 'Block'
 					),
 					'default' => 'medium',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'button_style',
 					'type' => 'button_group',
 					'label' => __( 'Button Style', 'tatsu' ),
 					'options' => array (
 						'none' => 'Rectangular',
 						'rounded' => 'Rounded',
 						'circular' => 'Circular'
 					),
 					'default' => 'none',
 					'tooltip' => ''
 				), 	        	 								
 				array (
 					'att_name' => 'alignment',
 					'type' => 'button_group',
 					'label' => __( 'Button Alignment', 'tatsu' ),
 					'options' => array (
 						'none' => 'None',
 						'left' => array(
 							'icon' => '',
 							'title' => 'Left',
 						),
 						'center' => array(
 							'icon' => '',
 							'title' => 'Center',
 						),
 						'right' => array(
 							'icon' => '',
 							'title' => 'Right',
 						),
 					),
 					'default' => 'none',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'bg_color',
 					'type' => 'color',
 					'label' => __( 'Background Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'hover_bg_color',
 					'type' => 'color',
 					'label' => __( 'Hover Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'color',
 					'type' => 'color',
 					'label' => __( 'Text Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => ''
 				),
  				array (
 					'att_name' => 'hover_color',
 					'type' => 'color',
 					'label' => __( 'Hover Text Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'border_width',
 					'type' => 'number',
 					'label' => __( 'Border Size', 'tatsu' ),
 					'options' => array(
 						'unit' => 'px',
 						'add_unit_to_value' => false,
 					),
 					'default' => '0',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'border_color',
 					'type' => 'color',
 					'label' => __( 'Border Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
 					'visible' => array( 'border_width', '>', '0' ),
 				),
 				array ( 
 					'att_name' => 'hover_border_color',
 					'type' => 'color',
 					'label' => __( 'Hover Border Color', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
 					'visible' => array( 'border_width', '>', '0' ),
 				),
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
 				array (
 					'att_name' => 'icon_alignment',
 					'type' => 'button_group',
 					'label' => __( 'Icon Alignment', 'tatsu' ),
 					'options' => array (
 						'left' => 'Left',
 						'right' => 'Right',
 					),
 					'default' => 'left',
 					'tooltip' => '',
 					'visible' => array( 'icon', '!=', '' ),
 				), 				
 				array (
 					'att_name' => 'lightbox',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Lightbox Image / Video', 'tatsu' ),
 					'tooltip' => ''
 				),  				
 				array (
 					'att_name' => 'image',
 					'type' => 'single_image_picker',
 					'label' => __( 'Background Image', 'tatsu' ),
 					'default' => '',
 					'tooltip' => '',
 					'visible' => array( 'lightbox', '=', '1' ),
 				),
	        	array (
	        		'att_name' => 'video_url',
	        		'type' => 'text',
	        		'label' => __( 'Youtube / Vimeo Url in lightbox', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'visible' => array( 'lightbox', '=', '1' ),
	        	),					
 				array (
 					'att_name' => 'background_animation',
 					'type' => 'button_group',
 					'label' => __( 'Background Animation', 'tatsu' ),
 					'options' => array (
 						'none' => 'None',
 						'bg-animation-slide-left' => 'Slide Left',
 						'bg-animation-slide-right' => 'Slide Right',
 						'bg-animation-slide-top' => 'Slide Top',
 						'bg-animation-slide-bottom' => 'Slide Bottom',
 					),
 					'default' => 'none',
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'animate',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Css Animations', 'tatsu' ),
 					'tooltip' => ''
 				),
 				array (
 					'att_name' => 'animation_type',
 					'type' => 'select',
 					'options' => tatsu_css_animations(),
 					'label' => __( 'Animation Type', 'tatsu' ),
 					'default' => 'fadeIn',
 					'tooltip' => '',
 					'visible' => array( 'animate', '=', '1' ),
 				),
			),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
						'button_text' => 'Click Here',
						'bg_color' => tatsu_get_color( 'tatsu_accent_color' ),
						'color' => tatsu_get_color( 'tatsu_accent_twin_color' ),
						'button_style' => 'circular',	        			
	        		),
	        	)
	        ),
		);
	tatsu_register_module( 'tatsu_button', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_button_group' );
function tatsu_register_button_group() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#button_group',
	        'title' => __( 'Button Group', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'tatsu_button',
	        'allowed_sub_modules' => array( 'tatsu_button' ),
	        'type' => 'multi',
	        'initial_children' => 2,
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array (
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
	        ),	        
	    );
	tatsu_register_module( 'tatsu_button_group', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_icon_module');
function tatsu_register_icon_module() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#icon',
	        'title' => __( 'Icon', 'tatsu' ),
	        'is_js_dependant' => false,
	        'inline' => true,
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'name',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'tatsu' ),
	        		'options' => array (
						'tiny' => 'Tiny',
						'small' => 'Small',
						'medium' => 'Medium',
						'large' => 'Large',
						'xlarge' =>'XL',
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'tatsu' ),
	        		'options' => array (
						'circle' => 'Circle',
						'plain' => 'Plain',
						'square' => 'Square',
						'diamond' => 'Diamond'
					),
	        		'default' => 'circle',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Hover Background Color', 'tatsu' ),
		            'default' => '', //color_scheme
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'Icon Color', 'tatsu' ),
		            'default' => '', 
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'hover_color',
		            'type' => 'color',
		            'label' => __( 'Hover Icon Color', 'tatsu' ),
		            'default' => '', //alt_bg_text_color
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'border_width',
	        		'type' => 'number',
	        		'label' => __( 'Border Width', 'tatsu' ),
	        		'options' => array (
	        			'unit' => 'px',
	        		),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
		            'visible' => array( 'border_width', '>', '0' ),
	            ),
	        	array (
		            'att_name' => 'hover_border_color',
		            'type' => 'color',
		            'label' => __( 'Hover Border Color', 'tatsu' ),
		            'default' => '', //color_scheme
		            'tooltip' => '',
		            'visible' => array( 'border_width', '>', '0' ),
	            ),
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'none' => 'None',
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'none',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'href',
	        		'type' => 'text',
	        		'label' => __( 'URL to be linked to the Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'new_tab',
	              	'type' => 'switch',
	              	'label' => __( 'Open as new tab', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	              	'visible' => array( 'href', '!=', '' ),
	            ),
 				array (
 					'att_name' => 'lightbox',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Lightbox Image / Video', 'tatsu' ),
 					'tooltip' => ''
 				), 	            
	        	array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Select Lightbox image / video', 'tatsu' ),
	              	'tooltip' => '',
	              	'visible' => array( 'lightbox', '=', '1' ),
	            ),
	        	array (
	        		'att_name' => 'video_url',
	        		'type' => 'text',
	        		'label' => __( 'Youtube / Vimeo Url in lightbox', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'visible' => array( 'lightbox', '=', '1' ),
	        	),	            	            
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),

	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'name' => 'icon-icon_desktop',
	        			'size' => 'medium',
	        			'style' => 'plain',
	        			'color' => tatsu_get_color( 'tatsu_accent_color' ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_icon', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_icon_group');
function tatsu_register_icon_group() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#icon_group',
	        'title' => __( 'Icon Group', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'tatsu_icon',
	        'type' => 'multi',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'center',
	        		'tooltip' => ''
	        	),
	        ),
	    );
	tatsu_register_module( 'tatsu_icon_group', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_divider');
function tatsu_register_divider() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#divider',
	        'title' => __( 'Divider', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'height',
	        		'type' => 'slider',
	        		'label' => __( 'Divider Thickness', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '50',
	        			'step' => '1',
	        			'unit' => 'px',
	        		),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'width',
	        		'type' => 'slider',
	        		'label' => __( 'Divider Width', 'tatsu' ),
	        		'options' => array(
	        			'min' => '0',
	        			'max' => '100',
	        			'step' => '1',
	        			'unit' => '%',
	        		),	        		
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'Divider Color', 'tatsu' ),
		            'default' => '', //sec_border
		            'tooltip' => '',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'height' => '1',
	        			'width' => '100',
	        			'color' => '#efefef'
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_divider', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_title_icon');
function tatsu_register_title_icon() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#title_icon',
	        'title' => __( 'Title with Icon', 'tatsu' ),
	        'is_js_dependant' => true,
	        'child_module' => '',
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Size', 'tatsu' ),
	        		'options' => array (
						'small' => 'Small',
						'medium' => 'Medium',
						'large' => 'Large',
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array (
						'left' => 'Left',
						'right' => 'Right'
					),
	        		'default' => 'left',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'button_group',
	        		'label' => __( 'Style', 'tatsu' ),
	        		'options' => array (
						'circled' => 'Circled',
						'plain' => 'Plain'
					),
	        		'default' => 'circled',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'icon_bg',
		            'type' => 'color',
		            'label' => __( 'Background Color of Icon if circled', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
		            'visible' => array( 'style', '=', 'circled' ),
	            ),
	        	array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
		            'label' => __( 'Icon Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'icon_border_color',
		            'type' => 'color',
		            'label' => __( 'Icon Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
		            'visible' => array( 'style', '=', 'circled' ),
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'icon' => 'icon-icon_desktop',
	        			'icon_color' => tatsu_get_color( 'tatsu_accent_color' ),
	        			'icon_border_color' => tatsu_get_color( 'tatsu_accent_color' ),
	        			'size' => 'medium',
	        			'style' => 'plain',
	        			'content' => '<h6>Title Goes Here</h6><p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt.</p>'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_title_icon', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_testimonial');
function tatsu_register_testimonial() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#bubble_testimonial',
	        'title' => __( 'Bubble Testimonial', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'description',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'content_color',
		            'type' => 'color',
		            'label' => __( 'Testimonial Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'author_image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Testimonial Author Image', 'tatsu' ),
	              	'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'author',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Author', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'author_color',
		            'type' => 'color',
		            'label' => __( 'Testimonial Author Text Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'author_role',
	        		'type' => 'text',
	        		'label' => __( 'Testimonial Author Role', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'author_role_color',
		            'type' => 'color',
		            'label' => __( 'Testimonial Author Role Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'alignment',
	        		'type' => 'button_group',
	        		'label' => __( 'Alignment', 'tatsu' ),
	        		'options' => array(
	        			'left' => 'Left',
	        			'center' => 'Center',
	        			'right' => 'Right'
	        		),
	        		'default' => 'left',
	        		'tooltip' => ''
	        	),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'description' => 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt.',
	        			'author' => 'Swami',
	        			'author_role' => 'Designer',
	        			'bg_color' => tatsu_get_color( 'tatsu_accent_color' ),
	        			'content_color' => tatsu_get_color( 'tatsu_accent_twin_color' ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_testimonial', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_video');
function tatsu_register_video() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#video',
	        'title' => __( 'Video', 'tatsu' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => true,
	        'drag_handle' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'source',
	        		'type' => 'select',
	        		'label' => __( 'Choose Video Source', 'tatsu' ),
	        		'options' => array (
						'youtube' => 'Youtube',
						'vimeo' => 'Vimeo',
						//'self' => 'Self Hosted'
					),
	        		'default' => 'youtube',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'url',
	        		'type' => 'text',
	        		'label' => __( 'Enter the video url', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'source' => 'youtube',
						'url' => 'https://www.youtube.com/watch?v=8z4FSMLtWoQ' ,
					)
				),
			),
	    );
	tatsu_register_module( 'tatsu_video', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_notifications');
function tatsu_register_notifications() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#notifications',
	        'title' => __( 'Notifications', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color of Notification box', 'tatsu' ),
		            'default' => '', //sec_bg
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Notification Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __('Animation Type','tatsu'),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => '<span style="color: #fff">This is a Cool Notice</span>',
	        			'bg_color' => tatsu_get_color( 'tatsu_accent_color' ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_notifications', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_lists');
function tatsu_register_lists() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#lists',
	        'title' => __( 'Lists', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => 'tatsu_list',
	        'initial_children' => 5,
	        'type' => 'multi',
	        'is_built_in' => true,
	        'atts' => array (),
	    );
	tatsu_register_module( 'tatsu_lists', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_list');
function tatsu_register_list() {
		$controls = array (
	        'icon' => '',
	        'title' => __( 'List', 'tatsu' ),
	        'is_js_dependant' => false,
	        'type' => 'sub_module',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __( 'Icon', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'circled',
	              	'type' => 'switch',
	              	'label' => __( 'Circle the Icon', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
		            'att_name' => 'icon_bg',
		            'type' => 'color',
		            'label' => __( 'Background Color if circled', 'tatsu' ),
		            'default' => '', //color_scheme
		            'tooltip' => '',
		            'visible' => array( 'circled', '=', '1' ),
	            ),
	            array (
		            'att_name' => 'icon_color',
		            'type' => 'color',
		            'label' => __( 'Icon Color','tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Content', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text.',
	        			'icon' => 'icon-icon_check',
	        			'icon_color' => tatsu_get_color( 'tatsu_accent_color' ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_list', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_gmaps');
function tatsu_register_gmaps() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#gmaps',
	        'title' => __( 'Google Maps', 'tatsu' ),
	        'is_js_dependant' => true,
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'address',
	        		'type' => 'text',
	        		'label' => __( 'Address', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'latitude',
	        		'type' => 'text',
	        		'label' => __( 'Latitude', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'longitude',
	        		'type' => 'text',
	        		'label' => __( 'Longitude', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'tatsu' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '300',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'zoom',
	        		'type' => 'slider',
	        		'label' => __( 'Zoom Value', 'tatsu' ),
	        		'options' => array(
	        			'min' => '1',
	        			'max' => '25',
	        			'step' => '1',
	        		),
	        		'default' => '14',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'style',
	        		'type' => 'select',
	        		'label' => __( 'Style', 'tatsu' ),
	        		'options' => array (
						'standard' => 'Standard',
						'greyscale' => 'Greyscale', 
						'bluewater' => 'Bluewater', 
						'midnight' => 'Midnight',
						'black' => 'Black'
					),
	        		'default' => 'standard',
	        		'tooltip' => ''
	        	),
	        	array (
	              	'att_name' => 'marker',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Custom Marker Pin', 'tatsu' ),
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'latitude' => '13.043442',
	        			'longitude' => '80.273681'
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_gmaps', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_empty_space');
function tatsu_register_empty_space() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#empty_space',
	        'title' => __( 'Extra Spacing', 'tatsu' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
	        'drag_handle' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'height',
	        		'type' => 'number',
	        		'label' => __( 'Height', 'tatsu' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	            array (
	              'att_name' => 'hide_in',
	              'type' => 'screen_visibility',
	              'label' => __( 'Hide in', 'tatsu' ),
	              'default' => 0,
	              'tooltip' => '',
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'height' => '30'
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_empty_space', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_call_to_action');
function tatsu_register_call_to_action() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#call_to_action',
	        'title' => __( 'Call to Action', 'tatsu' ),
	        'is_js_dependant' => false,
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
		            'att_name' => 'bg_color',
		            'type' => 'color',
		            'label' => __( 'Background Color', 'tatsu' ),
		            'default' => '', //color_scheme
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'title',
	        		'type' => 'text',
	        		'label' => __( 'Title', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'h_tag',
	        		'type' => 'button_group',
	        		'label' => __( 'Heading tag to use for Title', 'tatsu' ),
	        		'options' => array (
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h5',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'button_text',
	        		'type' => 'text',
	        		'label' => __( 'Button Text', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'button_link',
	        		'type' => 'text',
	        		'label' => __( 'URL to be linked to the button', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'new_tab',
	        		'type' => 'switch',
	        		'label' => __( 'Open Link in New Tab', 'tatsu' ),
	        		'default' => 0,
	        		'tooltip' => '',
	        		'visible' => array( 'button_link', '!=', '' ),
	        	),
	        	array (
		            'att_name' => 'button_bg_color',
		            'type' => 'color',
		            'label' => __( 'Button Background Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'hover_bg_color',
		            'type' => 'color',
		            'label' => __( 'Button Hover Background Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => __( 'Button Text Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	        	array (
		            'att_name' => 'hover_color',
		            'type' => 'color',
		            'label' => __( 'Button Hover Text Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'border_width',
	        		'type' => 'number',
	        		'label' => __( 'Button Border Size', 'tatsu' ),
	        		'options' => array(
	        			'unit' => 'px',
	        		),
	        		'default' => '1',
	        		'tooltip' => '',
	        	),
	        	array (
		            'att_name' => 'border_color',
		            'type' => 'color',
		            'label' => __( 'Button Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
		            'visible' => array( 'border_width', '>', '0' ),
	            ),
	        	array (
		            'att_name' => 'hover_border_color',
		            'type' => 'color',
		            'label' => __( 'Button Hover Border Color', 'tatsu' ),
		            'default' => '',
		            'tooltip' => '',
		            'visible' => array( 'border_width', '>', '0' ),

	            ),
 				array (
 					'att_name' => 'lightbox',
 					'type' => 'switch',
 					'default' => 0,
 					'label' => __( 'Enable Lightbox Image / Video', 'tatsu' ),
 					'tooltip' => ''
 				), 
	            array (
	              	'att_name' => 'image',
	              	'type' => 'single_image_picker',
	              	'label' => __( 'Select Lightbox image / video', 'tatsu' ),
	              	'tooltip' => '',
	              	'visible' => array( 'lightbox', '=', '1' ),
	            ),
	        	array (
	        		'att_name' => 'video_url',
	        		'type' => 'text',
	        		'label' => __( 'Youtube / Vimeo Url in lightbox', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => '',
	        		'visible' => array( 'lightbox', '=', '1' ),
	        	),		            
	            array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'tooltip' => '',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'bg_color' => tatsu_get_color( 'tatsu_accent_color' ) ,
	        			'title' => 'Have a project ? Call us Now ',
	        			'h_tag' => 'h5',
	        			'title_color' => tatsu_get_color( 'tatsu_accent_twin_color' ) ,
	        			'button_text' => 'Get In Touch',
	        			'hover_bg_color' => tatsu_get_color( 'tatsu_accent_twin_color' ),
	        			'color' => tatsu_get_color( 'tatsu_accent_twin_color' ),
	        			'hover_color' => tatsu_get_color( 'tatsu_accent_color' ),
	        			'border_width' => '1',
	        			'border_color' => tatsu_get_color( 'tatsu_accent_twin_color' ),
	        			'hover_border_color' => tatsu_get_color( 'tatsu_accent_twin_color' ),
	        		),
	        	)
	        ),
	    );
	tatsu_register_module( 'tatsu_call_to_action', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_dropcap');
function tatsu_register_dropcap() {

		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#dropcap',
	        'title' => __('Dropcap','tatsu'),
	        'is_js_dependant' => false,
	        'type' => 'single',
			'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'letter',
	        		'type' => 'text',
	        		'label' => __('Letter to be Dropcapped', 'tatsu'),
	        		'default' => '',
	        		'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => __('Icon to be Dropcapped', 'tatsu'),
	        		'default' => '',
	        		'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'type',
	        		'type' => 'button_group',
	        		'label' => __( 'Dropcap Style', 'tatsu' ),
	        		'options' => array (
						'circle' => 'Circle',
						'rounded' => 'Square',
						'letter' => 'Plain',
					),
	        		'default' => 'circle',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'button_group',
	        		'label' => __( 'Dropcap Size', '' ),
	        		'options' => array (
						'small' => 'Small',
						'big' => 'Big',
					),
	        		'default' => 'small',
	        		'tooltip' => ''
	        	),
	        	array (
	              'att_name' => 'color',
	              'type' => 'color',
	              'label' => 'Dropcap Color',
	              'default' => '',	//color_scheme
	              'tooltip' => '',
	            ),
	        	array (
	              'att_name' => 'bg_color',
	              'type' => 'color',
	              'label' => 'Dropcap Background Color',
	              'default' => '',	//color_scheme
	              'tooltip' => '',
	              'hidden' => array( 'type', '=', 'letter' ),
	            ),	            
	        	array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => 'Dropcap Content',
	        		'default' => '',
	        		'tooltip' => 'Add/Edit content'
 	        	),	
	        	array (
	              'att_name' => 'animate',
	              'type' => 'switch',
	              'label' => 'Enable CSS Animation',
	              'default' => 0,
	              'tooltip' => '',
	            ),
	            array (
	              'att_name' => 'animation_type',
	              'type' => 'select',
	              'label' => 'Animation Type',
	              'options' => tatsu_css_animations(),
	              'default' => 'fadeIn',
	              'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
						'letter' => 'T',
						'color' => tatsu_get_color( 'tatsu_accent_color' ),
						'type' => 'letter',
					)
				),
			),
	    );
	tatsu_register_module( 'tatsu_dropcap', $controls );
}


add_action( 'tatsu_register_modules', 'tatsu_register_dropcap2');
function tatsu_register_dropcap2() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#dropcap',
	        'title' => __('Dropcap - 2','tatsu'),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => true,
	        'atts' => array (
	            array (
	        		'att_name' => 'letter',
	        		'type' => 'text',
	        		'label' => __('Letter to be Dropcapped', 'tatsu'),
	        		'default' => '',
	        		'tooltip' => '',
	        	),
	        	array (
	        		'att_name' => 'icon',
	        		'type' => 'icon_picker',
	        		'label' => 'Icon to be Dropcapped',
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'size',
	        		'type' => 'slider',
	        		'label' => 'Dropcap Size',
	        		'options' => array (
						'unit' => 'px',
						'min' => '10',
						'max' => '200',
						'step' => '1'
					),
	        		'default' => '60',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'color',
		            'type' => 'color',
		            'label' => 'Dropcap Color',
		            'default' => '',	//color_scheme
		            'tooltip' => '',
	            ),
	            array (
	        		'att_name' => 'dropcap_title',
	        		'type' => 'text',
	        		'label' => __('Dropcap Title','tatsu'),
	        		'default' => '',
	        		'tooltip' => ''
	        	),
	        	array (
	        		'att_name' => 'title_font',
	        		'type' => 'select',
	        		'label' => __('Font for Title','tatsu'),
	        		'options' => array (
	        			'body'=> 'Body', 
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6'
					),
	        		'default' => 'h6',
	        		'tooltip' => ''
	        	),
	        	array (
		            'att_name' => 'title_color',
		            'type' => 'color',
		            'label' => __( 'Title Color', 'tatsu' ),
		            'default' => '', //color_scheme
		            'tooltip' => '',
	            ),
				array (
	              	'att_name' => 'animate',
	              	'type' => 'switch',
	              	'label' => __( 'Enable CSS Animation', 'tatsu' ),
	              	'default' => 0,
	              	'tooltip' => '',
	            ),
	            array (
	              	'att_name' => 'animation_type',
	              	'type' => 'select',
	              	'label' => __( 'Animation Type', 'tatsu' ),
	              	'options' => tatsu_css_animations(),
	              	'default' => 'fadeIn',
	              	'visible' => array( 'animate', '=', '1' ),
	            ),
	        ),
			'presets' => array(
				'default' => array(
					'title' => '',
					'image' => '',
					'preset' => array(
						'letter' => 'T',
						'color' => 'rgba(0,0,0,0.1)',
						'dropcap_title' => 'TATSU IS AWESOME',
						'title_color' => '#000',
						'size' => '100',
					)
				),
			),
	    );
	tatsu_register_module( 'tatsu_dropcap2', $controls );
}

add_action( 'tatsu_register_modules', 'tatsu_register_text_with_shortcodes');
function tatsu_register_text_with_shortcodes() {
		$controls = array (
	        'icon' => TATSU_PLUGIN_URL.'/builder/svg/modules.svg#text',
	        'title' => __( 'Shortcode Editor', 'tatsu' ),
	        'is_js_dependant' => false,
	        'child_module' => '',
	        'type' => 'single',
	        'is_built_in' => false,
	        'atts' => array (
	            array (
	        		'att_name' => 'content',
	        		'type' => 'tinymce',
	        		'label' => __( 'Shortcode', 'tatsu' ),
	        		'default' => '',
	        		'tooltip' => ''
 	        	),	
	        ),
	        'presets' => array(
	        	'default' => array(
	        		'title' => '',
	        		'image' => '',
	        		'preset' => array(
	        			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s',
	        		),
	        	)
	        ),	        
	    );
	tatsu_register_module( 'tatsu_text_with_shortcodes', $controls );
}
?>