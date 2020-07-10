<?php
$libraries = $parameters['libraries'];

echo '<div class="do-results">';
if (!empty($libraries)) {
	echo '<table class="list">
				<tr>
					<th></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=name">Library</a></th>
					<th><a class="do-sort" href="'.$app_http.'?sort=count">Tracks</a></th>
					<th>Actions</th>
				</tr>';
	foreach ($libraries as $library) {
		echo "<tr>
					<td style=\"background-color:#{$library['color']};\"></td>
					<td>{$library['name']}</td>
					<td class=\"center\">{$library['trackcount']}</td>
					<td>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=view&libraryid={$library['id']}\">View</a>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=tracks&libraryid={$library['id']}\">Tracks</a>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=edit&libraryid={$library['id']}\">Edit</a>";
		echo			'<form class="do-remove-inline" name="removelibrary" method="POST" action="'.$app_http.'">
							<input type="hidden" name="action" value="remove" />
							<input type="hidden" name="libraryid" value="'.$library['id'].'" />
							<input type="submit" class="small" name="submitremove" value="Remove" />
						</form>
					</td>
				</tr>';
	}
	echo '</table>';
} elseif ($data['term']) {
	echo '<div>No results for that search!</div>';
} else {
	echo '<div>No libraries, yet!</div>';
}
echo '</div>';
?>
