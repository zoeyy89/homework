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
margin: 10px auto;
background-color: #ffa94d;
width: 400px;
padding: 50px 100px;
border: groove #663500 5px;
}
</style>
</head>
<body>
<?php

    session_start();
	
	
	if ( ! empty( $_SESSION[ "logined" ]) && $_SESSION[ "logined" ] ) {
		
		$email = $_SESSION[ "email" ] ;	
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			include 'connect_db.php' ;
			$check_data_ok = true ;
			$error_message = "" ;;				
			$old_password = $_POST['old_password'];
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			
			if ( ! check_old_password_ok() ){
				$check_data_ok = false ;
				$error_message .= "[舊密碼]不正確!<br>";
			}

			if (strlen($password) < 8) {
				$check_data_ok = false ;
				$error_message .= "[新密碼]長度至少要八碼!<br>";
			}
	
			if ($password != $password2) {
				$check_data_ok = false ;
				$error_message .= "[新密碼]與[確認新密碼]不一致!<br>";
			}			
	
			if ( $check_data_ok ) {
				$pwdHash = password_hash($password , PASSWORD_DEFAULT);	
				$sql = "update persons set password='{$pwdHash}' where email = '{$email}'" ;
				if ($conn->query($sql) === TRUE) {			
					display_change_password_successful() ;
				}
				else {
					show_db_update_error() ;
				}
				$conn->close();
			} 
			else {
				show_change_password_form()  ;
			}
		}
		else {
				show_change_password_form() ;
		}
    }
	else  {
        show_not_logined_page();
	}


?>	

<?php

//=====================================================================

function check_old_password_ok()
{
	global $conn, $email, $old_password ;	
	
	$sql = "SELECT password FROM persons where email = '{$email}'" ;
	$result = $conn->query($sql);

	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc() ;
		if( password_verify($old_password, $row["password"] ) ) {
			return true;
		}
		else {
			return false;
		}
	}
}
	
function show_change_password_form()
{
	global $old_password, $email, $password, $password2, $error_message ;	
	
echo <<<EOD
<form id="f1" name ="f1" method="post" action="{$_SERVER['PHP_SELF']}">
<div align="center">
<h2>修改會員密碼</h2>
<table cellpadding="5">
<tr><td align="right">電子郵件: </td><td align="left">{$email}</td></tr>
<tr><td align="right">舊密碼: </td><td align="left"><input type="password" name="old_password"></td></tr>
<tr><td align="right">設定新密碼: </td><td align="left"><input type="password" name="password"></td></tr>
<tr><td align="right">再次確認新密碼: </td><td align="left"><input type="password" name="password2"></td></tr>
<tr><td colspan="2" align="center">
<input type="submit" value="儲存變更"><input type="reset"></td></tr>
</table>
{$error_message}<br>
<a href='index.php'>回主選單</a><br>
</div>
</form>
EOD;
}

//=====================================================================

function show_not_logined_page()
{
	echo <<<EOD
<div align="center">	
<h2>你尚未登入系統，不能檢視會員基本資料</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
</div>
EOD;
}

function show_db_query_error()
{
	echo <<<EOD
<div align="center">	
<h2>資料庫查詢錯誤</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
</div>
EOD;
}

function show_db_update_error()
{
	echo <<<EOD
<h2>資料庫變更密碼時發生錯誤</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
EOD;
}

function display_change_password_successful()
{
	echo <<<EOD
<div align="center">	
<h2>變更密碼成功</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
</div>
EOD;
}

?>

</body>
</html>

