<?php
$out .= '<div class="do-results">';
if (!empty($tracks)) {
	$out .= '<table class="list">
				<tr>
					<th>Title</th>
					<th>Date</th>
					<th>Genre</th>
					<th>Description</th>
					<th>Actions</th>
				</tr>';
	foreach ($tracks as $track) {
		$out .="<tr>
					<td>{$track['name']}</td>
					<td>{$track['date']}</td>
					<td>{$genres[$track['genreid']]['name']}</td>
					<td>{$track['description']}</td>
					<td>
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=view&trackid={$track['id']}\">View</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=edit&trackid={$track['id']}\">Edit</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=keywords&trackid={$track['id']}\">Keywords</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=emotions&trackid={$track['id']}\">Emotions</a> | 
						<a class=\"do-remove\" href=\"{$app_http}?action=remove&trackid={$track['id']}\">Remove</a>
				</tr>";
	}
	$out .= '</table>';
} elseif ($data['term']) {
	$out .= '<div>No results for that search!</div>';
} else {
	$out .= '<div>No tracks, yet!</div>';
}
$out .= '</div>';
?>