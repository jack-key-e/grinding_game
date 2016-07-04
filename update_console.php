<?php
	include "database.inc";
	mysql_select_db("game");
	$sql_query = "SELECT * FROM `mob_properties` WHERE `id`=".$_GET["id"];
	$result=mysql_query($sql_query);
?>
 <?php
 	if(isset($_POST["submit"])&&isset($_POST["check"]))
 	{
 		$sql = "UPDATE  `game`.`mob_properties` SET 
 		`mob_name` =  '".$_POST['name']."', `power_bonus` =  '".$_POST['power']."', `stamina_bonus` =  '".$_POST['stamina']."' WHERE  `mob_properties`.`id` =".$_GET['id'];
		mysql_query($sql);
		echo"<body onload=\"window.open('console.php','_top')\">";
	}
	?>
<html>
<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/></head>
<body>
<table border="1" align="center">
	<tr>
    <th>編號</th>
    <th>名稱</th>
    <th>力量增益</th>
    <th>體力增益</th>
  </tr>
<?php 

		while ($row =mysql_fetch_array($result))
		{
			echo"<tr>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo"</tr>";
		}
		//重新導向回到主畫面
//header("Location: console.php");
?>
<tr>
<form action="" method="POST" align="center">
	<td></td>
	<td><input type="text" name="name" id="name"></td>
	<td><input type="text" name="power" id="power"></td>
	<td><input type="text" name="stamina" id="stamina"></td>
</tr>
<tr>
	<td colspan="4"align="center"><input type="submit" name="submit" id="submit" value="新增"><input type="hidden" name="check" id="check"></td>
</tr>
</form>
</table>
</body>
</html>