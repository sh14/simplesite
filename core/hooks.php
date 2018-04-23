<?php
/**
 * User: sh14ru
 * Date: 19.04.18
 */

/**
 * Add action to setted hook
 *
 * @param $action
 * @param $function
 */
function add_action( $action, $function ) {
	global $global_actions;

	if ( ! empty( $action ) && ! empty( $function ) ) {
		if ( empty( $global_actions[ $action ] ) ) {
			$global_actions[ $action ] = array();
		}

		// добавление названия функции в глобальную переменную
		$global_actions[ $action ][] = $function;
	}
}

/**
 * Execute an action Вызов функций по которые запускаются по указанному хуку
 *
 * @param $action
 */
function do_action( $action ) {
	global $global_actions;

	if ( ! empty( $action ) && ! empty( $global_actions[ $action ] ) ) {
		foreach ( $global_actions[ $action ] as $name ) {

			// вызов функции, название которой содержится в переменной $name
			$name();
		}
	}
}


function add_filter( $action, $function ) {
	global $global_filters;

	if ( ! empty( $action ) && ! empty( $function ) ) {
		if ( empty( $global_filters[ $action ] ) ) {
			$global_filters[ $action ] = array();
		}

		// добавление названия функции в глобальную переменную
		$global_filters[ $action ][] = $function;
	}
}

/**
 * Filter a given value
 *
 * @param $filter
 * @param $value
 */
function apply_filters( $filter, $value ) {
	global $global_filters;

	if ( ! empty( $filter ) ) {
		if ( isset( $value ) ) {

			// set filter value
			$global_filters[ $filter ] = $value;
		} else {
			$global_filters[ $filter ] = null;
		}
	}

	return $global_filters[ $filter ];
}

