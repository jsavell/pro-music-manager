<?php
$tracks = $parameters['tracks'];
$library = $parameters['library'];

echo '<div class="column column-third">
			<h4>Available Tracks</h4>
 			<div id="doAddable">';
if (!empty($tracks)) {
	foreach ($tracks as $track) {
		echo "<a class=\"do-add-track\" href=\"#\" data-trackid=\"{$track['id']}\" data-name=\"{$track['name']}\">{$track['name']}</a><br />";
	}
}
echo '	</div>
		</div>
		<div class="column column-third">
			<h4>Pending Tracks</h4>
			<div id="doAddPending">
			</div>
		</div>
		 <div class="column column-third">
			<form id="doAddForm" class="do-submit" name="addtracks" method="POST" action="'.$app_http.'">
				<input type="hidden" name="action" value="tracks" />
				<input type="hidden" name="subaction" value="insert" />
				<input type="hidden" name="libraryid" value="'.$library['id'].'" />
				<input type="submit" name="submittracks" value="Add" />
			</form>
		</div>';
?>
