<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $form = @$this -> form; ?>
<?php $row = @$this -> row; ?>
<?php JHTML::_('behavior.calendar');
	JHtml::_('behavior.formvalidation');
?>
<!--ű-->
<script type="text/javascript">
	/* Override joomla.javascript, as form-validation not work with ToolBar */
	/*
	 So Check this, if we convert the whole included form into a JSON object from the form view, we can avoid having to write long php save functions.
	 that way all the included forms for all the future types will all keep the same save method.
	
	well replace Modal functions later most likely
	
	 like a boss
	 *
	 * */

	/*Joomla.submitbutton = function(task) {
     
		var formObjects = $('favoriteplugin').toQueryString().parseQueryString();
		var formJson = JSON.encode(formObjects);
		var params = document.id('params');
		params.set('value', formJson);
		Joomla.submitform(task);
		return true;
	}*/
</script>

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
				<input name="user_id" value="<?php echo @$row -> user_id; ?>" size="50" maxlength="250" type="text" style="font-size: 20px;" />
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

<?php
// works for now maybe replace with Jform stuff  later when rest is done

/*
if(!empty($row -> type)){
echo $this -> loadTemplate($row -> type);
} else {
echo 'Select a Type, and save for more options';
}*/
?>

