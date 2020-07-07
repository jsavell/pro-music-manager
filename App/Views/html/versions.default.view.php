<?php
$versions = $parameters['versions'];
echo '<div class="options">
			<a class="do-loadmodal" href="'.$app_http.'?action=versions&subaction=add">Add</a>
		</div>';
echo '<div class="do-results">';
if (!empty($versions)) {
	echo '<table class="list">
				<tr>
					<th>Name</th>
					<th>Description</th>
					<th>Tracks</th>
					<th>Actions</th>
				</tr>';
	foreach ($versions as $version) {
		echo "<tr>
					<td>{$version['name']}</td>
					<td>{$version['description']}</td>
					<td class=\"center\">{$version['trackcount']}</td>
					<td>
						<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=versions&subaction=edit&id={$version['id']}\">Edit</a>
						<a class=\"button small do-remove\" href=\"{$app_http}?action=versions&remove&id={$version['id']}\">Remove</a>
				</tr>";
	}
	echo '</table>';
} else {
	echo 'No versions, yet!';
}
echo '</div>';
?>