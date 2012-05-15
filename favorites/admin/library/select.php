<?php 

defined('_JEXEC') or die('Restricted access');


class FavoritesSelect extends DSCSelect
{
	/**
     * 
     * Enter description here ...
     * @param $selected
     * @param $name
     * @param $attribs
     * @param $idtag
     * @param $allowAny
     * @param $title
     * @return unknown_type
     */
    public static function type( $selected, $name = 'filter_group', $attribs = array('class' => 'inputbox', 'size' => '1'), $idtag = null, $allowAny = false, $title='Select Type', $allowNone = false, $title_none = 'No Type' )
    {
        $list = array();
        if ($allowAny) {
            $list[] =  self::option('', "- ".JText::_( $title )." -" );
        }

        if ($allowNone) 
        {
            $list[] =  self::option( '0', "- ".JText::_( $title_none )." -" );
        }
        // make this based on a table or some kind of plugin system
		$items = array();
        $items['url'] = 'URL';
		$items['content'] = 'Content Item';
        
        foreach ($items as $key => $value)
        {
            $list[] = JHTML::_('select.option', $key, $value );
        }
        
        return self::genericlist($list, $name, $attribs, 'value', 'text', $selected, $idtag );
    }
	
	
}