<?php
class genres extends dbobject {
	public function getGenres() {
		$sql = "SELECT * FROM `genres` ORDER BY `name`";
		return $this->queryWithIndex($sql,"id");
	}

	public function getGenreById($id) {
		$sql = "SELECT * FROM `genres` WHERE id=:id";
		$this->executeQuery($sql,array(":id"=>$id))[0];
	}

	public function removeGenre($id) {
//TODO: handle tracks tied to the genre being removed
		$sql = "DELETE FROM `genres` WHERE id=:id";
		return $this->executeUpdate($sql,array(":id"=>$id));
	}

	public function insertGenre($genre) {
		return $this->buildInsertStatement("genres",$key);
	}

	public function updateGenre($id,$genre) {
		return $this->buildUpdateStatement("genres",$id,$genre);
	}

}