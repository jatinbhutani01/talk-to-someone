<?php 
session_start();
require_once 'config.php';
$db= mysqli_connect($host, $user, $password, $database);
$query="select * from available where chatid=".$_SESSION['id'].";";
$result=mysqli_query($db,$query);
$r=mysqli_fetch_array($result);
$p=$_SESSION['person'];
if($p==1)
{
    $name=$r[3];
}
else
{
    $name=$r[1];
}
if(isset($_SESSION['tablename']))
{
?>
<html>
    <head>
        <script type="text/javascript" src="fetchchat.js"></script>
        <link rel="stylesheet" href="chat.css">
        <title>Chat with random person</title>
    </head>
    <body>
        <header>
            <span id="logo">TalkToSomeone</span>
        </header>
        <div class="chatouter">
            <div class="chatinner">
                <div class="chatheader">
                    <?php
                        echo "<h2 class=\"head\" id=\"headchat\" align=\"center\">You are connected to $name</h2>";
                    ?>
                </div>
                <div class="chatbody" id="chatbody">
                </div>
                <div class="lowerchat" id="lowerchat">
                </div>
                <div class="send">
                    <button onclick="endchat();">End</button>
                    <textarea id="message" onkeydown="keypress()" name="message" placeholder="Message" value=""></textarea>
                    <button onclick="loadmessage()" id="sendbutton" >Send</button>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
}
?>