<?php
$track = $parameters['track'];
echo '<div class="do-results">
			<form class="do-submit" name="addkeywords" method="POST" action="'.$app_http.'">
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="trackid" value="'.$track['id'].'" />
				<textarea name="track[keywords]">'.$track['keywords'].'</textarea>
				<input class="inline" type="submit" name="submitkeywords" value="Update Keywords" />
			</form>
		</div>';
?>