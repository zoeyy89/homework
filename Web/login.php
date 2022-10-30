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
	
	if ( ! empty( $_SESSION[ "logined" ]) && $_SESSION[ "logined" ] ) {
		show_already_logined_page() ;
    }
	else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    include 'connect_db.php' ;			
		if( check_email_password_ok() ) {
			show_login_successful_page() ;
		}
		else {
			show_user_login_page() ;
		}
	}
    else {
		show_user_login_page() ;
    }	
?>
<br>
</body>
</html>

<?php
function show_user_login_page()
{

	echo <<<EOD
<form id="f1" name ="f1" method="post" action="{$_SERVER['PHP_SELF']}">
<h2> 會員登入 </h2>
<table cellpadding="5">
<tr><td align="right">電子郵件: </td><td align="left"><input type="text" name="email" required></td></tr>
<tr><td align="right">密碼: </td><td align="left"><input type="password" name="password" required></td></tr>
<tr><td colspan="2" align="center">
<input type="submit" value="登入"><input type="reset"></td></tr>
</table>
EOD;
	
}

function show_already_logined_page()
{
	echo <<<EOD
<h2>你之前已經成功登入系統了</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
EOD;
}

function show_login_successful_page()
{
	echo <<<EOD
<h2>你已經成功登入系統</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
EOD;
	
}

function check_email_password_ok()
{
	global $conn ;
	
	$email = $_POST['email'];	
	$password = $_POST['password'];	
	
	$sql = "SELECT email, password FROM persons where email = '{$email}'" ;
	$result = $conn->query($sql);

	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc() ;
		if( password_verify($password, $row["password"] ) ) {
			$_SESSION[ "logined" ] = true ;
			$_SESSION[ "email" ] = $email ;
			return true ;
		}
		else {
			return false ;
		}
	}
	else {
		return false ;		
	}		
}

