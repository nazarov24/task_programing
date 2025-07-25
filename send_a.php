<?php
// Подключение к БД
$conn = new mysqli('localhost', 'root', '', 'zadachnik');
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверяем, существует ли таблица files, если нет — создаем
$checkTable = $conn->query("SHOW TABLES LIKE 'files'");
if ($checkTable->num_rows == 0) {
    $createTableSql = "
    CREATE TABLE files (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        source VARCHAR(255) NOT NULL,
        comment TEXT,
        user_id INT(11) NOT NULL,
        upload_date DATE DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    if (!$conn->query($createTableSql)) {
        die("Ошибка при создании таблицы: " . $conn->error);
    }
}

$name = $_POST['name_file'] ?? '';
$uid = (int)($_POST['uid'] ?? 0);
$date = $_POST['date_file'] ?? date('Y-m-d');
$comment = $_POST['comment'] ?? '';

if (isset($_FILES['save_file']) && $_FILES['save_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['save_file']['tmp_name'];
    $fileName = basename($_FILES['save_file']['name']);
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $destPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $stmt = $conn->prepare("INSERT INTO files (name, source, comment, user_id, upload_date) VALUES (?, ?, ?, ?, ?)");
        // Типы: s-string, i-integer; всего 5 параметров — строка из 5 символов!
        $stmt->bind_param("sssis", $name, $destPath, $comment, $uid, $date);

        if ($stmt->execute()) {
            echo "Маълумоти шумо бо муваффақият сабт карда шуд<br>";
        } else {
            echo "Хатоги ҳангоми сабт: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "Хатогӣ: Файл бор карда нашуд<br>";
    }
} else {
    echo "Файл интихоб нашуд ё хатогӣ буд<br>";
}

$conn->close();
?>
