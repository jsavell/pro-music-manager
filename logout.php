<?php
$accesslevel = -1;
include "./_application/config/config.php";

$controller = 'user';
$data['action'] = 'logout';

include "{$config['path_lib']}loader.php";
?>