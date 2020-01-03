<?php
$id=$_POST['id'];
require_once 'DAOPDO.class.php';
$config=array(
    'dbname'=>'test'
);
$pdo=DAOPDO::getSingleton($config);
$sql="delete from student where id=$id";
$res=$pdo->query($sql);
if($res){
    $arr=array(
        'code'=>0,
        'msg'=>'删除成功'
    );
    echo json_encode($arr);
}else{
    $arr=array(
        'code'=>1,
        'msg'=>'删除失败'
    );
    echo json_encode($arr);
}