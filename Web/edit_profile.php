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
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$check_data_ok = true ;
			$error_message = "" ;
			$email = $_SESSION[ "email" ] ;	
			$name = $_POST['name'];
			$gender = $_POST['gender'];
			$phone = $_POST['phone'];
			$address = $_POST['address'];
	
			if (empty( $name )) {
				$check_data_ok = false ;
				$error_message .= "[姓名]是必填欄位不得空白!<br>";
			}
			
			if (empty( $gender )) {
				$check_data_ok = false ;
				$error_message .= "[性別]是必填欄位不得空白!<br>";
			}			
	
			if ( $check_data_ok ) {
				include 'connect_db.php' ;
				$sql = "update persons set name='{$name}', gender='{$gender}', phone='{$phone}', address='{$address}' where email = '{$email}'" ;
				if ($conn->query($sql) === TRUE) {			
					display_profile() ;
				}
				else {
					show_db_update_error() ;
				}
				$conn->close();
			} 
			else {
				show_edit_form() ;
			}
		}
		else {
			include 'connect_db.php' ;
			$email = $_SESSION[ "email" ] ;
			$sql = "SELECT name, gender, phone, address FROM persons where email = '{$email}'" ;
			$result = $conn->query($sql);
	
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc() ;
				$name = $row[ 'name' ] ;
				$gender = $row[ 'gender' ] ;
				$phone = $row[ 'phone' ] ;
				$address = $row[ 'address' ] ;
			
				show_edit_form() ;
			}
			else {
				show_db_query_error() ;
			}
			$conn->close();		
		}
    }
	else  {
        show_not_logined_page();
	}


?>	

<?php

//=====================================================================

function show_edit_form()
{
	global $email, $name, $gender, $phone, $address, $error_message ;	
	
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
<h2>修改會員基本資料</h2>
<table cellpadding="5">
<tr><td align="right">電子郵件*: </td><td align="left">{$email}</td></tr>
<tr><td align="right">姓名*: </td><td align="left"><input type="text" name="name" required value="{$name}"></td></tr>
<tr><td align="right">性別*: </td><td align="left">
 <input type="radio" name="gender" value="M" required {$gener_m}>
 <label for="男">男</label><br>
 <input type="radio"  name="gender" value="F" required {$gener_f}>
 <label for="女">女</label><br>
</td></tr>
<tr><td align="right">電話: </td><td align="left"><input type="text" name="phone" value="{$phone}"></td></tr>
<tr><td align="right">地址: </td><td align="left"><input type="text" name="address" value="{$address}"></td></tr>
<tr><td colspan="2" align="center">
<input type="submit" value="儲存"><input type="reset"></td></tr>
</table>
{$error_message}<br>
</div>
</form>
EOD;
}



//=====================================================================

function display_profile()
{

	global $email, $name, $gender, $phone, $address, $password, $password2 ;
	
echo <<<EOD
<div align="center">
<h2> 會員基本資料儲存成功 </h2>
<table cellpadding="5">
<tr><td align="right">電子郵件: </td>
    <td align="left">{$email}</td>
</tr>
<tr><td align="right">姓名: </td>
    <td align="left">{$name}</td>
</tr>
<tr><td align="right">性別: </td>
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
<br>
<center><a href='edit_profile.php'>修改個人資料</a></center><br>
<center><a href='index.php'>回主選單</a></center>
EOD;

}

function show_not_logined_page()
{
	echo <<<EOD
<h2>你尚未登入系統，不能檢視會員基本資料</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
EOD;
}

function show_db_query_error()
{
	echo <<<EOD
<h2>資料庫查詢錯誤</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
EOD;
}

function show_db_update_error()
{
	echo <<<EOD
<h2>資料庫儲存時發生錯誤</h2>
<table cellpadding="5">
<tr><td>
<a href='index.php'>回主選單</a><br>
</td></tr>
</table>
EOD;
}

?>

</body>
</html>

