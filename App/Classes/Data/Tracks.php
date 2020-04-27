<?php
namespace App\Classes\Data;

class Tracks extends AppDatabaseRepository {
	protected $sortQueries = array("name"=>"name","date"=>"`date` DESC,`name`","genre"=>"g.`name`");

	public function __construct() {
		parent::__construct('tracks','id','name');
	}

	public function searchTracksBasic($term, $showHidden=false) {
		$sql = "SELECT * FROM `tracks` WHERE
		`name` LIKE ? OR
		`description` LIKE ?";
		if (!$showHidden) {
			$sql .= " WHERE t.statusid=0";
		}
		$bindparams = array("%".$term."%","%".$term."%");
		if ($result = $this->executeQuery($sql,$bindparams)) {
			return $result;
		}
		return false;
	}

	public function searchPublic($search) {
		$conj = 'WHERE';
		$bindparams = array();
		$sql = "SELECT m.*,DATE_FORMAT(m.`date`,'%m/%d/%y') AS `fdate`, TIME_FORMAT(m.`length`,'%i:%s') AS `length`, g.`name` as genre
				FROM `tracks` AS m
				LEFT JOIN `genres` g ON m.`genreid`=g.`id` ";
		if ($search['text']['keywords'] || $search['text']['usage'] || $search['text']['emotion']) {
			foreach ($search['text'] as $param=>$terms) {
				if ($terms) {
					$sql .= "{$conj} ";
					$conj = 'AND';
					$keyx = explode(',',$terms);
					$sql .= '(';
					foreach($keyx as $comp) {
//todo: reimplement keyword/emotion/usage search
//						$keys = " m.`name` LIKE :track OR m.`description` LIKE :desc ".(1==2 &&(array_key_exists($param,$search['text'])) ? "OR {$param} LIKE :{$param}":"")."OR ";
						$keys = " m.`name` LIKE :track OR m.`description` LIKE :desc OR ";
						$keys = substr_replace($keys,' ) ',-3);
						$sql .= $keys;
						$bindparams[":track"] = "%".$comp."%";
						$bindparams[":desc"] = "%".$comp."%";
						/*if (array_key_exists($param,$search['text'])) {
							$bindparams[":{$param}"] = "%".$comp."%";
						}*/
					}
				}
			}
		}
		if ($search['genreid']) {
			$sql .= "{$conj} m.`genreid`=:genreid";
			$conj = 'AND';
			$bindparams[":genreid"] = $search['genreid'];
		} elseif ($search['length']) {
			$hasParam = true;
			switch ($search['length']) {
				case '00:00:29':
					$sql .= "{$conj} m.`length` <= :length";
				break;
				case '00:00:30':
				case '00:00:60':
					$sql .= "{$conj} m.`length`= :length";
				break;
				case '00:02:00':
					$sql .= "{$conj} m.`length` >= '00:01:00' AND m.`length` <= :length";
				break;
				case '00:03:00':
					$sql .= "{$conj} m.`length` >= '00:02:00' AND m.`length` <= :length ";
				break;
				case '00:03:01':
					$sql .= "{$conj} m.`length` >= '00:03:00' ";
					$hasParam = false;
				break;
			}
			if ($hasParam) {
				$bindparams[":length"] = $search['length'];
			}
			$conj = 'AND';
		}
		$sql .= " {$conj} `statusid`!=1 ORDER BY `date` DESC";
		return $this->enrichTracks($this->executeQuery($sql,$bindparams));
	}


	public function getTracks($sortBy=NULL, $showHidden=false) {
		if (!$this->checkSort($sortBy)) {
			$sortBy = "date";
		}
		$sort = $this->sortQueries[$sortBy];
		$sql = "SELECT t.* FROM `tracks` t
				LEFT JOIN `genres` g ON g.`id`=t.`genreid`";
		if (!$showHidden) {
			$sql .= " WHERE t.statusid=0";
		}
		$sql .= " ORDER BY {$sort}";
		$tracks = $this->queryWithIndex($sql,"id");
		if ($tracks) {
			$tracks = $this->enrichTracks($tracks);
		}
		return $tracks;
	}

	public function getPublicTracksByIds($trackids) {
		$sql = "SELECT m.*,DATE_FORMAT(m.date,'%m/%d/%y') AS fdate, TIME_FORMAT(m.length,'%i:%s') AS flength, g.name as genre
				FROM tracks AS m
				LEFT JOIN genres g ON m.genreid=g.id";
		$sql .= " WHERE m.id IN ({$trackids}) AND statusid!=1";
		$sql .= " ORDER BY m.date DESC";
		if ($tracks = $this->queryWithIndex($sql,'id')) {
			return $this->enrichTracks($tracks);
		}
		return false;
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
			$clibraries = $this->getSite()->getDataRepository("Libraries");
			$track[0]['libraries'] = $clibraries->getLibrariesByTrack($id);
			$track[0]['emotions'] = $this->getEmotionsByTrack($id);
			$track[0]['versions'] = $this->getTrackVersionsById($id);
			return $track[0];
		}
		return false;
	}

	protected function getTrackLink($id,$typeid) {
		$sql = "SELECT * FROM `tracks_linktypes` WHERE `id`=:typeid";
		$bindparams = array();
		$bindparams[":typeid"] = $typeid;
		$linkType = $this->executeQuery($sql,$bindparams)[0];
		if ($linkType) {
			$url = null;
			$siteid = NULL;
			$sql = "SELECT * FROM `tracks_links` WHERE `musicid`=:musicid AND `typeid`=:typeid";
			$linkResult = $this->executeQuery($sql,array(":musicid"=>$id,":typeid"=>$typeid));
			if (!empty($linkResult[0])) {
				$link = $linkResult[0];
				$url = $linkType['url'];
				if ($typeid == 11) {
					if ($link['filename']) {
						$url .= $link['filename'];
					} else {
						$url = NULL;
					}
				} elseif ($link['siteid'] != 0) {
					$url .= $link['siteid'];
					$siteid = $link['siteid'];
				} elseif ($link['filename'] != "") {
					$url .= $link['filename'];
				} else {
					$url = NULL;
				}
			}
			if ($url) {
				return array('typeid'=>$linkType['id'],'url'=>$url,'embed'=>$linkType['embed'],'siteid'=>$siteid);
			}
		}
		return null;
	}

	function getTrackLibraryLink($trackid) {
		$sql = "SELECT IF(ls.siteid!=0 OR ls.siteid IS NOT NULL, CONCAT( lt.url, ls.siteid ) , lib.url ) AS link
				FROM `libraries_tracks` l
				LEFT JOIN `libraries` lib ON lib.id=l.libraryid
				LEFT JOIN `tracks_linktypes` lt ON lt.id=lib.linktypeid
				LEFT JOIN `tracks_links` ls ON ls.typeid=lt.id AND ls.musicid=:trackid
				WHERE l.`trackid`=:trackid2
				LIMIT 0,1";
		$temp = $this->executeQuery($sql,array(":trackid"=>$trackid,":trackid2"=>$trackid));
		if (!empty($temp[0])) {
			return $temp[0]['link'];
		}
		return null;
	}

	protected function enrichTracks($tracks) {
		foreach ($tracks as &$row) {
			$row['stratus'] = $this->getTrackLink($row['id'],11);
			if (!$row['stratus']) {
				$row['soundfile'] = $this->getTrackLink($row['id'],2);
			}
			$row['license'] = $this->getTrackLibraryLink($row['id']);
		}
		return $tracks;
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

	public function updateTrack($id,$track) {
		return $this->buildUpdateStatement("tracks",$id,$track);
	}

	public function findEmotion($emotion) {
		$sql = "SELECT * FROM `emotions` WHERE `name` = :emotion";
		if ($temp = $this->executeQuery($sql,array(":emotion"=>$emotion))) {
			return $temp[0]['id'];
		}
		return false;
	}

	public function addEmotion($trackid,$emotion) {
		return $this->buildInsertStatement("emotions",array('name'=>$emotion));
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
		return $this->queryWithIndex($sql,'id',null,array(":trackid"=>$trackid));
	}

	public function getEmotions() {
		$sql = "SELECT * FROM `emotions` k ORDER BY `name`";
		return $this->executeQuery($sql);
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