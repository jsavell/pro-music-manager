<?php
echo '<form class="do-submit" name="addlibrary" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="insert" />
			<div class="column">
				<label for="library[name]">Library</label>
				<input type="text" name="library[name]" />
			</div>
			<div class="column column-half">
				<label for="library[url]">URL</label>
				<input type="text" name="library[url]" />
			</div>
			<div class="column column-half">
				<label for="library[color]">Color</label>
				<input type="text" name="library[color]" />
			</div>

			<input type="submit" name="submitlibrary" value="Add Library" />
		</form>';
?>
