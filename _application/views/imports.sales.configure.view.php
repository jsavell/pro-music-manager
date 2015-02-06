<?php
$out .= '<div>';
$out .= '	<table class="list">
				<tr>';
for ($x=0;$x<$columnCount;$x++) {
	$out .= "		<th>
						<select class=\"capitalize\" name=\"field{$x}\">
							<option value=\"\"></option>";
	foreach ($salesFields as $field) {
		$out .= "		<option value=\"{$field}\">{$field}</option>";
	}
	$out .= '			</select>
					</th>';
}
$out .= '		</tr>';
foreach ($csvData as $row) {
	$out .= '<tr>';
    $num = count($row);
    foreach ($row as $value) {
        $out .= "<td>{$value}</td>";
    }
	$out .= '</tr>';
}
$out .= '	</table>
		</div>';
?>