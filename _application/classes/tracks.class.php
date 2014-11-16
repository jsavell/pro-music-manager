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
		$sql = "SELECT * FROM `tracks` ORDER BY `name`";
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
			return $track[0];
		}
		return false;
	}

	public function getTracksByGenre($genreid) {
		$sql = "SELECT * FROM `genres` WHERE id=:id";
		return $this->executeQuery($sql,array(":id"=>$genreid));
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
}