<?php
$out .= '<div>
			<form id="importFile" name="importFile" method="POST" action="'.$app_http.'" enctype="multipart/form-data">
				<input type="hidden" name="action" value="sales" />
				<input type="hidden" name="subaction" value="configure" />
				<input type="file" name="fileupload" />
				<input type="submit" name="submit_import" value="Upload File" />
			</form>
		</div>';
?>