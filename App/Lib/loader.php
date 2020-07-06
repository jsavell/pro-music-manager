<?php
namespace App\Lib;
use Core\Classes as CoreClasses;
use Core\Lib as CoreLib;

/**
*	App Loader - The entry point for the application. All endpoints lead, here.
*	Instantiates a Loader implementation and fires off the site load()
*
*	@author Jason Savell <jsavell@library.tamu.edu>
*
*/

require_once PATH_LIB."functions.php";

/**
*   This autoloader will search NAMESPACE_APP for a matching file containing the declaration of that class or interface.
*/
spl_autoload_register(function($class) {
    CoreLib\loadFile($class,NAMESPACE_APP,PATH_APP);
});

if (WITH_COMPOSER) {
	require PATH_VENDOR.'/autoload.php';
} else {
	require PATH_CORE_LIB.'/autoload.php';
}

require_once PATH_CONFIG.'config.dynamic.repositories.php';
require_once PATH_CONFIG.'config.pages.php';

$config = get_defined_constants(true)["user"];
if (!empty($sitePages)) {
	$config['sitePages'] = $sitePages;
	unset($sitePages);
}

if (!empty($GLOBALS[DYNAMIC_REPOSITORY_KEY])) {
	$config[DYNAMIC_REPOSITORY_KEY] = $GLOBALS[DYNAMIC_REPOSITORY_KEY];
	unset($GLOBALS[DYNAMIC_REPOSITORY_KEY]);
} else {
	$config[DYNAMIC_REPOSITORY_KEY] = null;
}

if (!empty($forceRedirectUrl)) {
	$config['forceRedirectUrl'] = $forceRedirectUrl;
	unset($forceRedirectUrl);
}

if (!empty($controllerConfig)) {
	$config['controllerConfig'] = $controllerConfig;
	unset($controllerConfig);
}

$logger = CoreLib\getLogger();

if (!empty($config['LOADER_CLASS'])) {
	$className = "{$config['NAMESPACE_APP']}Classes\\Loaders\\{$config['LOADER_CLASS']}";
	$siteLoader = new $className($config);
	$logger->debug("Using Configured Loader Class: {$className}");
} else {
	$siteLoader = new CoreClasses\Loaders\CoreLoader($config);
	$logger->debug("Using Default Loader Class: CoreLoader");
}
$siteLoader->load();
/*
session_start();
require_once "{$config['path_lib']}functions.php";
//don't recommend using, sanitizing in case someone does
$_SERVER['PHP_SELF'] = htmlentities($_SERVER['PHP_SELF']);
$globaluser = new user();

if (!isset($data)) {
	$data = $_REQUEST;
}

//initialize output var
$out = '';

//load admin controller if user is logged in and an admin page
if (isset($accesslevel) && ($accesslevel == 1)) {
	//if the user is an admin, load the admin controller, otherwise, redirect to the home page
	if ($globaluser->isAdmin()) {
		$app['path_http'] = "{$config['path_http']}admin/";
		if ($data['action']) {
			$filename = "{$config['path_controllers']}admin/{$data['action']}.control.php";
		} else {
			$filename = "{$config['path_controllers']}admin/default.control.php";
		}
	} else {
		header("Location:{$config['path_http']}");
	}
} elseif ($globaluser->isLoggedIn() || (isset($accesslevel) && $accesslevel == -1)) {
//load standard controller
	$app_http = "{$config['path_http']}{$controller}/";
	$filename = "{$config['path_controllers']}{$controller}.control.php";
}
//try to load the controller
if (!empty($filename) && is_file($filename)) {
	include $filename;
	//if the controller defined a $viewfile, try to load it
	if (isset($viewfile)) {
		if (isset($accesslevel) && ($accesslevel == 1)) {
			$viewpath = loadView($viewfile,$globaluser->isAdmin());
		} else {
			$viewpath = loadView($viewfile);
		}
		if (isset($viewpath)) {
			include $viewpath;
		} else {
			$system[] = 'Error loading view';
		}
	}
} elseif ($globaluser->isLoggedIn()) {
	$system[] = 'Error loading content';
} else {
	header("Location: {$config['path_http']}login.php");
}
//display the content
$pages = array(
			array("name"=>"tracks","path"=>"tracks"),
			array("name"=>"sales","path"=>"sales"),
			array("name"=>"libraries","path"=>"libraries"),
			array("name"=>"genres","path"=>"genres"));
if (!empty($data['json']) == 1) {
	header('Content-Type: application/json');
	echo $out;
} else {
	include "{$config['path_app']}layouts/header.lo.php";
	echo $out;
	include "{$config['path_app']}layouts/footer.lo.php";
}
*/
?>