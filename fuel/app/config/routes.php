<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route

	//追加ルーティンング
	'index' => 'index',
	'signup' => 'signup',
	'login' => 'login',
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);
