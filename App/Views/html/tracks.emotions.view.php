<?php
$emotions = $parameters['emotions'];
$trackEmotions = $parameters['trackEmotions'];
$track = $parameters['track'];
echo '<div class="do-results">';
foreach ($emotions as $emotion) {
	if (array_key_exists($emotion['id'], $trackEmotions)) {
		echo '<form class="do-remove-inline" name="addemotion" method="POST" action="'.$app_http.'">
				<input type="hidden" name="action" value="emotions" />
				<input type="hidden" name="subaction" value="remove" />
				<input type="hidden" name="trackid" value="'.$track['id'].'" />
				<input type="hidden" name="emotionid" value="'.$emotion['id'].'" />
				<input type="hidden" name="refresh_url" value="'.$app_http.'?action=emotions&trackid='.$track['id'].'" />
				<input class="bubble bubble-emotion selected inline" type="submit" name="submitemotion" value="'.$emotion['name'].'" />
			</form>';
	} else {
		echo '<form class="do-submit-inline" name="addemotion" method="POST" action="'.$app_http.'">
					<input type="hidden" name="action" value="emotions" />
					<input type="hidden" name="subaction" value="insert" />
					<input type="hidden" name="trackid" value="'.$track['id'].'" />
					<input type="hidden" name="emotionid" value="'.$emotion['id'].'" />
					<input type="hidden" name="refresh_url" value="'.$app_http.'?action=emotions&trackid='.$track['id'].'" />
					<input class="bubble bubble-emotion inline" type="submit" name="submitemotion" value="'.$emotion['name'].'" />
				</form>';
	}
}
echo '</div>';
?>