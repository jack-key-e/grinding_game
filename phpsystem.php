<?php
header("refresh: 10;url='phpsystem.php'");
session_start();
include "database.inc";
$dbhost='localhost';
$dbuser='root';
$dbpass='1234';
$key = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
mysql_query("SET NAMES 'utf8'");
mysql_select_db("game");

$gear="SELECT * FROM `equipment_pack` WHERE `equip` = 'Y' LIMIT 0, 30 ";
$gearget=mysql_query($gear);
while ($row = mysql_fetch_array($gearget, MYSQL_NUM)){
$weapon_Name=$row[1];
}	

function map_spawn($x,$y,$xray,$yray){
	for($i=0;$i<$y;$i++){
		for($j=0;$j<$x;$j++){
			$map_local[$j][$i]='<font size="20" color="green">@</font>';
		}
	}
 	$map_local[$xray][$yray]='<font size="20" color="red">X</font>';
 	echo 'x='.$xray."&nbsp;".'y='.$yray."<br>";
	for($i=0;$i<10;$i++){
			for($j=0;$j<10;$j++){
				echo $map_local[$j][$i];
			}
		echo "<br>";
	}
}//map_spawn(地圖X軸邊界,地圖Y軸邊界,玩家X軸,玩家Y軸)



$_SESSION["xray"] = isset($_SESSION["xray"])? $_SESSION["xray"] : "0";
$_SESSION["yray"] = isset($_SESSION["yray"])? $_SESSION["yray"] : "0";
//沒有xray與yray的話宣告XY位置，反之沿用


if(!isset($_SESSION["checkpoint"])){
	$_SESSION["checkpoint"]=0;
}

if(isset($_POST["submit"])){
	if($_POST["submit"]=="上"){
		$_SESSION["yray"]--;
		$_SESSION['stamina']-=1;
		$_SESSION["checkpoint"]++;
	}
	elseif($_POST["submit"]=="下"){
		$_SESSION["yray"]++;
		$_SESSION['stamina']-=1;
		$_SESSION["checkpoint"]++;
	}
	elseif($_POST["submit"]=="左"){
		$_SESSION["xray"]--;
		$_SESSION['stamina']-=1;
		$_SESSION["checkpoint"]++;
	}
	elseif($_POST["submit"]=="右"){
		$_SESSION["xray"]++;
		$_SESSION['stamina']-=1;
		$_SESSION["checkpoint"]++;
	}
	elseif($_POST["submit"]=="裝備切換"){
  		echo"<body onload=\"window.open('inventory.php','_top')\">";
		;
	}	
}
else{
	$_POST["submit"]=null;
}//判斷按鈕進行移動


$_SESSION["xyraycheck"] = isset($_SESSION["xyraycheck"])?
$_SESSION["xyraycheck"] : 10*$_SESSION["xray"]+$_SESSION["yray"];//宣告xyraycheck，已有的話沿用


if (rand(1,100)<30&&10*$_SESSION["xray"]+$_SESSION["yray"]!=$_SESSION["xyraycheck"]){
	echo"<br>battle".$_SESSION["xyraycheck"];
	$_SESSION["xyraycheck"]=10*$_SESSION["xray"]+$_SESSION["yray"];
  	echo"<body onload=\"window.open('battlesystem.php','_top')\">";
  	$disabledbutton=1;//使按鈕失效
}//是否觸發戰鬥，xyraycheck防止原地觸發，並觸發時寫入xyraycheck


if(!isset($_SESSION['start_Time']))
{
	$_SESSION['start_Time']=floor(microtime(true));
	$_SESSION['stamina']=20;
	$_SESSION['now_Time']=0;
}elseif(microtime(true)-$_SESSION['start_Time']>10){
	$_SESSION['now_Time']=floor(microtime(true)-$_SESSION['start_Time']);
	$_SESSION['stamina']+=floor($_SESSION['now_Time']/10);
	$_SESSION['start_Time']=floor(microtime(true));
}//活力值計算，10秒+1，由於用無條件捨去小數因此>10時才+1

if($_SESSION['stamina']<1)
{
	$disabledbutton=1;
	header("refresh: 10;url='phpsystem.php'");
}//活力值<1時，等10秒自動刷新頁面


?>

<html>
<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/><title>maplocal</title></head>
<body>

	<center>
	<div class='map'>
	<?php
	map_spawn(10,10,$_SESSION["xray"],$_SESSION["yray"]);//呼叫地圖並代入位置
	echo '<br/>已走步數='.$_SESSION["checkpoint"];//顯示步數
	?>
	</div>
	<form action="" method="POST">
		<?php
		echo "活力值:". $_SESSION['stamina'] ."</br>" ;
		echo ($_SESSION["yray"]>0&&!isset($disabledbutton))?
		"<input name=\"submit\" type=\"submit\" value=\"上\" /><br>":
		"<input name=\"submit\" type=\"submit\" value=\"&nbsp;&nbsp\" disabled=\"disabled\"/><br>";
		echo ($_SESSION["xray"]>0&&!isset($disabledbutton))?
		"<input name=\"submit\" type=\"submit\" value=\"左\" />":
		"<input name=\"submit\" type=\"submit\" value=\"&nbsp;&nbsp\" disabled=\"disabled\"/>";
		echo ($_SESSION["xray"]<9&&!isset($disabledbutton))?
		"<input name=\"submit\" type=\"submit\" value=\"右\" /><br>":
		"<input name=\"submit\" type=\"submit\" value=\"&nbsp;&nbsp\" disabled=\"disabled\"/><br>";
		echo ($_SESSION["yray"]<9&&!isset($disabledbutton))?
		"<input name=\"submit\" type=\"submit\" value=\"下\" /><br>":
		"<input name=\"submit\" type=\"submit\" value=\"&nbsp;&nbsp\" disabled=\"disabled\"/><br>";
		//移動鈕，在邊界的話顯示文字?>
		<input name="submit" type="submit" value="裝備切換" />
	</form>
	<h2><?php echo $weapon_Name;?></h2>
	<h2><a href="ranked.php">排行榜</a></h2>
	<h2><a href="login.php">後台</a></h2>

</center></body>
</html>