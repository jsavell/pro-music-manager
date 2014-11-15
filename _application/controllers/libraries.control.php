<?php
$page['title'] = 'Manage Libraries';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

if (isset($data['action'])) {
	switch ($data['action']) {
		default:
			$viewfile = "libraries.default.view.php";
		break;
	}
} else {
	$viewfile = "libraries.default.view.php";
}
?>