<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $form = @$this -> form; ?>
<?php $row = @$this -> row; ?>
<?php 
    JHTML::_('behavior.calendar');
	JHtml::_('behavior.formvalidation');
?>


<form action="<?php echo JRoute::_( @$form['action'] ) ?>" method="post" class="favform" name="favForm" id="favForm" enctype="multipart/form-data" >

	<fieldset>
		<table class="admintable">
			

			<tr>
				<td class="key"> <?php echo JText::_('Name'); ?>: </td>
				<td>
				<input name="name" value="<?php echo @$row -> name; ?>" size="50" maxlength="250" type="text" style="font-size: 20px;" />
				</td>
			</tr>
			
			
		</table>
	</fieldset>
	<div>
		
		<input type="hidden" name="id" id="id" value="<?php echo @$row -> id; ?>" />
		<input type="hidden" name="params" id="params" value="" />
		<input type="hidden" name="task" value="save" />
		<button type="submit" class="validate"><span><?php echo JText::_('JSUBMIT'); ?></span></button>
		
			<a href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
	</div>
</form>

