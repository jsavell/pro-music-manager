<?php
$page['title'] = 'Manage Tracks';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

$ctracks = new tracks();
$cgenres = new genres();

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'insert':
			if (!empty($data['track']) && $ctracks->insertTrack($data['track'])) {
				$system[] = 'Track added';
			} else {
				$system[] = 'Error adding track';
			}
		break;
		case 'add':
			$genres = $cgenres->getGenres();		
			$viewfile = "tracks.add.view.php";
		break;
	}
} else {
	$tracks = $ctracks->getTracks();
	$viewfile = "tracks.default.view.php";
}
?>