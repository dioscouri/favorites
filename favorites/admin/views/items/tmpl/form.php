<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $form = @$this -> form; ?>
<?php $row = @$this -> row; ?>
<?php JHTML::_('behavior.calendar');
	JHtml::_('behavior.formvalidation');
?>

<form action="<?php echo JRoute::_( @$form['action'] ) ?>" method="post" class="adminform" name="adminForm" id="adminForm" enctype="multipart/form-data" >

	<fieldset>
		<legend>
			<?php echo JText::_("BASIC INFORMATION"); ?>
		</legend>

		<table class="admintable">
			<tr>
				<td class="key"> <?php echo JText::_('id'); ?>: </td>
				<td> <?php echo @$row -> id; ?> </td>
			</tr>

			<tr>
				<td class="key"> <?php echo JText::_('Name'); ?>: </td>
				<td>
				<input name="name" value="<?php echo @$row -> name; ?>" size="50" maxlength="250" type="text" style="font-size: 20px;" />
				</td>
			</tr>
			<tr>
				<td class="key"> <?php echo JText::_('URL'); ?>: </td>
				<td>
				<input name="url" value="<?php echo @$row -> url; ?>" size="50" maxlength="250" type="text" style="font-size: 20px;" />
				</td>
			</tr>
			<tr>
				<td class="key"> <?php echo JText::_('User ID'); ?>: </td>
				<td>
					<?php // note is this useful? should it just be an input field? or all users or a user element? why would we need to change a favorites user?
					 echo FavoritesSelect::users( @$row -> user_id, 'filter_userid', $attribs, 'user_id', TRUE, 'User' ); ?>
				
				</td>
			</tr>
			<tr>
				<td class="key"> <?php echo JText::_('Type'); ?>: </td>
				<td>
					<?php $attribs = array('class' => 'inputbox', 'size' => '1'); ?>
               	<?php echo FavoritesSelect::type( @$row -> type, 'type', $attribs, 'type', true, 'select type', false ); ?>
	            
				</td>
			</tr>

			<tr>
				<td class="key"> <?php echo JText::_('Date Created'); ?>: </td>
				<td> <?php echo JHTML::calendar(@$row -> datecreated, 'datecreated', 'datecreated', ''); ?> </td>
			</tr>
			<tr>
				<td class="key"> <?php echo JText::_('Last Modified'); ?>: </td>
				<td> <?php echo JHTML::calendar(@$row -> lastmodified, 'lastmodified', 'lastmodified', ''); ?> </td>
			</tr>
		</table>
	</fieldset>
	<div>
		<input type="hidden" name="id" id="id" value="<?php echo @$row -> id; ?>" />
		<input type="hidden" name="params" id="params" value="" />
		<input type="hidden" name="task" value="" />
	</div>
</form>
