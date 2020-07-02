<?php
namespace App\Classes\Controllers;

class ApiController extends AppController {
	private $tracksRepo;
	private $genresRepo;

	public function configure() {
		$this->tracksRepo = $this->getSite()->getDataRepository("Tracks");
		$this->genresRepo = $this->getSite()->getDataRepository("Genres");
	}

	public function loadDefault() {
	}

	public function tracks() {
		$data = $this->getInputData();
		if (!empty($data['trackids'])) {
			$tracks = $this->tracksRepo->getPublicTracksByIds($data['trackids']);
		} else if (!empty($data['search'])) {
			$tracks = $this->tracksRepo->searchPublic($data['search']);
		} else {
			$sortBy = null;
			if (!empty($data['sort'])) {
				$sortBy = $data['sort'];
			}

			$tracks = $this->tracksRepo->getTracks($sortBy);
			$genres = $this->genresRepo->getGenres();
			foreach ($tracks as &$track) {
				$track['genre'] = $genres[$track['genreid']]['name'];
			}
		}
		$this->getViewRenderer()->registerViewVariable("tracks", $tracks);
	}

	public function genres() {
		$this->getViewRenderer()->registerViewVariable("genres", $this->genresRepo->getGenresDetailed());
	}
}
?>