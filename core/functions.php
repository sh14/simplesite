<?php
/**
 * User: sh14ru
 * Date: 19.04.18
 */

function options( $key = null ) {
	global $conf;
	$options = $conf;
	if ( empty( $key ) ) {
		return $options;
	} else {
		return $options[ $key ];
	}
}

function init() {
	do_action( 'init' );
}

function load_theme() {
	echo get_template_part( 'index' );
}

add_action( 'init', 'load_theme' );
/**
 * Get current page name
 *
 * @return string
 */
function page_name() {
	if ( ! empty( $_GET['p'] ) ) {
		$p = $_GET['p'];
	} else {
		$p = 'main';
	}

	return $p;
}


function site_menu( $atts = null ) // формирование меню для вывода на сайте
{
	if ( function_exists( 'menu_array' ) ) {
		$atts    = parse_args( $atts, array(
			'ul_class' => '',
			'li_class' => '',
		) );
		$menu    = menu_array(); // получаем данные меню
		$options = options();
		$out     = '';
		foreach ( $menu as $page => $key ) // начинаем перебор массива
		{
			// если файл не скрыт, если не из списка "неудаляемых", загружаем...
			if ( ! $key['hidden'] ) {
				if ( $page != 'main' || $options['permalink'] == 2 ) // если ссылка не на главную или включен лэндинг..
				{
					switch ( $options['permalink'] ) {
						case 0:
							$href = '?p=' . $page;
							break;
						case 1:
							$href = $page . '.html';
							break;
						case 2:
							$href = '#' . $page;
							break;
					}
				} else {
					$href = '';
				}
				$href = $options['site_url'] . $href;
				if ( page_name() == $page ) // определяем текущую страницу
				{
					$class = 'active';
				} else {
					$class = '';
				}
				$title = $key['title'];
				if ( ! $title ) {
					$title = $page;
				}
				$out .= '<li class="' . $atts['li_class'] . $class . '"><a href="' . $href . '">' . $title . '</a></li>';
			}
		}

		return '<ul class="' . $atts['ul_class'] . '">' . $out . '</ul>'; // возвращаем сформированную строку
	}

	return false;
}

/**
 * функция определяет какой файл подключить в части контента
 */
function page_load() {
	$ext          = '.php';
	$pathes       = array();
	$path         = siteinfo( 'path' ) . 'content/pages/';
	$path_default = siteinfo( 'path' ) . 'content/default/';

	// если не включен режим лендинга
	if ( options( 'permalink' ) != 2 ) {

		// получаем значение переменной из строки адреса
		$page     = page_name();
		$pathes[] = $path . $page . $ext;
		$pathes[] = $path_default . $page . $ext;
		$pathes[] = $path . '404' . $ext;
		$pathes[] = $path_default . '404' . $ext;

		$pathes = apply_filters( 'page_load', $pathes );

		foreach ( $pathes as $path ) {
			if ( _include( $path ) ) {
				return true;
			}
		}
	} else {
		// включен режим лендинга

		if ( function_exists( 'menu_array' ) ) {

			// получаем данные меню
			$menu = menu_array();

			// начинаем перебор массива
			foreach ( $menu as $key => $value ) {

				// if page is public
				if ( $value['type'] == 'public' ) {

					// если страница из темы не подгрузилась
					if ( ! _include( $path . $key . $ext ) ) {

						// подгружаем страницу из общего контента
						_include( $path_default . $key . $ext );
					}
				}
			}

			return true;
		} else {
			// меню не создано
		}
	}

	return false;
}


// eof
