<?php
$out .= '<div class="do-results">';
if (!empty($libraries)) {
	$out .= '<table class="list">
				<tr>
					<th><a class="do-sort" href="'.$app_http.'?sort=name">Library</a></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=count">Tracks</a></th>
					<th>Actions</th>
				</tr>';
	foreach ($libraries as $library) {
		$out .="<tr>
					<td>{$library['name']}</td>
					<td class=\"center\">{$library['trackcount']}</td>
					<td>
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=view&libraryid={$library['id']}\">View</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=tracks&libraryid={$library['id']}\">Tracks</a> | 
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
