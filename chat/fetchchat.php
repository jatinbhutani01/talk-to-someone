<?php 
session_start();
require_once 'config.php';
$db= mysqli_connect($host, $user, $password, $database);
if($_GET['ended']==1)
{
    $query4="update available set ended=1 where chatid=".$_SESSION['id'].";";
    $result4= mysqli_query($db, $query4);
    $query5="delete from ".$_SESSION['tablename'].";";
    $result5= mysqli_query($db, $query5);
    $query6="delete from ".$_SESSION['statustable'].";";
    $result6=mysqli_query($db,$query6);
    $tableid= intval(substr($_SESSION['tablename'], 1));
    $query7="insert into availabletable(tablename,tableid) values('".$_SESSION['tablename']."',$tableid);";
    echo "$query7";
    $result7= mysqli_query($db, $query7);
    session_destroy();
    session_start();
}
else
{
$typing=$_GET['typing'];
$tablename=$_SESSION['tablename'];
$statustable=$_SESSION['statustable'];
$p=$_SESSION['person'];
if(!isset($_SESSION['lastmessage']))
{
    $started=0;
    for($i=0;$i<5;$i++)
    {
        $query="select * from $tablename";
        $result=mysqli_query($db,$query);
        if(mysqli_num_rows($result)>0)
        {
            $r=mysqli_fetch_array($result);
            $_SESSION['lastmessage']=$r[0];
            echo "start";
            $started=1;
            exit();
        }
        sleep(0.4);
    }
}
else
{
    $query3="select ended from available where chatid=".$_SESSION['id'].";";
    $result3=mysqli_query($db,$query3);
    $r3=mysqli_fetch_array($result3);
    if($r3[0]==1)
    {
        session_destroy();
        session_start();
        echo "typing-0:ended-1";
    }
    else
    {
        if(isset($_GET['message']))
        {
            $query2="insert into $tablename(message,sender_id) values('".$_GET['message']."',$p);";
            $result2=mysqli_query($db,$query2);
        }
        if($p==1)
        {
            $p2=2;
        }
        else
        {
            $p2=1;
        }
        $query2="select * from $statustable";
        $result2=mysqli_query($db,$query2);
        $r2= mysqli_fetch_array($result2);
        if($p2==1)
        {
            echo "typing-".$r2[0];
            if($r2[1]!=$typing)
            {
                $query8="update $statustable set typing$p=$typing";
                $result8=mysqli_query($db,$query8);
            }
        }
        else  if($p2==2)
        {
            echo "typing-".$r2[1];
            if($r2[0]!=$typing)
            {
                $query8="update $statustable set typing$p=$typing";
                $result8=mysqli_query($db,$query8);
            }
        }
        echo ":ended-0";
        $query3="select * from $tablename where chatid > ".$_SESSION['lastmessage']." and sender_id=$p2";
        $result3=mysqli_query($db,$query3);
        while( $r3= mysqli_fetch_array($result3) )
        {
            $_SESSION['lastmessage']=$r3[0];
            echo ":message-".$r3[1];
        }
    }
}
}
