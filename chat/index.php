<?php
ini_set('max_execution_time',1000);
session_start();
require_once 'config.php';
$notfound=0;
$db= mysqli_connect($host, $user, $password, $database);
if(isset($_SESSION['started']))
{
    header('loation:chat.php');
}
else
{
    if(isset($_POST['submit']))
    {
        $name=$_POST['chatname'];
        $query="select * from available where ssid is NULL";
        $result=mysqli_query($db,$query);
        if(mysqli_num_rows($result)==0)
        {
            $quer="insert into available(fpn,fsid) values('$name','".session_id()."');";
            $resul=mysqli_query($db,$quer);
            $_SESSION['id']= mysqli_insert_id($db);
            $id=$_SESSION['id'];
            $found=0;
            for($i=0;$i<20;$i++)
            {
                $query1="select chatid, fpn, fsid, spn, ssid, tablename, statustable,ended from available where chatid=$id";
                $result1=mysqli_query($db,$query1);
                $r= mysqli_fetch_array($result1);
                if(is_null($r[4]))
                {
                    if($i<19)
                    {
                    sleep(1);
                    }
                }
                else
                {
                    $_SESSION['id']=$id;
                    $_SESSION['tablename']=$r[5];
                    $_SESSION['statustable']=$r[6];
                    
                    $_SESSION['person']=1;
                    $found=1;
                    $query6="insert into ".$r[5]."(message,sender_id) values('start','0000');";
                    $result6=mysqli_query($db, $query6);
                    header('location:chat.php');
                    exit();
                    
                }
            }
            if($found==0)
            {
                $notfound=1;
                $query4="delete from available where chatid=$id";
                $result4=mysqli_query($db,$query4);
            }
        }
        else
        {
            $data=mysqli_fetch_array($result);
            $query2="select * from availabletable LIMIT 1";
            $result2=mysqli_query($db,$query2);
            $re=mysqli_fetch_array($result2);
            $query5="delete from availabletable where tableid=".$re[1].";";
            $result5=mysqli_query($db,$query5);
            $query3="update available set spn='$name',ssid='".session_id()."',tablename='".$re[0]."',statustable='s".$re[1]."' , ended=0 where chatid=".$data[0].";";
            $result3=mysqli_query($db,$query3);
            $query7="insert into s".$re[1]." values(0,0);";
            $result7= mysqli_query($db, $query7);
            $_SESSION['person']=2;
            $_SESSION['id']=$data[0];
            $_SESSION['tablename']=$re[0];
            $_SESSION['statustable']="s".$re[1];
            header('location:chat.php');
        }
    }
    
?>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>
            Welcome
        </title>
    </head>
    <body>
        <header>
            <span id="logo">TalkToSomeone</span>
        </header>
        <h1 id="h1">
            TalkToSomeone is a website that helps you to talk to random person person willing to talk an available
        </h1>
        <br>
        <h2>
            Fill in your name below and start chatting with someone.
        </h2>
        <div id="body">
        <div id="inner">
        <h1>
            Enter your desired name
        </h1>
        <p>
        (entered name will be visible to the other person)
        </p>
        <?php
            if($notfound==1)
            {
                echo "<p class=\"notfound\">No one is available please try after some time<p>";
            }
        ?>
        <div id="form">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="chatname" autocomplete="none" required>
                <br>
                <input type="submit" value="Start Chat" name="submit" >
            </form>
        </div>
        </div>
        </div>
    </body>
</html>
<?php
}
?>