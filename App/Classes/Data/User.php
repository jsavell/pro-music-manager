<?php
namespace App\Classes\Data;
use Core\Classes\Data as CoreData;

class User extends CoreData\UserDB {
	public function logIn($username,$password) {
		session_regenerate_id(true);
		$sql = "SELECT id,password FROM {$this->primaryTable} WHERE username=:username";
		echo $sql;
		if ($result = $this->executeQuery($sql,array(":username"=>$username))) {
			if (password_verify($password,$result[0]['password'])) {
				$this->setSessionUserId($result[0]['id']);
				return true;
			}
		}
		return false;
	}

}