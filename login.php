<?php
if(isset($_POST['submit']))
{
	if($_POST['name']=="root"&&$_POST['pass']=="1234")
	{
		echo "<body onload=\"window.open('console.php','_top')\">";
	}
	else
	{
		echo "登入失敗!";
	}
}
if(isset($_POST['back']))
{
	echo "<body onload=\"window.open('phpsystem.php','_top')\">";
}
?>
<html>
<head>
</head>
<body>
	<form action="" method="POST" align="center">
		<h1>LOGIN PAGE</h1>
		帳號:<input type="text" name="name" id="name"></br>
		密碼:<input type="password" name="pass" id="pass"></br>
		<input type="submit" name="submit" id="submit" value="登入">
		<input type="submit" name="back" id="back" value="返回">
	</form>
</body>
</html>