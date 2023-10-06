<?php
function conectar()
{
	$linkdb =  new mysqli('127.0.0.1', 'root', '', 'desis');
    $linkdb->set_charset("utf8");

  			if (!$linkdb) {
				echo "Error: No es posible conectar con la BD: " . mysql_error($linkdb);
			    exit;
			}
  		 	return $linkdb;
}			
?>
