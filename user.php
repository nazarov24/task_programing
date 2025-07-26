<?php
session_start();

// Проверяем авторизацию
$uid = isset($_SESSION['uid']) ? (int)$_SESSION['uid'] : 0;
if ($uid === 0) {
    die("Пользователь не авторизован.");
}

// Подключение к базе
$conn = new mysqli("localhost", "root", "", "zadachnik");
if ($conn->connect_error) {
    die("Ошибка подключения к базе: " . $conn->connect_error);
}

// --- Создаем таблицы, если их нет ---
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
        $conn->query($sql);
    }
}

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
        $conn->query($sql);
    }
}

function createFilesTable($conn) {
    $check = $conn->query("SHOW TABLES LIKE 'files'");
    if ($check->num_rows == 0) {
        $sql = "
        CREATE TABLE files (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            source VARCHAR(255) NOT NULL,
            comment TEXT,
            user_id INT(11) NOT NULL,
            upload_date DATE DEFAULT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        $conn->query($sql);
    }
}

createUsersTable($conn);
createTasksTable($conn);
createFilesTable($conn);

// Получаем задачи пользователя
$sql_tasks = "SELECT id, name, date, comment FROM tasks WHERE user_id = ?";
$stmt_tasks = $conn->prepare($sql_tasks);
$stmt_tasks->bind_param("i", $uid);
$stmt_tasks->execute();
$result_tasks = $stmt_tasks->get_result();

// Получаем файлы пользователя
$sql_files = "SELECT id, name, source, comment, upload_date FROM files WHERE user_id = ?";
$stmt_files = $conn->prepare($sql_files);
$stmt_files->bind_param("i", $uid);
$stmt_files->execute();
$result_files = $stmt_files->get_result();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
            background-color: #000;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="main-content">
    <div class="container mt-4">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h2>Личный кабинет</h2>
            <a href="logout.php" class="btn btn-danger btn-sm">Выйти</a>
        </header>

        <h4>Ваши задачи</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Мухлат</th>
                    <th>Эзоҳ</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_tasks && $result_tasks->num_rows > 0) {
                    $k = 0;
                    while ($row = $result_tasks->fetch_assoc()) {
                        $k++;
                        echo "<tr>";
                        echo "<td>$k</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                        echo "<td><a href='send_user.php?id=" . (int)$row['id'] . "' class='btn btn-success btn-sm'>Супоридан</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Нет задач</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h4 class="mt-4">Ваши файлы</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Комментарий</th>
                    <th>Дата загрузки</th>
                    <th>Файл</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_files && $result_files->num_rows > 0) {
                    $i = 0;
                    while ($file = $result_files->fetch_assoc()) {
                        $i++;
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>" . htmlspecialchars($file['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($file['comment']) . "</td>";
                        echo "<td>" . htmlspecialchars($file['upload_date']) . "</td>";
                        echo "<td><a href='" . htmlspecialchars($file['source']) . "' download class='btn btn-primary btn-sm'>Скачать</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Файлы не найдены</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <p>© 2025 Все права защищены | <a href="admin.php" style="color: #fff;">Админ-панель</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
