<?php
$out .= "<div class=\"column\">
			<table class=\"list\">
				<tr>
					<th>Title</th>
					<th>Genre</th>
					<th>Length</th>
					<th>Date</th>
				</tr>
				<tr>
					<td>{$track['name']}</td>
					<td>{$track['genre']}</td>
					<td>{$track['length']}</td>
					<td>{$track['date']}</td>
				</tr>
				<tr>
					<th colspan=\"4\">Description</th>
				</tr>
				<tr>
					<td colspan=\"4\">{$track['description']}</td>
				</tr>
				<tr>
					<th colspan=\"2\">Libraries</th>
					<th colspan=\"2\">Keywords</th>
				</tr>
				<tr>
					<td rowspan=\"3\" colspan=\"2\">";
if (!empty($track['libraries'])) {
	$out .= '			<table>
							<tr>
								<th>Library</th>
								<th>Date Added</th>
							</tr>';
	foreach ($track['libraries'] as $library) {
		$out .= "			<tr>
								<td>{$library['name']}</td>
								<td>{$library['date_added']}</td>
							</tr>";
	}
	$out .= '			</table>';
}
$out .= "			</td>
					<td colspan=\"2\">";
if (!empty($track['keywords'])) {
	foreach ($track['keywords'] as $keyword) {
		$out .= "{$keyword['name']},";
	}
	$out = rtrim($out,',');
}
$out .= "</td>
				</tr>
				<tr>
					<th colspan=\"2\">Emotions</th>
				</tr>
				<tr>
					<td colspan=\"2\">";
if (!empty($track['emotions'])) {
	foreach ($track['emotions'] as $emotion) {
		$out .= "{$emotion['name']},";
	}
	$out = rtrim($out,',');
}
$out .= "			</td>
				</tr>
			</table>
		</div>";
?>