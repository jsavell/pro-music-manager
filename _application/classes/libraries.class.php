<?php
class libraries extends dbobject {
	protected $sortQueries = array("name"=>"name","count"=>"trackcount");

	public function searchLibrariesBasic($term) {
		$sql = "SELECT * FROM `libraries` WHERE
		`name` LIKE ?";
		$bindparams = array("%".$term."%");
		if ($result = $this->executeQuery($sql,$bindparams)) {
			return $result;
		}
		return false;
	}

	public function getLibraries() {
		$sql = "SELECT * FROM `libraries` ORDER BY `name`";
		return $this->queryWithIndex($sql,"id");
	}

	public function getLibrariesDetailed($sortBy=null) {
		if (!$this->checkSort($sortBy)) {
			$sortBy = "name";
		}
		$sort = $this->sortQueries[$sortBy];
		$sql = "SELECT l.*, (SELECT COUNT(id) FROM libraries_tracks WHERE libraryid=l.id) AS trackcount 
				FROM `libraries` l 
				ORDER BY `{$sort}`";
		return $this->queryWithIndex($sql,"id");
	}

	public function getLibraryById($id) {
		$sql = "SELECT * FROM `libraries` WHERE id=:id";
		return $this->executeQuery($sql,array(":id"=>$id))[0];
	}

	public function getDetailedLibraryById($id) {
		$sql = "SELECT * FROM `libraries` WHERE id=:id";
		return $this->executeQuery($sql,array(":id"=>$id))[0];
	}

	public function removeLibrary($id) {
//TODO: handle tracks tied to the library being removed
		$sql = "DELETE FROM `libraries` WHERE id=:id";
		return $this->executeUpdate($sql,array(":id"=>$id));
	}

	public function insertLibrary($library) {
		return $this->buildInsertStatement("libraries",$library);
	}

	public function updateLibrary($id,$library) {
		return $this->buildUpdateStatement("libraries",$id,$library);
	}

	public function addTrackToLibrary($libraryid,$trackid) {
		return $this->buildInsertStatement("libraries_tracks",array("trackid"=>$trackid,"libraryid"=>$libraryid));
	}

	public function addTracksToLibrary($libraryid,$trackids) {
		$bindparams = array();
		$sql_fields = NULL;
		$sql_values = NULL;
		$x = 1;
		foreach ($trackids as $trackid) {
			$sql_values .= "(:libraryid{$x},:trackid{$x}),";
			$bindparams[":libraryid{$x}"] = $libraryid;
			$bindparams[":trackid{$x}"] = $trackid;
			$x++;
		}
		$sql_values = rtrim($sql_values,',');
		$sql = "INSERT INTO `libraries_tracks` (`libraryid`,`trackid`) VALUES {$sql_values}";
		if ($this->executeUpdate($sql,$bindparams)) {
			return $this->getLastInsertId();
		}
		return false;
	}

	public function updateLibraryTrack($libraryid,$trackid,$data) {
		return $this->buildKeyedUpdateStatement("libraries_tracks",array("trackid"=>$trackid,"libraryid"=>$libraryid),$data);
	}

	public function getLibraryTracks($libraryid) {
		$sql = "SELECT t.*,lt.`statusid`,lt.`date_added`
				FROM `tracks` t
				LEFT JOIN `libraries_tracks` lt ON t.`id`=lt.`trackid`
				WHERE lt.`libraryid`=:libraryid";
		return $this->executeQuery($sql,array(":libraryid"=>$libraryid));
	}

	public function getLibraryIdsByTrack($trackid) {
		$sql = "SELECT l.`id`
				FROM `libraries` l
				LEFT JOIN `libraries_tracks` lt ON l.`id`=lt.`libraryid`
				WHERE lt.`trackid`=:trackid";
		if ($libraries = $this->executeQuery($sql,array(":trackid"=>$trackid))) {
			$temp = array();
			foreach ($libraries as $library) {
				$temp[] = $library['id'];
			}
			return $temp;
		}
		return false;		
	}

	public function getLibrariesByTrack($trackid) {
		$sql = "SELECT l.`id`,l.`name`,ls.`name` AS `status`,lt.`date_added`
				FROM `libraries` l
				LEFT JOIN `libraries_tracks` lt ON l.`id`=lt.`libraryid`
				LEFT JOIN `libraries_tracks_statuses` ls ON lt.`statusid`=ls.`id`
				WHERE lt.`trackid`=:trackid";
		return $this->executeQuery($sql,array(":trackid"=>$trackid));
	}

	public function getAvailableTracks($libraryid) {
		$sql = "SELECT t.`id`, t.`name` FROM `tracks` t
				WHERE t.`id` NOT IN (SELECT trackid FROM libraries_tracks lt WHERE lt.`libraryid`=:libraryid) ORDER BY t.name";
		return $this->executeQuery($sql,array(":libraryid"=>$libraryid));
	}

	public function getLibraryTrackStatuses() {
		$sql = "SELECT * FROM `libraries_tracks_statuses`";
		return $this->queryWithIndex($sql,'id');
	}
}