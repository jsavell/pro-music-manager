<?php
$page['title'] = 'Manage Libraries';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

$clibraries = new libraries();

$out .= '<link href="'.$config['path_css'].'libraries.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="'.$config['path_js'].'libraries.js"></script>';

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'tracks':
			if (!empty($data['libraryid'])) {
				$library = $clibraries->getDetailedLibraryById($data['libraryid']);
				if (!empty($data['subaction'])) {
					switch ($data['subaction']) {
						case 'update':
							if (!empty($data['trackid']) && !empty($data['librarytrack']) && $clibraries->updateLibraryTrack($library['id'],$data['trackid'],$data['librarytrack'])) {
								$system[] = "Track updated in {$library['name']}";
							} else {
								$system[] = "Error updating track in {$library['name']}";
							}
						break;
						case 'insert':
							if (!empty($data['trackids']) && $clibraries->addTracksToLibrary($library['id'],$data['trackids'])) {
								$system[] = "Track added to {$library['name']}";
							} else {
								$system[] = "Error adding track to {$library['name']}";
							}
						break;
						case 'add':
							$page['subtitle'] = "Add Tracks to {$library['name']}";
							$tracks = $clibraries->getAvailableTracks($library['id']);
							$viewfile = "libraries.tracks.add.view.php";
						break;
					}
				} else {
					$page['subtitle'] = "Tracks in {$library['name']}";
					$tracks = $clibraries->getLibraryTracks($library['id']);
					$statuses = $clibraries->getLibraryTrackStatuses();
					$viewfile = "libraries.tracks.view.php";
				}
			}
		break;
		case 'search':
			if (isset($data['term'])) {
				$libraries = $clibraries->searchLibrariesBasic($data['term']);
				$viewfile = "libraries.default.view.php";
			} else {
				$system[] = 'There was an error with the search';
			}
		break;
		case 'remove':
			if (!empty($data['libraryid']) && $clibraries->removeLibrary($data['libraryid'])) {
				$system[] = 'Library removed';
			} else {
				$system[] = 'Error removing library';
			}
		break;
		case 'update':
			if ((!empty($data['libraryid']) && !empty($data['library'])) && $clibraries->updateLibrary($data['libraryid'],$data['library'])) {
				$system[] = 'Library updated';
			} else {
				$system[] = 'Error updating library';
			}
		break;
		case 'edit':
			$page['subtitle'] = 'Edit Track';
			if (!empty($data['libraryid']) && ($library = $clibraries->getLibraryById($data['libraryid']))) {
				$viewfile = "libraries.edit.view.php";
			}
		break;
		case 'insert':
			if (!empty($data['library']) && $clibraries->insertLibrary($data['library'])) {
				$system[] = 'Library added';
			} else {
				$system[] = 'Error adding library';
			}
		break;
		case 'add':
			$page['subtitle'] = 'Add Library';
			$viewfile = "libraries.add.view.php";
		break;
		case 'view':
			$page['subtitle'] = 'View Library';
			if (!empty($data['libraryid'])) {
				$library = $clibraries->getDetailedLibraryById($data['libraryid']);
				$viewfile = "libraries.view.view.php";
			}
		break;
	}
} else {
	$libraries = $clibraries->getLibrariesDetailed();
	$viewfile = "libraries.default.view.php";
}
?>