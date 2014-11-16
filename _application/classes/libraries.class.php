<?php
class libraries extends dbobject {
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

	public function getLibraryTracks($libraryid) {
		$sql = "SELECT t.* FROM `tracks` t
				LEFT JOIN `libraries_tracks` lt ON t.`id`=lt.`trackid`
				WHERE lt.`libraryid`=:libraryid";
		return $this->executeQuery($sql,array(":libraryid"=>$libraryid));
	}

	public function getAvailableTracks($libraryid) {
		$sql = "SELECT t.* FROM `tracks` t
				LEFT JOIN `libraries_tracks` lt ON t.`id`=lt.`trackid`
				WHERE lt.`libraryid`!=:libraryid";
		return $this->executeQuery($sql,array(":libraryid"=>$libraryid));
	}
}