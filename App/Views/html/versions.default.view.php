<?php
$out .= '<div class="options">
			<a class="do-loadmodal" href="'.$app_http.'?action=versions&subaction=add">Add</a>
		</div>';
$out .= '<div class="do-results">';
if (!empty($versions)) {
	$out .= '<table class="list">
				<tr>
					<th>Name</th>
					<th>Description</th>
					<th>Tracks</th>
					<th>Actions</th>
				</tr>';
	foreach ($versions as $version) {
		$out .="<tr>
					<td>{$version['name']}</td>
					<td>{$version['description']}</td>
					<td class=\"center\">{$version['trackcount']}</td>
					<td>
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=versions&subaction=edit&id={$version['id']}\">Edit</a> | 
						<a class=\"do-remove\" href=\"{$app_http}?action=versions&remove&id={$version['id']}\">Remove</a>
				</tr>";
	}
	$out .= '</table>';
} else {
	$out .= 'No versions, yet!';
}
$out .= '</div>';
?>