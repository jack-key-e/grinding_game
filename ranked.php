<?php 
session_start();
include "database.inc";
mysql_select_db("game");
$sql_query="SELECT * FROM `rank`ORDER BY  `rank`.`point` DESC";
$result= mysql_query($sql_query);
$total_records =mysql_num_rows($result);
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html";charset=utf-8 /></head>
<body>
	<h1 align="center">排行榜</h1>
	<p align="center"目前排行人數：<?php echo $total_records;?></p>
	<table border="1" align="center">
	<tr>
    <th>排名</th>
    <th>名稱</th>
    <th>農出裝備數</th>
    <th>持有裝備</th>
  </tr>
  <?php
  	$num= isset($num)? $num : "1";
	while ($row =mysql_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>".$num."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "</tr>";
			$num++;
		}
?>
</table>
<table border="0" align="center">
<tr><td><font align="center" size="5" color="red">登陸排行會使你一切的紀錄初始化,請確定要結束遊戲後再登記</font></td></tr>
</table>
<table border="0" align="center">
<form action="" method="POST">
	<input name="action" type="hidden" value="update">
    <tr>
    	<td>輸入姓名:<input type="text" name="name" id="name" value=""></td>
    	<td><input type="submit" name="button" id="button" value="登錄排行榜"></td>
    	<td><input type="submit" name="back" id="back" value="返回" ></td>
    </tr>
</table>
</form>
<?php if(isset($_POST["back"]))
	{
		echo"<body onload=\"window.open('phpsystem.php','_top')\">";
	}
	if(isset($_POST["button"])&&($_POST["name"]!=NULL))
	{
		$gear_query= "SELECT * FROM `equipment_pack`". "WHERE `equipment_pack`.`equip`='Y'";//找正在裝備的武器
		$result=mysql_query($gear_query);
		$gearrow =mysql_fetch_array($result);
		$gear_query="SELECT * FROM  `equipment_pack` ORDER BY  `equipment_pack`.`id`  DESC ";//找ID最高的武器
		$result=mysql_query($gear_query);
		$topgearrow =mysql_fetch_array($result);
		$topeadd="INSERT INTO  `game`.`rank` (`id` ,`name` ,`point` ,`gear`)
		VALUES (NULL,  '".$_POST["name"]."',  '".$topgearrow[0]."',  '".$gearrow[1]."')";
		mysql_query($topeadd);
		$restart1="truncate table `equipment_pack`";//刪除所有裝備
		mysql_query($restart1); 
		$restart2="INSERT INTO `game`.`equipment_pack` (`id`, `gear_name`, `power_value`, `stamina_value`, `equip`, `power_id`, `stamina_id`) 
		VALUES ('001', '破亂又脆弱的劍', '10', '10', 'Y', '1', '1');";
		mysql_query($restart2);	//建立初始裝備
		session_destroy();
		echo"<body onload=\"window.open('ranked.php','_top')\">";
	}
?>
</body>

</html>
