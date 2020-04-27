$(document).ready(function() {
	$("#theModal").on("click",".do-add-track",function(e) {
		e.preventDefault();
		$(this).fadeOut("fast",function() {
			$("#doAddPending").append("<div>"+$(this).attr("data-name")+"</div>");
			$("#doAddForm").append("<input type=\"hidden\" name=\"trackids[]\" value=\""+$(this).attr("data-trackid")+"\" />");
		});
	});
});
