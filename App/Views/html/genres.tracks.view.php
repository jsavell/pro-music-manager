<?php
$tracks = $parameters['tracks'];
echo '<div class="do-results">';
if (!empty($tracks)) {
	echo '<table class="list">
				<tr>
					<th>Track</th>
				</tr>';
	foreach ($tracks as $track) {
		echo"<tr>
					<td>{$track['name']}</td>
				</tr>";
	}
	echo '</table>';
} else {
	echo 'No tracks in this genre';
}
echo '</div>';
?>
