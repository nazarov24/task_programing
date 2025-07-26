<?php 
$fio = filter_var(trim($_POST['username']), FILTER_SANITIZE_SPECIAL_CHARS); 
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$pass = trim($_POST['pass']);

$status = 0;

function back() {
    echo "<br><br>";
    echo "<form action='reg.html'>";
    echo "<input type='submit' value='Назад'>";
    echo "</form>";
}

// Валидация
if (mb_strlen($login) < 5 || mb_strlen($login) > 16) {
    echo "Недопустимая длина логина";
    back();
    exit();
}
if (mb_strlen($pass) < 5) {
    echo "Недопустимая длина пароля.";
    back();
    exit();
}

// Хэшируем пароль
$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

// Подключение к базе
$mysql = new mysqli('localhost', 'root', '', 'zadachnik');
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}

// Проверка уникальности логина
$stmt = $mysql->prepare("SELECT id FROM users WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Данный логин уже используется!";
    back();
    $stmt->close();
    $mysql->close();
    exit();
}
$stmt->close();

// Запись в базу с хэшем
$stmt = $mysql->prepare("INSERT INTO users (username, login, user_status, email, pass) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $fio, $login, $status, $email, $hashed_pass);
$stmt->execute();
$stmt->close();
$mysql->close();

// ✅ Перенаправление на login.html
header('Location: login.html');
exit();
?>
