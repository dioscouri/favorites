if( typeof (Favorites) === 'undefined') {
		var Favorites = {};
	}

	Favorites.addFormFavorite = function(container, msg) {
		var url = '/index.php?option=com_favorites&task=addFavorite&format=raw&view=items';
		Dsc.doTask(url, container, document.favForm, msg, true, Dsc.update() );
	}
	Favorites.addArrayFavorite = function(container, msg, array) {
		var url = '/index.php?option=com_favorites&task=addFavorite&format=raw&view=items';
		
		//custom Function here to add a favorite  based on an array of values instead of  form
		
		Dsc.doTaskArray(url, container, array, msg, true );
	}
	Favorites.removeFavorite = function(container, msg, id) {
		var url = '/index.php?option=com_favorites&task=removeFavorite&format=raw&view=items';
		
		// custom function that only requires an Id, make sure that only the user that owns the favorite can delete it. but that is in  controller.
		
		Dsc.doTask(url, container, document.form, msg, false, Dsc.showHideDiv('fav' + id));
	}
	

