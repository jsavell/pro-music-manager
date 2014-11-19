<?php
class sales extends dbobject {
	public function searchSalesBasic($term) {
/*
		$sql = "SELECT * FROM `sales` WHERE
		`name` LIKE ?";
		$bindparams = array("%".$term."%");
		if ($result = $this->executeQuery($sql,$bindparams)) {
			return $result;
		}
*/
		return false;
	}

	public function getSales() {
		$sql = "SELECT s.*,t.`name` AS `track`,l.`name` AS `library`,'version' AS `version`
				FROM `sales` s
				LEFT JOIN `tracks` t ON t.`id`=s.`trackid`
				LEFT JOIN `libraries` l ON l.`id`=s.`libraryid`
				ORDER BY `date` DESC";
		return $this->queryWithIndex($sql,"id");
	}

	public function getSaleId($id) {
		$sql = "SELECT * FROM `sales` WHERE id=:id";
		return $this->executeQuery($sql,array(":id"=>$id))[0];
	}

	public function removeSale($id) {
		$sql = "DELETE FROM `sales` WHERE id=:id";
		return $this->executeUpdate($sql,array(":id"=>$id));
	}

	public function insertSale($sale) {
		return $this->buildInsertStatement("sales",$genre);
	}

	public function updateSale($id,$sale) {
		return $this->buildUpdateStatement("sales",$id,$sale);
	}

}