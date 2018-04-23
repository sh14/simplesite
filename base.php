<?php
/**
 * User: sh14ru
 * Date: 19.04.18
 */


/**
 * Getting site root path
 *
 * @return string
 */
function get_root_path() {
	$path = stripcslashes( dirname( __FILE__ ) ) . '/';

	return $path;
}

/**
 * Getting site root url
 *
 * @return string
 */
function get_root_url() {
	$protocol = stripos( $_SERVER['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';

	// adding server port if it's not wmpty or not default
	$port = ! empty( $_SERVER['SERVER_PORT'] ) && $_SERVER['SERVER_PORT'] != 80 ? ':' . $_SERVER['SERVER_PORT'] : '';

	$url = $protocol . $_SERVER["SERVER_NAME"] . $port . dirname( $_SERVER["SCRIPT_NAME"] );

	// deleting last slash from url
	$url = preg_replace( '{/$}', '', $url );

	return $url;
}

require get_root_path() . 'conf.php';
require get_root_path() . 'core/variables.php';
require get_root_path() . 'core/common.php';
require get_root_path() . 'core/hooks.php';
require get_root_path() . 'core/templates.php';
require get_root_path() . 'core/functions.php';
_require( get_root_path() . 'menu.php' );

/**
 * If file exists then it will be included, if it has a function that has same name it could be executed.
 *
 * @param      $file
 * @param bool $return
 * @param bool $once
 *
 * @return bool
 */
function _require( $file, $return = false, $once = false ) {
	if ( file_exists( $file ) ) {

		if ( $once == false ) {
			require $file;
		} else {
			require_once $file;
		}

		if ( $return == true ) {

			// get file name without extention
			$func = pathinfo( $file, PATHINFO_FILENAME );

			// if function with same name as file exists
			if ( function_exists( $func ) ) {

				// execute and return function result
				return $func();
			}
		}

		return true;
	} else {
		return false;
	}
}

/**
 * Include a file if exists
 *
 * @param $file
 *
 * @return bool
 */
function _include( $file ) {
	if ( file_exists( $file ) ) {
		include $file;

		return true;
	} else {
		return false;
	}
}

/**
 *
 * @param string $what
 *
 * @return string
 */
function siteinfo( $what = '' ) {
	$options = options();
	if ( $what ) {
		switch ( $what ) {
			case 'theme_name':
				return $options['theme_name'];
			case 'theme_url':
				return get_root_url() . '/themes/' . $options['theme_name'] . '/';
			case 'theme_path':
				return get_root_path() . 'content/themes/' . $options['theme_name'] . '/';
			case 'path':
				return get_root_path();
			case 'url':
				return get_root_url();
		}
	}
}

function pr( $data, $debug_backtrace = false ) {

	if ( $debug_backtrace == true ) {
		echo '<pre><code>';
		var_dump( debug_backtrace() );
		echo '</pre></code><br/>';
	}
	switch ( $data ) {
		case is_bool( $data ):
			if ( $data === true ) {
				$data = 'true';
			} else {
				$data = 'false';
			}
			break;
		case ( is_array( $data ) || is_object( $data ) ):
			ob_start();
			print_r( (array) $data );
			$data = ob_get_contents();
			ob_clean();
			break;
	}

	echo '<pre><code>' . htmlspecialchars( $data ) . '</pre></code><br/>';
}


// eof
