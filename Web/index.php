<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員管理系統</title>
<style type="text/css">
table tr td {
background-color: #ffdab3;
padding: 10px;
}
div {
margin: 100px auto;
background-color: #ffa94d;
width: 400px;
padding: 50px 100px;
border: groove #663500 5px;
}
</style>
</head>
<body>
<div align="center">
<h2> 會員管理系統 </h2>
<table cellpadding="5">
<?php
    session_start();
	
	if ( ! empty( $_SESSION[ "logined" ]) && $_SESSION[ "logined" ] ) {
?>	
<tr><td>	
<a href='view_profile.php'>檢視個人資料</a><br>
</td></tr>
<tr><td>
<a href='edit_profile.php'>修改個人資料</a><br>
</td></tr>
<tr><td>
<a href='change_password.php'>修改個人密碼</a><br>
</td></tr>
<tr><td><a href='logout.php'>登出系統</a><br>
</td></tr>
<?php	
    }else {
?>		
<tr><td>
<a href='login.php'>會員登入</a><br>
</td><tr>
<tr><td>
<a href='register.php'>註冊會員</a><br>	
</td><tr>
<?php		
    }	
?>
</table>

</body>
</html>