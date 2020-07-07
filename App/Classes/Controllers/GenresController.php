<?php
namespace App\Classes\Controllers;

class GenresController extends AppController {
	private $tracksRepo;
	private $genresRepo;

	public function configure() {
		$this->getPage()->setOptions(
			array(array("name" => "list"),
					array("name" => "add", "action" => "add","modal"=>true)));
		$this->getPage()->setTitle('Manage Genres');
		$this->getPage()->setIsSearchable(true);
		$this->tracksRepo = $this->getSite()->getDataRepository("Tracks");
		$this->genresRepo = $this->getSite()->getDataRepository("Genres");
	}

	public function search() {
		$data = $this->getInputData();
		if (isset($data['term'])) {
			$this->getViewRenderer()->registerViewVariable("genres", $this->genresRepo->searchGenresBasic($data['term']));
			$this->setViewName("genres.default");
		} else {
			$this->getSite()->addSystemError('There was an error with the search');
		}
	}

	public function insert() {
		$data = $this->getInputData();
		if (!empty($data['genre']) && $this->genresRepo->add($data['genre'])) {
			$this->getSite()->addSystemMessage('Genre added');
		} else {
			$this->getSite()->addSystemError('Error adding genre');
		}
	}

	public function add() {
		$this->getPage()->setSubTitle('Add Genre');
		$this->setViewName("genres.add");
		}


	public function update() {
		$data = $this->getInputData();
		if ((!empty($data['genreid']) && !empty($data['genre'])) && $this->genresRepo->update($data['genreid'],$data['genre'])) {
			$this->getSite()->addSystemMessage('Genre updated');
		} else {
			$this->getSite()->addSystemError('Error updating genre');
		}
	}

	public function edit() {
		$this->getPage()->setSubTitle('Edit Genre');
		$data = $this->getInputData();
		if (!empty($data['genreid'])) {
			$this->getViewRenderer()->registerViewVariable("genre", $this->genresRepo->getGenreById($data['genreid']));
			$this->setViewName("genres.edit");
		}
	}

	public function remove() {
		$data = $this->getInputData();
		if (!empty($data['genreid']) && $this->genresRepo->removeById($data['genreid'])) {
			$this->getSite()->addSystemMessage('Genre removed');
		} else {
			$this->getSite()->addSystemError('Error removing genre');
		}
	}

	public function tracks() {
		$data = $this->getInputData();
		if (!empty($data['genreid'])) {
			$genre = $this->genresRepo->getGenreById($data['genreid']);
			$tracks = $this->tracksRepo->getTracksByGenre($genre['id']);
			$this->getViewRenderer()->registerViewVariable("tracks", $tracks);
			$this->getPage()->setSubTitle(count($tracks)." Tracks in {$genre['name']}");
			$this->setViewName("genres.tracks");
		}
	}

	public function loadDefault() {
		$data = $this->getInputData();
		$sortBy = (!empty($data['sort'])) ? $data['sort']:null;
		$this->getViewRenderer()->registerViewVariable("genres", $this->genresRepo->getGenresDetailed($sortBy));
		$this->setViewName("genres.default");
	}
}
?>