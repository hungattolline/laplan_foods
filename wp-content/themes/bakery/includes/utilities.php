<?php if ( ! defined( 'ABSPATH' ) ) exit();

// Check if string starts with
if ( ! function_exists( 'bakery_string_starts_with' ) ) {
	function bakery_string_starts_with( $haystack, $needle ) {
		$length = strlen( $needle );

		return ( substr( $haystack, 0, $length ) === $needle );
	}
}

// Check if string ends with
if ( ! function_exists( 'bakery_string_start_with' ) ) {
	function bakery_string_ends_with( $haystack, $needle ) {
		$length = strlen( $needle );

		return $length === 0 || ( substr( $haystack, -$length ) === $needle );
	}
}

// Convert Color from HEX to RGB
if ( ! function_exists( 'bakery_hex2rgb' ) ) {
	function bakery_hex2rgb( $color, $string = false ) {
		if ( empty( $color ) ) {
			return;
		}

		if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		if ( strlen( $color ) == 6 ) {
			list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return false;
		}

		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );

		if ( $string == true ) {
			return $r . ',' . $g . ',' . $b;
		} else {
			return array( 'red' => $r, 'green' => $g, 'blue' => $b );
		}
	}
}

// Convert Color from RGB to HEX
if ( ! function_exists( 'bakery_rgb2hex' ) ) {
	function bakery_rgb2hex( $r, $g = -1, $b = -1 ) {
		if ( is_array( $r ) && sizeof( $r ) == 3 ) {
			list( $r, $g, $b ) = $r;
		}

		$r = intval( $r ); $g = intval( $g );
		$b = intval( $b );

		$r = dechex( $r < 0 ? 0 : ( $r > 255 ? 255 : $r ) );
		$g = dechex( $g < 0 ? 0 : ( $g > 255 ? 255 : $g ) );
		$b = dechex( $b < 0 ? 0 : ( $b > 255 ? 255 : $b ) );

		$color = ( strlen( $r ) < 2 ? '0' : '' ) . $r;
		$color .= ( strlen( $g ) < 2 ? '0' : '' ) . $g;
		$color .= ( strlen( $b ) < 2 ? '0' : '' ) . $b;

		return '#' . $color;
	}
}

// Compress the CSS
if ( ! function_exists( 'bakery_css_compress' ) ) {
	//https://github.com/matthiasmullie/minify/blob/master/src/CSS.php
	function bakery_css_compress($content) {
		$before = '(?<=[:(, ])';
		$after = '(?=[ ,);}])';
		$units = '(em|ex|%|px|cm|mm|in|pt|pc|ch|rem|vh|vw|vmin|vmax|vm)';

		$content = preg_replace( '/' . $before . '(-?0*(\.0+)?)(?<=0)' . $units . $after . '/', '\\1', $content );
		$content = preg_replace( '/' . $before . '\.0+' . $after . '/', '0', $content );
		$content = preg_replace( '/' . $before . '(-?[0-9]+)\.0+' . $units . '?' . $after . '/', '\\1\\2', $content );
		$content = preg_replace( '/' . $before . '-?0+' . $after . '/', '0', $content);

		$content = preg_replace( '/(?<![\'"])#([0-9a-z])\\1([0-9a-z])\\2([0-9a-z])\\3(?![\'"])/i', '#$1$2$3', $content );

		$content = preg_replace( '/\/\*.*?\*\//s', '', $content );

		$content = preg_replace( '/^\s*/m', '', $content );
		$content = preg_replace( '/\s*$/m', '', $content );

		$content = preg_replace( '/\s+/', ' ', $content );

		$content = preg_replace( '/\s*([\*$~^|]?+=|[{};,>~]|!important\b)\s*/', '$1', $content );
		$content = preg_replace( '/([\[(:])\s+/', '$1', $content );
		$content = preg_replace( '/\s+([\]\)])/', '$1', $content );
		$content = preg_replace( '/\s+(:)(?![^\}]*\{)/', '$1', $content );

		$content = preg_replace( '/\s*([+-])\s*(?=[^}]*{)/', '$1', $content );

		$content = preg_replace( '/;}/', '}', $content );

		return trim( $content );
	}
}
