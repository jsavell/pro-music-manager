<?php
$out .= '<div class="do-results">';
if (!empty($genres)) {
	$out .= '<table class="list">
				<tr>
					<th><a class="do-sort" href="'.$app_http.'?sort=name">Name</a></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=count">Track Count</a></th>
					<th>Actions</th>
				</tr>';
	foreach ($genres as $genre) {
		$out .="<tr>
					<td>{$genre['name']}</td>
					<td class=\"center\">{$genre['trackcount']}</td>
					<td>
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