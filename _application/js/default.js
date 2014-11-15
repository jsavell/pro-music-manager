function confirmAction() {
	if (confirm("Are you sure?")) {
		return true;
	}
	return false;
}

$(document).ready(function() {
	$(".container").on("submit",".do-submit",function() {
		$("#doResults").load(app_http+" #doResults",$(this).serialize());
		return false;
	});

	$(".container").on("click",".do-remove",function() {
		if (confirmAction()) {
			$.ajax({
				url: $(this).attr("href")
			}).done(function() {
				$("#doResults").load(app_http+"/ #doResults");
			});
		}
		return false;
	});

	$("#theModal").on("submit",".do-submit",function() {
		$.ajax({
			url: app_http,
			data: $(this).serialize(),
		}).done(function() {
			$("#doResults").load(app_http+" #doResults",$(this).serialize(),function() {
				$("#theModal .do-close").click();
			});
		});
		return false;
	});

	$(".container").on("click",".do-confirm",function() {
		return confirmAction();
	});

	$(".container").on("click",".do-loadmodal",function(e) {
		e.preventDefault();
		$(".container").addClass("blur");
		$("#theModal .content").load($(this).attr("href")+" #modalContent",function() {
			$("#theOverlay").fadeIn("fast",function() {
				$("#theModal").fadeIn("fast");
			});
		});
	});

	$("#theModal .do-close").click(function(e) {
		e.preventDefault();
		$("#theModal").fadeOut("fast",function() {
			$(".container").removeClass("blur");
			$("#theOverlay").fadeOut("fast");
		});
	});
});