<?php
require_once 'include.php';
checkLogined();
$act=$_REQUEST['act'];
if($act=="reg"){
    $mes=reg();
}elseif($act=="login"){
    $mes=login();
}elseif($act=="userOut"){
    $mes=userOut();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php 
	if($mes){
		echo $mes;
	}
?>
</body>
</html>