<?php
$out .= '<div class="do-results">
			<div class="column column-two-thirds">
				<h3>Sales</h3>';
if (!empty($sales)) {
	$out .= '<table class="list">
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
		$out .= "<tr>
					<td>{$sale['date']}</td>
					<td>{$sale['track']}</td>
					<td>{$sale['version']}</td>
					<td>{$sale['library']}</td>
					<td class=\"right\">{$sale['total']}</td>
					<td class=\"right\">{$sale['payout']}</td>
					<td class=\"actions\">
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=view&id={$sale['id']}\">View</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=edit&id={$sale['id']}\">Edit</a> | 
						<a class=\"do-remove\" href=\"{$app_http}?action=remove&id={$sale['id']}\">Remove</a>
					</td>
				</tr>";
	}
	$out .= '</table>';
} elseif (!empty($data['term'])) {
	$out .= '<div>No results for that search!</div>';
} else {
	$out .= '<div>No sales, yet!</div>';
}
$out .= '</div>
		<div class="column column-third">
			<h3>Sales By Library</h3>
			<div>';
if (!empty($salesByLibraries)) {
	$out .= '<table class="list">
				<tr>
					<th>Library</th>
					<th>Total</th>
					<th>Payout</th>
				</tr>';
	foreach ($salesByLibraries as $sale) {
		$out .= "<tr>
					<td>{$sale['library']}</td>
					<td class=\"right\">{$sale['grandtotal']}</td>
					<td class=\"right\">{$sale['grandpayout']}</td>
				</tr>";
	}
	$out .= '</table>';
}
$out .= '	</div>
			<h3>Sales By Track</h3>
			<div>';
if (!empty($salesByTracks)) {
	$out .= '<table class="list">
				<tr>
					<th>Track</th>
					<th>Total</th>
					<th>Payout</th>
				</tr>';
	foreach ($salesByTracks as $sale) {
		$out .= "<tr>
					<td>{$sale['track']}</td>
					<td class=\"right\">{$sale['grandtotal']}</td>
					<td class=\"right\">{$sale['grandpayout']}</td>
				</tr>";
	}
	$out .= '</table>';
}
$out .= '	</div>
			<h3>Sales By Genre</h3>
			<div>';
if (!empty($salesByGenres)) {
	$out .= '<table class="list">
				<tr>
					<th>Genre</th>
					<th>Total</th>
					<th>Payout</th>
				</tr>';
	foreach ($salesByGenres as $sale) {
		$out .= "<tr>
					<td>{$sale['genre']}</td>
					<td class=\"right\">{$sale['grandtotal']}</td>
					<td class=\"right\">{$sale['grandpayout']}</td>
				</tr>";
	}
	$out .= '</table>';
}
$out .= '	</div>
		</div>
	</div>';
?>