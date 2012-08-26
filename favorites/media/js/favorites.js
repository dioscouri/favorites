
	
jQuery(document).ready(function() {
	
	
	jQuery('a.addFav').click(function(e) {
		e.preventDefault();
		var url = jQuery(this).attr("href");
		alert(url);
				
		jQuery.getJSON(url,
  {
  },
  function(data) {
    alert(data.msg);
  });
		
});
});
	

	

