<?php
$sale = $parameters['sale'];
$tracks = $parameters['tracks'];
$libraries = $parameters['libraries'];
$versions = $parameters['versions'];
$trackVersions = $parameters['trackVersions'];
echo '<form class="do-submit" name="addsale" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="id" value="'.$sale['id'].'" />
			<div class="column column-half">
				<label for="sale[date]">Date</label>
				<input type="text" name="sale[date]" value="'.$sale['date'].'" />
				<label for="sale[trackid]">Track</label>
				<select id="doTrackId" name="sale[trackid]">';
if (!empty($tracks)) {
	foreach ($tracks as $track) {
		echo "	<option".(($sale['trackid'] == $track['id']) ? ' selected':'')." value=\"{$track['id']}\">{$track['name']}</option>";
	}
}
echo '		</select>
			</div>
			<div class="column column-half">
				<label for="sale[versionid]">Track Version</label>
				<select id="doVersionId" name="sale[versionid]">';
if (!empty($versions)) {
	foreach ($versions as $version) {
		echo "	<option ".(((is_array($trackVersions) && !in_array($version['id'],$trackVersions)) || !is_array($trackVersions)) ? ' disabled':'').(($sale['versionid'] == $version['id']) ? ' selected':'')." value=\"{$version['id']}\">{$version['name']}</option>";
	}
}
echo '		</select>
				<label for="sale[libraryid]">Library</label>
				<select id="doLibraryId" name="sale[libraryid]">';
if (!empty($libraries)) {
	foreach ($libraries as $library) {
		echo "	<option ".(((is_array($trackLibraries) && !in_array($library['id'],$trackLibraries)) || !is_array($libraryVersions)) ? ' disabled':'').(($sale['libraryid'] == $library['id']) ? ' selected':'')." value=\"{$library['id']}\">{$library['name']}</option>";
	}
}
echo '		</select>
			</div>
			<div class="column column-half">
				<label for="sale[total]">Total Amount</label>
				<input type="text" name="sale[total]" value="'.$sale['total'].'" />
				<label for="sale[payout]">Payout</label>
				<input type="text" name="sale[payout]" value="'.$sale['payout'].'" />
			</div>
			<input type="submit" name="submitsale" value="Update Sale" />
		</form>';
?>