<?php
/**
* @package		Favorites
* @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');


// Check the registry to see if our Favorites class has been overridden
if ( !class_exists('Favorites') ) 
    JLoader::register( "Favorites", JPATH_ADMINISTRATOR.DS."components".DS."com_favorites".DS."defines.php" );

// Require the base controller
Favorites::load( 'FavoritesController', 'controller' );

// Require specific controller if requested
$controller = JRequest::getWord('controller', JRequest::getVar( 'view' ) );
if (!Favorites::load( 'FavoritesController'.$controller, "controllers.$controller" ))
    $controller = '';


// If we don't have a requested controller we direct this if very often dashboard'
if (empty($controller))
{
    // redirect to default
	$default_controller = new FavoritesController();
	$redirect = "index.php?option=com_favorites&view=" . $default_controller->default_view;
    $redirect = JRoute::_( $redirect, false );
    JFactory::getApplication()->redirect( $redirect );
}

$doc = JFactory::getDocument();
$uri = JURI::getInstance();
$js = "var com_favorites = {};\n";
$js.= "com_favorites.jbase = '".$uri->root()."';\n";
$doc->addScriptDeclaration($js);

JHTML::_('stylesheet', 'admin.css', 'media/com_favorites/css/');

$parentPath = JPATH_ADMINISTRATOR . '/components/com_favorites/helpers';
DSCLoader::discover('MediamanagerHelper', $parentPath, true);

$parentPath = JPATH_ADMINISTRATOR . '/components/com_favorites/library';
DSCLoader::discover('Mediamanager', $parentPath, true);

// load the plugins
JPluginHelper::importPlugin( 'favorites' );

// Create the controller
$classname = 'FavoritesController'.$controller;
$controller = Favorites::getClass( $classname );
    
// ensure a valid task exists, if we don't have a valid task our components just won't display because of security features in the base view.
$task = JRequest::getVar('task');
if (empty($task))
{
    $task = 'display';  
}
JRequest::setVar( 'task', $task );

// Perform the requested task
$controller->execute( $task );

// Redirect if set by the controller
$controller->redirect();