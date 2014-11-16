<?php
$out .= '<div>
			<form class="do-submit-inline" name="addkeyword" method="POST" action="'.$app_http.'">
				<input type="hidden" name="action" value="keywords" />
				<input type="hidden" name="subaction" value="insert" />
				<input type="hidden" name="trackid" value="'.$track['id'].'" />
				<input type="hidden" id="refreshUrl" name="refresh_url" value="'.$app_http.'?action=keywords&trackid='.$track['id'].'" />
				<input class="inline" type="text" name="keyword" />
				<input class="inline" type="submit" name="submitkeyword" value="Add" />
			</form>
			<div class="column do-results">
				<div>';
if (!empty($trackKeywords)) {
	foreach ($trackKeywords as $keyword) {
		$out .=	"{$keyword['name']},";
	}
}
$out .= '		</div>
			</div>
		</div>';
?>