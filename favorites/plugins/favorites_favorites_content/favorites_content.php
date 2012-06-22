<?php
/**
 * @version 1.5
 * @package Favorites
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

// Check the registry to see if our Favorites class has been overridden
if (!class_exists('Favorites'))
	JLoader::register("Favorites", JPATH_ADMINISTRATOR . DS . "components" . DS . "com_favorites" . DS . "defines.php");

Favorites::load('FavoritesPluginBase', 'library.plugin.base');

class plgContentFavorites_Content extends FavoritesPluginBase {

	public $_element = 'favorites';
	public $dot_path_prefix = 'favorites_url.';
	public $path_prefix = 'favorites_url/';
	public $plain_name = 'FavoriteUrl';
	public $full_path = '';
	public $relative_path = '';
	public $url = '';
	public $showaddlink = '';
	var $function = 'onContentBeforeDisplay';

	function __construct(&$subject, $config) {
		parent::__construct($subject, $config);

		// Get the application object.
		$app = JFactory::getApplication();
		$uri = JFactory::getURI();
		$this -> url = $uri -> getPath();

		$params = json_decode($config['params']);
		$this -> showaddlink = $params -> showaddlink;

		// was getting a Jmodel Error when using the admin not sure why
		if (!$app -> isAdmin()) {
			JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_favorites/tables');
			JModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_favorites/models');
		}

		$this -> function = 'onContentBeforeDisplay';

		$doc = JFactory::getDocument();

		$js = "
		
		if( typeof (FavoritesContent) === 'undefined') {
		var FavoritesContent = {};
	}

	FavoritesContent.addNewFavorite = function(container, msg) {
		var url = '/index.php?option=com_favorites&task=doTaskAjax&format=raw&view=items&element=favorites_content&elementTask=addNewFavorite';
		Dsc.doTask(url, container, document.favFormContent, msg, true);
		Dsc.update()
	}
	FavoritesContent.removeFavorite = function(container, msg, id) {
		var url = '/index.php?option=com_favorites&task=doTaskAjax&format=raw&view=items&element=favorites_content&elementTask=removeFavorite';
		Dsc.doTask(url, container, document.favFormContent, msg, false, Dsc.showHideDiv('fav' + id));
	}
		
		
		";
		$doc -> addScriptDeclaration($js);
	}

	function showAddbutton($url, $name) {

		$db = JFactory::getDBO();
		$user = JFactory::getUser();

		if ($user -> id == 0) {
			return FALSE;
		}
		$query = "select count(*) from `#__favorites_items` where `type` = 'content' AND `name` = '{$name}' AND `url` = '{$url}' AND `user_id` = '{$user->id}' limit 1";

		$db -> setQuery($query);
		$result = $db -> loadResult();

		if ($result == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function addButton() {
		$html = '';
		$html .= '<button class="FavoritesContent" onclick="document.favFormContent.add_type.value=\'add_new_favorite\'; FavoritesContent.addNewFavorite( \'form_files\', \'Adding Favorite\' );" value="Add too Favorites">Add To Favorites</button>';
		return $html;

	}

	function onContentAfterDisplay($context, &$row, &$params, $page = 0) {
		$app = JFactory::getApplication();

		if ($app -> isAdmin()) {
			return true;
		}

		$show = $this -> showAddbutton($this -> url, $row -> title);

		$html = '';
		$uri = JFactory::getURI();
		$html .= '<form action="" method="post" class="favFormContent" name="favFormContent" id="favFormContent" enctype="multipart/form-data">';
		$html .= '<input name="add_type" type="hidden" value="" id="add_type">';
		$html .= '<input name="id" type="hidden" value="" id="id">';
		$html .= '<input name="type" type="hidden" value="content" id="content">';
		$html .= '<input name="url" type="hidden" value="' . $this -> url . '" id="url">';
		$html .= '<input name="name" type="hidden" value="' . $row -> title . '" id="name">';
		$html .= '<input name="content_id" type="hidden" value="' . $row -> id . '" id="content_id">';
		if ($show) {$row -> showfavicon = 0;
		} else {
			$row -> showfavicon = 1;
			if ($this -> showaddlink == 1) {
				$html .= $this -> addButton();
			}
		}
		$html .= '</form>';

		return $html;
	}

}
