if( typeof (Favorites) === 'undefined') {
		var Favorites = {};
	}

	Favorites.addFormFavorite = function(container, msg) {
		var url = '/index.php?option=com_favorites&task=addFavorite&format=raw&view=items';
		Dsc.doTask(url, container, document.favForm, msg, true );
	}
	Favorites.addArrayFavorite = function(container, msg, array) {
		var url = '/index.php?option=com_favorites&task=addFavorite&format=raw&view=items';
		Dsc.doTaskArray(url, container, array, msg, true );
	}
	Favorites.removeFavorite = function(container, msg, id) {
		var url = '/index.php?option=com_favorites&task=removeFavorite&format=raw&view=items';
		Dsc.doTaskArray(url, container, document.form, msg, false, Dsc.showHideDiv('fav' + id));
	}
	

