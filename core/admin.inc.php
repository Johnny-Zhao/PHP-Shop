<?php
/**
 * 检查是否有管理员
 * @param unknown $sql
 * @return multitype:
 */
function checkAdmin($sql){
    return fetchOne($sql);
}

/**
 * 检车是否有管理员登录
 */
function checkLogined(){
    if(@$_SESSION['adminId']==""&&@$_COOKIE['adminId']=""){
        alertMes("请先登陆", "login.php");
    }
}

/**
 * 添加管理员
 * @return string
 */
function addAdmin(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    //print_r($arr);
    $mes=insert("shop_admin", $arr);
    /* print_r($arr);
    print_r($mes); */
    //$mes总是返回0
    //!$mes为什么是！未解决
    //如果记录中没有这条所以可以添加
    if($mes){
        $mes="添加成功！<br/><a href='addAdmin.php'>继续添加</a>
            |<a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes="添加失败！<br/><a href='addAdmin.php'>重新添加</a>";
    }
    return $mes;
}

/**
 * 编辑管理员
 * @param unknown $id
 * @return Ambigous <string, number>
 */
function editAdmin($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    //print_r($arr);
    //$mes=update("shop_admin", $arr,"id={$id}");
    if(update("shop_admin", $arr,"id='{$id}'")){
        $mes="编辑成功！<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes="编辑失败！<br/><a href='listAdmin.php'>重新修改</a>";
    }
    return $mes;
}

/**
 * 删除管理员
 * @param unknown $id
 * @return string
 */
function delAdmin($id){
    if(delete("shop_admin","id={$id}")){
        $mes="删除成功！<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }else{
        $mes="删除失败！<br/><a href='listAdmin.php'>重新删除</a>";
    }
    return $mes;
}


/**
 * 得到所有的管理员
 * @return multitype:
 */
function getAllAdmin(){
    $sql="select id,username,email from shop_admin";
    $rows=fetchAll($sql);
    return $rows;
}

function getAdminByPage($pageSize=2){
    $sql = "select * from shop_admin";
    global $totalPage;
    $totalRows = getResultNum($sql);
    global $totalPage;
    $totalPage = ceil($totalRows / $pageSize);
    global $page;
    $page = empty($_REQUEST['page']) ? 1 : intval ($_REQUEST['page']);
    if ($page < 1 || $page == null || ! is_numeric($page)) {
        $page = 1;
    }
    if ($page >= $totalPage) {
        $page = $totalPage;
    }
    $offset = ($page - 1) * $pageSize;
    $sql = "select id,username,email from shop_admin limit {$offset},{$pageSize}";
    $rows = fetchAll($sql);
    return $rows;
}

/**
 * 注销管理员
 */
function logout(){
    //清空$_SESSION
    $_SESSION=array();
    if(isset($_COOKIE[session_name()])){
        //注销cookie
        setcookie(session_name(),"",time()-1);
    }
    if(isset($_COOKIE['adminName'])){
        setcookie('adminName',"",time()-1);
    }
    if(isset($_COOKIE['adminId'])){
        setcookie('adminId',"",time()-1);
    }
    //注销session
    session_destroy();
    //跳转到登录页面
    header("location:login.php");
}

