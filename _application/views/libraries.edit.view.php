<?php
$out .= '<form class="do-submit" name="editlibrary" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="libraryid" value="'.$library['id'].'" />
			<div class="column column-half">
				<label for="library[name]">Library</label>
				<input type="text" name="library[name]" value="'.$library['name'].'" />
			<input type="submit" name="submitlibrary" value="Update Library" />
		</form>';
?>