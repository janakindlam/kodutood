<?php
$pildid = array("nameless1.jpg", "nameless2.jpg", "nameless3.jpg", "nameless1.jpg", "nameless5.jpg", "nameless6.jpg");
?>

<div id="wrap">
	<h3>Fotod</h3>
	<div id="gallery">
        <?php
            foreach($pildid as $pilt){
                echo "<img src=\"pildid/".$pilt."\" alt=\"".$pilt."\">";
            }
        ?>
	</div>
</div>