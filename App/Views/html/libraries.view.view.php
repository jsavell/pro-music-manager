<?php
$library = $parameters['library'];
echo '<div class="do-results">';
echo '	<h4>'.$library['name'].'</h4>';
echo "	<dl>
			<dt>URL</dt>
			<dd>{$library['url']}</dd>
			<dt>Color</dt>
			<dd>{$library['color']}</dd>
		</dl>";
echo '</div>';
?>