<?php
namespace App\Classes\Data;
use Core\Classes\Data as CoreData;

class Users extends CoreData\AbstractDataBaseRepository {
	public function __construct() {
		parent::__construct('users','id','lastname,firstname,username',array('username','first','lastname'),array('username','firstname','lastname'));
	}

	private function buildBaseUserSql() {
		return "SELECT ".(($this->gettableColumns) ? "id,".implode(",",$this->gettableColumns):"*")." FROM {$this->primaryTable}";
	}

	public function get() {
		$sql = "{$this->buildBaseUserSql()}";

		if ($this->defaultOrderBy) {
			$sql .= " ORDER BY {$this->defaultOrderBy}";
		}
		return $this->queryWithIndex($sql,$this->primaryKey);
	}
}
