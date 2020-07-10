<?php
$library = $parameters['library'];
$libraryTracks = $parameters['libraryTracks'];
$statuses = $parameters['statuses'];
echo '<div class="options">
			<a class="do-loadmodal" href="'.$app_http.'?action=tracks&subaction=add&libraryid='.$library['id'].'">Add Track</a>
		</div>
		<input id="refreshUrl" type="hidden" value="'.$app_http.'?action=tracks&libraryid='.$library['id'].'" />';
echo '<div class="do-results">';
if (!empty($libraryTracks)) {
	echo '<table class="list">
				<tr>
					<th>Track</th>
					<th>Date Added</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>';
	foreach ($libraryTracks as $libraryTrack) {
		echo"<tr class=\"do-update-row\">
					<td>{$libraryTrack['name']}</td>
					<td class=\"library-track-{$libraryTrack['id']}\">
						<div class=\"default-view\">{$libraryTrack['date_added']}</div>
						<div class=\"edit-view hidden\">
							<input type=\"hidden\" name=\"action\" value=\"tracks\" />
							<input type=\"hidden\" name=\"subaction\" value=\"update\" />
							<input type=\"hidden\" name=\"id\" value=\"{$libraryTrack['id']}\" />
							<input type=\"text\" name=\"librarytrack[date_added]\" value=\"{$libraryTrack['date_added']}\" />
						</div>
					</td>
					<td class=\"library-track-{$libraryTrack['id']}\">
						<div class=\"default-view\">{$statuses[$libraryTrack['statusid']]['name']}</div>
						<div class=\"edit-view hidden\">
							<select name=\"librarytrack[statusid]\">";
		if (!empty($statuses)) {
			foreach ($statuses as $status) {
				echo "		<option".(($status['id']==$libraryTrack['statusid']) ? ' selected':'')." value=\"{$status['id']}\">{$status['name']}</option>";
			}
		}
		echo "			</select>
						</div>
					</td>
					<td>
						<a class=\"button small do-inline-edit\" href=\"library-track-{$libraryTrack['id']}\">Edit</a>
						<a class=\"button small do-inline-save hidden\" href=\"library-track-{$libraryTrack['id']}\">Save</a>
						<a class=\"button small do-inline-cancel hidden\" href=\"library-track-{$libraryTrack['id']}\">Cancel</a>
					</td>
				</tr>";
	}
	echo '</table>';
} else {
	echo 'No tracks, yet';
}
echo '</div>';
?>
