<?php
$page['title'] = 'Manage Sales';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = false;

$csales = new sales();

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'tracklibraries':
			$clibraries = new libraries();
			$libraries = $clibraries->getLibraryIdsByTrack($data['trackid']);
			if ($libraries) {
				$out = json_encode($libraries);
			} else {
				$out = '[]';
			}
		break;
		case 'update':
			if ((!empty($data['id']) && !empty($data['sale']) && ($csales->updateSale($data['id'],$data['sale'])))) {
				$system[] = 'Sale added';
			} else {
				$system[] = 'Error adding sale';
			}
		break;
		case 'insert':
			if (!empty($data['sale']) && ($csales->insertSale($data['sale']))) {
				$system[] = 'Sale added';
			} else {
				$system[] = 'Error adding sale';
			}
		break;
		case 'remove':
			if (!empty($data['id']) && ($csales->removeSale($data['id']))) {
				$system[] = 'Sale removed';
			} else {
				$system[] = 'Error removing sale';
			}
		break;
		case 'add':
			$page['subtitle'] = 'Add Sale';
			$ctracks = new tracks();
			$clibraries = new libraries();
			$tracks = $ctracks->getTracks("`name`");
			$libraries = $clibraries->getLibraries();
			$viewfile = "sales.add.view.php";
		break;
		case 'edit':
			$page['subtitle'] = 'Edit Sale';
			if (!empty($data['id']) && ($sale = $csales->getSaleById($data['id']))) {
				$ctracks = new tracks();
				$clibraries = new libraries();
				$tracks = $ctracks->getTracks();
				$libraries = $clibraries->getLibraries();
				$versions = $ctracks->getVersions();
				$viewfile = "sales.edit.view.php";
			}
		break;
	}
} else {
	$sales = $csales->getSales();
	$salesByLibraries = $csales->getSalesByLibraries();
	$salesByTracks = $csales->getSalesByTracks();
	$salesByGenres = $csales->getSalesByGenres();
	$salesByYears = $csales->getSalesByYears();
	//by license
	//by royalty
	//by stream
	$viewfile = "sales.default.view.php";
}
?>