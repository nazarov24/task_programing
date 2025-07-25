<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Супоридан</title>
    <link rel="stylesheet" href="/css/style_3.css" />
    <link rel="stylesheet" href="/css/style_1.css" />
</head>
<body>
<div class="container">
    <div class="forms">
        <div class="form login">
            <form action="send_a.php" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <input type="text" placeholder="Номи файл" name="name_file" required>
                </div>
                <input type="hidden" name="uid" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
                <div class="input-field">
                    <input type="file" name="save_file" required>
                </div>
                <div class="input-field">
                    <input type="date" name="date_file" required>
                </div>
                <textarea class="textarea" id="comment_form_content_anonym" placeholder="Введите текст комментария." name="comment"></textarea>
                <div class="input-field button">
                    <input type="submit" value="Фиристодан">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/js.js"></script>
</body>
</html>
