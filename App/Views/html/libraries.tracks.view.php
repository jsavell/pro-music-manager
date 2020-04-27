<?php
$out .= '<div class="options">
			<a class="do-loadmodal" href="'.$app_http.'?action=tracks&subaction=add&libraryid='.$library['id'].'">Add Track</a>
		</div>
		<input id="refreshUrl" type="hidden" value="'.$app_http.'?action=tracks&libraryid='.$library['id'].'" />';
$out .= '<div class="do-results">';
if (!empty($tracks)) {
	$out .= '<table class="list">
				<tr>
					<th>Track</th>
					<th>Date Added</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>';
	foreach ($tracks as $track) {
		$out .="<tr class=\"do-update-row\">
					<td>{$track['name']}</td>
					<td class=\"library-track-{$track['id']}\">
						<div class=\"default-view\">{$track['date_added']}</div>
						<div class=\"edit-view hidden\">
							<input type=\"hidden\" name=\"action\" value=\"tracks\" />
							<input type=\"hidden\" name=\"subaction\" value=\"update\" />
							<input type=\"hidden\" name=\"trackid\" value=\"{$track['id']}\" />
							<input type=\"hidden\" name=\"libraryid\" value=\"{$library['id']}\" />
							<input type=\"text\" name=\"librarytrack[date_added]\" value=\"{$track['date_added']}\" />
						</div>
					</td>
					<td class=\"library-track-{$track['id']}\">
						<div class=\"default-view\">{$statuses[$track['statusid']]['name']}</div>
						<div class=\"edit-view hidden\">
							<select name=\"librarytrack[statusid]\">";
		if (!empty($statuses)) {
			foreach ($statuses as $status) {
				$out .= "		<option".(($status['id']==$track['statusid']) ? ' selected':'')." value=\"{$status['id']}\">{$status['name']}</option>";
			}
		}
		$out .= "			</select>
						</div>
					</td>
					<td>
						<a class=\"do-inline-edit\" href=\"library-track-{$track['id']}\">Edit</a>
						<a class=\"do-inline-save hidden\" href=\"library-track-{$track['id']}\">Save</a>
						<a class=\"do-inline-cancel hidden\" href=\"library-track-{$track['id']}\">Cancel</a>
					</td>
				</tr>";
	}
	$out .= '</table>';
} else {
	$out .= 'No tracks, yet';
}
$out .= '</div>';
?>
