<?php
$out .= '<div class="do-results">';
if (!empty($genres)) {
	$out .= '<table class="list">
				<tr>
					<th>Name</th>
					<th>Actions</th>
				</tr>';
	foreach ($genres as $genre) {
		$out .="<tr>
					<td>{$genre['name']}</td>
					<td>
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=view&genreid={$genre['id']}\">View</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=tracks&genreid={$genre['id']}\">Tracks</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=edit&genreid={$genre['id']}\">Edit</a> | 
						<a class=\"do-remove\" href=\"{$app_http}?action=remove&genreid={$genre['id']}\">Remove</a>
				</tr>";
	}
	$out .= '</table>';
} else {
	$out .= 'No genres, yet!';
}
$out .= '</div>';
?>