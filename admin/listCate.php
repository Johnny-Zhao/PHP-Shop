<?php 
require_once '../include.php';
$page = empty($_REQUEST['page']) ? 1 : intval($_REQUEST['page']);
$sql="select * from shop_cate";
$totalRows=getResultNum($sql);
$pageSize=2;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select id,cName from shop_cate order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
if(!$rows){
	alertMes("sorry,没有分类,请添加!","addCate.php");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="styles/backstage.css">
</head>
<body>
<div class="details">
                    <div class="details_operation clearfix">
                        <div class="bui_select">
                            <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addCate()">
                        </div>
                            
                    </div>
                    <!--表格-->
                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="15%">编号</th>
                                <th width="25%">分类</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  foreach($rows as $row):?>
                            <tr>
                                <!--这里的id和for里面的c1 需要循环出来-->
                                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
                                <td><?php echo $row['cName'];?></td>
                                <td align="center"><input type="button" value="修改" class="btn" onclick="editCate(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn"  onclick="delCate(<?php echo $row['id'];?>)"></td>
                            </tr>
                            <?php endforeach;?>
                            <?php if($row>$pageSize):?>
                            <tr>
                            	<td colspan="4"><?php echo showPage($page, $totalPage);?></td>
                            </tr>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
<script type="text/javascript">
	function editCate(id){
		window.location="editCate.php?id="+id;
	}
	function delCate(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delCate&id="+id;
		}
	}
	function addCate(){
		window.location="addCate.php";
	}
</script>
</body>
</html>