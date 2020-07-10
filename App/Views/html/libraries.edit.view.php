<?php
$library = $parameters['library'];
echo '<form class="do-submit" name="editlibrary" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="libraryid" value="'.$library['id'].'" />
			<div class="column">
				<label for="library[name]">Library</label>
				<input type="text" name="library[name]" value="'.$library['name'].'" />
			</div>
			<div class="column column-half">
				<label for="library[url]">URL</label>
				<input type="text" name="library[url]" value="'.$library['url'].'" />
			</div>
			<div class="column column-half">
				<label for="library[color]">Color</label>
				<input type="text" name="library[color]" value="'.$library['color'].'" />
			</div>
			<input type="submit" name="submitlibrary" value="Update Library" />
		</form>';
?>
