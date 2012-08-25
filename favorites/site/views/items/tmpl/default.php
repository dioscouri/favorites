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

JHTML::_('behavior.modal');
JHTML::_('script', 'favorites.js', 'media/com_favorites/js/');

DSC::loadJQuery();
$edit = Favorites::getInstance() -> get('favorites_can_edit', '0');
?>

<div id="Favorites">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1>
	<?php echo $this -> escape($this -> params -> get('page_heading')); ?>
	</h1>
<?php endif; ?>
<?php if (!empty($items)) : ?>
<ul class="favoritesList">
	<?php
	
	foreach ($items as $scope => $favs) {
  echo '<h1>' . $scope . '</h1>';

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


<h1>Example add from form</h1>
<form action="" method="post" class="favForm" name="favForm" id="favForm" enctype="multipart/form-data">
<input name="id" type="hidden" value="" id="id">
scope_id:<input name="scope_id" type="text" value="1" id="scope_id">
url:<input name="url" type="text" value="http://www.fakeur.com" id="url">
name:<input name="name" type="text" value="Testing Form" id="name">
<input type="button" onclick="Favorites.addFormFavorite( 'form_files', 'Adding Favorite' );" value="Add too Favorites">

</form>
<hr>
<h1>Example add from Jquery</h1>
<script>
var url = '/index.php?option=com_favorites&task=addFavorite&format=raw&view=items';

var data = '';
jQuery(document).ready(function() {
jQuery("#secondway").click(function () {
	
	var postdata = {};
postdata.scope_id = 2;
postdata.url = "http://www.fakeur.com";
postdata.name = "Second way";
	post =  JSON.stringify(postdata);
	alert(post);
     jQuery.post(url, { elements:post  },
 function(data){
   console.log(data.msg); 
   console.log(data.success); 
 }, "json");
    });
});

</script>
<button id="secondway" name="secondway">Second way just jQuery</button>


</div>