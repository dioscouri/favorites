<?php
/**
* @package		Favorites
* @copyright	Copyright (C) 2009 DT Design Inc. All rights reserved.
* @license		GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
* @link 		http://www.dioscouri.com
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');


Favorites::load('FavoritesModelBase','models.base');

class FavoritesModelItems extends FavoritesModelBase 
{
	
	protected function _buildQueryWhere(&$query)
    {
        $filter     = $this->getState('filter');
		$filter_id_from = $this->getState('filter_id_from');
        $filter_id_to   = $this->getState('filter_id_to');
       	$filter_name      = $this->getState('filter_name');
		$filter_url    = $this->getState('filter_url');
    	$filter_scope    = $this->getState('filter_scope');
    	$filter_userid     = $this->getState('filter_userid');
    	$filter_datecreated     = $this->getState('filter_datecreated ');
    	$filter_lastmodified    = $this->getState('filter_lastmodified');
		$filter_enabled    = $this->getState('filter_enabled');
		
        if ($filter) 
        {
            $key    = $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter ) ) ).'%');
            $where = array();
            $where[] = 'LOWER(tbl.name) LIKE '.$key;
           
      
            $query->where('('.implode(' OR ', $where).')');
        }
		if ($filter_name) 
        {
            $key    = $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter_name ) ) ).'%');
            $where = array();
            $where[] = 'LOWER(tbl.name) LIKE '.$key;
          
      
            $query->where('('.implode(' OR ', $where).')');
        }
		
		 if (strlen($filter_id_from))
        {
            if (strlen($filter_id_to))
            {
                $query->where('tbl.id >= '.(int) $filter_id_from);  
            }
                else
            {
                $query->where('tbl.id = '.(int) $filter_id_from);
            }
        }
        
        if (strlen($filter_id_to))
        {
            $query->where('tbl.id <= '.(int) $filter_id_to);
        }
        
    	if (strlen($filter_scope))
    	{
    		$query->where("tbl.scope_id = '".$filter_scope."'");
    	}
		 if ($filter_url) 
        {
            $key    = $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter_url ) ) ).'%');
            
           $query->where("tbl.url  LIKE ".$key);
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

	 protected function _buildQueryGroup(&$query)
    {
    	//$query->group( 'tbl.scope_id' );
    }

	/**
     * Builds JOINS clauses for the query
     */
    protected function _buildQueryJoins(&$query)
    {
    $query -> join('LEFT', '#__favorites_scopes AS scope ON tbl.scope_id = scope.scope_id');	
		
    }
	/**
	 * Builds SELECT fields list for the query
	 */
	protected function _buildQueryFields(&$query)
	{
		$fields = array();
		$fields[] = " scope.* ";
		
	
	//	 $fields[] = " MAX(review.lastVisited)  ";
        
		
		$query -> select($fields);
		// if you move this up above the fields than the building addresses override the school address
		$query -> select($this -> getState('select', 'tbl.*'));
		
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
	
	//admin style lists
	public function getList($refresh = false)
	{
		
		
		$items = parent::getList($refresh); 
		
		foreach(@$items as $item)
		{
			$item->link = 'index.php?option=com_favorites&controller=items&view=items&task=edit&id='.$item->id;
			$item->edit_link = 'index.php?option=com_favorites&task=edit&tmpl=component&layout=form&id='.$item->id;
			// Geting the username for list views, should we store the username in the favs table to cut overhead or better to do this? this avoids problems is someone changes  their username
			$user = JFactory::getUser($item->user_id);
			$item->username = $user->get('username');
			
		}
		
		return $items;
	}
	
	
	
	
	
	/*This is  just a wrapper for setting states and calling getItem, so you can  say for a list view  load this modal and  just $modal->checkItem($pk); and get a yes no to show the  add box.*/
	public function checkItem( $pk = NULL, $url = NULL, $name = NULL, $id = NULL, $scope_id = NULL, $user_id = NULL  ) {
		
		$this->setState('filter_id_from', $id);
		$this->setState('filter_url', $url);
		$this->setState('filter_name', $name);
		$this->setState('filter_scope', $scope_id );
		if(!$user_id) {$user_id = $user_id = JFactory::getUser()->id; }
		$this->setState('$user_id', $user_id);
	
		$item = parent::getItem($pk); 
		if($item) {
			return TRUE;
		} else {
			return FALSE; 
		}
	
	}
	
	
}