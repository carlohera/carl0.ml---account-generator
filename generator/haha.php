<?PHP

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
include 'inc/database.php';
include 'inc/captcha.php';
include 'db.php';

$user_ip = getUserIP();
$date = date("Y-m-d H:i:s");
mysqli_query($con, "INSERT INTO `iplogs` (`ip`, `date`) VALUES ('$user_ip', NOW())") or die(mysqli_error($con));


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="author" content="SinisterExploits">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>You got caught!</title>
<style>#cf-content{display:none!important}body{background:#101010;font-size:14px;color:#FFF;text-align:center;padding-top:2%;margin:auto;font-family:Helvetica,Arial,sans-serif;overflow:hidden}.dickbutt{margin-top:10%}i{font-style:normal;color:#14c9c9}h1,h2{font-weight:400}h1{margin:auto;max-width:417px;border-bottom:1px dashed #fff;font-size:64px}h2{font-size:24px}</style>
<script type="text/javascript">
  //<![CDATA[
  (function(){
    var a = function() {try{return !!window.addEventListener} catch(e) {return !1} },
    b = function(b, c) {a() ? document.addEventListener("DOMContentLoaded", b, c) : document.attachEvent("onreadystatechange", b)};
    b(function(){
      var a = document.getElementById('cf-content');a.style.display = 'block';
      setTimeout(function(){
        var s,t,o,p,b,r,e,a,k,i,n,g,f, rHJZCzM={"TKVSi":+((+!![]+[])+(!+[]+!![]))};
        t = document.createElement('div');
        t.innerHTML="<a href='/'>x</a>";
        t = t.firstChild.href;r = t.match(/https?:\/\//)[0];
        t = t.substr(r.length); t = t.substr(0,t.length-1);
        a = document.getElementById('jschl-answer');
        f = document.getElementById('challenge-form');
        ;rHJZCzM.TKVSi+=+((!+[]+!![]+!![]+[])+(!+[]+!![]+!![]));rHJZCzM.TKVSi+=!+[]+!![]+!![]+!![]+!![]+!![]+!![];rHJZCzM.TKVSi-=+((!+[]+!![]+!![]+!![]+[])+(!+[]+!![]+!![]+!![]+!![]+!![]));a.value = parseInt(rHJZCzM.TKVSi, 10) + t.length; '; 121'
        f.submit();
      }, 4000);
    }, false);
  })();
  //]]>
</script>

</head>
<body>
<div class="ModHeader Patch">
<h1><i class="fa fa-angle-down"></i> Your IP <i class="fa fa-angle-down"></i> <?php echo $user_ip; ?></h1>
<h2>Nice try!</h2>
<h3>Why would you do that?..</h3>
  <form id="challenge-form" action="logout.php" method="get">
    <input type="hidden" name="jschl_vc" value=""/>
    <input type="hidden" name="pass" value=""/>
    <input type="hidden" id="jschl-answer" name=""/>
  </form>
</div>
<p>Your IP address has been saved in our database.</p>
</div>
</body>
</html>

