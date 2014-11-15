<?php

session_start();

//don't recommend using, sanitizing in case someone does
$_SERVER['PHP_SELF'] = htmlentities($_SERVER['PHP_SELF']);

$config['path_root'] = "";
$config['path_file'] = "{$config['path_root']}pmm/";
$config['path_app'] = "{$config['path_file']}_application/";
$config['path_lib'] = "{$config['path_app']}lib/";
$config['path_classes'] = "{$config['path_app']}classes/";
$config['path_controllers'] = "{$config['path_app']}controllers/";
$config['path_views'] = "{$config['path_app']}views/";
$config['path_http'] = "http://localhost/pmm/";
$config['path_css'] = "{$config['path_http']}_application/css/";
$config['path_js'] = "{$config['path_http']}_application/js/";
$config['path_images'] = "{$config['path_http']}_application/images/";

$dbconfig['dbtype'] = 'mysql';
$dbconfig['user'] = '';
$dbconfig['password'] = '';
$dbconfig['host'] = '';
$dbconfig['database'] = '';

?>