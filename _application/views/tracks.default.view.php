<?php
$out .= '<div class="do-results">';
if (!empty($tracks)) {
	$out .= '<table class="list">
				<tr>
					<th><a class="do-sort" href="'.$app_http.'?sort=name">Title</a></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=date">Date</a></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=genre">Genre</a></th>
					<th>Description</th>
					<th>Actions</th>
				</tr>';
	foreach ($tracks as $track) {
		$out .="<tr>
					<td>{$track['name']}</td>
					<td>{$track['date']}</td>
					<td>{$genres[$track['genreid']]['name']}</td>
					<td>{$track['description']}</td>
					<td class=\"actions\">
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=view&trackid={$track['id']}\">View</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=edit&trackid={$track['id']}\">Edit</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=keywords&trackid={$track['id']}\">Keywords</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=emotions&trackid={$track['id']}\">Emotions</a> | 
						<a class=\"do-remove\" href=\"{$app_http}?action=remove&trackid={$track['id']}\">Remove</a>
					</td>
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