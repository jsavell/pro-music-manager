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

	public function getTracks($sort=NULL) {
 		$sort = ($sort) ? $sort:"`date` DESC,`name`";
		$sql = "SELECT * FROM `tracks` ORDER BY {$sort}";
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
			$track[0]['versions'] = $this->getTrackVersionsById($id);
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

	public function insertVersion($version) {
		return $this->buildInsertStatement('versions',$version);
	}

	public function updateVersion($id,$version) {
		return $this->buildUpdateStatement('versions',$id,$version);
	}

	public function getVersions() {
		$sql = "SELECT v.*,(SELECT COUNT(id) FROM tracks_versions WHERE versionid=v.id) AS trackcount 
				FROM `versions` v 
				ORDER BY v.`name`";
		return $this->queryWithIndex($sql,'id');
	}

	public function getVersionById($id) {
		$sql = "SELECT v.* FROM `versions` v 
				WHERE v.`id`=:id";
		return $this->executeQuery($sql,array(':id'=>$id))[0];
	}

	public function getTrackVersionsById($trackid) {
		$sql = "SELECT `id`,`versionid` FROM `tracks_versions` WHERE `trackid`=:trackid";
		$temp = $this->executeQuery($sql,array(":trackid"=>$trackid));
		$versionids = array();
		foreach ($temp as $version) {
			$versionids[$version['id']] = $version['versionid'];
		}
		return $versionids;
	}

	public function deleteAllTrackVersions($trackid) {
		return $this->delete("tracks_versions",array("trackid"=>$trackid));
	}

	public function deleteTrackVersions($ids) {
		$bindparams = array();
		$sql = "DELETE FROM `tracks_versions` WHERE `id` ".$this->buildIn($ids,$bindparams);
		return $this->executeUpdate($sql,$bindparams);
	}

	public function updateTrackVersions($id,$versions) {
		$existingVersions = $this->getTrackVersionsById($id);
		$newVersions = array();
		if ($existingVersions) {
			$removVersions = array();
			foreach ($existingVersions as $evid=>$evs) {
				if (!in_array($evs['versionid'],$versions)) {
					$removeVersions[] = $evid;
				}
			}
			$this->deleteTrackVersions($removeVersions);
			foreach ($versions as $versionId) {
				if (!in_array($versionId,$existingVersions)) {
					$newVersions[] = array("trackid"=>$id,"versionid"=>$versionId);
				}
			}
		} else {
			foreach ($versions as $versionId) {
				$newVersions[] = array("trackid"=>$id,"versionid"=>$versionId);
			}
		}
		if ($newVersions) {
			return $this->buildMultiRowInsertStatement("tracks_versions",$newVersions);
		}
		return false;
	}
}