<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Супоридан</title>
    <link rel="stylesheet" href="/css/style_3.css">
    <link rel="stylesheet" href="/css/style_1.css">
</head>
<body>
<div class="container">
        <div class="forms">
            <div class="form login">

                <form action="send_a.php" method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Номи файл" name="name_file">
                        <input type="text" name="uid" value='<?php echo $_GET["id"]; ?>' hidden>
                        <i class="uil uil-envelope"></i>
                    </div>
                    <div class="input-field">
                        <input type="file" name="save_file">
                        <i class="uil uil-envelope"></i>
                    </div>
                    <div class="input-field">
                        <input type="date" name="date_file">
                        <i class="uil uil-envelope"></i>
                    </div>
                    <textarea class="textarea" id="comment_form_content_anonym" placeholder="Введите текст комментария." name="comment"></textarea>
                    <div class="input-field button">
                        <input type="submit" value="Фиристодан">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script href="/js/js.js"></script>
</body>
</html>