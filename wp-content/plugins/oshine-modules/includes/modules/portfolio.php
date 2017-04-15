<?php
/**************************************
			PORTFOLIO
**************************************/
if (!function_exists('be_portfolio')) {
	function be_portfolio( $atts ) {
		global $be_themes_data;
		extract( shortcode_atts( array (
			'col' => 'three',
			'gutter_style' => 'style1',
			'gutter_width' => 40,
	        'show_filters' => '1',
	        'tax_name' => 'portfolio_categories',
	        'filter' => 'categories',        
	        'category' => '',
	        'items_per_page' => '-1',
			'masonry' => '0',
			'gallery' => '0',
			'pagination' => 'none',
			'initial_load_style' => 'none',
			'item_parallax' => 0,
			'hover_style' => 'style1-hover',
			'title_alignment_static' => '',
			'overlay_color' => $be_themes_data['color_scheme'],
			'gradient_color' => $be_themes_data['color_scheme'],
			'gradient' => '0',
			'gradient_direction' => 'bottom',
			'overlay_opacity' => '85',
			'show_overlay' => '',
			'title_style' => 'style1',
			'title_color' => '',
			'cat_color' => '',
			'cat_hide' => 0,
			'default_image_style' => 'color',
			'hover_image_style' => 'color',
			'title_animation_type' => 'none',
			'cat_animation_type' => 'none',
			'image_effect' => 'none',
			'like_button' => 0,
	    ) , $atts ) );
		$output = $global_thumb_overlay_color = $thumb_overlay_color = $global_gradient_style_color = $gradient_style_color = '';
		$col = ((!isset($col)) || empty($col)) ? 'three' : $col;
		$gutter_style = ((!isset($gutter_style)) || empty($gutter_style)) ? 'style1' : $gutter_style;
		$gutter_width = ( isset( $gutter_width ) ) ? intval( $gutter_width ) : intval(40);
		$masonry_enable = ((!isset($masonry)) || empty($masonry)) ? 'masonry_disable' : 'masonry_enable';
		$show_filters = ( !empty( $show_filters ) ) ? 'yes' : 'no';
		$tax_name = ((!isset($tax_name)) || empty($tax_name)) ? 'portfolio_categories' : $tax_name;
		$filter_to_use = ((!isset($filter)) || empty($filter)) ? 'categories' : $filter;
		$items_per_page = ((!isset($items_per_page)) || empty($items_per_page)) ? '-1' : $items_per_page;
		$pagination = ((!isset($pagination)) || empty($pagination)) ? 'none' : $pagination;
		$default_image_style = ((!isset($default_image_style)) || empty($default_image_style)) ? 'color' : $default_image_style;
		$hover_image_style = ((!isset($hover_image_style)) || empty($hover_image_style)) ? 'color' : $hover_image_style;
		$title_animation_type = ((!isset($title_animation_type)) || empty($title_animation_type)) ? 'none' : $title_animation_type;
		$cat_animation_type = ((!isset($cat_animation_type)) || empty($cat_animation_type)) ? 'none' : $cat_animation_type;
		$image_effect = ((!isset($image_effect)) || empty($image_effect)) ? 'none' : $image_effect;
		$initial_load_style = ((!isset($initial_load_style)) || empty($initial_load_style)) ? 'none' : $initial_load_style;
		$gradient_direction = ((!isset($gradient_direction)) || empty($gradient_direction)) ? 'bottom' : $gradient_direction;
		$global_title_color = $title_color = (isset($title_color) && !empty($title_color)) ? $title_color : '';
		$global_cat_color = $cat_color = (isset($cat_color) && !empty($cat_color)) ? $cat_color : '';
		$cat_hide = (isset($cat_hide) && !empty($cat_hide) && intval($cat_hide) != 0) ? $cat_hide : 0;
		$item_parallax = (isset($item_parallax) && !empty($item_parallax) && intval($item_parallax) != 0) ? 'portfolio-item-parallax' : '';
		$show_overlay = ( !empty( $show_overlay ) ) ? 'force-show-thumb-overlay' : '';
		$hover_style = ((!isset($hover_style)) || empty($hover_style) )  ? 'style1-hover' : $hover_style;
		$hover_style = (($show_overlay == 'force-show-thumb-overlay') || ($title_style == 'style5') || ($title_style == 'style6') || ($title_style == 'style7')) ? '' : $hover_style;
		$filter_style = (isset($be_themes_data['portfolio_filter_style']) && !empty($be_themes_data['portfolio_filter_style']) ) ? $be_themes_data['portfolio_filter_style'] : 'border' ;
		$filter_alignment = (isset($be_themes_data['portfolio_filter_alignment']) && !empty($be_themes_data['portfolio_filter_alignment']) ) ? $be_themes_data['portfolio_filter_alignment'] : 'center' ;

		if($show_overlay != ''){
			$title_animation_type = 'none';
			$cat_animation_type = 'none';
			// $initial_load_style = 'none';
		}

		if(isset($title_alignment_static) && !empty($title_alignment_static) && ($title_style == 'style5' || $title_style == 'style6')) {
			$title_alignment_static = 'text-align: '.$title_alignment_static.';';
		} else {
			$title_alignment_static = '';
		}
		if($default_image_style == 'black_white') {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'bw_to_bw';
			} else {
				$img_grayscale = 'bw_to_c';
			}
		} else {
			if($hover_image_style == 'black_white') {
				$img_grayscale = 'c_to_bw';
			} else {
				$img_grayscale = 'c_to_c';
			}
		}
		if($gutter_style == 'style2') {
			$portfolio_wrap_style = 'style="margin-left: -'.$gutter_width.'px;"';
		} else {
			$portfolio_wrap_style = 'style="margin-right: '.$gutter_width.'px;"';
		}
		if(isset($overlay_opacity) && !empty($overlay_opacity)) {
			$global_overlay_opacity = $overlay_opacity = $overlay_opacity;
		} else {
			$global_overlay_opacity = $overlay_opacity = 85;
		}
		if(isset($overlay_color) && !empty($overlay_color)) {
			if($gradient) {
				if(!isset($gradient_color) && empty($gradient_color)) {
					$gradient_color = $overlay_color;
				} 
				$global_gradient_style_color = $gradient_style_color = 'background-image: -o-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -moz-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -webkit-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: -ms-linear-gradient('.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);background-image: linear-gradient(to '.$gradient_direction.', '.$overlay_color.' 0%, '.$gradient_color.' 100%);';
			} else {
				$global_gradient_style_color = $gradient_style_color = 'background:'.$overlay_color;
			}
		}
		$output .= '<div class="portfolio-all-wrap oshine-portfolio-module"><div class="portfolio full-screen full-screen-gutter '.$masonry_enable.' '.$gutter_style.'-gutter '.$col.'-col" data-action="get_ajax_full_screen_gutter_portfolio" data-category="'.$category.'" data-enable-masonry="'.$masonry.'" data-showposts="'.$items_per_page.'" data-paged="2" data-col="'.$col.'" data-gallery="'.$gallery.'" data-filter="'.$filter_to_use.'" data-show_filters="'.$show_filters.'" data-thumbnail-bg-color="'.$global_thumb_overlay_color.'" data-thumbnail-bg-gradient="'.$gradient_style_color.'" data-title-style="'.$title_style.'" data-cat-color="'.$cat_color.'" data-title-color="'.$title_color.'" data-title-animation-type="'.$title_animation_type.'" data-cat-animation-type="'.$cat_animation_type.'" data-hover-style="'.$hover_style.'" data-gutter-width="'.$gutter_width.'" data-img-grayscale="'.$img_grayscale.'" data-image-effect="'.$image_effect.'" data-gradient-style-color="'.$global_gradient_style_color.'" data-cat-hide="'.$cat_hide.'" data-like-indicator="'.$like_button.'" '.$portfolio_wrap_style.'>';
		$category = explode(',', $category);
		
		if($filter_to_use == 'portfolio_tags' || empty( $category ) ) {
			// $terms = get_terms( $filter_to_use , array( 'orderby' => 'count' , 'order' => 'DESC') );
			$terms = get_terms( $filter_to_use );
		} else {
	 	 	$args_cat = array( 'taxonomy' => 'portfolio_categories' ) ;
	 	 	
			$stack = array();
			foreach(get_categories( $args_cat ) as $single_category ) {
				if ( in_array( $single_category->slug, $category ) ) {
					array_push( $stack, $single_category->cat_ID );
				}
			}

			// $terms = get_terms($filter_to_use, array( 'orderby' => 'count' , 'order' => 'DESC', 'include' => $stack) );
			$terms = get_terms($filter_to_use, array( 'include' => $stack) );
		}
		// var_dump($terms);
	    if(!empty( $terms ) && $show_filters == 'yes') {
	    	if($gutter_style == 'style2') {
				$portfolio_filter_style = 'style="margin-left: '.$gutter_width.'px;"';
			} else {
				$portfolio_filter_style = '';
			} 
		    $output .= '<div class="filters clearfix '.$filter_style.' align-'.$filter_alignment.'" '.$portfolio_filter_style.'>';
	    	$output .= '<div class="filter_item"><span class="sort current_choice" data-id="element">'.__( 'All', 'oshine-modules' ).'</span></div>';
	    	foreach ($terms as $term) {
	    		if( is_object( $term ) ) {
		    		$output .= '<div class="filter_item">';    		
		    		$output .= '<span class="sort" data-id="'.$term->slug.'">'.$term->name.'</span>';		
		    		$output .= '</div>';
		    	}
	    	}
	    	$output .= '</div>';
		}
		$output .= '<div class="portfolio-container clickable clearfix portfolio-shortcode '.$show_overlay.' '.$initial_load_style.' '.$item_parallax.'">';
		if( empty( $category[0] ) ) {
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'orderby'=> apply_filters('be_portfolio_order_by','date'),
				'order'=> apply_filters('be_portfolio_order','DESC'),
				'post_status'=> 'publish'
			);
		} else {
			$args = array (
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'orderby'=> apply_filters('be_portfolio_order_by','date'),
				'order'=> apply_filters('be_portfolio_order','DESC'),
				'post_status'=> 'publish',
				'tax_query' => array (
					array (
						'taxonomy' => $tax_name,
						'field' => 'slug',
						'terms' => $category,
						'operator' => 'IN',
					),
				),
			);	
		}
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				if ( has_post_thumbnail( get_the_ID() ) ) :
					$filter_classes = $permalink = '';
					$mfp_class = 'mfp-image';
					$post_terms = get_the_terms( get_the_ID(), $filter_to_use );
					if( $show_filters == 'yes' && is_array( $post_terms ) ) {
						foreach ( $post_terms as  $term ) {
							$filter_classes .=$term->slug." ";
						}
					} else{
						$filter_classes='';
					}
					$attachment_id = get_post_thumbnail_id(get_the_ID());
					$image_atts = get_portfolio_image(get_the_ID(), $col, $masonry);
					$attachment_thumb = wp_get_attachment_image_src( $attachment_id, $image_atts['size']);
					$attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
					$attachment_thumb_url = $attachment_thumb[0];
					$attachment_full_url = $attachment_full[0];
					$video_url = get_post_meta( $attachment_id, 'be_themes_featured_video_url', true );
					$visit_site_url = get_post_meta( get_the_ID(), 'be_themes_portfolio_external_url', true );
					$link_to = get_post_meta( get_the_ID(), 'be_themes_portfolio_link_to', true );
					$open_with = get_post_meta( get_the_ID(), 'be_themes_portfolio_single_page_style', true );
					$single_overlay_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color', true );
					$single_overlay_opacity = get_post_meta( get_the_ID(), 'be_themes_single_overlay_color_opacity', true );
					$single_title_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_title_color', true );
					$single_cat_color = get_post_meta( get_the_ID(), 'be_themes_single_overlay_cat_color', true );
					$attachment_info = be_wp_get_attachment($attachment_id);
					if(!isset($visit_site_url) || empty($visit_site_url)) {
						$visit_site_url = '#';
					}
					$permalink = ( $link_to == 'external_url' ) ? $visit_site_url : get_permalink();
					//$target = ( $link_to == 'external_url' ) ? 'target="_blank"' : '';
					$target = ("1" == get_post_meta( get_the_ID(), 'be_themes_portfolio_open_new_tab', true )) ? 'target="_blank"' : '';
					if(isset($single_overlay_opacity) && !empty($single_overlay_opacity)) {
						$overlay_opacity = $single_overlay_opacity;
					} else {
						$overlay_opacity = 85;
					}
					if(isset($single_overlay_color) && !empty($single_overlay_color)) {
						$single_overlay_color = be_themes_hexa_to_rgb( $single_overlay_color );
						$thumb_overlay_color = 'rgba('.$single_overlay_color[0].','.$single_overlay_color[1].','.$single_overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';
						$gradient_style_color = '';
					} else {
						$thumb_overlay_color = $global_thumb_overlay_color;
						$gradient_style_color = $global_gradient_style_color;
					}
					if(isset($single_title_color) && !empty($single_title_color)) {
						$title_color = $single_title_color;
					} else {
						$title_color = $global_title_color;
					}
					if(isset($single_cat_color) && !empty($single_cat_color)) {
						$cat_color = $single_cat_color;
					} else {
						$cat_color = $global_cat_color;
					}

					if(!empty( $video_url ) ) {
						$attachment_full_url = $video_url;
						$mfp_class = 'mfp-iframe';
					}
					if( ( $link_to != 'external_url' ) && isset($open_with) && $open_with == 'lightbox-gallery') {
						$thumb_class = 'be-lightbox-gallery';
					} else if( ( $link_to != 'external_url' ) && isset($open_with) && $open_with == 'lightbox') {
						$thumb_class = 'single-image';
					} else if( ( $link_to != 'external_url' ) && isset($open_with) && $open_with == 'none') {
						$thumb_class = 'no-link';
						$attachment_full_url = '#';
					} else {
						$thumb_class = '';
						$mfp_class = '';
						$attachment_full_url = $permalink;
					}
					if($title_style == 'style5' || $title_style == 'style6') {
						$trigger_animation  = '';
					} else {
						$trigger_animation  = 'animation-trigger';
					}
					$output .= '<div class="element be-hoverlay '.$filter_classes.' '.$image_atts['class'].' '.$image_atts['alt_class'].' '.$hover_style.' '.$img_grayscale.' '.$title_style.'-title" style="margin-bottom: '.$gutter_width.'px;">';
					$output .= '<div class="element-inner" style="margin-left: '.$gutter_width.'px;">';
					$output .= '<a href="'.$attachment_full_url.'" class=" thumb-wrap '.$thumb_class.' '.$mfp_class.'" title="'.$attachment_info['title'].'" '.$target.'>';
					$output .= '<div class="flip-wrap" ><div class="flip-img-wrap '.$image_effect.'-effect"><img src="'.$attachment_thumb_url.'" alt="'.$attachment_info['alt'].'" /></div></div>';
					$output .= '<div class="thumb-overlay "><div class="thumb-bg " style="background-color:'.$thumb_overlay_color.'; '.$gradient_style_color.'">';
					$output .= '<div class="thumb-title-wrap ">';
					$output .= '<div class="thumb-title animated '.$trigger_animation.'" data-animation-type="'.$title_animation_type.'" style="color: '.$title_color.'; '.$title_alignment_static.'">'.get_the_title().'</div>';
					$terms = be_themes_get_taxonomies_by_id(get_the_ID(), 'portfolio_categories');
					if(!empty($terms) && (isset($cat_hide) && !($cat_hide) ) ) {	
						$output .= '<div class="portfolio-item-cats animated '.$trigger_animation.'" data-animation-type="'.$cat_animation_type.'" style="color: '.$cat_color.'; '.$title_alignment_static.'">';
						$length = 1;
						foreach ($terms as $term) {
							if( is_object($term) ) {
								$output .= '<span>'.$term->name.'</span>';
								if(count($terms) != $length) {
									$output .= '<span> &middot; </span>';
								}
							}
							$length++;
						}
						$output .= '</div>';
					}
					$output .= '</div>';
					$output .= '</div></div>'; //End Thumb Bg & Thumb Overlay
					$output .= '</a>'; //End Thumb Wrap
					if(isset($open_with) && $open_with == 'lightbox-gallery') :
						$output .='<div class="popup-gallery">';
						$attachments = get_post_meta(get_the_ID(),'be_themes_single_portfolio_slider_images');
						if(!empty($attachments)) {
							foreach ( $attachments as $attachment_id ) {
								$attach_img = wp_get_attachment_image_src($attachment_id, 'full');
								$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
								$attachment_info = be_wp_get_attachment($attachment_id);
								if($video_url) {
									$url = $video_url;
									$mfp_class = 'mfp-iframe';
								} else {
									$url = $attach_img[0];
									$mfp_class ='mfp-image';
								}
								$output .='<a href="'.$url.'" class="'.$mfp_class.'" title="'.$attachment_info['title'].'"></a>';
							}
						}
						$output .= '</div>'; //End Gallery
					endif;
					$output .= ($like_button != 1) ? '<div class="like-button-wrap">'.be_get_like_button(get_the_ID()).'</div>' : '';
					$output .= '</div>'; //End Element Inner
					$output .= '</div>'; //End Element
				endif;	
			endwhile;
		endif;
		wp_reset_postdata();
		$output .='</div>'; //end portfolio-container
		if('-1' != $items_per_page && ($the_query->found_posts-$items_per_page)>0) {
			$items_initial_load = $items_per_page;
			if( $pagination == 'infinite' ) {
				$output .='<div class="trigger_infinite_scroll portfolio_infinite_scroll" data-type="portfolio"></div>';
			} elseif( $pagination == 'loadmore' ) {
				$output .='<div class="trigger_load_more portfolio_load_more" data-total-items="'.($the_query->found_posts-$items_initial_load).'" data-type="portfolio"><a class="be-shortcode mediumbtn be-button tatsu-button alt-bg alt-bg-text-color" href="#">'.__( 'Load More', 'oshine-modules' ).'</a></div>';
			}
		}
		$output .='</div></div>'; //end portfolio
		return $output;
	}
	add_shortcode( 'portfolio' , 'be_portfolio' );
}
?>