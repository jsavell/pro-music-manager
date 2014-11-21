<?php
$filename = dirname(__FILE__)."/config.json";
if (is_file($filename)) {
	$config = json_decode(file_get_contents($filename),true);
} else {
	echo "Couldn't find the config file!";
	die();
}
?>