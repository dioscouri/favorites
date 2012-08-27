<?php
$list = $this -> items;
//convert this to a categorized list based on scope
$items = array();

foreach ($list as $item) {
	$items[$item -> scope_name][$item -> id]['id'] = $item -> id;
	$items[$item -> scope_name][$item -> id]['url'] = $item -> url;
	$items[$item -> scope_name][$item -> id]['name'] = $item -> name;
	$items[$item -> scope_name][$item -> id]['edit_link'] = $item -> edit_link;
	// etc
}

Favorites::load( 'FavoritesHelperFavorites', 'helpers.favorites' );
$helper = new FavoritesHelperFavorites();
?>

<div id="Favorites">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1><?php echo $this -> escape($this -> params -> get('page_heading')); ?>
	</h1>
<?php endif; ?>
<?php if (!empty($items)) : ?>
<ul class="favoritesList">
	<?php foreach ($items as $scope => $favs) {
 	 echo '<h1>' . $scope . '</h1>';
foreach ($favs as $id => $fav) {
  	if(!empty($fav['url']) && !empty($fav['name'])){
  		?>
 <li id="fav<?php echo $fav['id']; ?>">
		<a href="<?php echo $fav['url'] ?>"><?php echo $fav['name']; ?></a>
<?php $attribs = array('class' => 'delete favorites'); ?>
<?php echo $helper->removeFavButton($fav['id'],NULL,NULL,NULL,NULL,'remove', $attribs); ?>
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