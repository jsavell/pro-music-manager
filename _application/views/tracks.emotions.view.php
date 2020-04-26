<?php
$out .= '<div class="do-results">';
foreach ($emotions as $emotion) {
	if (array_key_exists($emotion['id'], $trackEmotions)) {
		$href = "{$app_http}?action=emotions&subaction=remove&trackid={$track['id']}&emotionid={$emotion['id']}";
		$out .= "<a data-refresh-url=\"{$app_http}?action=emotions&trackid={$track['id']}\" class=\"bubble bubble-emotion selected do-remove-inline\" href=\"{$href}\">{$emotion['name']}</a>";
/*		$out .= '<form class="do-submit-inline" name="addemotion" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="emotions" />
			<input type="hidden" name="subaction" value="insert" />
			<input type="hidden" name="trackid" value="'.$track['id'].'" />
			<input type="hidden" name="emotionid" value="'.$emotion['id'].'" />
			<input type="hidden" name="refresh_url" value="'.$app_http.'?action=emotions&trackid='.$track['id'].'" />
			<input class="bubble bubble-emotion inline" type="submit" name="submitemotion" value="'.$emotion['name'].'" />
		</form>';*/
	} else {
		$out .= '<form class="do-submit-inline" name="addemotion" method="POST" action="'.$app_http.'">
					<input type="hidden" name="action" value="emotions" />
					<input type="hidden" name="subaction" value="insert" />
					<input type="hidden" name="trackid" value="'.$track['id'].'" />
					<input type="hidden" name="emotionid" value="'.$emotion['id'].'" />
					<input type="hidden" name="refresh_url" value="'.$app_http.'?action=emotions&trackid='.$track['id'].'" />
					<input class="bubble bubble-emotion inline" type="submit" name="submitemotion" value="'.$emotion['name'].'" />
				</form>';
	}
}
$out .= '</div>';
?>