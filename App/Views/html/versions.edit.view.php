<?php
$version = $parameters['version'];
echo '<form class="do-submit" name="editversion" method="POST" action="'.$app_http.'">
		<input type="hidden" name="action" value="versions" />
		<input type="hidden" name="subaction" value="update" />
		<input type="hidden" name="id" value="'.$version['id'].'" />
		<div class="column column-half">
			<label for="version[name]">Version</label>
			<input type="text" name="version[name]" value="'.$version['name'].'" />
			<label for="version[description]">Description</label>
			<textarea name="version[description]">'.$version['description'].'</textarea>
		</div>
		<input type="submit" name="submitversion" value="Update Version" />
	  </form>';
?>