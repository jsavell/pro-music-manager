<?php
$out .= '<form class="do-submit" name="addtrack" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="insert" />
			<div class="column column-half">
				<label for="track[name]">Title</label>
				<input type="text" name="track[name]" />
				<label for="track[description]">Description</label>
				<textarea name="track[description]"></textarea>
				<select name="track[genreid]">
					<option value="0">No Genre</option>';
if (!empty($genres)) {
	foreach ($genres as $genre) {
		$out .= "	<option value=\"{$genre['id']}\">{$genre['name']}</option>";
	}
}
$out .= '		</select>
				<label for="track[length]">Length</label>
				<input type="text" name="track[length]" />
				<label for="track[date]">Date</label>
				<input type="text" name="track[date]" />
			</div>
			<input type="submit" name="submittrack" value="Add Track" />
		</form>';
?>