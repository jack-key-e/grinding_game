<?php 
session_start();
include "database.inc";
mysql_select_db("game");
?>
<?php
	$equip_check="SELECT * FROM `equipment_pack` WHERE `id`=".$_GET["id"];
	$qeuip_result= mysql_query($equip_check);
	$row =mysql_fetch_array($qeuip_result);
	if($row[4]=="Y")
	{
		$_SESSION["message"]=1;
		header("Location: inventory.php");
	}
	else{
		$sql_query = "DELETE FROM `equipment_pack` WHERE `id`=".$_GET["id"];
		mysql_query($sql_query);
		//重新導向回到主畫面
		header("Location: inventory.php");
	}
?>
