<?php
session_start();

// Для теста, если uid не установлен, можно временно задать:
// $_SESSION['uid'] = 1;

$uid = isset($_SESSION['uid']) ? (int)$_SESSION['uid'] : 0;
if ($uid === 0) {
    die("Пользователь не авторизован.");
}

$conn = new mysqli("localhost", "root", "", "zadachnik");
if ($conn->connect_error) {
    die("Ошибка подключения к базе: " . $conn->connect_error);
}

// Функция для создания таблицы users, если нет
function createUsersTable($conn) {
    $check = $conn->query("SHOW TABLES LIKE 'users'");
    if ($check->num_rows == 0) {
        $sql = "
        CREATE TABLE users (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            login VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL,
            pass VARCHAR(255) NOT NULL,
            user_status TINYINT(1) DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        if (!$conn->query($sql)) {
            die("Ошибка создания таблицы users: " . $conn->error);
        }
    }
}

// Функция для создания таблицы tasks, если нет
function createTasksTable($conn) {
    $check = $conn->query("SHOW TABLES LIKE 'tasks'");
    if ($check->num_rows == 0) {
        $sql = "
        CREATE TABLE tasks (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) NOT NULL,
            name VARCHAR(255) NOT NULL,
            date DATE DEFAULT NULL,
            comment TEXT DEFAULT NULL,
            status TINYINT(1) DEFAULT 0,
            source_2 VARCHAR(255) DEFAULT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        if (!$conn->query($sql)) {
            die("Ошибка создания таблицы tasks: " . $conn->error);
        }
    }
}

createUsersTable($conn);
createTasksTable($conn);

// Теперь выводим задачи пользователя
$sql = "SELECT id, name, date, comment FROM tasks WHERE user_id = $uid";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>USER</title>
    <link rel="stylesheet" href="/css/style_1.css" />
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">Suporish</span>
      </a>
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="#" class="nav-link" aria-current="page">Асосӣ</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Алоқа</a></li>
      </ul>
    </header>
</div>

<h1 class="texts">Руйхати супоришхо</h1>
<div class="container">
  <div class="row">
    <div class="col-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Супоришҳо</th>
            <th scope="col">Мухлат</th>
            <th scope="col">Эзоҳ</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result && $result->num_rows > 0) {
              $k = 0;
              while ($row = $result->fetch_assoc()) {
                  $k++;
                  echo "<tr>";
                  echo "<td>" . $k . "</td>";
                  echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                  echo "<td>"
                     . "<a href='#' download>Боргирӣ</a> "
                     . "<a href='send_user.php?id=" . (int)$row['id'] . "'>Супоридан</a>"
                     . "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Барои ин корбар супориш нест.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<footer class="bg-light text-center text-lg-start job mt-5">
  <div class="container p-4">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022:
      <a class="text-dark" href="admin.php">Ҳамаи ҳуқуқҳо ҳифз карда шудаанд</a>
    </div>
  </div>
</footer>
</body>
</html>

<?php
$conn->close();
?>
