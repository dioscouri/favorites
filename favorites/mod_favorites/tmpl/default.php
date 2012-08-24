
<?php if (!empty($items)) : ?>
<ul class="favoritesList">
	<?php 
	foreach($items as $link){
		if(!empty($link->url) && !empty($link->name)){ ?>
			
			<li id="fav<?php echo $link->id; ?>"><a href="<?php echo $link->url ?>"><?php echo $link->name; ?></a>
			<?php if($removeButton) : ?>
			<span class="edit"> 
			<a class="remove" href="#" onclick="document.favForm.add_type.value='removeFavorite'; document.favForm.id.value='<?php echo $link->id; ?>'; FavoritesUrl.removeFavorite( 'form_files', 'Removing Favorite','<?php echo $link->id; ?>' );"><img src="/media/dioscouri/images/publish_x.png"></a>
			</span>
			<?php endif ?>
			</li>
		<?php }
	}
?>
</ul>
<?php else : ?>
	No Favorites yet.
<?php endif ?>

<form action="" method="post" class="favForm" name="favForm" id="favForm" enctype="multipart/form-data">
<input name="add_type" type="hidden" value="" id="add_type">
<input name="id" type="hidden" value="" id="id">
<input name="type" type="hidden" value="url" id="type">
<input name="url" type="hidden" value="<?php echo $url; ?>" id="url">
<input name="name" type="hidden" value="<?php echo $name; ?>" id="name">
<?php if($addButton) :?>
<input name="add_new_favorite" type="button" onclick="FavoritesUrl.addNewFavorite( 'form_files', 'Adding Favorite' );" value="Add too Favorites">
<?php endif ?>
</form>