<?php
/**
 * 添加分类
 * @return string
 */
function addCate(){
    $arr=$_POST;
    if(insert("shop_cate", $arr)){
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
    if(update("shop_cate", $arr,$where)){
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
function delCate($id){
    $res=checkProExit($id);
    if(!$res){
        $where="id=".$id;
        if(delete("shop_cate",$where)){
            $mes="分类删除成功！<br/><a href='listCate.php'>查看分类</a>";
        }else{
            $mes="分类删除失败！<br/><a href='listCate.php'>重新删除</a>";
        }
        return $mes;
    }else{
        alertMes("不能删除分类,请先删除分类下的商品", "listPro.php");
    }
    
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