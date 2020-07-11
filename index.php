<?php
$configBase = "./App/Config/";
include $configBase.'config.php';
$forceRedirectUrl = "{$config['PATH_HTTP']}login.php";
include PATH_LIB."loader.php";

?>