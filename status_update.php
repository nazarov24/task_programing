<?php
$conn = new mysqli('localhost','root','','zadachnik');
if ($conn->connect_error) { die('Err: '.$conn->connect_error); }

$fileId     = (int)($_POST['file_id'] ?? 0);
$newStatus  = $_POST['new_status'] ?? 'Нопурра';

$stmt = $conn->prepare("UPDATE files SET status = ? WHERE id = ?");
$stmt->bind_param('si', $newStatus, $fileId);
$stmt->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
