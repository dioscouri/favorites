<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $row = @$this -> row; ?>
<form name="favoriteplugin" id="favoriteplugin" class="adminform">
	<fieldset>
		<legend>
			<?php echo JText::_("Content Information"); ?>
		</legend>
		<table class="admintable">
			<tr>
				<td class="key"> <?php echo JText::_('Item ID'); ?>: </td>
				<td>
				<input name="id" value="<?php echo @$row -> attribs -> id; ?>" size="50" maxlength="250" type="text" style="font-size: 20px;" />
				</td>
			</tr>
			<tr>
				<td class="key"> <?php echo JText::_('Custom Title'); ?>: </td>
				<td>
				<input name="title" value="<?php echo @$row -> attribs -> title; ?>" size="50" maxlength="250" type="text" style="font-size: 20px;" />
				</td>
			</tr>
		</table>
	</fieldset>
</form>