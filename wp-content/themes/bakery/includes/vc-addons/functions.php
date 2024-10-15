<?php if ( ! defined( 'ABSPATH' ) ) exit();

if ( ! function_exists( 'bakery_parse_multi_attribute' ) ){
	function bakery_parse_multi_attribute( $value, $default = array() ) {
		$result = $default;
		$params_pairs = explode( '|', $value );

		if ( ! empty( $params_pairs ) ) {
			foreach ( $params_pairs as $pair ) {
				$param = preg_split( '/\:/', $pair );
				if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
					$result[ $param[0] ] = rawurldecode( $param[1] );
				}
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'vc_build_link' ) ){
	function vc_build_link( $value ) {
		return bakery_parse_multi_attribute( $value, array( 'url' => '', 'title' => '', 'target' => '' ) );
	}
}
