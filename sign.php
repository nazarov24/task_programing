<?php 
$fio = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING); 
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
$status = 0;
function back(){
	echo "<br>"."<br>";
	echo "<form action=reg.html>";
	echo "<input type=submit value=Назад>";
	echo "</form>";
}
if(mb_strlen($login) < 5 || mb_strlen($login) > 16){
	echo "Недопустимая длина логина";
	back();
	exit();
}
else if(mb_strlen($pass) < 5){
	echo "Недопустимая длина имени.";
	back();
	exit();
} 
$mysql = new mysqli('localhost', 'root', '', 'zadachnik');

$result1 = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login'");
$user1 = $result1->fetch_assoc();
if(!empty($user1)){
	echo "Данный логин уже используется!";
	back();
	exit();
}
else{
	echo "Маълумоти шумо бо муваффақият сабт карда шуд";
	back();
}
$mysql->query("INSERT INTO `users` (`username`,`login`,`user_status`,`email`,`pass`)
	VALUES('$fio','$login','$status','$email','$pass')");
$mysql->close();
?>