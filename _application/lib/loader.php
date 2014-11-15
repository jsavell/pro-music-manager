<?php
require_once "{$config['path_lib']}functions.php";

$globaluser = new user();

$data = $_REQUEST;

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
} else {
//load standard controller
	$app_http = "{$config['path_http']}{$controller}/";
	$filename = "{$config['path_controllers']}{$controller}.control.php";
}
//try to load the controller
if (is_file($filename)) {
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
} else {
	$system[] = 'Error loading content';
}
//display the content
$pages = array(
			array("name"=>"tracks","path"=>"tracks"),
			array("name"=>"libraries","path"=>"libraries"),
			array("name"=>"genres","path"=>"genres"),
			array("name"=>"users","path"=>"users"));
include "{$config['path_app']}layouts/header.lo.php";
echo $out;
include "{$config['path_app']}layouts/footer.lo.php";
?>