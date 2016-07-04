<?php session_start();
include "database.inc";
mysql_select_db("game");
if(!isset($_SESSION["player_Max_stamina"])){	//從裝備頁面讀取裝備
	$gear="SELECT * FROM `equipment_pack` WHERE `equip` = 'Y' LIMIT 0, 30 ";
	$gearget=mysql_query($gear);
	while ($row = mysql_fetch_array($gearget, MYSQL_NUM)){
	$_SESSION["player_powerid"]=$row[5];	//力量的ID
	$_SESSION["player_staminaid"]=$row[6];//體力的ID
	$_SESSION["player_name"]=$row[1];
	$_SESSION["player_power"]=$row[2];
	$_SESSION["player_Max_stamina"]=$row[3];	
	}	
}


function game_restart(){
	$xray=$_SESSION["xray"];	//	->	先儲存地圖上的座標之訊戰鬥結束後重製後會用到
	$yray=$_SESSION["yray"];	//-|
	$stamina=$_SESSION['stamina'];
	$start_Time=$_SESSION['start_Time'];
	$now_Time=$_SESSION['now_Time'];
	$checkpoint=$_SESSION["checkpoint"];
	$xyraycheck=$_SESSION["xyraycheck"];
	session_destroy();			//SESSION全部重置
	session_start();
	$_SESSION["xray"]=$xray;	//回復X,Y座標
	$_SESSION["yray"]=$yray;
	$_SESSION['stamina']=$stamina;
	$_SESSION['start_Time']=$start_Time;
	$_SESSION['now_Time']=$now_Time;
	$_SESSION["checkpoint"]=$checkpoint;
	$_SESSION["xyraycheck"]=$xyraycheck;
}
if(!isset($_SESSION["monster_name"])){
	$mob = "SELECT * FROM `mob_properties`";		//先讀取資料庫怪物頁面
	$mobget = mysql_query($mob, $key);
	$mob .= "WHERE id=".rand(1,mysql_num_rows($mobget));	//之後再重怪物頁面讀取幾隻怪物
	$mobget = mysql_query($mob, $key);						//以防止ID超過原本設定的值所造成的錯誤
	while ($row = mysql_fetch_array($mobget, MYSQL_NUM)) {
	    $monster_Name=$row[1];
	    $monster_Bonus_Power=$row[2];
	    $monster_Bonus_Stamina=$row[3];
	    $monster_Pic=$row[4];
	}//從資料庫中抓取怪物加成值


	$main = "SELECT * FROM `main_properties`";		//設定力量亂數上限,防止當亂數超過資料庫裡的ID上線後所發生的錯誤
	$mainget = mysql_query($main, $key);
	$power_number=rand(1,$_SESSION["player_powerid"]+1);
	while($power_number>mysql_num_rows($mainget)){
		$power_number=rand(1,$_SESSION["player_powerid"]+1);
	}
	$main .= "WHERE id=".$power_number;
	$mainget = mysql_query($main, $key);
	while ($row = mysql_fetch_array($mainget, MYSQL_NUM)) {
	    $power_Name=$row[1];
	    $power_Value=$row[2];
	}

	$main = "SELECT * FROM `main_properties`";		//設定體力亂數上限,防止當亂數超過資料庫裡的ID上線後所發生的錯誤
	$mainget = mysql_query($main, $key);
	$stamina_number=rand(1,$_SESSION["player_staminaid"]+1);
	while($stamina_number>mysql_num_rows($mainget)){
		$stamina_number=rand(1,$_SESSION["player_staminaid"]+1);
	}
	$main .= "WHERE id=".$stamina_number;
	$mainget = mysql_query($main, $key);
	while ($row = mysql_fetch_array($mainget, MYSQL_NUM)) {
	    $stamina_Name=$row[3];
	    $stamina_Value=$row[4];
	}//從資料庫中抓取名詞



	$_SESSION["monster_Max_stamina"]=$stamina_Value*$monster_Bonus_Stamina;//怪物最大血量
	$_SESSION["monster_stamina"]=$_SESSION["monster_Max_stamina"];//怪物當前血量
	$_SESSION["monster_name"]=$power_Name."又".$stamina_Name."的".$monster_Name;//怪物名字
	$_SESSION["monster_Last_power"]=$power_Value*$monster_Bonus_Power;//怪物的攻擊力
	$_SESSION["monster_Pic"]=$monster_Pic;
	$_SESSION["player_stamina"]=$_SESSION["player_Max_stamina"];//玩家的血量(暫定)
	$_SESSION["weapon_name"]=$power_Name."又".$stamina_Name."的劍";//武器名稱
	$_SESSION["weapon_power"]=$power_Value;//武器攻擊力
	$_SESSION["weapon_stamina"]=$stamina_Value;//武器體力
	$_SESSION["weapon_power_id"]=$power_number;//武器攻擊力ID
	$_SESSION["weapon_stamina_id"]=$stamina_number;//武器體力ID

}//抓取一次資料庫並宣告所需session變數

if(isset($_POST["submit"])){
	switch($_POST["submit"]){
		case "攻擊":
			//玩家方戰鬥方公式:(怪物體力x怪物加城值)-(武器力量x0.01x(亂數[50~100]))
			$_SESSION["monster_stamina"]=$_SESSION["monster_stamina"]-($_SESSION["player_power"]*0.01*rand(50,100));
			//怪物攻擊=玩家體力-(武器力量x怪物加成值x0.01x(亂數[10~50]))
			$_SESSION["player_stamina"]=$_SESSION["player_stamina"]-($_SESSION["monster_Last_power"]*0.01*rand(10,50));
			$_SESSION["monster_stamina"]=$_SESSION["monster_stamina"]<0? 0:$_SESSION["monster_stamina"];
			$_SESSION["player_stamina"]=$_SESSION["player_stamina"]<0? 0:$_SESSION["player_stamina"];
			//player_stamina與monster_stamina的值被扣到0以下會直接寫成0，反之沿用
			break;
		case "離開":
			//武器掉落系統同遇到的怪物
			$sql = "INSERT INTO  `game`.`equipment_pack` (`id` ,`gear_name` ,`power_value` ,`stamina_value` ,`equip` ,`power_id` ,`stamina_id`)
			VALUES (NULL ,  '".$_SESSION["weapon_name"]."',  '".$_SESSION["weapon_power"]."',  '"
				.$_SESSION["weapon_stamina"]."',  'N',  '".$_SESSION["weapon_power_id"]."',  '"
				.$_SESSION["weapon_stamina_id"]."');";
			$result= mysql_query($sql);
			game_restart();
			header('Location: phpsystem.php');
			break;
		case "逃跑":
			$_SESSION['stamina']-=5;
			$_SESSION['stamina']=$_SESSION['stamina']<0 ? 0:$_SESSION['stamina'];
			game_restart();
			header('Location: phpsystem.php');
			break;
		case "復活":
			$_SESSION['stamina']-=10;
			$_SESSION['stamina']=$_SESSION['stamina']<0 ? 0:$_SESSION['stamina'];
			game_restart();
			header('Location: phpsystem.php');
			break;
		//二種扣不同量的活力值
	}
}
 ?>

<html>
	<head><meta http-equiv="Content-Type"content="text/html; charset=utf8"/></head>
	<body>
		<center><h1><?php echo $_SESSION["monster_name"]?></h1>
		<hr>
		<?php
		
		 if($_SESSION['player_stamina']<=0) {
			echo "你掛了</br>殺死你的是".$_SESSION["monster_name"]."</br>請按復活重來";
			$button_control="lose";
		}elseif($_SESSION['monster_stamina']<=0){
			echo "你贏了</br>你殺死的是".$_SESSION["monster_name"]."</br>幹得好!";
			$button_control="win";
		}else{
			echo "<img src='".$_SESSION["monster_Pic"]."'>";
		}
		//怪物圖片/勝利/失敗畫面

		?>
		<hr>
		<table border="1">
			<tr>
				<td colspan="2">
					裝備：<?php echo $_SESSION["player_name"];?>
				</td>
			</tr>
			<tr>
				<td>
					我方體力：<?php echo  $_SESSION["player_stamina"] . "/" .  $_SESSION["player_Max_stamina"];?>
				</td>
				<td>
					我方攻擊力：<?php echo $_SESSION["player_power"] ?>
				</td>
			</tr>
			<tr>
				<td>
					敵方體力：<?php echo $_SESSION["monster_stamina"] . "/" .  $_SESSION["monster_Max_stamina"];?>
				</td>
				<td>
					敵方攻擊力：<?php echo $_SESSION["monster_Last_power"]	?>
				</td>
			</tr>
		</table>
		<hr>
		<form method="POST" action="">
			<?php 
			if(isset($button_control))
				{
				if($button_control=="win"){ ?>
					<input type="submit" name="submit" disabled="disabled" value="攻擊">
					<input type="submit" name="submit" value="離開">
					<?php }else{?>
					<input type="submit" name="submit" disabled="disabled" value="攻擊">
					<input type="submit" name="submit" value="復活">
					<?php }
				}else{?>
				<input type="submit" name="submit" value="攻擊">
				<input type="submit" name="submit" value="逃跑">
				<?php }//判斷勝利/死亡/逃跑?>			
		</form></center>
	</body>
</html>