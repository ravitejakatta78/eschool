$(document).ready(function() {
	$("[data-toggle]").click(function() {
	  var toggle_el = $(this).data("toggle");
	  $(toggle_el).toggleClass("open-sidebar");
	});
	   
  });
  $(document).ready(function() {
	$(".sidebarclose").click(function() {
	 $('.wrapper.open-sidebar').removeClass("open-sidebar");
	});

	$('.dateselect').datepicker({
		format: 'dd-M-yyyy',
		autoclose: true,
		// startDate: '-3d'
	});
	   
  });
   
 function getSections()
 {
	let class_id = $("#class_id").val();
	var request = $.ajax({
		url: "sectionslist",
		type: "POST",
		data: {id : class_id},
	  }).done(function(msg) {
		  $('#section_id').html(msg);

	  });		 
 }