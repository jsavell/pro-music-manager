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

	public function getSalesByLibraries() {
		$sql = "SELECT l.`id`,l.`name` as `library`, SUM(s.`total`) AS `grandtotal`,SUM(s.`payout`) AS `grandpayout`
			FROM `libraries` l 
			LEFT JOIN `sales` s on s.`libraryid`=l.`id`
			GROUP BY l.`id`
			HAVING `grandpayout` > 0
			ORDER BY `grandpayout` DESC";
		return $this->executeQuery($sql);
	}

	public function getSalesByTracks() {
		$sql = "SELECT t.`id`,t.`name` as `track`, SUM(s.`total`) AS `grandtotal`,SUM(s.`payout`) AS `grandpayout`
			FROM `tracks` t 
			LEFT JOIN `sales` s on s.`trackid`=t.`id`
			GROUP BY t.`id`
			HAVING `grandpayout` > 0
			ORDER BY `grandpayout` DESC";
		return $this->executeQuery($sql);
	}

	public function getSalesByGenres() {
		$sql = "SELECT g.id,g.name as `genre`, SUM(s.`total`) AS `grandtotal`,SUM(s.`payout`) AS `grandpayout`
			FROM `genres` g
			LEFT JOIN `tracks` t ON g.`id`=t.`genreid`
			LEFT JOIN `sales` s on s.`trackid`=t.`id`
			GROUP BY g.`id`
			HAVING `grandpayout` > 0
			ORDER BY `grandpayout` DESC";
		return $this->executeQuery($sql);
	}

	public function getSalesByYears() {
		$sql = "SELECT YEAR(s.`date`) AS `year`, SUM(s.`payout`) AS `yearpayout`, SUM(s.`total`) AS `yeartotal`
			FROM `sales` s
			GROUP BY `year`
			HAVING `yearpayout` > 0
			ORDER BY `year` DESC";
		return $this->executeQuery($sql);
	}

	public function getSaleById($id) {
		$sql = "SELECT * FROM `sales` WHERE id=:id";
		return $this->executeQuery($sql,array(":id"=>$id))[0];
	}

	public function removeSale($id) {
		$sql = "DELETE FROM `sales` WHERE id=:id";
		return $this->executeUpdate($sql,array(":id"=>$id));
	}

	public function insertSale($sale) {
		return $this->buildInsertStatement("sales",$sale);
	}

	public function bulkInsertSales($sales) {
		return $this->buildMultiRowInsertStatement('sales',$sales);
	}

	public function updateSale($id,$sale) {
		return $this->buildUpdateStatement("sales",$id,$sale);
	}

}