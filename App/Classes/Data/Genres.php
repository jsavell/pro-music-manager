<?php
namespace App\Classes\Data;

class Genres extends AppDatabaseRepository {
	protected $sortQueries = array("name"=>"name","count"=>"trackcount");

	public function __construct() {
		parent::__construct('genres','id','name');
	}

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

	public function getGenresDetailed($sortBy=null) {
		if (!$this->checkSort($sortBy)) {
			$sortBy = "name";
		}
		$sort = $this->sortQueries[$sortBy];
		$sql = "SELECT g.*, (SELECT COUNT(id) FROM tracks WHERE genreid=g.id) AS trackcount FROM `genres` g ORDER BY `{$sort}`";
		return $this->queryWithIndex($sql,"id");
	}

	public function getGenreById($id) {
		$sql = "SELECT * FROM `genres` WHERE id=:id";
		return $this->executeQuery($sql,array(":id"=>$id))[0];
	}
}