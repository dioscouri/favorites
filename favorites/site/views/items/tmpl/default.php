<?php
$items = $this->items;

?>
<style>
	span.edit {
		float: right;
	}
	span.delete {
		float: right;
	}
	span.edit a.remove:hover {
		background: none;
	}
	ul.favoritesList li {
		padding-top: 5px;
	}
</style>
<div class="Favorites">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
<?php if (!empty($items)) :
?>
<ul class="favoritesList">
	<?php
foreach($items as $link){
if(!empty($link->url) && !empty($link->name)){
	?>

	<li id="fav<?php echo $link -> id; ?>">
		<a href="<?php echo $link->url ?>"><?php echo $link -> name; ?></a>
		<span class="edit"> <a class="remove modal" href="<?php echo $link -> edit_link; ?>" ><img width="16px" src="/media/dioscouri/images/page_edit.png"></a> </span>
	
		<span class="delete"> <a class="remove" href="#" onclick="document.favForm.add_type.value='removeFavorite'; document.favForm.id.value='<?php echo $link -> id; ?>'; FavoritesUrl.removeFavorite( 'form_files', 'Removing Favorite','<?php echo $link -> id; ?>' );"><img src="/media/dioscouri/images/publish_x.png"></a> </span>
	
	</li>
	<?php }
		}
	?>
</ul>
<?php else : ?>
No Favorites yet.
<?php endif ?>

<script>
	if( typeof (FavoritesUrl) === 'undefined') {
		var FavoritesUrl = {};
	}
	FavoritesUrl.addNewFavorite = function(container, msg) {
		var url = '/index.php?option=com_favorites&task=doTaskAjax&format=raw&view=items&element=favorites_url&elementTask=addNewFavorite';
		Dsc.doTask(url, container, document.favForm, msg, true, Dsc.update());
	}
	FavoritesUrl.removeFavorite = function(container, msg, id) {
		var url = '/index.php?option=com_favorites&task=doTaskAjax&format=raw&view=items&element=favorites_url&elementTask=removeFavorite';
		Dsc.doTask(url, container, document.favForm, msg, false, Dsc.showHideDiv('fav' + id));
	}
</script>
<form action="" method="post" class="favForm" name="favForm" id="favForm" enctype="multipart/form-data">
	<input name="add_type" type="hidden" value="" id="add_type">
	<input name="id" type="hidden" value="" id="id">
	<input name="url" type="hidden" value="<?php echo $url; ?>" id="url">
	<input name="name" type="hidden" value="<?php echo $name; ?>" id="name">
	<?php if($addButton) :
	?>
	<input name="add_new_favorite" type="button" onclick="document.favForm.add_type.value='add_new_favorite'; FavoritesUrl.addNewFavorite( 'form_files', 'Adding Favorite' );" value="Add too Favorites">
	<?php endif ?>
</form>

</div>
