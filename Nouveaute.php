<?php
include ('Plats.php');

	$ret = " 
	<div class=\"container_12\">
    <div class=\"grid_12\">
      <h3>Nouveautés</h3>
    </div>";
				
		$all = Plats::findLast();
		
		
		foreach ($all as $i) {
		   
		$ret = $ret. "<div class=\"grid_3\">
				<div class = \"box maxheight\">
					<img src=\"image/originales/".$i->photo."\" width = 500px; height = 150px;>
			
					<div class = \"title\">".$i->nom."  </div>
			
					".$i->description."
				<a href=\"index2.php?act=resto&id=".$i->id_resto."\">Details</a>
				</div>
				</div>";
		}			
		$ret = $ret. "</div>";
		print $ret;
?>