<?php
echo '<form class="do-submit" name="addversion" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="versions" />
			<input type="hidden" name="subaction" value="insert" />
			<div class="column column-half">
				<label for="version[name]">Version</label>
				<input type="text" name="version[name]" />
				<label for="version[description]">Description</label>
				<textarea name="version[description]"></textarea>
			</div>
			<input type="submit" name="submitversion" value="Add Version" />
		</form>';
?>