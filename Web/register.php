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

include 'connect_db.php' ;

$check_data_ok = true ;
$error_message = "" ;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST['email'];	
	$name = $_POST['name'];
	$gender = $_POST['gender'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];	
	
	if (empty( $email )) {
        $check_data_ok = false ;
        $error_message .=  "[email]是必填欄位不得空白!<br>";
	}
	
	if (empty( $name )) {
        $check_data_ok = false ;
        $error_message .= "[姓名]是必填欄位不得空白!<br>";
	}
	
	if (empty( $gender )) {
        $check_data_ok = false ;
        $error_message .= "[性別]是必填欄位不得空白!<br>";
	}	
	
	if (strlen($password) < 8) {
        $check_data_ok = false ;
        $error_message .= "[密碼]長度至少要八碼!<br>";
	}
	
	if ($password != $password2) {
        $check_data_ok = false ;
        $error_message .= "[密碼]與[確認密碼]不一致!<br>";
	}	
	
	if ( ! check_email_ok( $email ) ) {
        $check_data_ok = false ;
        $error_message .= "此 email 已註冊過!<br>";		
	}
	
	if ( $check_data_ok ) 
		show_registed_page() ;
	else
		show_edit_form() ;
  	
}
else {
	$email = '';	
	$name = '';
	$gender = '';
	$phone = '';
	$address = '';
	$password = '';
	$password2 = '';		

    show_edit_form() ;
}

?>	

<?php


//==================================================================
function check_email_ok( $email )
{
	global $conn ;
	
	$sql = "SELECT email FROM persons where email = '" . $email . "'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		return false ;
	}
	else {
		return true ;		
	}	
}

//===================================================================

function insert_member_data()
{
	global $conn ;
	global $email, $name, $gender, $phone, $address, $password ;
	
	$pwdHash = password_hash($password , PASSWORD_DEFAULT);	
	$sql = "INSERT INTO persons (email, name, gender, phone, address, password )
VALUES ( '{$email}', '{$name}', '{$gender}', '{$phone}', '{$address}', '{$pwdHash}' )";

	if ($conn->query($sql) === TRUE) {
		return true ;
	} else {
		return false;
	}	
}

//===================================================================

function show_edit_form()
{
	global $email, $name, $gender, $phone, $address, $password, $password2, $error_message ;	
	
	$gener_m = "" ;	
	$gener_f = "" ;	
	
	if ($gender == 'M' ) {
		$gener_m = "checked=checked" ;
	}

	if ($gender == 'F' ) {
		$gener_f = "checked=checked" ;
	} 
	
echo <<<EOD
<form id="f1" name ="f1" method="post" action="{$_SERVER['PHP_SELF']}">
<div align="center">
<h2>會員註冊</h2>
<table cellpadding="5">
<tr><td align="right">電子郵件*: </td><td align="left"><input type="text" name="email" required value="{$email}"></td></tr>
<tr><td align="right">姓名*: </td><td align="left"><input type="text" name="name" required value="{$name}"></td></tr>
<tr><td align="right">性別*: </td><td align="left">
 <input type="radio" name="gender" value="M" required {$gener_m}>
 <label for="男">男</label><br>
 <input type="radio"  name="gender" value="F" required {$gener_f}>
 <label for="女">女</label><br>
</td></tr>
<tr><td align="right">電話: </td><td align="left"><input type="text" name="phone" value="{$phone}"></td></tr>
<tr><td align="right">地址: </td><td align="left"><input type="text" name="address" value="{$address}"></td></tr>
<tr><td align="right">設定密碼: </td><td align="left"><input type="password" name="password" value="{$password}"></td></tr>
<tr><td align="right">再次確認密碼: </td><td align="left"><input type="password" name="password2" value="{$password2}"></td></tr>
<tr><td colspan="2" align="center">
<input type="submit" value="會員註冊"><input type="reset"></td></tr>
</table>
{$error_message}<br>
</div>
</form>
EOD;
}

//=====================================================================

function show_registed_page()
{

	global $email, $name, $gender, $phone, $address, $password, $password2 ;
	
	if( insert_member_data() ) {
		
echo <<<EOD
<div align="center">
<h2>~ 完成會員註冊 ~</h2>
<table cellpadding="5">
<tr><td align="right">電子郵件*: </td>
    <td align="left">{$email}</td>
</tr>
<tr><td align="right">姓名*: </td>
    <td align="left">{$name}</td>
</tr>
<tr><td align="right">性別*: </td>
<td align="left">{$gender}</td>
</tr>
<tr><td align="right">電話: </td>
    <td align="left">{$phone}</td>
</tr>
<tr><td align="right">地址: </td>
<td align="left">{$address}</td>
</tr>
</table>
</div>
EOD;
	} else {
		echo '資料庫錯誤，無法儲存會員資料!!' ;
	}

}

?>

<center><a href='index.php'>回主選單</a></center>
<br>
</body>
</html>

