<?php
function menu_array() {
	$menu = array(
		'main'  => array(
			'order'       => 10,
			'title'       => 'Главная',
			'description' => '',
			'hidden'      => false,
			'type'      => 'public',
		),
		'about' => array(
			'order'       => 20,
			'title'       => 'О сайте',
			'description' => '',
			'hidden'      => false,
			'type'      => 'public',
		),
		'404'   => array(
			'order'       => 30,
			'title'       => 'Ошибка 404',
			'description' => '',
			'hidden'      => false,
			'type'      => 'staff',
		),

	);

	return $menu;
}
