<?php
/**
 * 连接数据库
 * @return resource
 */
function connect()
{
    //$link = mysqli_connect(DB_HOST, DB_USER, DB_PWD) or die("数据库连接失败Error:" . mysqli_errno() . ":" . mysqli_error());
    //mysqli_set_charset($link, DB_CHAREST);
    //mysqli_select_db($link,DB_DBNAME) or die("用户名错误");
    $link=new mysqli("localhost", "root", "960223", "shop");
    //$link= new mysqli(DB_HOST,DB_USER,DB_PWD,DB_DBNAME);
    if ($link->connect_error) {
        die("连接失败: " . $link->connect_error);
    }
    return $link;
}

/**
 * 插入记录
 *
 * @param string $table            
 * @param array $array            
 * @return number
 */
function insert($table, $array)
{
    $keys = "".join(",", array_keys($array));
    $vals = "'" . join("','", array_values($array)) . "'";
    $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$vals})";
    mysqli_query(connect(),$sql);
    return mysqli_insert_id(connect());
}

/**
 * 更新记录
 *
 * @param string $table            
 * @param array $array            
 * @param string $where            
 * @return number
 */
 //未解决更新
function update($table, $array, $where = null)
{
    //定义放在循环外面！！！！！！！
    $str = "";
    foreach ($array as $key => $val) {
        if ($str == null) {
            $sep = "";
        } else {
            $sep = ",";
        }
        $str .= $sep . $key . "='" . $val . "'";
    }
    $sql = "update {$table} set {$str} " . ($where == null ? null : " where " . $where);
    //echo $sql;exit;
    $result=mysqli_query(connect(),$sql);
    if($result){
        return mysqli_affected_rows(connect());
    }else{
        return false;     
    }
}

/**
 * 删除记录
 *
 * @param string $table            
 * @param string $where            
 */
function delete($table, $where = null)
{
    $where = $where == null ? null : " where " . $where;
    $sql = "delete from {$table}{$where}";
    mysqli_query(connect(),$sql);
    return mysqli_affected_rows(connect());
}

/**
 * 获取其中一条记录
 *
 * @param string $sql            
 * @param string $result_type            
 */
function fetchOne($sql)
{
    $result = mysqli_query(connect(),$sql);
    $row=mysqli_fetch_assoc($result);
    return $row;
}

/**
 * 获取所有记录
 *
 * @param string $sql            
 * @param string $result_type            
 * @return multitype:
 */
function fetchAll($sql)
{
    $result = mysqli_query(connect(),$sql);
    while (@$row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

/**
 * 获取记录条数
 *
 * @param string $sql            
 * @return number
 */
function getResultNum($sql)
{
    $result = mysqli_query(connect(),$sql);
    return mysqli_num_rows($result);
}

/**
 * 获取插入记录的id
 * @return number
 */
function getInsertId(){
    return mysqli_insert_id(connect());
}
