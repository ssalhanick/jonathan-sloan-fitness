<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_To_Tatsu_Rest_Api {

	private static $instance;
	private $namespace;
	public static function getInstance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
 
        return self::$instance;		
	}

	private function __construct() {
		$this->namespace = 'be-to-tatsu';
	}

	public function register_rest_routes() {
	    register_rest_route( 
	    	$this->namespace.'/v1', 
	    	'/convert/', 
	    	array(
		        'methods'  => 'POST',
		        'callback' => array( $this, 'convert_to_tatsu' )
	  		) 
	    );	    
	} 

	public function convert_to_tatsu( WP_REST_Request $request ) {
		$post_id = $request->get_param('post_id');
		$be_pb_content = get_post_meta( $post_id, '_be_pb_content', true );
		$post = get_post( $post_id, 'ARRAY_A');
		$data = array();
		$data['title'] = $post['post_title'];
		$data['type'] = ucfirst( $post['post_type'] );
		$parser = new Be_To_Tatsu_Parser( $be_pb_content );
		$tatsu_content = $parser->get_tatsu_page_content();

		$post_content = $this->shortcodes_from_tatsu_content( json_decode( $tatsu_content, true ) );

		$save_tatsu_content = update_post_meta( $post_id, '_tatsu_page_content', wp_slash( $tatsu_content ) );
		$my_post = array(
	    	'ID' => $post_id,
	    	'post_content' => $post_content,
		);
		// Update the post into the database
		$save_post_content = wp_update_post( $my_post );

		if( $save_post_content ) {
			//update_post_meta( $post_id, '_be_pb_disable', 'yes' );
			update_post_meta( $post_id, '_edited_with', 'tatsu' );
			wp_send_json_success( $data );
		} else {
			wp_send_json_error( $data );
		}		    
	}

	private function shortcodes_from_tatsu_content( $inner ) {
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
				$new_content .= $this->shortcodes_from_tatsu_content( $module['inner'] );
			} else {
				if( array_key_exists( 'content', $module['atts'] ) ) {
					$new_content .=	shortcode_unautop( stripslashes_deep( $module['atts']['content'] ) );
				}
			}
			$new_content .= '[/'.$module["name"].']';
		}
		return $new_content;		
	}


}

?>