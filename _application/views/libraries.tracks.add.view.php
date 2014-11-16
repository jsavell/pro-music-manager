<?php
$out .= '<div>';
if (!empty($tracks)) {
	foreach ($tracks as $track) {
		$out .= "<a href=\"{$app_http}?action=tracks&subaction=insert&libraryid={$library['id']}&trackid={$track['id']}\">{$track['name']}</a><br />";
	}
}
$out .= '</div>';
?>
