<?php
require_once 'i_DAOPDO.class.php';
class DAOPDO implements i_DAOPDO{
    private $host;//服务器地址
    private $dbname;//数据库名
    private $port;//端口号
    private $charset;//字符集
    private $user;//用户名
    private $pass;//密码
    private $pdo;//连接对象
    private static $instance;//保存创建出来的实例对象
    private function __clone(){
    }
    private function __construct($options)
    {
        $this->host=isset($options['host'])?$options['host']:'localhost';
        $this->dbname=isset($options['dbname'])?$options['dbname']:'php';
        $this->port=isset($options['port'])?$options['port']:'3306';
        $this->charset=isset($options['charset'])?$options['charset']:'utf8';
        $this->user=isset($options['user'])?$options['user']:'root';
        $this->pass=isset($options['pass'])?$options['pass']:'root';
        //        初识化pdo对象
        $dsn="mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=$this->charset";
        $user=$this->user;
        $pass=$this->pass;
        try{
            $this->pdo=new PDO($dsn,$user,$pass);
        }catch (PDOException $e){
            echo '连接失败'.$e->getMessage();
        }
    }
    public static function getSingleton($options){
        if(!self::$instance instanceof self){
            self::$instance=new self($options);
        }
        return self::$instance;
    }
    //    查询全部
    public function fetchAll($sql){
        $pdo_statement=$this->pdo->query($sql);
        if($pdo_statement==false){
            echo 'sql语句有问题'.$this->pdo->errorInfo()[2];
        }
        $arr=$pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }
    //    查询单条
    public function fetchRow($sql){
        $pdo_statement=$this->pdo->query($sql);
        if($pdo_statement==false){
            echo 'sql语句有问题'.$this->pdo->errorInfo()[2];
        }
        return $pdo_statement->fetch(PDO::FETCH_ASSOC);
    }
    //    查询某个字段
    public function fetchOne($sql){
        $pdo_statement=$this->pdo->query($sql);
        if($pdo_statement==false){
            echo 'sql语句有问题'.$this->pdo->errorInfo()[2];
        }
        return $pdo_statement->fetchColumn();
    }
    //    增删改
    public function query($sql){
        $affect_rows=$this->pdo->exec($sql);
        if($affect_rows>0){
            return true;
        }else{
            return false;
        }
    }
    //    添加引号
    public function quote($data){
        return $this->pdo->quote($data);
    }
    //    获取增加成功的id号
    public function getInsertId(){
        return $this->pdo->lastInsertId();
    }
}
//$configs=array(
//    'host'=>'localhost',
//    'dbname'=>'php',
//    'port'=>'3306',
//    'charset'=>'utf8',
//    'user'=>'root',
//    'pass'=>'root'
//);
//$p1=DAOPDO::getSingleton($configs);

//$sql="select * from article";
//$res=$p1->fetchAll($sql);
//echo '<pre>';
//print_r($res);
//echo '</pre>';

//$sql="insert into article (id,title,content,cid) values (null,'mad','mad的内容','2')";
//$res=$p1->query($sql);
//if ($res){
//    echo '增加成功';
//}else{
//    echo '增加失败';
//}

//$sql="update article set title='C++' where id=5";
//$res=$p1->query($sql);
//if ($res){
//    echo '修改成功';
//}else{
//    echo '修改失败';
//}

//$sql="delete from article where id=5";
//$res=$p1->query($sql);
//if ($res){
//    echo '删除成功';
//}else{
//    echo '删除失败';
//}