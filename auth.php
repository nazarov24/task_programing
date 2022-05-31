<?php
    if(!isset($_POST['login'])){
        header("Location: login.html");
    }

session_start();

$login = $_POST['login'];
$pass = $_POST['pass'];

//Пайвастшавӣ бо БМ
$link=mysqli_connect("localhost", "root", "", "zadachnik");
$user = mysqli_query($link, "SELECT `id`,`user_status` FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
$id_user = mysqli_fetch_array($user);

if (!empty($id_user['id']) AND ($id_user['user_status']==1)) 
        {
            $_SESSION["login"] = $_POST['login'];
            $_SESSION["uid"] = $id_user['id'];
            header("Location: admin.php");
            exit();  
        }
elseif( !empty($id_user['id']) AND ($id_user['user_status']==0))
    {
        $_SESSION["login"] = $_POST['login'];
        $_SESSION["uid"] = $id_user['id'];
        header("Location: user.php");
        exit();  
    }
else echo "Шумо ҳуқуқӣ ворид шудан надоред! Барои ворид шудан "."<a href=reg.html>"."дар ин ҷо"."</a>"." аз қайд гузаред"
?>
<html><body>
 <form>
<p align="left"><input type="submit" name="back" value ="Назад"></a></p>
</form>
 </body></html>
    