<?php
$page['title'] = 'Manage Sales';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

$csales = new sales();

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'add':
			$page['subtitle'] = 'Add Sale';
			$viewfile = "sales.add.view.php";
		break;
	}
} else {
	$sales = $csales->getSales();
	//sales by genre
	//by library
	//by license
	//by royalty
	//by stream
	$viewfile = "sales.default.view.php";
}
?>