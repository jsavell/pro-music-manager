<?php
$page['title'] = 'Manage Genres';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

if (isset($data['action'])) {
	switch ($data['action']) {
		default:
			$viewfile = "genres.default.view.php";
		break;
	}
} else {
	$viewfile = "genres.default.view.php";
}
?>