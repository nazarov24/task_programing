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
  <title>Рӯйхати супоришҳо</title>
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
  <style>
    html, body {
      height: 100%;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    main {
      flex: 1;
    }
    footer {
      background-color: #212529;
      color: #fff;
      text-align: center;
      padding: 15px 0;
    }
    footer a {
      color: #fff;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<header class="bg-light border-bottom mb-4">
  <div class="container py-3">
    <h2 class="text-center">Suporish</h2>
  </div>
</header>

<main class="container">
  <h1 class="mb-4">Рӯйхати супоришҳо</h1>
  <div class="row">
    <div class="col-12">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
              echo "<tr><td colspan='5' class='text-center'>Барои ин корбар супориш нест.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<footer>
  <div class="container">
    © 2022: <a href="#">Ҳамаи ҳуқуқҳо ҳифз карда шудаанд</a>
  </div>
</footer>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
