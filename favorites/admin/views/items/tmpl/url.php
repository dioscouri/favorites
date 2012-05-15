<?php defined('_JEXEC') or die('Restricted access'); ?>


  <legend><?php echo JText::_( "LINK Information" ); ?></legend>
        
        <table class="admintable">
            <tr>
                <td class="key">
                    <?php echo JText::_( 'URL' ); ?>:
                </td>
                <td>
                   <?php echo @$row->params; ?>
                </td>
            </tr>
        </table>    