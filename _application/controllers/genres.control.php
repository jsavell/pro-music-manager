<?php
$page['title'] = 'Manage Genres';
$page['navigation'] = array(
						array("name"=>"list"),
						array("name"=>"add","action"=>"add","modal"=>true));
$page['search'] = true;

$cgenres = new genres();

if (isset($data['action'])) {
	switch ($data['action']) {
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
			$viewfile = "genres.add.view.php";
		break;
	}
} else {
	$genres = $cgenres->getGenres();
	$viewfile = "genres.default.view.php";
}
?>