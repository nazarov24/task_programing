<?php
$name_f = $_POST['name_file'];
$file = $_POST['save_file'];
$date = $_POST['date_file'];
$comment = $_POST['comment'];
$uid = $_POST['uid'];
$status = 3;
// $today = date("d.m.y");
$file2 = 0;

function back(){
	echo "<br>"."<br>";
	echo "<form action=admin.php>";
	echo "<input type=submit value=Назад>";
	echo "</form>";
}
$conn = new mysqli('localhost', 'root', '', 'zadachnik');

$user = $conn->query("SELECT `id` FROM `users` WHERE `username` = '$uid'");
$user1 = $user->fetch_assoc();
print_r($user1);
if(!empty($user1)){
	echo "Ин супориш аллакай супорида шудааст!";
	back();
	exit();
}
else{
	echo "Маълумоти шумо бо муваффақият сабт карда шуд";
	back();
}
$conn->query("INSERT INTO `tasks` (`name`,`source`,`source_2`,`user_id`,`date`,`status`,`comment`)
VALUES ('$name_f','$file','$file2','$uid','$date','$status','$comment')");

$conn->close();
?>