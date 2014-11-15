<?php
$out .= '<form class="do-submit" name="updatetrack" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="trackid" value="'.$track['id'].'" />
			<div class="column column-half">
				<label for="track[name]">Title</label>
				<input type="text" name="track[name]" value="'.$track['name'].'" />
				<label for="track[description]">Description</label>
				<textarea name="track[description]">'.$track['description'].'</textarea>
				<select name="track[genreid]">
					<option value="0">No Genre</option>';
if (!empty($genres)) {
	foreach ($genres as $genre) {
		$out .= "	<option".(($track['genreid'] == $genre['id']) ? ' selected':'')." value=\"{$genre['id']}\">{$genre['name']}</option>";
	}
}
$out .= '		</select>
				<label for="track[length]">Length</label>
				<input type="text" name="track[length]" value="'.$track['length'].'" />
				<label for="track[date]">Date</label>
				<input type="text" name="track[date]" value="'.$track['date'].'" />
			</div>
			<input type="submit" name="submittrack" value="Update Track" />
		</form>';
?>