<?php
$genres = $parameters['genres'];
echo '<div class="do-results">';
if (!empty($genres)) {
	echo '<table class="list">
				<tr>
					<th><a class="do-sort" href="'.$app_http.'?sort=name">Name</a></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=count">Track Count</a></th>
					<th>Actions</th>
				</tr>';
	foreach ($genres as $genre) {
		echo"<tr>
					<td>{$genre['name']}</td>
					<td class=\"center\">{$genre['trackcount']}</td>
					<td>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=tracks&genreid={$genre['id']}\">Tracks</a>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=edit&genreid={$genre['id']}\">Edit</a>";
		echo '          <form class="do-remove-inline" name="removegenre" method="POST" action="'.$app_http.'">
							<input type="hidden" name="action" value="remove" />
							<input type="hidden" name="genreid" value="'.$genre['id'].'" />
							<input class="button button small inline" type="submit" name="submitgenre" value="Remove" />
						</form>
					</td>
				</tr>';
	}
	echo '</table>';
} else {
	echo 'No genres, yet!';
}
echo '</div>';
?>