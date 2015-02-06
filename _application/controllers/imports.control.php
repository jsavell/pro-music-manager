<?php
$page['title'] = 'Import Data';
$page['navigation'] = array(
						array("name"=>"sales","action"=>"sales","modal"=>true));
$page['search'] = false;

function processFile($file) {
	if (($handle = fopen($file, "r")) !== FALSE) {
		$csvData = array();
		$rowCount = 0;
	    while (($csvRow = fgetcsv($handle, 1000, ",")) !== FALSE) {
	        $num = count($csvRow);
	        for ($c=0; $c < $num; $c++) {
				$csvData[$rowCount][$c] = $csvRow[$c]; 
	        }
			$rowCount++;
	    }
	    fclose($handle);
		return $csvData;
	}
	return false;
}

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
						$salesFields = array('date','track','version','library','total','payout');
						$fieldCount = count($salesFields);
						if ($csvData = processFile($_FILES['fileupload']['tmp_name'])) {
							$columnCount = count($csvData[0]);

						}
						$viewfile = 'imports.sales.configure.view.php';
					break;
				}
			} else {
				$viewfile = 'imports.files.new.view.php';
			}
		break;
	}
}
?>