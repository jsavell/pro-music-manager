<?php
namespace App\Classes\Controllers;
use App\Classes\Data as AppClasses;
use Core\Classes as Core;

/**
 * An app level base controller for handling shared behavior across app Controllers
 *
 * @author Jason Savell <jsavell@library.tamu.edu>
 */
abstract class AppController extends Core\AbstractController {
	protected $inputData;
	protected $viewRenderer;
	protected $globalUser;

	public function __construct($site,$controllerConfig=null) {
		$this->setViewRenderer($site->getViewRenderer());
		parent::__construct($site,$controllerConfig);
		$this->setInputData($this->getSite()->getSanitizedInputData());
		$this->setGlobalUser($this->getSite()->getGlobalUser());
	}

	protected function setInputData($inputData) {
		$this->inputData = $inputData;
	}

	protected function getInputData() {
		return $this->inputData;
	}

	protected function setViewRenderer($viewRenderer) {
		$this->viewRenderer = $viewRenderer;
	}

	protected function getViewRenderer() {
		return $this->viewRenderer;
	}

	protected function setGlobalUser($globalUser) {
		$this->globalUser = $globalUser;
	}

	protected function getGlobalUser() {
		return $this->globalUser;
	}
}
