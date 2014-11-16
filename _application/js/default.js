function confirmAction() {
	if (confirm("Are you sure?")) {
		return true;
	}
	return false;
}

function runDatePicker() {
	$(".date-input-db").datepicker({ dateFormat: 'yy-mm-dd' });
}

$(document).ready(function() {
/*	runDatePicker();
	$(document).ajaxComplete(function() {
		runDatePicker();
	});
*/
	$("#searchResults").click(function() {
		$("#searchStatus a.hidden").fadeIn("fast");
	});

	$("#searchStatus a").click(function(e) {
		e.preventDefault();
		$("#searchTerm").val("");
		$("#doSearch").submit();
		$(this).fadeOut("fast");
	});

	$(".container").on("submit",".do-submit",function() {
		$("#modalContent .do-results").load(app_http+" .do-results > *",$(this).serialize());
		return false;
	});

	$(".container,#theModal").on("click",".do-remove",function() {
		isModal = ($(this).parents("#theModal").length != 0) ? true:false;
		if (confirmAction()) {
			$.ajax({
				type: "POST",
				url: $(this).attr("href")
			}).done(function() {
				if (isModal) {
					$("#theModal .do-close").click();
				} else {
					$("#modalContent .do-results").load(app_http+"/ #modalContent .do-results > *");
				}
			});
		}
		return false;
	});

	$("#theModal").on("submit",".do-submit",function() {
		$.ajax({
			type: "POST",
			url: app_http,
			data: $(this).serialize(),
		}).done(function() {
			$(".do-results").load(app_http+" #modalContent .do-results > *",$(this).serialize(),function() {
				$("#theModal .do-close").click();
			});
		});
		return false;
	});

	$(".container,#theModal").on("click",".do-confirm",function() {
		return confirmAction();
	});

	$(".container,#theModal").on("click",".do-loadmodal",function(e) {
		e.preventDefault();
		$(".container").addClass("blur");
		$("#theModal .content").load($(this).attr("href")+" #modalContent > *",function() {
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