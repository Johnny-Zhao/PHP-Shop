<?php
require_once '../lib/string.func.php';
header("content-type:text/html;charset=utf-8");

/**
 * 构建文件上传信息
 */
function buildInfo()
{
    foreach ($_FILES as $v) {
        $i = 0;
        // 单文件
        if (is_string($v['name'])) {
            $files[$i] = $v;
            $i ++;
        } else {
            // 多文件
            foreach ($v['name'] as $key => $val) {
                $files[$i]['name'] = $val;
                $files[$i]['size'] = $v['size'][$key];
                $files[$i]['tmp_name'] = $v['tmp_name'][$key];
                $files[$i]['error'] = $v['error'][$key];
                $files[$i]['type'] = $v['type'][$key];
                $i ++;
            }
        }
        return $files;
    }
}

function uploadFile($path = "uploads", $allowExt = array("gif","jpg","jpeg","png","wbmp"), $maxSize = 2200000, $imgFlag = true)
{
    if (! file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $i=0;
    $files = buildInfo();
    foreach ($files as $file) {
        if ($file['error'] == UPLOAD_ERR_OK) {
            // 需要判断下文件是否通过是HTTP POST方式上传上来的
            // is_uploaded_file($tmp_name);
            $ext = getExt($file['name']);
            $filename = getUniName() . "." . $ext;
            // $path = "uploads";
            // 限制上传文件类型
            if (! in_array($ext, $allowExt)) {
                exit("非法文件类型");
            }
            if ($file['size'] > $maxSize) {
                exit("文件过大");
            }
            if ($imgFlag) {
                // 如何验证图片是否是一个真正的图片类型
                // getimagesize($filename):验证文件是否是图片类型
                $info = getimagesize($file['tmp_name']);
                if (! $info) {
                    exit("不是真正的图片类型");
                }
            }
            if (! is_uploaded_file($file['tmp_name'])) {
                exit("文件不是通过HTTP POST方式上传上来的");
            }
            $filename = getUniName() . "." . $ext;
            $destination = $path . "/" . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $file['name'] = $filename;
                unset($file['error'], $file['tmp_name'], $file['type'],$file['size']);
                $uploadFiles[$i] = $file;
                $i ++;
            }
        } else {
            switch ($file['error']) {
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
            echo $mes;
        }
    }
    return $uploadFiles;
}

$info=uploadFile();
print_r($info);