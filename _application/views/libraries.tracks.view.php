<?php
$out .= '<div class="options">
			<a class="do-loadmodal" href="'.$app_http.'?action=tracks&subaction=add&libraryid='.$library['id'].'">Add Track</a>
		</div>';
$out .= '<div class="do-results">';
if (!empty($tracks)) {
	$out .= '<table class="list">
				<tr>
					<th>Track</th>
					<th>Actions</th>
				</tr>';
	foreach ($tracks as $track) {
		$out .="<tr>
					<td>{$track['name']}</td>
					<td>
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=removetrack&libraryid={$library['id']}&trackid={$track['id']}\">Remove</a>
					</td>
				</tr>";
	}
	$out .= '</table>';
} else {
	$out .= 'No tracks, yet';
}
$out .= '</div>';
?>
