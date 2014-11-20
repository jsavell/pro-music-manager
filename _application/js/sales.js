$(document).ready(function() {
	$("#theModal").on("change","#doTrackId",function() {
		$id = $(this);
		$("#doLibraryId").children("option").each(function() {
			$(this).prop("disabled",true);
		});

		$.ajax({type:"POST",url:app_http,data:{"action":"tracklibraries","json":1,"trackid":$(this).val()}}).done(function(data) {
			libraryids = JSON.parse(data);
			if (libraryids.length > 0) {
				$("#doLibraryId").children("option").each(function() {
					if ($.inArray($(this).val(),libraryids) != -1) {
						$(this).prop("disabled",false);
					}
				});
			}
		});
	});
});
