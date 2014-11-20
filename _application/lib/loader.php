<?php
require_once "{$config['path_lib']}functions.php";

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
	echo $out;
} else {
	include "{$config['path_app']}layouts/header.lo.php";
	echo $out;
	include "{$config['path_app']}layouts/footer.lo.php";
}
?>