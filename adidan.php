<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$conn = new mysqli("localhost", "root", "", "zadachnik");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверка таблицы tasks (оставим как есть)
$checkTable = $conn->query("SHOW TABLES LIKE 'tasks'");
if ($checkTable->num_rows == 0) {
    $createTableSql = "
    CREATE TABLE tasks (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        name VARCHAR(255) NOT NULL,
        date DATE DEFAULT NULL,
        status TINYINT(1) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $conn->query($createTableSql);
}

// Получаем name, upload_date, status из таблицы files
$stmt = $conn->prepare("SELECT name, upload_date, status FROM files WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Руйхати супоришхо</title>
  <link rel="stylesheet" href="/css/style_1.css" />
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
</head>
<body>
<h1 class="texts">Руйхати супоришхо</h1>
<div class="container">
  <div class="row">
    <div class="col-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">№</th>
            <th scope="col">Супоришҳо</th>
            <th scope="col">Дата</th>
            <th scope="col">Статус</th>
            <th scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result && $result->num_rows > 0) { 
              $k = 0;
              while($row = $result->fetch_assoc()) { 
                  $k++;
                  $name = htmlspecialchars($row["name"] ?? "-");
                  $date = htmlspecialchars($row["upload_date"] ?? "-");
                  $statusRaw = $row["status"] ?? "Нопурра";

                  // Если статус числовой, преобразуем его в текст
                  switch (strval($statusRaw)) {
                      case "1": $statusText = "Қабул шуд"; break;
                      case "0": $statusText = "Қабул нашуд"; break;
                      default: $statusText = $statusRaw ?: "Нопурра"; break;
                  }

                  echo "<tr>";
                  echo "<td>$k</td>";
                  echo "<td>$name</td>";
                  echo "<td>$date</td>";
                  echo "<td>$statusText</td>";
                  echo "<td><a href='status.php?id=$id' class='btn btn-primary btn-sm'>Дидан</a></td>";
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

<footer class="bg-dark text-center text-white view mt-5">
  <div class="container p-4">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022: <a class="text-white" href="#">Ҳамаи ҳуқуқҳо ҳифз карда шудаанд</a>
    </div>
  </div>
</footer> 

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
