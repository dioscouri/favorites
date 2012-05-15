<?php
/**
* @package		Favorites
* @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

JLoader::import( 'com_favorites.views._base', JPATH_ADMINISTRATOR.DS.'components' );

class FavoritesViewItems extends FavoritesViewBase 
{
	
	function _defaultToolbar()
	{
	
        JToolBarHelper::publishList( 'enabled.enable' );
        JToolBarHelper::unpublishList( 'enabled.disable' );
		
		parent::_defaultToolbar();
	}
	
	function getLayoutVars($tpl=null) 
    {
        $layout = $this->getLayout();

        switch(strtolower($layout))
        {
            case "form":
                JRequest::setVar('hidemainmenu', '1');
                $this->_form($tpl);
              break;
            case "view":
                $this->_form($tpl);
                break;
            case "default":
            default:
             
                $this->_default($tpl);
              break;
        }
    }
	
}
	