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

	$("#theModal").on("submit",".do-submit-inline",function() {
		$form = $(this);
		$.ajax({
			type: "POST",
			url: app_http,
			data: $(this).serialize(),
		}).done(function() {
			var refreshUrl = $form.children("#refreshUrl").val();
			if (!refreshUrl) {
				refreshUrl = $form.children('input[name="refresh_url"]').val();
			}
			$("#theModal .do-results").load(refreshUrl+" #modalContent .do-results > *",$(this).serialize(),function() {
			});
		});
		return false;
	});

	$(".page-header").on("submit",".do-submit",function() {
		$("#modalContent .do-results").load(app_http+" .do-results > *",$(this).serialize());
		return false;
	});

	$(".container").on("click",".do-sort",function(e) {
		e.preventDefault();
		$("#modalContent .do-results").load($(this).attr("href")+" #modalContent .do-results > *");
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

	$("#theModal").on("click",".do-remove-inline",function(e) {
		e.preventDefault();
		if (confirmAction()) {
			var refreshUrl = $("#refreshUrl").val();
			if (!refreshUrl) {
				refreshUrl = $(this).attr("data-refresh-url");
			}
			$.ajax({
				type: "POST",
				url: app_http,
				data: $(this).serialize()
			}).done(function() {
				$("#theModal .do-results").load(refreshUrl+" #modalContent .do-results > *");
			});
		}
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

	$(".page-header,.container,#theModal").on("click",".do-loadmodal",function(e) {
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

	$(".container,#theModal").on("click",".do-inline-edit",function(e) {
		e.preventDefault();
		$(this).fadeOut("fast",function() {
			$(this).siblings(".do-inline-cancel,.do-inline-save").fadeIn("fast");
		});
		selector = "."+$(this).attr("href");
		$(selector).children(".default-view").fadeOut("fast",function() {
			$(this).siblings(".edit-view").fadeIn("fast");
		});
	});

	$(".container,#theModal").on("click",".do-inline-cancel",function(e) {
		e.preventDefault();
		$(this).fadeOut("fast",function() {
			$(this).siblings(".do-inline-save").fadeOut("fast");
			$(this).siblings(".do-inline-edit").fadeIn("fast");
		});
		selector = "."+$(this).attr("href");
		$(selector).children(".edit-view").fadeOut("fast",function() {
			$(this).siblings(".default-view").fadeIn("fast");
		});
	});

	$("#theModal").on("click",".do-inline-save",function(e) {
		e.preventDefault();
		selector = "."+$(this).attr("href");
		data = {};
		$(selector).find("input,select").each(function() {
			data[$(this).attr("name")] = $(this).val();
		});

		$.ajax({
			type: "POST",
			url: app_http,
			data: data,
		}).done(function() {
			$("#theModal .do-results").load($("#refreshUrl").val()+" #modalContent .do-results > *");
		});
	});
});