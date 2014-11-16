<?php
$out .= '<div class="do-results">';
if (!empty($tracks)) {
	$out .= '<table class="list">
				<tr>
					<th>Track</th>
				</tr>';
	foreach ($tracks as $track) {
		$out .="<tr>
					<td>{$track['name']}</td>
				</tr>";
	}
	$out .= '</table>';
} else {
	$out .= 'No tracks in this genre';
}
$out .= '</div>';
?>
