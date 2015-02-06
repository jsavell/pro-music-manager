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
							$out .= '<table class="list">
										<tr>';
							for ($x=0;$x<$columnCount;$x++) {
								$out .= "	<th>
												<select class=\"capitalize\" name=\"field{$x}\">
													<option value=\"\"></option>";
								foreach ($salesFields as $field) {
									$out .= "		<option value=\"{$field}\">{$field}</option>";
								}
								$out .= '		</select>
											</th>';
							}
							$out .= '</tr>';
						    foreach ($csvData as $row) {
								$out .= '<tr>';
						        $num = count($row);
						        foreach ($row as $value) {
						            $out .= "<td>{$value}</td>";
						        }
								$out .= '</tr>';
						    }
							$out .= '</table>';
						}
					break;
				}
			} else {
				$viewfile = 'imports.files.new.view.php';
			}
		break;
	}
}
?>