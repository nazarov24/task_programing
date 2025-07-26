<?php
session_start();

// Если нет авторизации – отправляем на login.html
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$conn = new mysqli('localhost', 'root', '', 'zadachnik');
if ($conn->connect_error) {
    die('Ошибка подключения: ' . $conn->connect_error);
}

// Проверка колонки status
$colCheck = $conn->query("SHOW COLUMNS FROM files LIKE 'status'");
if ($colCheck->num_rows == 0) {
    $conn->query("ALTER TABLE files ADD COLUMN status VARCHAR(50) DEFAULT 'Нопурра'");
}

// Выборка данных
$stmt = $conn->prepare(
    "SELECT id, name, source, upload_date, status
     FROM files
     WHERE user_id = ?"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="tg">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Рӯйхати супоришҳо</title>
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
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

<!-- Header с навигацией -->
<header class="bg-light border-bottom mb-4">
  <div class="container d-flex justify-content-between align-items-center py-3">
    <a href="index.php" class="text-dark text-decoration-none fw-bold fs-4">Suporish</a>
    <nav>
      <a href="index.html" class="btn btn-outline-primary btn-sm me-2">Асосӣ</a>
      <a href="logout.php" class="btn btn-danger btn-sm">Баромадан</a>
    </nav>
  </div>
</header>

<!-- Основной контент -->
<main class="container">
  <h2 class="mb-4">Супоришҳои корбар #<?= $id ?></h2>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Ном</th>
        <th>Файл</th>
        <th>Дата</th>
        <th>Статус</th>
        <th class="text-center">Действие</th>
      </tr>
    </thead>
    <tbody>
<?php if ($result->num_rows):
        $n = 0;
        while ($row = $result->fetch_assoc()):
            $n++;
            $badge = match($row['status']) {
                'Қабул шуд'   => 'success',
                'Қабул нашуд' => 'danger',
                default       => 'secondary'
            };
?>
      <tr>
        <td><?= $n ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td>
          <?php if (is_file($row['source'])): ?>
            <a href="<?= htmlspecialchars($row['source']) ?>" target="_blank">Скачать</a>
          <?php else: ?>
            —
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row['upload_date'] ?: '-') ?></td>
        <td><span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($row['status']) ?></span></td>

        <!-- Форма смены статуса -->
        <td class="text-center">
          <form action="status_update.php" method="post" class="d-flex gap-1">
            <input type="hidden" name="file_id" value="<?= $row['id'] ?>">
            <select name="new_status" class="form-select form-select-sm">
              <option <?= $row['status']=='Қабул шуд'   ? 'selected' : ''?> value="Қабул шуд">Қабул шуд</option>
              <option <?= $row['status']=='Қабул нашуд' ? 'selected' : ''?> value="Қабул нашуд">Қабул нашуд</option>
              <option <?= $row['status']=='Нопурра'     ? 'selected' : ''?> value="Нопурра">Нопурра</option>
            </select>
            <button class="btn btn-sm btn-outline-primary">OK</button>
          </form>
        </td>
      </tr>
<?php   endwhile;
      else: ?>
      <tr><td colspan="6" class="text-center">Барои ин корбар супориш нест.</td></tr>
<?php endif; ?>
    </tbody>
  </table>
</main>

<!-- Footer -->
<footer>
  <div class="container">
    © 2022: <a href="#">Ҳамаи ҳуқуқҳо ҳифз карда шудаанд</a>
  </div>
</footer>

<script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
