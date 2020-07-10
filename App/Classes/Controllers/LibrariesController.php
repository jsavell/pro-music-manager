<?php
namespace App\Classes\Controllers;

class LibrariesController extends AppController {
	private $librariesRepo;

	public function configure() {
		$this->getPage()->setOptions(
			array(array("name" => "list"),
					array("name" => "add", "action" => "add","modal"=>true)));
		$this->getPage()->setTitle('Manage Libraries');
		$this->getPage()->setIsSearchable(true);
		$this->librariesRepo = $this->getSite()->getDataRepository("Libraries");
	}


	public function tracks() {
		$data = $this->getInputData();
		if (!empty($data['libraryid'])) {
			$library = $this->librariesRepo->getDetailedLibraryById($data['libraryid']);
			$this->getViewRenderer()->registerViewVariable("library", $library);
			$this->getPage()->setSubtitle("Tracks in {$library['name']}");
			$this->getViewRenderer()->registerViewVariable("libraryTracks", $this->librariesRepo->getLibraryTracks($library['id']));
			$this->getViewRenderer()->registerViewVariable("statuses", $this->librariesRepo->getLibraryTrackStatuses());
			$this->setViewName("libraries.tracks");

		}
	}

	public function tracksUpdate() {
		$data = $this->getInputData();
		if (!empty($data['id']) && $this->librariesRepo->updateLibraryTrack($data['id'],$data['librarytrack'])) {
			$this->getSite()->addSystemMessage("Track updated in library");
		} else {
			$this->getSite()->addSystemError("Error updating track in library");
		}
	}

	public function tracksInsert() {
		$data = $this->getInputData();
		if (!empty($data['trackids']) && $this->librariesRepo->addTracksToLibrary($data['libraryid'],$data['trackids'])) {
			$system[] = "Tracks added to library";
		} else {
			$system[] = "Error adding track to library";
		}
	}
	public function tracksAdd() {
		$data = $this->getInputData();
		$library = $this->librariesRepo->getDetailedLibraryById($data['libraryid']);
		$this->getViewRenderer()->registerViewVariable("library", $library);

		$this->getPage()->setSubtitle("Add Tracks to {$library['name']}");
		$this->getViewRenderer()->registerViewVariable("tracks", $this->librariesRepo->getAvailableTracks($library['id']));
		$this->setViewName("libraries.tracks.add");
	}

	public function search() {
		$data = $this->getInputData();
		if (isset($data['term'])) {
			$this->getViewRenderer()->registerViewVariable("libraries", $this->librariesRepo->searchLibrariesBasic($data['term']));
			$this->setViewName("libraries.default");
		} else {
			$this->getSite()->addSystemError('There was an error with the search');
		}
	}

	public function remove() {
		$data = $this->getInputData();
		if (!empty($data['libraryid']) && $this->librariesRepo->removeById($data['libraryid'])) {
			$this->getSite()->addSystemMessage('Library removed');
		} else {
			$this->getSite()->addSystemError('Error removing library');
		}
	}

	public function update() {
		$data = $this->getInputData();
		if ((!empty($data['libraryid']) && !empty($data['library'])) && $this->librariesRepo->update($data['libraryid'],$data['library'])) {
			$this->getSite()->addSystemMessage('Library updated');
		} else {
			$this->getSite()->addSystemError('Error updating library');
		}
	}

	public function edit() {
		$data = $this->getInputData();
		$this->getPage()->setSubtitle('Edit Track');
		if (!empty($data['libraryid'])) {

			$this->getViewRenderer()->registerViewVariable("library", $this->librariesRepo->getById($data['libraryid']));
			$this->setViewName("libraries.edit");
		}
	}

	public function insert() {
		$data = $this->getInputData();
		if (!empty($data['library']) && $this->librariesRepo->add($data['library'])) {
			$this->getSite()->addSystemMessage('Library added');
		} else {
			$this->getSite()->addSystemError('Error adding library');
		}
	}


	public function add() {
		$this->getPage()->setSubtitle('Add Library');
		$this->setViewName("libraries.add");
	}

	public function view() {
		$data = $this->getInputData();
		$this->getPage()->setSubtitle('View Library');
		if (!empty($data['libraryid'])) {
			$this->getViewRenderer()->registerViewVariable("library", $this->librariesRepo->getDetailedLibraryById($data['libraryid']));
			$this->setViewName("libraries.view");
		}
	}

	public function loadDefault() {
		$data = $this->getInputData();
		$sortBy = (!empty($data['sort'])) ? $data['sort']:null;
		$this->getViewRenderer()->registerViewVariable("libraries", $this->librariesRepo->getLibrariesDetailed($sortBy));
		$this->setViewName("libraries.default");
	}
}
?>