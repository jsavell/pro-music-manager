<?php
$out .= '<div>
			<form class="do-add-inline" name="addkeyword" method="POST" action="'.$app_http.'">
				<input type="hidden" name="action" value="keywords" />
				<input type="hidden" name="subaction" value="insert" />
				<input type="hidden" name="trackid" value="'.$track['id'].'" />
				<input class="inline" type="text" name="keyword" />
				<input class="inline" type="submit" name="submitkeyword" value="Add" />
			</form>
		</div>';
?>