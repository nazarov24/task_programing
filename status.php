<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$conn = new mysqli('localhost', 'root', '', 'zadachnik');
if ($conn->connect_error) {
    die('Ошибка подключения: ' . $conn->connect_error);
}

/* ── гарантируем, что в files есть колонка status ─────────────────────────── */
$colCheck = $conn->query("SHOW COLUMNS FROM files LIKE 'status'");
if ($colCheck->num_rows == 0) {
    $conn->query("ALTER TABLE files ADD COLUMN status VARCHAR(50) DEFAULT 'Нопурра'");
}

/* ── выборка данных ───────────────────────────────────────────────────────── */
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
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Руйхати супоришҳо</title>
  <link rel="stylesheet" href="/css/style_1.css">
  <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
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
            <a href="<?= htmlspecialchars($row['source']) ?>" target="_blank">скачать</a>
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
</div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
