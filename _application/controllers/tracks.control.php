<?php
$page['title'] = 'Manage Tracks';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true),
						array("name"=>"versions","action"=>"versions","modal"=>true));
$page['search'] = true;

$ctracks = new tracks();
$cgenres = new genres();

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'versions':
			if (!empty($data['subaction'])) {
				switch ($data['subaction']) {
					case 'update':
						if ($ctracks->updateVersion($data['id'],$data['version'])) {
							$system[] = 'Version updated';
						} else {
							$system[] = 'Error updating version';
						}
					break;
					case 'insert':
						if ($ctracks->insertVersion($data['version'])) {
							$system[] = 'Version added';
						} else {
							$system[] = 'Error adding version';
						}
					break;
					case 'edit':
						if (!empty($data['id'])) {
							$page['subtitle'] = 'Edit Version';
							$version = $ctracks->getVersionById($data['id']);
							$viewfile = 'versions.edit.view.php';
						}
					break;
					case 'add':
						$page['subtitle'] = 'Add Version';
						$viewfile = 'versions.add.view.php';
					break;
				}
			} else {
				$page['subtitle'] = 'Track Versions';
				$versions = $ctracks->getVersions();
				$viewfile = 'versions.default.view.php';
			}
		break;
		case 'emotions':
			$page['subtitle'] = 'Track Emotions';
			if (!empty($data['subaction'])) {
				switch ($data['subaction']) {
					case 'remove':
						if (!empty($data['trackid']) && !empty($data['emotionid']) && ($ctracks->removeTrackEmotion($data['trackid'],$data['emotionid']))) {
							$system[] = 'Emotion removed';
						}
					break;
					case 'insert':
						if (!empty($data['trackid']) && !empty($data['emotion']) && ($ctracks->addEmotion($data['trackid'],$data['emotion']))) {
							$system[] = 'Emotion added';
						}
					break;
				}
			} else {
				$track['id'] = $data['trackid'];
				$trackEmotions = $ctracks->getEmotionsByTrack($track['id']);
				$viewfile = "tracks.emotions.view.php";
			}
		break;
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
			if (!empty($data['term'])) {
				$tracks = $ctracks->searchTracksBasic($data['term']);
			} else {
				$tracks = $ctracks->getTracks();
			}
			$genres = $cgenres->getGenres();		
			$viewfile = "tracks.default.view.php";
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
				if (is_array($data['versionids'])) {
					$ctracks->updateTrackVersions($data['trackid'],$data['versionids']);
				}
				$system[] = 'Track updated';
			} else {
				$system[] = 'Error updating track';
			}
		break;
		case 'edit':
			$page['subtitle'] = 'Edit Track';
			if (!empty($data['trackid']) && ($track = $ctracks->getTrackById($data['trackid']))) {
				$genres = $cgenres->getGenres();		
				$versions = $ctracks->getVersions();
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