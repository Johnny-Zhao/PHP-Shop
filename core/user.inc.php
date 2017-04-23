<?php 
/**
 * 用户注册
 * @return string
 */
function reg(){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	$arr['regTime']=time();
	$uploadFile=uploadFile();
	
	//print_r($uploadFile);
	if($uploadFile&&is_array($uploadFile)){
		$arr['face']=$uploadFile[0]['name'];
	}else{
		return "注册失败";
	}
//	print_r($arr);exit;
	if(insert("shop_user", $arr)){
		$mes="注册成功!<br/>3秒钟后跳转到登陆页面!<meta http-equiv='refresh' content='3;url=login.php'/>";
	}else{
		$filename="uploads/".$uploadFile[0]['name'];
		if(file_exists($filename)){
			unlink($filename);
		}
		$mes="注册失败!<br/><a href='reg.php'>重新注册</a>|<a href='index.php'>查看首页</a>";
	}
	return $mes;
}

/**
 * 用户登录
 * @return string
 */
function login(){
	$username=$_POST['username'];
	//防sql注入
	//1.addslashes():使用反斜线引用特殊字符
	//$username=addslashes($username);
	$username=addslashes($username);
	//2.$username=mysqli_escape_string($link,$username);数据进行转译
	$password=md5($_POST['password']);
	$sql="select * from shop_user where username='{$username}' and password='{$password}'";
	//$resNum=getResultNum($sql);
	$row=fetchOne($sql);
	//echo $resNum;
	if($row){
		$_SESSION['loginFlag']=$row['id'];
		$_SESSION['username']=$row['username'];
		$mes="登陆成功！<br/>3秒钟后跳转到首页<meta http-equiv='refresh' content='3;url=index.php'/>";
	}else{
		$mes="登陆失败！<a href='login.php'>重新登陆</a>";
	}
	return $mes;
}

/**
 * 用户退出
 */
function userOut(){
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}
	session_destroy();
	header("location:index.php");
}

/**
 * 添加用户
 */
function addUser(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $arr['regTime']=time();
    $uploadFile=uploadFile("../uploads");
    if($uploadFile&&is_array($uploadFile)){
        $arr['face']=$uploadFile[0]['name'];
    }else{
        return "添加失败!<br/><a href='addUser.php'>重新添加</a>";
    }
    //	print_r($arr);exit;
    if(insert("shop_user", $arr)){
        $mes="添加成功!<br/><a href='addUser.php'>重新添加</a>|<a href='listUser.php'>查看列表</a>";
    }else{
        $filename="../uploads/".$uploadFile[0]['name'];
        if(file_exists($filename)){
            unlink($filename);
        }
        $mes="添加失败!<br/><a href='addUser.php'>重新添加</a>|<a href='listUser.php'>查看列表</a>";
    }
    return $mes;
}

/**
 * 编辑用户
 * @param unknown $id
 * @return Ambigous <string, number>
 */
function editUser($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    //print_r($arr);
    //$mes=update("shop_admin", $arr,"id={$id}");
    if(update("shop_user", $arr,"id='{$id}'")){
        $mes="编辑成功！<br/><a href='listUser.php'>查看用户列表</a>";
    }else{
        $mes="编辑失败！<br/><a href='listUser.php'>重新修改</a>";
    }
    return $mes;
}

/**
 * 删除用户
 * @param int $id
 * @return string
 */
function delUser($id){
    $sql="select face from shop_user where id=".$id;
    $row=fetchOne($sql);
    //删除关联的头像图片
    $face=$row['face'];
    if(file_exists("../uploads/".$face)){
        unlink("../uploads/".$face);
    }
    if(delete("shop_user","id={$id}")){
        $mes="删除成功！<br/><a href='listUser.php'>查看管理员列表</a>";
    }else{
        $mes="删除失败！<br/><a href='listUser.php'>重新删除</a>";
    }
    return $mes;
}






