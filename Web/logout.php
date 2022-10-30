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
<?php
    session_start();
    session_destroy();
?>
<br>
<center>登出成功</center><br>
<center><a href='index.php'>回主選單</a></center>
<br>
</body>
</html>

