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
		case 'search':
			if (isset($data['term'])) {
				$tracks = $ctracks->searchTracksBasic($data['term']);
				$genres = $cgenres->getGenres();		
				$viewfile = "tracks.default.view.php";
			} else {
				$system[] = 'There was an error with the search';
			}
		break;
		case 'remove':
			if (!empty($data['trackid']) && $ctracks->removeTrack($data['trackid'])) {
				$system[] = 'Track removed';
			} else {
				$system[] = 'Error removing track';
			}
		break;
		case 'update':
			if ((!empty($data['trackid']) && !empty($data['track'])) && $ctracks->updateTrack($data['trackid'],$data['track'])) {
				$system[] = 'Track updated';
			} else {
				$system[] = 'Error updating track';
			}
		break;
		case 'edit':
			if (!empty($data['trackid']) && ($track = $ctracks->getTrackById($data['trackid']))) {
				$genres = $cgenres->getGenres();		
				$viewfile = "tracks.edit.view.php";
			}
		break;
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
	$genres = $cgenres->getGenres();		
	$viewfile = "tracks.default.view.php";
}
?>