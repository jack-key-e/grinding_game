<?php session_start();
include "database.inc";
mysql_select_db("game");
$sql_query="SELECT * FROM `mob_properties`";
$result= mysql_query($sql_query);
$total_records =mysql_num_rows($result);
?>
 <?php
 	if(isset($_POST["submit"])&&isset($_POST["check"]))
 	{
 		$sql = "INSERT INTO  `game`.`mob_properties` (`id` ,`mob_name` ,`power_bonus` ,`stamina_bonus` ,`mob_pic`)
			VALUES (NULL ,  '".$_POST["name"]."','".$_POST["power"]."','".$_POST["stamina"]."','".NULL."');";
		mysql_query($sql);
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
		echo"<body onload=\"window.open('console.php','_top')\">";
 	}
 ?>
<html>
<head><meta http-equiv="Content-Type" content="text/html";charset=utf-8 /></head>
<body>
<h1 align="center">後台頁面</h1>
<p align="center">資料數量：<?php echo $total_records;?></p>
<table border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
    <th>編號</th>
    <th>名稱</th>
    <th>力量增益</th>
    <th>體力增益</th>
  </tr>
  <!-- 資料內容 -->
  <form action="" method="POST">
 <?php
 	$num= isset($num)? $num : "1";
	while ($row =mysql_fetch_array($result))
		{
			echo"<tr>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td><a href='update_console.php?id=".$row[0]."'>修改</a></td>";
			echo "<td> <a href='del_console.php?id=".$row[0]."'>刪除</a></td>";
		}
 ?>
</table>
 	<form action="" method="POST" align="center">
 	<table border="0" align="center">
	<tr>
		<td>怪物名稱:<input type="text" name="name" id="name">
			力量增幅:<input type="text" name="power" id="power">
			體力增幅:<input type="text" name="stamina" id="stamina">
		</td>
		<td><input type="submit" name="submit" id="submit" value="新增"><input type="hidden" name="check" id="check"></td>
	</tr>
	</table>
</form>
 </body>
</html>