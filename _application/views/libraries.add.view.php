<?php
$out .= '<form class="do-submit" name="addlibrary" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="insert" />
			<div class="column column-half">
				<label for="library[name]">Library</label>
				<input type="text" name="library[name]" />
			</div>
			<input type="submit" name="submitlibrary" value="Add Library" />
		</form>';
?>
