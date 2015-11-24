<?php
define( 'ROOT_PATH', realpath( dirname( __FILE__ ) ) ) ;

	function __autoload($class_name) {
		require_once ROOT_PATH . '/lib/'.$class_name .'.php';  
	}

	require_once(ROOT_PATH . '/configuration/identification.php');
	require_once(ROOT_PATH . '/configuration/options.php');
	require_once(ROOT_PATH . '/lib/lib_debug.php');
?>