<?php
namespace App\Classes\Controllers;

class TracksController extends AppController {
	private $tracksRepo;
	private $genresRepo;

	public function configure() {
		$this->getPage()->setOptions(
			array(array("name" => "list"),
					array("name" => "add", "action" => "add","modal"=>true),
					array("name"=>"versions","action"=>"versions","modal"=>true)));
		$this->getPage()->setTitle('Manage Tracks');
		$this->getPage()->setIsSearchable(true);
		$this->tracksRepo = $this->getSite()->getDataRepository("Tracks");
		$this->genresRepo = $this->getSite()->getDataRepository("Genres");
	}

	public function loadDefault() {
		$sortBy = null;
		if (!empty($data['sort'])) {
			$sortBy = $data['sort'];
		}

		$this->getViewRenderer()->registerViewVariable("tracks",$this->tracksRepo->getTracks($sortBy,true));
		$this->getViewRenderer()->registerViewVariable("genres",$this->genresRepo->getGenres());
		$this->setViewName("tracks.default");
	}

	public function	insert() {
		$data = $this->getInputData();
		if (!empty($data['track']) && $this->tracksRepo->add($data['track'])) {
			$this->getSite()->addSystemMessage('Track added');
		} else {
			$this->getSite()->addSystemError('Error adding track');
		}
	}

	public function add() {
		$this->getPage()->setSubTitle('Add Track');
		$this->getViewRenderer()->registerViewVariable("genres",$this->genresRepo->getGenres());
		$this->setViewName("tracks.add");
	}

	public function update() {
		$data = $this->getInputData();
		if ((!empty($data['trackid']) && !empty($data['track'])) && $this->tracksRepo->update($data['trackid'],$data['track'])) {
			if (is_array($data['versionids'])) {
				$this->tracksRepo->updateTrackVersions($data['trackid'],$data['versionids']);
			} else {
				$this->tracksRepo->deleteAllTrackVersions($data['trackid']);
			}
			$this->getSite()->addSystemMessage('Track updated');
		} else {
			$this->getSite()->addSystemError('Error updating track');
		}
	}

	public function edit() {
		$this->getPage()->setSubTitle('Edit Track');
		$data = $this->getInputData();
		if (!empty($data['trackid']) && ($track = $this->tracksRepo->getTrackById($data['trackid']))) {
			$this->getViewRenderer()->registerViewVariable("genres", $this->genresRepo->getGenres());
			$this->getViewRenderer()->registerViewVariable("versions", $this->tracksRepo->getVersions());
			$track['versions'] = $this->tracksRepo->getTrackVersionsById($data['trackid']);
			$this->getViewRenderer()->registerViewVariable("track", $track);
			$this->setViewName("tracks.edit");
		}
	}

	public function remove() {
		$data = $this->getInputData();
		if (!empty($data['trackid']) && $this->tracksRepo->removeById($data['trackid'])) {
			$this->getSite()->addSystemMessage('Track removed');
		} else {
			$this->getSite()->addSystemError('Error removing track');
		}
	}

	public function search() {
		$data = $this->getInputData();
		if (!empty($data['term'])) {
			$tracks = $this->tracksRepo->searchTracksBasic($data['term'], true);
		} else {
			$tracks = $this->tracksRepo->getTracks(null, true);
		}
		$this->getViewRenderer()->registerViewVariable("tracks", $tracks);
		$this->getViewRenderer()->registerViewVariable("genres", $this->genresRepo->getGenres());
		$this->setViewName("tracks.default");
	}

	public function keywords() {
		$this->getPage()->setSubTitle('Track Keywords');
		$data = $this->getInputData();
		$this->getViewRenderer()->registerViewVariable("track", $this->tracksRepo->getTrackById($data['trackid']));
		$this->setViewName("tracks.keywords");
	}

	public function emotions() {
		$this->getPage()->setSubTitle('Track Emotions');
		$data = $this->getInputData();
		$track['id'] = $data['trackid'];
		$this->getViewRenderer()->registerViewVariable("track",$track);
		$this->getViewRenderer()->registerViewVariable("trackEmotions",$this->tracksRepo->getEmotionsByTrack($track['id']));
		$this->getViewRenderer()->registerViewVariable("emotions", $this->tracksRepo->getEmotions());
		$this->setViewName("tracks.emotions");
	}

	public function emotionsInsert() {
		$data = $this->getInputData();
		if (!empty($data['trackid']) && !empty($data['emotionid']) && ($this->tracksRepo->addEmotionToTrack($data['trackid'],$data['emotionid']))) {
			$this->getSite()->addSystemMessage('Emotion added');
		}
	}

	public function emotionsRemove() {
		$data = $this->getInputData();
		if (!empty($data['trackid']) && !empty($data['emotionid']) && ($this->tracksRepo->removeTrackEmotion($data['trackid'],$data['emotionid']))) {
			$this->getSite()->addSystemMessage('Emotion removed');
		}
	}

	public function versions() {
		$this->getPage()->setSubTitle('Track Versions');
		$this->getViewRenderer()->registerViewVariable("versions", $this->tracksRepo->getVersions());
		$this->setViewName('versions.default');
	}

	public function versionsInsert() {
		$data = $this->getInputData();
		if ($this->tracksRepo->insertVersion($data['version'])) {
			$this->getSite()->addSystemMessage('Version added');
		} else {
			$this->getSite()->addSystemError('Error adding version');
		}
	}

	public function versionsAdd() {
		$this->getPage()->setSubTitle('Add Version');
		$this->setViewName('versions.add');
	}

	public function versionsUpdate() {
		$data = $this->getInputData();
		if ($this->tracksRepo->updateVersion($data['id'],$data['version'])) {
			$this->getSite()->addSystemMessage('Version updated');
		} else {
			$this->getSite()->addSystemError('Error updating version');
		}
	}

	public function versionsEdit() {
		$this->getPage()->setSubTitle('Edit Version');
		$data = $this->getInputData();
		if (!empty($data['id'])) {
			$this->getViewRenderer()->registerViewVariable("version", $this->tracksRepo->getVersionById($data['id']));
			$this->setViewName('versions.edit');
		}
	}

	public function versionsTrackversions() {
		$data = $this->getInputData();
		$temp = $this->tracksRepo->getTrackVersionsById($data['trackid']);
		$versionids = array();
		foreach ($temp as $versionid) {
			$versionids[] = $versionid;
		}
		$this->getViewRenderer()->registerViewVariable("versionids", $versionids);
	}

	public function view() {
		$this->getPage()->setSubTitle('View Track');
		$data = $this->getInputData();
		if (!empty($data['trackid']) && ($track = $this->tracksRepo->getDetailedTrackById($data['trackid']))) {
			$this->getViewRenderer()->registerViewVariable("track",$track);
			$this->getViewRenderer()->registerViewVariable("versions", $this->tracksRepo->getVersions());
			$this->setViewName("tracks.view");
		}
	}
}
?>