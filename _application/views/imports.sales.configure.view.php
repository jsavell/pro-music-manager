<?php
$out .= '<div>
			<form name="processsales" method="POST" action="'.$app_http.'">
				<input type="hidden" name="action" value="sales" />
				<input type="hidden" name="subaction" value="process" />
				<input type="submit" name="submit_sales" value="Import Sales" />';
$out .= '		<table class="list">
					<tr>';
for ($x=0;$x<$columnCount;$x++) {
	$out .= "			<th>
							<select class=\"capitalize\" name=\"fields[field{$x}]\">
								<option value=\"\"></option>";
	foreach ($salesFields as $field) {
		$out .= "				<option value=\"{$field}\">{$field}</option>";
	}
	$out .= '				</select>
						</th>';
}
$out .= '			</tr>';
$x=0;
foreach ($csvData as $row) {
	$out .= '		<tr>';
	$y = 0;
    foreach ($row as $value) {
        $out .= "		<td><input type=\"text\" name=\"sales[{$x}][field{$y}]\" value=\"{$value}\" /></td>";
		$y++;
    }
	$out .= '		</tr>';
	$x++;
}
$out .= '		</table>
			</form>
		</div>';
?>