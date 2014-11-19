<?php
$out .= '<div class="do-results">';
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
					<td>{$sale['total']}</td>
					<td>{$sale['payout']}</td>
					<td class=\"actions\">
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=view&trackid={$sale['id']}\">View</a> | 
						<a class=\"do-loadmodal\" href=\"{$app_http}?action=edit&trackid={$sale['id']}\">Edit</a> | 
						<a class=\"do-remove\" href=\"{$app_http}?action=remove&trackid={$sale['id']}\">Remove</a>
				</tr>";
	}
	$out .= '</table>';
} elseif (!empty($data['term'])) {
	$out .= '<div>No results for that search!</div>';
} else {
	$out .= '<div>No sales, yet!</div>';
}
$out .= '</div>';
?>