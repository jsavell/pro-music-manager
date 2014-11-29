<?php
$page['title'] = 'Import Data';
$page['navigation'] = array(
						array("name"=>"sales","action"=>"sales","modal"=>false));
$page['search'] = false;

if (isset($data['action'])) {
	switch ($data['action']) {
		case 'sales':
			$page['subtitle'] = 'Import Sales';
		break;
	}
}
?>