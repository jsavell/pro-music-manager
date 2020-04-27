<?php
namespace App\Classes\Data;
use Core\Classes\Data as CoreData;

class AppDatabaseRepository extends CoreData\AbstractDataBaseRepository {
	protected function checkSort($sortBy) {
		if ($sortBy && array_key_exists($sortBy,$this->sortQueries)) {
			return $sortBy;
		}
		return false;
	}
}