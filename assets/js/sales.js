$(document).ready(function() {
	function updateTrackFields(trackid) {
		$.ajax({type:"GET",url:app_http,data:{"action":"tracklibraries","json":1,"trackid":trackid}}).done(function(data) {
			libraryids = data["libraries"];
			if (libraryids.length > 0) {
				$("#doLibraryId").children("option").each(function() {
					if ($.inArray($(this).val(),libraryids) != -1) {
						$(this).prop("disabled",false);
					}
				});
			}
		});

		$.ajax({type:"GET",url:path_http+"tracks/",data:{"action":"versions","subaction":"trackversions","json":1,"trackid":trackid}}).done(function(data) {
			versionids = data["versionids"];
			if (versionids.length > 0) {
				$("#doVersionId").children("option").each(function() {
					if ($.inArray($(this).val(),versionids) != -1) {
						$(this).prop("disabled",false);
					}
				});
			}
		});
	}

	$("#theModal").on("change","#doTrackId",function() {
		$id = $(this);
		$("#doLibraryId").children("option").each(function() {
			$(this).prop("disabled",true);
		});

		$("#doVersionId").children("option").each(function() {
			$(this).prop("disabled",true);
		});
		updateTrackFields($(this).val());
	});
});
