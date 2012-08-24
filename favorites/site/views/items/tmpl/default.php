<?php
$list = $this -> items;
//convert this to a categorized list based on type
$items = array();
foreach ($list as $item) {
	if (empty($item -> type)) {$item -> type = 'MISC';
	}
	$items[$item -> type][$item -> id]['id'] = $item -> id;
	$items[$item -> type][$item -> id]['url'] = $item -> url;
	$items[$item -> type][$item -> id]['name'] = $item -> name;
	$items[$item -> type][$item -> id]['edit_link'] = $item -> edit_link;
	// etc

}
JHTML::_('behavior.modal');
$edit = Favorites::getInstance() -> get('favorites_can_edit', '0');
?>

<div id="Favorites">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1><?php echo $this -> escape($this -> params -> get('page_heading')); ?></h1>
	<?php endif; ?>
	
	
	
<?php if (!empty($items)) : ?>
<ul class="favoritesList">
	<?php
	foreach ($items as $type => $favs) {
 		 echo '<h1>' . $type . '</h1>';

  foreach ($favs as $id => $fav) {
  	if(!empty($fav['url']) && !empty($fav['name'])){
  		?>
 <li id="fav<?php echo $fav['id']; ?>">
		<a href="<?php echo $fav['url'] ?>"><?php echo $fav['name']; ?></a>
		<?php  if($edit) : ?>
		<span class="edit"> <a class="remove modal" href="<?php echo $fav['edit_link']; ?>" ><img width="16px" src="/media/dioscouri/images/page_edit.png"></a> </span>
	   <?php endif ?>
		<span class="delete"> <a class="remove" href="#" onclick="document.favForm.id.value='<?php echo $fav['id']; ?>'; FavoritesUrl.removeFavorite( 'form_files', 'Removing Favorite','<?php echo $fav['id']; ?>' );"><img src="/media/dioscouri/images/publish_x.png"></a> </span>
	
	</li>
 <?php
}//if
} //foreach
} //foreach
?>
</ul>
<?php else : ?>
No Favorites yet.
<?php endif ?>
</div>