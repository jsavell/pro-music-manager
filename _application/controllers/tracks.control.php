<?php
$app['path_http'] = "{$config['path_http']}login.php";

if (isset($data['action'])) {
	switch ($data['action']) {
		default:
			$viewfile = "tracks.default.view.php";
		break;
	}
} else {
	$viewfile = "tracks.default.view.php";
}

?>