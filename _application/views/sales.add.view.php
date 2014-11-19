<?php
$out .= '<form class="do-submit" name="addsale" method="POST" action="'.$app_http.'">
			<input type="hidden" name="action" value="insert" />
			<div class="column column-half">
				<label for="sale[date]">Date</label>
				<input type="text" name="sale[date]" />
				<label for="sale[trackid]">Track</label>
				<select name="sale[trackid]">';
if (!empty($tracks)) {
	foreach ($tracks as $track) {
		$out .= "	<option value=\"{$track['id']}\">{$track['name']}</option>";
	}
}
$out .= '		</select>
			</div>
			<div class="column column-half">
				<label for="sale[versionid]">Track Version</label>
				<select name="sale[versionid]">';
//todo: filter by versions of track that exist
if (!empty($versions)) {
	foreach ($versions as $version) {
		$out .= "	<option value=\"{$version['id']}\">{$version['name']}</option>";
	}
}
$out .= '		</select>
				<label for="sale[libraryid]">Library</label>
				<select name="sale[libraryid]">';
//todo: filter by tracks library is in
if (!empty($libraries)) {
	foreach ($libraries as $library) {
		$out .= "	<option value=\"{$library['id']}\">{$library['name']}</option>";
	}
}
$out .= '		</select>
			</div>
			<div class="column column-half">
				<label for="sale[total]">Total Amount</label>
				<input type="text" name="sale[total]" />
				<label for="sale[payout]">Payout</label>
				<input type="text" name="sale[payout]" />
			</div>
			<input type="submit" name="submitsale" value="Add Sale" />
		</form>';
?>