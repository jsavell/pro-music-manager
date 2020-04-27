<div class="do-results">
<?php
$track = $parameters['track'];
echo "<div class=\"column\">
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
					<th colspan=\"2\">Description</th>
					<th colspan=\"2\">Versions</th>
				</tr>
				<tr>
					<td colspan=\"2\">{$track['description']}</td>
					<td colspan=\"2\">";
if(!empty($track['versions'])) {
	echo '			<table>';
	foreach ($track['versions'] as $trackVersion) {
		echo "			<tr>
								<td>{$versions[$trackVersion]['name']}</td>
							</tr>";
	}
	echo '			</table>';
}
echo "			</td>
				</tr>
				<tr>
					<th colspan=\"2\">Libraries</th>
					<th colspan=\"2\">Keywords</th>
				</tr>
				<tr>
					<td rowspan=\"3\" colspan=\"2\" valign=\"top\">";
if (!empty($track['libraries'])) {
	echo '			<table>
							<tr>
								<th>Library</th>
								<th>Date Added</th>
							</tr>';
	foreach ($track['libraries'] as $library) {
		echo "			<tr>
								<td>{$library['name']}</td>
								<td>{$library['date_added']}</td>
							</tr>";
	}
	echo '			</table>';
}
echo "			</td>
					<td colspan=\"2\">";
if (!empty($track['keywords'])) {
	echo $track['keywords'];
}
echo "</td>
				</tr>
				<tr>
					<th colspan=\"2\">Emotions</th>
				</tr>
				<tr>
					<td colspan=\"2\">";
if (!empty($track['emotions'])) {
	foreach ($track['emotions'] as $emotion) {
		echo "{$emotion['name']},";
	}
	$out = rtrim($out,',');
}
echo "			</td>
				</tr>
			</table>
		</div>";
echo '</div>';
?>