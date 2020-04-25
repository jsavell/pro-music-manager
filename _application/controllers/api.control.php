<?php
$data['json'] = 1;

$cgenres = new genres();

if (!empty($data['data'])) {
	switch ($data['data']) {
		case 'tracks':
			$sortBy = null;
			if (!empty($data['sort'])) {
				$sortBy = $data['sort'];
			}

			$ctracks = new tracks();

			$tracks = $ctracks->getTracks($sortBy);
			$genres = $cgenres->getGenres();
			foreach ($tracks as &$track) {
				$track['genre'] = $genres[$track['genreid']]['name'];
			}
			$out = json_encode($tracks);
		break;
		case 'genres':
			$out = json_encode($cgenres->getGenresDetailed());
		break;
	}
}
?>