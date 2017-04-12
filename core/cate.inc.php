<?php
/**
 * 添加分类
 * @return string
 */
function addCate(){
    $arr=$_POST;
    if(!(insert("shop_cate", $arr))){
        $mes="分类添加成功！<br/><a href='addCate.php'>继续添加</a>|<a href='listCate.php'>查看分类</a>";
    }else{
        $mes="添加失败！<br/><a href='addCate.php'>重新添加</a>|<a href='listCate.php'>查看分类</a>";
    }
    return $mes;
}

/**
 * 根据id得到指定分类信息
 * @param int $id
 * @return unknown
 */
function getCateById($id){
    $sql="select id,cName from shop_cate where id='{$id}'";
    return fetchOne($sql);
}

/**
 * 修改分类列表
 * @param string $where
 * @return string
 */
function editCate($where){
    $arr=$_POST;
    if(!(update("shop_cate", $arr,$where))){
        $mes="分类修改成功！<br/><a href='listCate.php'>查看分类</a>";
    }else{
        $mes="分类修改失败！<br/><a href='listCate.php'>重新修改</a>";
    }
    return $mes;
}

/**
 * 删除分类
 * @param string $where
 * @return string
 */
function delCate($where){
    if(!delete("shop_cate",$where)){
        $mes="分类删除成功！<br/><a href='listCate.php'>查看分类</a>";
    }else{
        $mes="分类删除失败！<br/><a href='listCate.php'>重新删除</a>";
    }
    return $mes;
}

/**
 * 得到所有商品的分类
 */
function getAllCate(){
    $sql="select id,cName from shop_cate";
    $rows=fetchAll($sql);
    return $rows;
}




/* function getAllCateByPage(){
    
} */