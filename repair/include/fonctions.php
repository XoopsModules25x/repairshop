<?php

function get_proprietaire_info($id_proprietaire)
{
   global $xoopsDB, $id_proprietaire, $xoopsOption, $client_detail;
  $sql = sprintf("SELECT * FROM ".$xoopsDB->prefix("garage_clients")." WHERE id='%s'",$id_proprietaire);
  $res = $xoopsDB->query($sql)  or die ('erreur requete :'.$sql.'<br />');

  if ( $res )  {
		$nb_champs = mysql_num_fields($res);
		$i=0;
		while($i<$nb_champs)
		  {
		  $nom_champs=mysql_field_name($res,$i);
		  $$nom_champs=mysql_result($res,0,$nom_champs);
		  $i++;
		  }
		}
	}

?>