<?php

if (strtolower($_SERVER['SERVER_NAME'])=='localhost') {

	define("K_HOSTNAME", "127.0.0.1");
	define("K_PORT", "3306");
	define("K_USERNAME", "darpep");
	define("K_PASSWORD", "reserv123");
	define("K_DB", "biobarica");

	define("K_DEBUG", "true");
	define("K_SHOW_REQUEST", false);

}elseif (strtolower($_SERVER['SERVER_NAME'])=='dis.dev.biobarica.com') {
	
	define("K_HOSTNAME", "127.0.0.1");
	define("K_PORT", "3306");
	define("K_USERNAME", "dispositivo");
	define("K_PASSWORD", "biodev@@2017");
	define("K_DB", "dispositivo");

	define("K_DEBUG", "true");
	define("K_SHOW_REQUEST", false);
}


?>
