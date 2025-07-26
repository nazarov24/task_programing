<?php
session_start();

if (!isset($_POST['login']) || !isset($_POST['pass'])) {
    header("Location: login.html");
    exit;
}

$login = trim($_POST['login']);
$pass = trim($_POST['pass']);

// Подключение к базе
$conn = new mysqli("localhost", "root", "", "zadachnik");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Используем подготовленный запрос
$stmt = $conn->prepare("SELECT id, pass, user_status FROM users WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Проверка пароля (если используешь password_hash)
    if (password_verify($pass, $row['pass'])) {
        // Сохраняем в сессию
        $_SESSION["user_id"] = $row['id'];
        $_SESSION["login"] = $login;
        $_SESSION["role"] = $row['user_status']; // 0 - юзер, 1 - админ

        if ($row['user_status'] == 1) {
            header("Location: admin.php");
        } else {
            header("Location: user.php");
        }
        exit;
    } else {
        echo "Неверный пароль!";
    }
} else {
    echo "Пользователь не найден!";
}

$stmt->close();
$conn->close();
?>
