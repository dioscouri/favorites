
<ul>
	<?php 
	foreach($items as $link){
		if(!empty($link->attribs->url) && !empty($link->name)){
			echo '<li><a href="'. $link->attribs->url .'">'.$link->name.'</a></li>';
		}
		
		
	}
?>
</ul>
