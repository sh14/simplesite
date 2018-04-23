<?php
/**
 * User: sh14ru
 * Date: 19.04.18
 */

/**
 * Parse given array with default data
 *
 * @param $atts
 * @param $defaults
 */
function parse_args( $atts, $defaults ) {
	foreach ( $defaults as $key => $value ) {
		if ( ! isset( $atts[ $key ] ) ) {
			$atts[ $key ] = $defaults[ $key ];
		}
	}

	return $atts;
}



// eof
