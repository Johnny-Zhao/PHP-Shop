<?php 
require_once '../include.php';
$id=$_REQUEST['id'];
$sql="select id,username,password,email,sex from shop_user where id='{$id}'";
$row=fetchOne($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<h3>编辑用户</h3>
<form action="doAdminAction.php?act=editUser&id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">用户名</td>
		<td><input type="text" name="username" placeholder="<?php echo $row['username'];?>"/></td>
	</tr>
	<tr>
		<td align="right">密码</td>
		<td><input type="password" name="password"/></td>
	</tr>
	<tr>
		<td align="right">邮箱</td>
		<td><input type="text" name="email" placeholder="<?php echo $row['email'];?>"/></td>
		
	</tr>
	<tr>
		<td align="right">性别</td>
		<td><input type="radio" name="sex" value="1"  <?php echo $row['sex']=="男"?"checked='checked'":null;?>/>男
		<input type="radio" name="sex" value="2" <?php echo $row['sex']=="女"?"checked='checked'":null;?>/>女
		<input type="radio" name="sex" value="3" <?php echo $row['sex']=="保密"?"checked='checked'":null;?>/>保密
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="编辑用户"/></td>
	</tr>

</table>
</form>
</body>
</html>