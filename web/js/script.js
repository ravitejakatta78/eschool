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
	   
  });
   
  