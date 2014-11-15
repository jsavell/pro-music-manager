<?php
$page['title'] = 'Manage Tracks';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

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