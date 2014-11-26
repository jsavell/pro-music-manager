<?php
$out .= '<form class="do-submit" name="addgenre" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="insert" />
			<div class="column column-half">
				<label for="genre[name]">Genre</label>
				<input type="text" name="genre[name]" />
			</div>
			<input type="submit" name="submitgenre" value="Add Genre" />
		</form>';
?>