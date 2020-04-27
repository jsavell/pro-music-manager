<?php
$page['title'] = 'Manage Genres';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

$cgenres = new genres();

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'tracks':
			if (!empty($data['genreid'])) {
				$ctracks = new tracks();
				$genre = $cgenres->getGenreById($data['genreid']);
				$tracks = $ctracks->getTracksByGenre($genre['id']);
				$page['subtitle'] = count($tracks)." Tracks in {$genre['name']}";
				$viewfile = "genres.tracks.view.php";
			}
		break;
		case 'search':
			if (isset($data['term'])) {
				$genres = $cgenres->searchGenresBasic($data['term']);
				$viewfile = "genres.default.view.php";
			} else {
				$system[] = 'There was an error with the search';
			}
		break;
		case 'remove':
			if (!empty($data['genreid']) && $cgenres->removeGenre($data['genreid'])) {
				$system[] = 'Genre removed';
			} else {
				$system[] = 'Error removing genre';
			}
		break;
		case 'update':
			if ((!empty($data['genreid']) && !empty($data['genre'])) && $cgenres->updateGenre($data['genreid'],$data['genre'])) {
				$system[] = 'Genre updated';
			} else {
				$system[] = 'Error updating genre';
			}
		break;
		case 'edit':
			$page['subtitle'] = 'Edit Genre';
			if (!empty($data['genreid']) && ($genre = $cgenres->getGenreById($data['genreid']))) {
				$viewfile = "genres.edit.view.php";
			}
		break;
		case 'insert':
			if (!empty($data['genre']) && $cgenres->insertGenre($data['genre'])) {
				$system[] = 'Genre added';
			} else {
				$system[] = 'Error adding genre';
			}
		break;
		case 'add':
			$page['subtitle'] = 'Add Genre';
			$viewfile = "genres.add.view.php";
		break;
	}
} else {
	$sortBy = (!empty($data['sort'])) ? $data['sort']:null;
	$genres = $cgenres->getGenresDetailed($sortBy);
	$viewfile = "genres.default.view.php";
}
?>