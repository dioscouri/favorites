<?php
/**
* @package		Favorites
* @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

JLoader::import( 'com_favorites.models._base', JPATH_ADMINISTRATOR.DS.'components' );

class FavoritesModelItems extends FavoritesModelBase 
{
	
	protected function _buildQueryWhere(&$query)
    {
        $filter     = $this->getState('filter');
       	$filter_name      = $this->getState('filter_name');
    	$filter_type    = $this->getState('filter_type');
    	$filter_userid     = $this->getState('filter_userid');
    	$filter_datecreated     = $this->getState('filter_datecreated ');
    	$filter_lastmodified    = $this->getState('filter_lastmodified');
		$filter_enabled    = $this->getState('filter_enabled');
		
    	      
		
        if ($filter) 
        {
            $key    = $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter ) ) ).'%');
            $where = array();
            $where[] = 'LOWER(tbl.name) LIKE '.$key;
            $where[] = 'LOWER(tbl.type) LIKE '.$key;
      
            $query->where('('.implode(' OR ', $where).')');
        }
        
    	if (strlen($filter_type))
    	{
    		$query->where("tbl.type = '".$filter_type."'");
    	}

        if (strlen($filter_name))
        {
            $query->where("tbl.name = '".$filter_name."'");
        }
    	
    	if (strlen($filter_userid))
    	{
    		
    	 $query->where("tbl.user_id = '".$filter_userid."'");
	
		}
		
    	if (strlen($filter_datecreated))
        {
            $query->where("tbl.datecreated = '".$filter_datecreated."'");
        }
          
		    	
       if (strlen($filter_lastmodified))
        {
            $query->where("tbl.lastmodified = '".$filter_lastmodified."'");
        }
	    
		if (strlen($filter_enabled))
        {
            $query->where("tbl.enabled = '".$filter_enabled."'");
        }
	  
    }


	function getTable()
	{
		JTable::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_favorites'.DS.'tables' );
		$table = JTable::getInstance( 'Items', 'FavoritesTable' );
		return $table;
	}
	
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {
			// Convert the params field to an object, than we can  have access to edit in the admi views, i change it to attribs to keep the json if needed. 
			$registry = new JRegistry;
			$registry->loadString($item->params);
			$item->attribs = $registry->toObject();

			
		}

		return $item;
	}
	
	/*Use Get Items to get a listing of items that has had the attribs prepared*/
	
	public function getItems()
	{
		
		
		$items = parent::getList(); 
	
		foreach(@$items as $item)
		{
			$registry = new JRegistry;
			$registry->loadString($item->params);
			$item->attribs = $registry->toObject();
			//Modal Link
			$item->form_link = 'index.php?option=com_favorites&controller=items&view=items&layout=form&tmpl=component&id='.$item->id;
			
		}
		
		return $items;
	}
	
	
	public function getList()
	{
		
		
		$items = parent::getList(); 
	
		foreach(@$items as $item)
		{
			$item->link = 'index.php?option=com_favorites&controller=items&view=items&task=edit&id='.$item->id;
			
			
		}
		
		return $items;
	}
	
	
	
	
}