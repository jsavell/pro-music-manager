<?php
$data['json'] = 1;

if (!empty($data['data']) && $data['data'] == 'tracks') {
	$sortBy = null;
	if (!empty($data['sort'])) {
		$sortBy = $data['sort'];
	}

	$ctracks = new tracks();
	$cgenres = new genres();
		
	$tracks = $ctracks->getTracks($sortBy);
	$genres = $cgenres->getGenres();
	foreach ($tracks as &$track) {
		$track['genre'] = $genres[$track['genreid']]['name'];
	}
	$out = json_encode($tracks);
}
?>