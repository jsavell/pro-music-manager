<?php
$page['title'] = 'Import Data';
$page['navigation'] = array(
						array("name"=>"sales","action"=>"sales","modal"=>true));
$page['search'] = false;

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'sales':
			$page['subtitle'] = 'Import Sales';
			if (!empty($data['subaction'])) {
				switch ($data['subaction']) {
					case 'process':
						//todo: pass the data off to the model
					break;
					case 'configure':
						//todo: have the user define the correspondence between db field name and csv column
					break;
				}
			} else {
				$viewfile = 'imports.files.new.view.php';
			}
		break;
	}
}
?>