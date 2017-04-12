<?php
require_once '../lib/string.func.php';
header("content-type:text/html;charset=utf-8");
// $filename = $_FILES['myFile']['name'];
// $type = $_FILES['myFile']['type'];
// $tmp_name = $_FILES['myFile']['tmp_name'];
// $error = $_FILES['myFile']['error'];
// $size = $_FILES['myFile']['size'];
function uploadFile($fileInfo, $path = "uploads", $allowExt = array("gif","jpg","jpeg","png","wbmp"), $maxSize = 1048576, $imgFlag = true)
{
    /*
     * $allowExt = array(
     * "gif",
     * "jpg",
     * "jpeg",
     * "png",
     * "wbmp"
     * );
     */
    // $maxSize = 1048576; // 2M
    // $imgFlag = true;
    // 判断错误信息
    if ($fileInfo['error'] == UPLOAD_ERR_OK) {
        // 需要判断下文件是否通过是HTTP POST方式上传上来的
        // is_uploaded_file($tmp_name);
        $ext = getExt($fileInfo['name']);
        $filename = getUniName() . "." . $ext;
        // $path = "uploads";
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $destination = $path . "/" . $filename;
        // 限制上传文件类型
        if (! in_array($ext, $allowExt)) {
            exit("非法文件类型");
        }
        if ($fileInfo['size'] > $maxSize) {
            exit("文件过大");
        }
        if ($imgFlag) {
            // 如何验证图片是否是一个真正的图片类型
            // getimagesize($filename):验证文件是否是图片类型
            $info = getimagesize($fileInfo['tmp_name']);
            if (! $info) {
                exit("不是真正的图片类型");
            }
        }
        if (is_uploaded_file($fileInfo['tmp_name'])) {
            if (move_uploaded_file($fileInfo['tmp_name'], $destination)) {
                $mes = "文件上传成功";
            } else {
                $mes = "文件移动失败";
            }
        } else {
            $mes = "文件不是通过HTTP POST方式上传上来的";
        }
    } else {
        switch ($fileInfo['error']) {
            case 1:
                // UPLOAD_ERR_INI_SIZE==1
                $mes = "超过了配置文件上传文件的大小";
                break;
            case 2:
                // UPLOAD_ERR_FORM_SIZE==2
                $mes = "超过了表单设置上传文件的大小";
                break;
            case 3:
                // UPLOAD_ERR_PARTIAL
                $mes = "文件部分被上传";
                break;
            case 4:
                // UPLOAD_ERR_NO_FILE
                $mes = "没有文件被上传";
                break;
            case 6:
                // UPLOAD_ERR_NO_TMP_DIR
                $mes = "没有找到临时目录";
                break;
            case 7:
                // UPLOAD_ERR_CANT_WRITE
                $mes = "文件不可写";
                break;
            case 8:
                // UPLOAD_ERR_EXTENSION
                $mes = "由于PHP的扩展程序中断了文件上传";
                break;
        }
    }
    return $mes;
}

