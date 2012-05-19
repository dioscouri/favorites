<?php
/**
 * @package Favorites
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

// Check the registry to see if our Favorites class has been overridden
if ( !class_exists('Favorites') ) {
    JLoader::register( "Favorites", JPATH_ADMINISTRATOR.DS."components".DS."com_favorites".DS."defines.php" );
}

// before executing any tasks, check the integrity of the installation
Favorites::getClass( 'FavoritesHelperDiagnostics', 'helpers.diagnostics' )->checkInstallation();

// set the options array
$options = array( 'site'=>'site', 'type'=>'components', 'ext'=>'com_favorites' );

// Require the base controller
Favorites::load( 'FavoritesController', 'controller', $options );

// Require specific controller if requested
$controller = JRequest::getWord('controller', JRequest::getVar( 'view' ) );
if (!Favorites::load( 'FavoritesController'.$controller, "controllers.$controller", $options ))
    $controller = '';

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

$parentPath = JPATH_ADMINISTRATOR . '/components/com_favorites/helpers';
DSCLoader::discover('FavoritesHelper', $parentPath, true);

$parentPath = JPATH_ADMINISTRATOR . '/components/com_favorites/library';
DSCLoader::discover('Favorites', $parentPath, true);

// load the plugins
JPluginHelper::importPlugin( 'favorites' );

// Create the controller
$classname = 'FavoritesController'.$controller;
$controller = Favorites::getClass( $classname );

// ensure a valid task exists
$task = JRequest::getVar('task');
if (empty($task))
{
    $task = 'items';  
}
JRequest::setVar( 'task', $task );

// Perform the requested task
$controller->execute( $task );

// Redirect if set by the controller
$controller->redirect();

?>