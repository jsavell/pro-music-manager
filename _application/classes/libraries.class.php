<?php
class libraries extends dbobject {
	public function getLibraries() {
		$sql = "SELECT * FROM `libraries` ORDER BY `name`";
		return $this->queryWithIndex($sql,"id");
	}

	public function getLibraryById($id) {
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

}