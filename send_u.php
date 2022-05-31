<?php
$file = $_GET['file'];
$uid=$_GET["uid"];

$conn = new mysqli('localhost', 'root', '', 'zadachnik');
$sql = "UPDATE tasks SET source_2='$file' WHERE id=$uid";

function back(){
	echo "<br>"."<br>";
	echo "<form action=user.php";
	echo "<input type=submit value=Назад>";
	echo "</form>";
}

if ($conn->query($sql) === TRUE) {
  echo "Маълумот бо муваффақият ирсол карда шуд"."<br>";
  back();
  
} else {
  echo "Error updating record:" . $conn->error."<br>";
  back();
}

$conn->close();
?>