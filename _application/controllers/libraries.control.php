<?php
$page['title'] = 'Manage Libraries';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

$clibraries = new libraries();

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'tracks':
			if (!empty($data['libraryid'])) {
				$library = $clibraries->getDetailedLibraryById($data['libraryid']);
				if (!empty($data['subaction'])) {
					switch ($data['subaction']) {
						case 'insert':
							if (!empty($data['trackid']) && $clibraries->addTrackToLibrary($library['id'],$data['trackid'])) {
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
	$libraries = $clibraries->getLibraries();
	$viewfile = "libraries.default.view.php";
}
?>