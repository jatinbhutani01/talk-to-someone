var started=0;
var typing=0;
var ended=0;
var time;
var message;
var messageloaded=0;
var endsent=0;
var call=setInterval(fetchchat,1000);
var required=1;
var url="http://localhost/chat/";
//window.onbeforeunload=function(){
//    clearInterval(call);
//    ended=1;
//    required=0;
//    fetchchat();
//};
function endchat()
{
    var head=document.getElementById("headchat");
    head.innerHTML="You LEFT";
    ended=1;
}
function keypress()
{
    typing=1;
    clearTimeout(time);
    time=setTimeout(function(){
        typing=0;
    },2000);
}

function loadmessage()
{
    var mtext=document.getElementById('message');
    var aaaa=document.getElementById('chatbody');
    message=mtext.value;
    if(message!="")
    {
        clearTimeout(time);
        typing=0;
        messageloaded=1;
        message=message.split("\n").join("<br>");
        var para=document.createElement("div");
        para.classList.add("message");
        para.classList.add("sent");
        para.innerHTML=message;
        aaaa.appendChild(para);
        var scrollaa=document.getElementById("chatbody");
        scrollaa.scrollTop=scrollaa.scrollHeight;
    }
    mtext.value="";
    
}
function fetchchat(){
    var aaaa=document.getElementById("chatbody");
    if(window.XMLHttpRequest)
    {
        var accesschat= new XMLHttpRequest();
    }
    else
    {
        var accesschat= new ActiveXObject("Microsoft.XMLHTTP");
    }
    accesschat.onreadystatechange=function(){
        if(this.readyState == 4 && this.status == 200 && required==1)
        {
            var textback=this.responseText;
            if(endsent==0)
            {
                if(textback=="start")
                {
                    started=1;
                }
                var arr=textback.split(":");
                for(var i=0;i<arr.length;i++)
                {
                    var temptext=arr[i];
                    var temparr=temptext.split("-");
                    if(i==0)
                    {
                        if( temparr[0]=="typing")
                        {   if(temparr[1]==0)
                            {
                                var lowerchat=document.getElementById("lowerchat");
                                lowerchat.innerHTML="";
                            }
                            else
                            {
                                var lowerchat=document.getElementById("lowerchat");
                                lowerchat.innerHTML="<p>typing...</p>";
                            }
                        }
                    }
                    else if(i==1)
                    {
                        if(temparr[1]==1)
                        {
                            var head=document.getElementById("headchat");
                            head.innerHTML="Guest LEFT";
                            clearInterval(call);
                            setTimeout(function(){
                                window.location=url+"index.php";
                            },1000);
                        }
                    }
                    else
                    {
                        var para=document.createElement("div");
                        para.classList.add("message");
                        para.classList.add("recieved");
                        para.innerHTML=temparr[1];
                        var scrolll=document.getElementById("chatbody");
                        var aaaaaa=scrolll.scrollHeight;
                        aaaa.appendChild(para);
                        scrolll.scrollTop=aaaaaa-10;
                    }
                }
            }
            else
            {
                clearInterval(call);
                setTimeout(function(){
                    window.location=url+"index.php";
                },1000);
            }
        }
    };
    var link="fetchchat.php?typing="+typing+"&ended="+ended;
    if(ended==1)
    {
        endsent=1;
    }
    if(messageloaded==1)
    {
        link+="&message="+message+"";
        messageloaded=0;
    }
    
    accesschat.open("GET",link,true);
    accesschat.send();
}