<?php
$sales = $parameters['sales'];
$salesByYears = $parameters['salesByYears'];
$salesByLibraries = $parameters['salesByLibraries'];
$salesByTracks = $parameters['salesByTracks'];
$salesByGenres = $parameters['salesByGenres'];

echo '<div class="do-results">';
if (!empty($salesByYears)) {
	echo '	<div class="right" id="yearlyPayouts">';
	foreach ($salesByYears as $year) {
		echo "<h1 class=\"inline-block\"><span>{$year['year']} //</span> <a onclick=\"return false;\" href=\"#\" title=\"total: \${$year['yeartotal']} / payout: \${$year['yearpayout']}\">\${$year['yearpayout']}</a></h1>";
	}
	echo '	</div>';
}
echo '	<div class="column column-two-thirds">
				<h3>Sales</h3>';
if (!empty($sales)) {
	echo '	<table class="list">
					<tr>
						<th>Date</th>
						<th>Track</th>
						<th>Version</th>
						<th>Library</th>
						<th>Total</th>
						<th>Payout</th>
						<th>Actions</th>
					</tr>';
	foreach ($sales as $sale) {
		echo "	<tr>
						<td>{$sale['date']}</td>
						<td>{$sale['track']}</td>
						<td>{$sale['version']}</td>
						<td>{$sale['library']}</td>
						<td class=\"right\">\${$sale['total']}</td>
						<td class=\"right\">\${$sale['payout']}</td>
						<td class=\"actions\">
							<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=view&id={$sale['id']}\">View</a>
							<a class=\"button small do-loadmodal\" href=\"{$app_http}?action=edit&id={$sale['id']}\">Edit</a>";
		echo			'	<form class="do-remove-inline" name="removesale" method="POST" action="'.$app_http.'">
								<input type="hidden" name="action" value="remove" />
								<input type="hidden" name="id" value="'.$sale['id'].'" />
								<input type="submit" class="small" name="submitremove" value="Remove" />
							</form>
						</td>
					</tr>';
	}
	echo '	</table>';
} elseif (!empty($data['term'])) {
	echo '	<div>No results for that search!</div>';
} else {
	echo '	<div>No sales, yet!</div>';
}
echo '	</div>
			<div class="column column-third">';
echo '		<h3>Sales By Library</h3>
				<div>';
if (!empty($salesByLibraries)) {
	echo '		<table class="list">
						<tr>
							<th>Library</th>
							<th>Total</th>
							<th>Payout</th>
						</tr>';
	foreach ($salesByLibraries as $sale) {
		echo "		<tr>
							<td>{$sale['library']}</td>
							<td class=\"right\">\${$sale['grandtotal']}</td>
							<td class=\"right\">\${$sale['grandpayout']}</td>
						</tr>";
	}
	echo '	</table>';
}
echo '	</div>
			<h3>Sales By Track</h3>
			<div>';
if (!empty($salesByTracks)) {
	echo '	<table class="list">
					<tr>
						<th>Track</th>
						<th>Total</th>
						<th>Payout</th>
					</tr>';
	foreach ($salesByTracks as $sale) {
		echo "	<tr>
						<td>{$sale['track']}</td>
						<td class=\"right\">\${$sale['grandtotal']}</td>
						<td class=\"right\">\${$sale['grandpayout']}</td>
					</tr>";
	}
	echo '	</table>';
}
echo '	</div>
			<h3>Sales By Genre</h3>
			<div>';
if (!empty($salesByGenres)) {
	echo '<table class="list">
				<tr>
					<th>Genre</th>
					<th>Total</th>
					<th>Payout</th>
				</tr>';
	foreach ($salesByGenres as $sale) {
		echo "<tr>
					<td>{$sale['genre']}</td>
					<td class=\"right\">\${$sale['grandtotal']}</td>
					<td class=\"right\">\${$sale['grandpayout']}</td>
				</tr>";
	}
	echo '</table>';
}
echo '	</div>
		</div>
	</div>';
?>