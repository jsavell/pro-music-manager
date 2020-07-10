<?php
namespace App\Classes\Controllers;

class SalesController extends AppController {
	private $salesRepo;
	private $librariesRepo;
	private $tracksRepo;

	public function configure() {
		$this->getPage()->setOptions(
			array(array("name" => "list"),
					array("name" => "add", "action" => "add","modal"=>true)));
		$this->getPage()->setTitle('Manage Sales');
		$this->getPage()->setIsSearchable(false);
		$this->salesRepo = $this->getSite()->getDataRepository("Sales");
		$this->librariesRepo = $this->getSite()->getDataRepository("Libraries");
		$this->tracksRepo = $this->getSite()->getDataRepository("Tracks");
	}


	public function tracklibraries() {
		$data = $this->getInputData();
		$this->getViewRenderer()->registerViewVariable("libraries", $this->librariesRepo->getLibraryIdsByTrack($data['trackid']));
	}

	public function remove() {
		$data = $this->getInputData();
		if (!empty($data['id']) && ($this->salesRepo->removeById($data['id']))) {
			$this->getSite()->addSystemMessage('Sale removed');
		} else {
			$this->getSite()->addSystemError('Error removing sale');
		}
	}

	public function insert() {
		$data = $this->getInputData();
		if (!empty($data['sale']) && ($this->salesRepo->add($data['sale']))) {
			$this->getSite()->addSystemMessage('Sale added');
		} else {
			$this->getSite()->addSystemError('Error adding sale');
		}
	}

	public function add() {
		$this->getPage()->setSubtitle('Add Sale');
		$this->getViewRenderer()->registerViewVariable("tracks", $this->tracksRepo->getTracks("`name`"));
		$this->getViewRenderer()->registerViewVariable("libraries", $this->librariesRepo->getLibraries());
		$this->getViewRenderer()->registerViewVariable("versions", $this->tracksRepo->getVersions());
		$this->setViewName("sales.add");
	}

	public function update() {
		$data = $this->getInputData();
		if ((!empty($data['id']) && !empty($data['sale']) && ($this->salesRepo->update($data['id'],$data['sale'])))) {
			$this->getSite()->addSystemMessage('Sale added');
		} else {
			$this->getSite()->addSystemError('Error adding sale');
		}
	}


	public function edit() {
		$this->getPage()->setSubtitle('Edit Sale');
		$data = $this->getInputData();
		if (!empty($data['id']) && ($sale = $this->salesRepo->getById($data['id']))) {
			$this->getViewRenderer()->registerViewVariable("sale", $sale);
			$this->getViewRenderer()->registerViewVariable("tracks", $this->tracksRepo->getTracks("`name`"));
			$this->getViewRenderer()->registerViewVariable("libraries", $this->librariesRepo->getLibraries());
			$this->getViewRenderer()->registerViewVariable("versions", $this->tracksRepo->getVersions());
			$this->getViewRenderer()->registerViewVariable("trackVersions", $this->tracksRepo->getTrackVersionsById($sale['trackid']));
			$this->getViewRenderer()->registerViewVariable("trackLibraries", $this->librariesRepo->getLibraryIdsByTrack($sale['trackid']));
			$this->setViewName("sales.edit");
		}
	}

	public function loadDefault() {
		$this->getViewRenderer()->registerViewVariable("sales", $this->salesRepo->getSales());
		$this->getViewRenderer()->registerViewVariable("salesByLibraries", $this->salesRepo->getSalesByLibraries());
		$this->getViewRenderer()->registerViewVariable("salesByTracks", $this->salesRepo->getSalesByTracks());
		$this->getViewRenderer()->registerViewVariable("salesByGenres", $this->salesRepo->getSalesByGenres());
		$this->getViewRenderer()->registerViewVariable("salesByYears", $this->salesRepo->getSalesByYears());
		//by license
		//by royalty
		//by stream
		$this->setViewName("sales.default");
	}
}
?>