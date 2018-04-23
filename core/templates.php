<?php
/**
 * User: sh14ru
 * Date: 19.04.18
 */

/**
 * Gets attributes for the html tag.
 *
 * @param $atts
 *
 * @return string
 */
function get_html_attributes( $atts = array() ) {
	$atts = parse_args( $atts, array(
		'lang' => 'ru',
		'dir'  => '',
	) );

	$attributes = array();

	foreach ( $atts as $key => $value ) {
		if ( ! empty( $value ) ) {
			$attributes[] = $key . '="' . htmlspecialchars( $value ) . '"';
		}
	}

	$output = implode( ' ', $attributes );

	return $output;
}

/**
 * Функция подключения шаблона или его возврата в виде строки
 *
 * @param       $name
 * @param array $atts
 *
 * @return bool|string
 */
function get_template_part( $name, $atts = array() ) {

	$template_path   = array();
	$template_path[] = get_root_path() . 'content/themes/' . options('theme_name') . '/' . $name . '.php';
	$template_path = apply_filters( 'template_path', $template_path );
	foreach ( $template_path as $path ) {
		if ( file_exists( $path ) ) {

			ob_start();
			include $path;
			$content = ob_get_contents();
			ob_end_clean();

			return $content;
		}
	}

	return 'No such file founded.';
}

// eof
