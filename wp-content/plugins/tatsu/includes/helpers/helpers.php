<?php

function tatsu_add_shortcode_content( $inner ) {
	  $new_content = array();
	  if( !is_array( $inner ) ) {
	  	return $new_content;
	  }
	  foreach ( $inner as $module ) {
	  	$type = Tatsu_Module_Options::getInstance()->get_module_type( $module['name'] );
	    if( $type == 'single' || $type == 'multi'  ) {
    		$tatsu_module = new Tatsu_Module( $module['name'], $module['atts'], $module['atts']['content'] );
	    	$module['shortcode_output'] = $tatsu_module->do_shortcode();
	    }
	    if( array_key_exists('inner', $module) && is_array( $module['inner'] ) ) {
	      $new_inner = tatsu_add_shortcode_content( $module['inner'] );
	      $module['inner'] = $new_inner;
	    }
	    array_push( $new_content, $module );
	  }
	  return $new_content;
}


function tatsu_shortcodes_from_content( $inner ) {
	$new_content = '';	
	if( !is_array( $inner ) ) {
		return $new_content;
	}
	foreach ( $inner as $module ) {
		$new_content .= '['.$module['name'];
		if( is_array( $module['atts'] ) ) {
			foreach ($module['atts'] as $att => $value) {
				if( 'content' !== $att ) {
					$new_content .= ' '.$att.'= "'.$value.'"';
				}
			}
		}
		$new_content .= ']';
		if( array_key_exists('inner', $module) && is_array( $module['inner'] ) && !empty( $module['inner'] ) ) {
			$new_content .= tatsu_shortcodes_from_content( $module['inner'] );
		} else {
			if( array_key_exists('content', $module['atts']) ) {
				$new_content .=	shortcode_unautop( stripslashes_deep( $module['atts']['content'] ) );
			}
		}
		$new_content .= '[/'.$module["name"].']';
	}
	return $new_content;		
}


function tatsu_validate_color( $color ) {
	if( preg_match( '/^(#(?:[A-Fa-f0-9]{3}){1,2}|(rgb[(](?:\s*0*(?:\d\d?(?:\.\d+)?(?:\s*%)?|\.\d+\s*%|100(?:\.0*)?\s*%|(?:1\d\d|2[0-4]\d|25[0-5])(?:\.\d+)?)\s*(?:,(?![)])|(?=[)]))){3}[)])|(rgba[(](?:\s*0*(?:\d\d?(?:\.\d+)?(?:\s*%)?|\.\d+\s*%|100(?:\.0*)?\s*%|(?:1\d\d|2[0-4]\d|25[0-5])(?:\.\d+)?)\s*,){3}\s*0*(?:\.\d+|1(?:\.0*)?)\s*[)]))$/i', $color ) ) {
		return true;
	}
	return false;
}


// function tatsu_edit_url( $post_id ) {
// 	return esc_url( add_query_arg( array( 'tatsu' => '1', 'id' => $post_id  ), get_permalink( $post_id ) ) );
// }

function tatsu_edit_url( $post_id ) {
	$tatsu_edit_url = add_query_arg( array( 'tatsu' => '1', 'id' => $post_id  ), get_permalink( $post_id ) );
	if ( defined( 'NGG_PLUGIN_VERSION' ) ) {
		$tatsu_edit_url = add_query_arg( 'display_gallery_iframe', '', $tatsu_edit_url );
	}
	$tatsu_edit_url = tatsu_protocol_based_urls( $tatsu_edit_url );
	return esc_url( $tatsu_edit_url );
}


function tatsu_get_image_from_url( $image_url, $size ) {
	global $wpdb;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts  WHERE guid = '%s';", $image_url ) );
	if( !empty( $attachment[0] ) ) {
		$image_thumb = wp_get_attachment_image_src( $attachment[0], $size );
		if( $image_thumb ) {
			return $image_thumb[0];
		} else {
			return $image_url;
		}
	} else {
		return $image_url;
	}
}

function tatsu_protocol_based_urls( $url ) {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
	return $protocol. str_replace( array( 'http:', 'https:' ), '', $url );
}

function tatsu_uniqid_base36($more_entropy=false) {
    $s = uniqid('', $more_entropy);
    if (!$more_entropy)
        return base_convert($s, 16, 36);
        
    $hex = substr($s, 0, 13);
    $dec = $s[13] . substr($s, 15); // skip the dot
    return base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
}

?>