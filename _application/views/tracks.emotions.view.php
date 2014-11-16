<?php
$out .= '<div>
			<form class="do-submit-inline" name="addemotion" method="POST" action="'.$app_http.'">
				<input type="hidden" name="action" value="emotions" />
				<input type="hidden" name="subaction" value="insert" />
				<input type="hidden" name="trackid" value="'.$track['id'].'" />
				<input type="hidden" id="refreshUrl" name="refresh_url" value="'.$app_http.'?action=emotions&trackid='.$track['id'].'" />
				<input class="inline" type="text" name="emotion" />
				<input class="inline" type="submit" name="submitemotion" value="Add" />
			</form>
			<div class="column do-results">
				<div>';
if (!empty($trackEmotions)) {
	foreach ($trackEmotions as $emotion) {
		$out .=	"<a class=\"do-remove-inline bubble bubble-emotion\" href=\"{$app_http}?action=emotions&subaction=remove&trackid={$track['id']}&emotionid={$emotion['id']}\">{$emotion['name']}</a>";
	}
}
$out .= '		</div>
			</div>
		</div>';
?>