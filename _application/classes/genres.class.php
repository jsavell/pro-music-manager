<?php
class genres extends dbobject {
	public function searchGenresBasic($term) {
		$sql = "SELECT * FROM `genres` WHERE
		`name` LIKE ?";
		$bindparams = array("%".$term."%");
		if ($result = $this->executeQuery($sql,$bindparams)) {
			return $result;
		}
		return false;
	}

	public function getGenres() {
		$sql = "SELECT * FROM `genres` ORDER BY `name`";
		return $this->queryWithIndex($sql,"id");
	}

	public function getGenresDetailed() {
		$sql = "SELECT g.*, (SELECT COUNT(id) FROM tracks WHERE genreid=g.id) AS trackcount FROM `genres` g ORDER BY `name`";
		return $this->queryWithIndex($sql,"id");
	}

	public function getGenreById($id) {
		$sql = "SELECT * FROM `genres` WHERE id=:id";
		return $this->executeQuery($sql,array(":id"=>$id))[0];
	}

	public function removeGenre($id) {
//TODO: handle tracks tied to the genre being removed
		$sql = "DELETE FROM `genres` WHERE id=:id";
		return $this->executeUpdate($sql,array(":id"=>$id));
	}

	public function insertGenre($genre) {
		return $this->buildInsertStatement("genres",$genre);
	}

	public function updateGenre($id,$genre) {
		return $this->buildUpdateStatement("genres",$id,$genre);
	}

}