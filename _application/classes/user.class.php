<?php
class user extends dbobject {
	private $sessionName;
	private $profile;
	private $passSalt;

	public function __construct() {
		parent::__construct();
		$this->sessionName = isset($_SESSION['sessionName']) ? $_SESSION['sessionName']:NULL;
		$this->passSalt = 'seIfslo#r';
		if ($this->isLoggedIn()) {
			$this->buildProfile();
		}		
	}

	public function logOut() {
		if ($this->isLoggedIn()) {
			unset($_SESSION[$this->sessionName]);
			unset($_SESSION['sessionName']);
			session_destroy();
			return true;
		}
		return false;
	}

	public function isLoggedIn() {
		if (isset($_SESSION[$this->sessionName]['user'])) {
			return true;
		}
		return false;
	}

	private function hash($plaintext) {
		return md5($this->passSalt.$plaintext);
	}

	public function logIn($username,$password) {
		$sql = "SELECT * FROM users WHERE username=:username AND password=:password";
		if ($result = $this->executeQuery($sql,array(":username"=>$username,":password"=>$this->hash($password)))) {
			$this->sessionName = "msl".time();
			$_SESSION['sessionName'] = $this->sessionName;
			foreach ($result[0] as $field=>$value) {
				$_SESSION[$this->sessionName]['user'][$field] = $value;
			}
			$this->buildProfile();
			return true;			
		}
		return false;
	}

	private function buildProfile() {
		foreach ($_SESSION[$this->sessionName]['user'] as $field=>$value) {
			$this->profile[$field] = $value;
		}
		return false;
	}

	function getProfileValue($field) {
		$temp = $this->getProfile();
		if (array_key_exists($field,$temp)) {
			return $temp[$field];
		}
		return false;
	}

	function getProfile() {
		return $this->profile;
	}

	function isAdmin() {
		if ($this->isLoggedIn() && $this->getProfileValue("isadmin")) {
			return true;
		}
		return false;
	}
}