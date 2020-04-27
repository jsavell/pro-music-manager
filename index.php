<?php
$configBase = "./App/Config/";
if (!is_file($configBase.'config.json')) {
	echo 'Make sure to create and configure the config file!';
} else {
	include $configBase.'config.php';
	$forceRedirectUrl = "{$config['PATH_HTTP']}login.php";
	include PATH_LIB."loader.php";
}
?>