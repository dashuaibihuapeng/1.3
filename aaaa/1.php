<?php
require_once 'DAOPDO.class.php';
require_once 'smarty/Smarty.class.php';
$config=array(
    'dbname'=>'text'
);
$pdo=DAOPDO::getSingleton($config);
$sql="select * from student";
$arr=$pdo->fetchAll($sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<style>
    table{
        background-color: red;
    }
    th,td{
        width: 400px;
        border: 1px solid #000;
        text-align: center;
    }
</style>
<body>
<table>
    <tr>
        <th>姓名</th>
        <th>分数</th>
        <th>操作</th>
    </tr>
    <?php foreach ($arr as $key=>$value){ ?>
    <tr>
        <td><?php echo $value['name'] ?></td>
        <td><?php echo $value['sx'] ?></td>
        <td><a href="javascript:void(0)" id="<?php echo $value['id'] ?>">删除</a></td>
    </tr>
    <?php } ?>
</table>
<script src="jquery.min.js"></script>
<script>
    $("a").click(function () {
        $id=$(this).attr('id');//获取属性值
        $.ajax({
            url:'2.php',
            type:'post',
            data:{id:$id},
            dataType:'json',
            success:function (data) {
                if(data.code==0){
                    alert('删除成功');
                }else{
                    alert('删除失败');
                }
            }
        })
    })
</script>
</body>
</html>
