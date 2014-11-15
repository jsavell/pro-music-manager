<?php
$out .= '<div class="do-results">';
if (!empty($tracks)) {
	$out .= '<table class="list">
				<tr>
					<th>Title</th>
					<th>Date</th>
					<th>Genre</th>
					<th>Description</th>
				</tr>';
	foreach ($tracks as $track) {
		$out .="<tr>
					<td>{$track['name']}</td>
					<td>{$track['date']}</td>
					<td>{$track['genreid']}</td>
					<td>{$track['description']}</td>
				</tr>";
	}
	$out .= '</table>';
} else {
	$out .= 'No tracks, yet!';
}
$out .= '</div>';
?>