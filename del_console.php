<?php session_start();
include "database.inc";
mysql_select_db("game");
		$sql_query = "DELETE FROM `mob_properties` WHERE `id`=".$_GET["id"];
		mysql_query($sql_query);
		$sql_query ="SELECT * FROM  `mob_properties` ORDER BY  `mob_properties`.`id` ASC ";
		mysql_query($sql_query);
		$result=mysql_query($sql_query);
		$num= isset($num)? $num : "1";
		while ($row =mysql_fetch_array($result))
		{
			$sql_query ="UPDATE  `game`.`mob_properties` SET  `id` =  '".$num."' WHERE  `mob_properties`.`id` =".$row[0];
			mysql_query($sql_query);
			$num++;
		}
		//重新導向回到主畫面
header("Location: console.php");
?>