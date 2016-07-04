<?php session_start();
include "database.inc";
mysql_select_db("game");
$sql_query="SELECT * FROM `equipment_pack` LIMIT 0, 30 ";
$result= mysql_query($sql_query);
$total_records =mysql_num_rows($result);
$_SESSION["message"] = isset($_SESSION["message"])? $_SESSION["message"] : "0";
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html";charset=utf-8 /></head>
<body>
<h1 align="center">裝備頁面</h1>
<p align="center">裝備數量：<?php echo $total_records;?></p>
<table border="1" align="center">
  <!-- 表格表頭 -->
  <tr>
    <th>編號</th>
    <th>裝備名稱</th>
    <th>力量</th>
    <th>體力</th>
    <th>是否裝備</th>
  </tr>
  <!-- 資料內容 -->
  <form action="" method="POST">
 <?php
 	$num= isset($num)? $num : "1";
	while ($row =mysql_fetch_array($result))
		{
			echo"<tr>";
			echo "<td>".$num++."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td align=\"center\">"."<input type=\"radio\" name=\"equip\" id=\"radio\" value=\"".$row[0]."\"";
			if($row[4]=="Y")echo "checked>"."</td>";
				else echo "</td>";
			echo "<td><a href='del.php?id=".$row[0]."'>刪除</a></td>";
		}
 ?>
 	<tr colspan="2" align="center">
	<td colspan="2" align="center">
    <input name="action" type="hidden" value="update">
    <input type="submit" name="button" id="button" value="裝備">
    </form>
    </td>
    <td colspan="2" align="center">
     		<?php 
      			  echo $_SESSION["message"]==1? '<font size="5" color="red">無發刪除裝備中的武器</font>':"";
      			  echo $_SESSION["message"]==2? '<font size="5" color="red">裝備成功</font>':"";
      		$_SESSION["error"]=0;
      		?>
    </td>
    </tr>
</table>
    <form action="" method="POST" align="center">
    <input type="submit" name="submit" id="submit" value="返回">
    </form>
    <?php
    	if(isset($_POST["action"])&&($_POST["action"]=="update"))	//防堵意外裝備
	{	
		$itemlist  = "UPDATE `equipment_pack` SET `equip` = 'N'";
		mysql_query($itemlist);
		$itemlist  = "UPDATE `equipment_pack` SET `equip` = 'Y' WHERE `equipment_pack`.`id` =".$_POST["equip"];
		mysql_query($itemlist);
		$_SESSION["message"]=2;//顯示裝備成功
		header("Location: inventory.php");
	}

	if(isset($_POST["submit"]))
	{
		echo"<body onload=\"window.open('phpsystem.php','_top')\">";
	}
    ?>
</body>
</html>