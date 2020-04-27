<?php
$out .= '<form class="do-submit" name="editgenre" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="genreid" value="'.$genre['id'].'" />
			<div class="column column-half">
				<label for="genre[name]">Genre</label>
				<input type="text" name="genre[name]" value="'.$genre['name'].'" />
			</div>
			<input type="submit" name="submitgenre" value="Update Genre" />
		</form>';
?>