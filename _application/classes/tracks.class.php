<?php
class tracks extends dbobject {
	public function searchTracksBasic($term) {
		$sql = "SELECT * FROM `tracks` WHERE
		`name` LIKE ? OR
		`description` LIKE ?";
		$bindparams = array("%".$term."%","%".$term."%");
		if ($result = $this->executeQuery($sql,$bindparams)) {
			return $result;
		}
		return false;
	}

	public function getTracks() {
		$sql = "SELECT * FROM `tracks` ORDER BY `date` DESC,`name`";
		return $this->queryWithIndex($sql,"id");
	}

	public function getTrackById($id) {
		$sql = "SELECT * FROM `tracks` WHERE id=:id";
		return $this->executeQuery($sql,array(":id"=>$id))[0];
	}

	public function getDetailedTrackById($id) {
		$sql = "SELECT t.*,g.`name` AS `genre` FROM `tracks` t
				LEFT JOIN `genres` g ON g.`id`=t.`genreid`
				 WHERE t.`id`=:id";
		if ($track = $this->executeQuery($sql,array(":id"=>$id))) {
			$clibraries = new libraries();
			$track[0]['libraries'] = $clibraries->getLibrariesByTrack($id);
			$track[0]['keywords'] = $this->getKeyWordsByTrack($id);
			$track[0]['emotions'] = $this->getEmotionsByTrack($id);
			return $track[0];
		}
		return false;
	}

	public function getTracksByGenre($genreid) {
		$sql = "SELECT t.* FROM `tracks` t WHERE t.`genreid`=:genreid";
		return $this->executeQuery($sql,array(":genreid"=>$genreid));
	}

	public function removeTrack($id) {
//TODO: delete ancillary track records
		$sql = "DELETE FROM `tracks` WHERE id=:id";
		return $this->executeUpdate($sql,array(":id"=>$id));
	}

	public function insertTrack($track) {
		return $this->buildInsertStatement("tracks",$track);
	}

	public function updateTrack($id,$track) {
		return $this->buildUpdateStatement("tracks",$id,$track);
	}

	public function findKeyWord($keyword) {
		$sql = "SELECT * FROM `keywords` WHERE `name` = :keyword";
		if ($temp = $this->executeQuery($sql,array(":keyword"=>$keyword))) {
			return $temp[0]['id'];
		}
		return false;
	}

	public function addKeyWord($trackid,$keyword) {
		if (!($keywordid = $this->findKeyWord($keyword))) {
			$keywordid = $this->buildInsertStatement("keywords",array('name'=>$keyword));
		}
		if ($keywordid) {
			return $this->addKeyWordToTrack($trackid,$keywordid);
		}
		return false;
	}

	public function addKeyWordToTrack($trackid,$keywordid) {
		return $this->buildInsertStatement("tracks_keywords",array('trackid'=>$trackid,'keywordid'=>$keywordid));
	}

	public function removeTrackKeyWord($trackid,$keywordid) {
		return $this->delete("tracks_keywords",array('trackid'=>$trackid,'keywordid'=>$keywordid));
	}

	public function getKeyWordsByTrack($trackid) {
		$sql = "SELECT k.id,k.name FROM `tracks_keywords` tk
				LEFT JOIN `keywords` k ON k.id=tk.keywordid
				WHERE `trackid`=:trackid ORDER BY `name`";
		return $this->executeQuery($sql,array(":trackid"=>$trackid));
	}

	public function findEmotion($emotion) {
		$sql = "SELECT * FROM `emotions` WHERE `name` = :emotion";
		if ($temp = $this->executeQuery($sql,array(":emotion"=>$emotion))) {
			return $temp[0]['id'];
		}
		return false;
	}

	public function addEmotion($trackid,$emotion) {
		if (!($emotionid = $this->findEmotion($emotion))) {
			$emotionid = $this->buildInsertStatement("emotions",array('name'=>$emotion));
		}
		if ($emotionid) {
			return $this->addEmotionToTrack($trackid,$emotionid);
		}
		return false;
	}

	public function addEmotionToTrack($trackid,$emotionid) {
		return $this->buildInsertStatement("tracks_emotions",array('trackid'=>$trackid,'emotionid'=>$emotionid));
	}

	public function removeTrackEmotion($trackid,$emotionid) {
		return $this->delete("tracks_emotions",array('trackid'=>$trackid,'emotionid'=>$emotionid));
	}

	public function getEmotionsByTrack($trackid) {
		$sql = "SELECT k.id,k.name FROM `tracks_emotions` tk
				LEFT JOIN `emotions` k ON k.id=tk.emotionid
				WHERE `trackid`=:trackid ORDER BY `name`";
		return $this->executeQuery($sql,array(":trackid"=>$trackid));
	}
}