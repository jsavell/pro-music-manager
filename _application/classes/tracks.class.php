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
}