<?php
/*
{
  "PATH_ROOT": "\\/var\\/www\\/html\\/php\\/",
  "PATH_HTTP": "http:\\/\\/localhost/php/pro-music-manager\\/",
  "APP_DIRECTORY": "php/pro-music-manager",
  "APP_NAME": "Pro Music Manager",
  "DB_USER": "phpmyadmin",
  "DB_PASSWORD", "boss",
  "DB_HOST, "",
  "DB_DATABASE", "musicmanager",
  "path_file": "\\/var\\/www\\/html\\/php\\/pro-music-manager\\/",
  "path_app": "\\/var\\/www\\/html\\/php\\/pro-music-manager\\/_application\\/",
  "PATH_LIB": "\\/var\\/www\\/html\\/php\\/pro-music-manager\\/App\\/Lib\\/",
  "path_classes": "\\/var\\/www\\/html\\/php\\/pro-music-manager\\/App\\/Classes\\/",
  "path_controllers": "\\/var\\/www\\/html\\/php\\/pro-music-manager\\/App\\/Controller\\/",
  "path_views": "\\/var\\/www\\/html\\/php\\/pro-music-manager\\/App\\/Views\\/",
  "path_css": "http:\\/\\/localhost/php/pro-music-manager\\/_application\\/css\\/",
  "path_js": "http:\\/\\/localhost/php/pro-music-manager\\/_application\\/js\\/",
  "path_images": "http:\\/\\/localhost/php/pro-music-manager\\/_application\\/images\\/"
}*/


define('PATH_ROOT', '/var/www/html/php/');

define('APP_NAME', 'Pro Music Manager');
define('APP_DIRECTORY', 'pro-music-manager');

define('PATH_APP', PATH_ROOT.APP_DIRECTORY.'/');

define('WITH_COMPOSER',true);


if (WITH_COMPOSER) {
	define('VENDOR_DIRECTORY', 'vendor');
	define('PATH_VENDOR', PATH_APP.VENDOR_DIRECTORY.'/');
	define('PATH_CORE', PATH_VENDOR.'tamu-lib/pipit/');
} else {
	define('PATH_CORE', PATH_ROOT.'Pipit/');
}

define('PATH_HTTP', "http://localhost/php/".APP_DIRECTORY."/");

define("SESSION_SCOPE",APP_DIRECTORY);

define("NAMESPACE_CORE","Core\\");
define("NAMESPACE_APP","App\\");

define('PATH_CONFIG', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Config/");
define('PATH_LIB', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Lib/");
define('PATH_CORE_LIB', PATH_CORE.str_replace('\\', '/', NAMESPACE_CORE)."Lib/");
define('PATH_CONTROLLERS', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Controllers/");
define('PATH_VIEWS', PATH_APP.str_replace('\\', '/', NAMESPACE_APP)."Views/");

define('PATH_RESOURCES', PATH_HTTP."assets/");
define('PATH_THEMES', PATH_RESOURCES."themes/");
define('PATH_CSS', PATH_RESOURCES."css/");
define('PATH_JS', PATH_RESOURCES."js/");
define('PATH_IMAGES', PATH_RESOURCES."images/");



define('DB_USER', 'phpmyadmin');
define('DB_PASSWORD', 'boss');
define('DB_HOST', '');
define('DB_DATABASE', 'musicmanager');

define("DB_DSN", 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE);

define('DB_DEBUG', false);

define("LOG_LEVEL",3);

//define('LOADER_CLASS','AppLoader');

//define('SITE_CLASS','Site');

//define('VIEW_RENDERER','AppViewRenderer');

define('USER_CLASS','User');

define('ACTIVE_THEME','html');

define('SECURITY_PUBLIC',-1);
define('SECURITY_USER',0);
define('SECURITY_ADMIN',1);

/*
$configFile = dirname(__FILE__)."/config.json";
if (is_file($configFile)) {
	$configValues = json_decode(file_get_contents($configFile),true);
    foreach ($configValues as $key => $val) {
        \define($key, $val);
    }

	unset($configFile);
} else {
	echo "Couldn't find the config file!";
	die();
}*/
?>