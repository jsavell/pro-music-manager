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
		case 'keywords':
			$page['subtitle'] = 'Track Keywords';
			if (!empty($data['subaction'])) {
				switch ($data['subaction']) {
					case 'remove':
						if (!empty($data['trackid']) && !empty($data['keywordid']) && ($ctracks->removeTrackKeyWord($data['trackid'],$data['keywordid']))) {
							$system[] = 'Keyword removed';
						}
					break;
					case 'insert':
						if (!empty($data['trackid']) && !empty($data['keyword']) && ($ctracks->addKeyWord($data['trackid'],$data['keyword']))) {
							$system[] = 'Keyword added';
						}
					break;
				}
			} else {
				$track['id'] = $data['trackid'];
				$trackKeywords = $ctracks->getKeyWordsByTrack($track['id']);
				$viewfile = "tracks.keywords.view.php";
			}
		break;
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
			$page['subtitle'] = 'Edit Track';
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
			$page['subtitle'] = 'Add Track';
			$genres = $cgenres->getGenres();		
			$viewfile = "tracks.add.view.php";
		break;
		case 'view':
			$page['subtitle'] = 'View Track';
			if (!empty($data['trackid']) && ($track = $ctracks->getDetailedTrackById($data['trackid']))) {
				$viewfile = "tracks.view.view.php";
			}
		break;
	}
} else {
	$tracks = $ctracks->getTracks();
	$genres = $cgenres->getGenres();		
	$viewfile = "tracks.default.view.php";
}
?>