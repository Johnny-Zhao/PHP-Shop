<?php
/**
 * 分页
 */
/* require_once '../include.php';
$sql = "select * from shop_admin";
$totalRows = getResultNum($sql);
// echo $totalRows;
$pageSize = 2;
// 得到总页码数
$totalPage = ceil($totalRows / $pageSize);
// $page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
// 解决$page没传参数报错：
$page = empty($_REQUEST['page']) ? 1 : intval ($_REQUEST['page']);
// 偏移量
$offset = ($page - 1) * $pageSize;
if ($page < 1 || $page == null || ! is_numeric($page)) {
    $page = 1;
}
if ($page >= $totalPage) {
    $page = $totalPage;
}
$sql = "select * from shop_admin limit {$offset},{$pageSize}";
// echo $sql;
$rows = fetchAll($sql);
// print_r($rows);
/* foreach ($rows as $row) {
    echo "编号:" . $row['id'], "<br/>";
    echo "管理员的名称：" . $row['username'], "<hr/>";
} */
//echo showPage($page, $totalPage); */

function showPage($page, $totalPage, $where = null, $sep = "&nbsp;")
{
    $where = ($where == null) ? null : "&" . $where;
    $url = $_SERVER['PHP_SELF'];
    $index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
    $last = ($page == $totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
    $prev = ($page == 1) ? "上一页" : "<a href='{$url}?page=" . ($page - 1) . "{$where}'>上一页</a>";
    $next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page=" . ($page + 1) . "{$where}'>下一页</a>";
    $str = "总共{$totalPage}页/当前是第{$page}页";
    $p = "";
    for ($i = 1; $i <= $totalPage; $i ++) {
        // 当前页无连接
        if ($page == $i) {
            $p .= "[{$i}]";
        } else {
            $p .= "<a href='{$url}?page={$i}'>[{$i}]</a>";
        }
    }
    $pageStr = $str . $sep . $index . $sep . $last . $sep . $prev . $sep . $next . $sep . $p;
    return $pageStr;
}