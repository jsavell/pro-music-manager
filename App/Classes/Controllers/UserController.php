<?php
namespace App\Classes\Controllers;

class UserController extends AppController {
	private $usersRepo;

	public function configure() {
		$this->usersRepo = $this->getSite()->getDataRepository("Users");
		$this->getSite()->getViewRenderer()->registerAppContextProperty("app_http", "{$this->getSite()->getSiteConfig()['PATH_HTTP']}login.php");
		$this->getPage()->setTitle('User');
	}

	protected function update() {
		$data = $this->getInputData();
		if (isset($data['user']) && $this->usersRepo->update($this->getGlobalUser()->getProfileValue("id"),$data['user'])) {
			$this->getSite()->addSystemMessage('User updated');
		} else {
			$this->getSite()->addSystemError('Error updating user');
		}
	}

	protected function edit() {
		$this->getPage()->setSubTitle('Edit Profile');
		$this->getViewRenderer()->registerViewVariable("user",$this->getGlobalUser()->getProfile());
		$this->setViewName('user.edit');
	}

	protected function login() {
		$data = $this->getInputData();
		if ($data['user']['username'] && $data['user']['password']) {
			if ($this->getGlobalUser()->logIn($data['user']['username'],$data['user']['password'])) {
				$this->getSite()->setRedirectUrl("{$this->getSite()->getSiteConfig()['PATH_HTTP']}");
			} else {
				$this->getSite()->addSystemError('Invalid username/password combination');
				$this->setViewName("user.login");
			}
		} else {
			$this->getSite()->addSystemError('Please provide both your username and password');
		}
	}

	protected function logout() {
		if ($this->getGlobalUser()->isLoggedIn()) {
			if ($this->getGlobalUser()->logOut()) {
				$this->getSite()->addSystemMessage("You've been logged out");
				$this->setViewName("user.login");
			} else {
				$this->getSite()->addSystemError('There was an error logging you out');
			}
		} else {
			$this->getSite()->addSystemError("You don't seem to be logged in");
			$this->setViewName("user.login");
		}
	}

	protected function loadDefault() {
		if ($this->getGlobalUser()->isLoggedIn()) {
			$this->setViewName("user.info");
		} else {
			$this->setViewName("user.login");
		}
	}

	protected function setGlobalUser($globalUser) {
		$this->globalUser = $globalUser;
	}

	protected function getGlobalUser() {
		return $this->globalUser;
	}
}
?>