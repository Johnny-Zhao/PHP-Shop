<?php
function addAlbum($arr){
    insert("shop_album", $arr);
}

/**
 * 根据商品id得到商品图片
 * @param int $id
 * @return array
 */
function getProImgById($id){
    $sql="select albumPath from shop_album where pid={$id} limit 1";
    $row=fetchOne($sql);
    return $row;
}

/**
 * 完成文字水印
 * @param int $id
 * @return string
 */
function doWaterText($id){
    $rows=getProImgsById($id);
    foreach ($rows as $row){
        $filename="../image_800/".$row['albumPath'];
        waterText($filename);
    }
    $mes="修改成功";
    return $mes;
}

/**
 * 完成图片水印
 * @param int $id
 * @return string
 */
function doWaterPic($id){
    $rows=getProImgsById($id);
    foreach ($rows as $row){
        $filename="../image_800/".$row['albumPath'];
        waterPic($filename);
    }
    $mes="修改成功";
    return $mes;
}