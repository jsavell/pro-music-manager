<?php
$out .= '<form class="do-submit" name="updatetrack" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="trackid" value="'.$track['id'].'" />
			<div class="column column-third">
				<label for="track[name]">Title</label>
				<input type="text" name="track[name]" value="'.$track['name'].'" />
				<label for="track[genreid]">Genre</label>
				<select name="track[genreid]">
					<option value="">Select a Genre</option>';
if (!empty($genres)) {
	foreach ($genres as $genre) {
		$out .= "	<option".(($track['genreid'] == $genre['id']) ? ' selected':'')." value=\"{$genre['id']}\">{$genre['name']}</option>";
	}
}
$out .= '		</select>
				<label for="track[statusid]">Status</label>
				<select name="track[statusid]">
					<option'.(($track['statusid'] == 0) ? ' selected':'').' value="0">Public</option>
					<option'.(($track['statusid'] == 1) ? ' selected':'').' value="1">Hidden</option>
				</select>
			</div>
			<div class="column column-third">
				<label for="track[length]">Length</label>
				<input type="text" name="track[length]" value="'.$track['length'].'" />
				<label for="track[date]">Date</label>
				<input type="text" name="track[date]" value="'.$track['date'].'" />

			</div>
			<div class="column column-third">
				<label for="versionids[]">Track Versions</label>
				<select multiple name="versionids[]">';
if (!empty($versions)) {
	foreach ($versions as $version) {
		$out .= "	<option".((is_array($track['versions']) && in_array($version['id'],$track['versions'])) ? ' selected':'')." value=\"{$version['id']}\">{$version['name']}</option>";
	}
}
$out .= '		</select>
			</div>
			<div class="column">
				<label for="track[description]">Description</label>
				<textarea name="track[description]">'.$track['description'].'</textarea>
			</div>
			<input type="submit" name="submittrack" value="Update Track" />
		</form>';
?>