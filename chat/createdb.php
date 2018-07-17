<?php
ini_set('max_execution_time',1000);
require_once 'config.php';
$db= mysqli_connect($host, $user, $password, $database);
for($i=1;$i<=100;$i++)
{
    $query="create table t$i(chatid int primary key auto_increment,message varchar(1000),sender_id int not null);";
    $res=mysqli_query($db,$query);
    echo "$res";
    $quer="create table s$i(typing1 int not null,typing2 int not null);";
    $resu=mysqli_query($db,$quer);
    echo "$resu";
    $qu="insert into availabletable(tablename,tableid) values('t$i',$i);";
    $re=mysqli_query($db, $qu);
    echo "$re";
}
ini_set('max_execution_time',30);