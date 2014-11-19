<?php
$page['title'] = 'Manage Sales';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true),
						array("name"=>"by track","action"=>"track"));
$page['search'] = true;

$csales = new sales();

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'insert':
			if (!empty($data['sale']) && ($csales->insertSale($data['sale']))) {
				$system[] = 'Sale added';
			} else {
				$system[] = 'Error adding sale';
			}
		break;
		case 'add':
			$page['subtitle'] = 'Add Sale';
			$ctracks = new tracks();
			$clibraries = new libraries();
			$tracks = $ctracks->getTracks();
			$libraries = $clibraries->getLibraries();
			$viewfile = "sales.add.view.php";
		break;
	}
} else {
	$sales = $csales->getSales();
	$salesByTracks = $csales->getSalesByTracks();
	$salesByGenres = $csales->getSalesByGenres();
	//sales by genre
	//by library
	//by license
	//by royalty
	//by stream
	$viewfile = "sales.default.view.php";
}
?>