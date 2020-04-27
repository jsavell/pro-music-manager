<div class="do-results">
<?php
$tracks = $parameters['tracks'];
$genres = $parameters['genres'];

if (!empty($tracks)) {
	echo '<table class="list">
				<tr>
					<th><a class="do-sort" href="'.$app_http.'?sort=name">Title</a></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=date">Date</a></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=genre">Genre</a></th>
					<th>Description</th>
					<th>Actions</th>
				</tr>';
	foreach ($tracks as $track) {
		echo "<tr>
					<td>{$track['name']}</td>
					<td>{$track['date']}</td>
					<td>{$genres[$track['genreid']]['name']}</td>
					<td>{$track['description']}</td>
					<td class=\"actions\">
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=view&trackid={$track['id']}\">View</a>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=edit&trackid={$track['id']}\">Edit</a>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=keywords&trackid={$track['id']}\">Keywords</a>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=emotions&trackid={$track['id']}\">Emotions</a>";
						/*<a class=\"do-remove\" href=\"{$app_http}?action=remove&trackid={$track['id']}\">Remove</a>*/
		echo			'<form class="do-submit-inline" name="removetrack" method="POST" action="'.$app_http.'">
							<input type="hidden" name="action" value="remove" />
							<input type="hidden" name="trackid" value="'.$track['id'].'" />
							<input type="submit" class="small" name="submitremove" value="Remove" />
						</form>
					</td>
				</tr>';
	}
	echo '</table>';
} elseif (!empty($data['term'])) {
	echo '<div>No results for that search!</div>';
} else {
	echo '<div>No tracks, yet!</div>';
}
?>
</div>