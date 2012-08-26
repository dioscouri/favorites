jQuery(document).ready(function() {

	jQuery('a.addFav').live('click', function(e) {
		e.preventDefault();
		var url = jQuery(this).attr("href");
		var id = jQuery(this).attr("id");

		jQuery.getJSON(url, {
		}, function(data) {

			jQuery('#' + id).replaceWith(data.btn);
		});

	});

	jQuery('a.removeFav').live('click', function(e) {
		e.preventDefault();
		var url = jQuery(this).attr("href");
		var id = jQuery(this).attr("id");

		jQuery.getJSON(url, {
		}, function(data) {
			jQuery('#' + id).replaceWith(data.btn);
		});

	});

});

