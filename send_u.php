<?php
$file = isset($_GET['file']) ? $_GET['file'] : '';
$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;

$conn = new mysqli('localhost', 'root', '', 'zadachnik');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function back(){
    echo "<br><br>";
    echo "<form action='user.php'>";
    echo "<input type='submit' value='Назад'>";
    echo "</form>";
}

// Подготовленный запрос для безопасности
$stmt = $conn->prepare("UPDATE tasks SET source_2 = ? WHERE id = ?");
$stmt->bind_param("si", $file, $uid);

if ($stmt->execute()) {
    echo "Маълумот бо муваффақият ирсол карда шуд<br>";
    back();
} else {
    echo "Error updating record: " . $stmt->error . "<br>";
    back();
}

$stmt->close();
$conn->close();
?>
