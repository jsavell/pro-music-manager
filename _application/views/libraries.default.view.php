<?php
$out .= '<div class="do-results">';
if (!empty($libraries)) {
	$out .= '<table class="list">
				<tr>
					<th>Name</th>
					<th>Actions</th>
				</tr>';
	foreach ($libraries as $library) {
		$out .="<tr>
					<td>{$library['name']}</td>
					<td>
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=edit&libraryid={$library['id']}\">Edit</a> | 
						<a class=\"do-remove\" href=\"{$app_http}?action=remove&libraryid={$library['id']}\">Remove</a>
				</tr>";
	}
	$out .= '</table>';
} elseif ($data['term']) {
	$out .= '<div>No results for that search!</div>';
} else {
	$out .= '<div>No libraries, yet!</div>';
}
$out .= '</div>';
?>
