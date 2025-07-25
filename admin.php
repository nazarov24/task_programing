<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="stylesheet" href="css/style_1.css">
    <link rel="stylesheet" href="css/style_4.css">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- Подключение иконок FontAwesome для кнопок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">ADMIN</span>
      </a>
    </header>
</div>

<div class="d col-2">
    <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Ҷустуҷӯ...">
</div>

<div class="container col-8">
  <div class="row">
    <div class="col-12">
      <table id="myTable" class="table table-striped" cellspacing="0" width="100%" border="1px">
        <thead>
          <tr>
            <th class="th-sm">№</th>
            <th class="th-sm">Ф.И.О.</th>
            <th class="th-sm">Действия</th>
          </tr>
        </thead>
        <tbody>
        <?php 
            $conn = new mysqli("localhost", "root", "", "zadachnik");
            if ($conn->connect_error) { 
                die("Connection failed: " . $conn->connect_error); 
            }  
            $sql = "SELECT `id`,`username` FROM users WHERE `user_status` = 0"; 
            $result = $conn->query($sql); 
            if ($result->num_rows > 0) { 
                $k = 0;
                while($row = $result->fetch_assoc()) { 
                    $k++;
                    echo "<tr>";
                    echo "<td>" . $k . "</td>";
                    echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                    echo "<td>";
                    echo "<a class='btn btn-primary me-2' href='adidan.php?id=".$row['id']."'><i class='far fa-eye'></i> Дидан</a>";
                    echo "<a class='btn btn-success' href='send_admin.php?id=".$row['id']."'><i class='fas fa-edit'></i> Супоридан</a>";
                    echo "</td>";
                    echo "</tr>"; 
                }
            } else {
                echo "<tr><td colspan='3'>Пользователи не найдены.</td></tr>";
            }
            $conn->close(); 
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<footer class="bg-dark text-center text-white view mt-5">
  <div class="container p-4">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022:
      <a class="text-white" href="#">Ҳамаи ҳуқуқҳо ҳифз карда шудаанд</a>
    </div>
  </div>
</footer>

<script>
function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
  
    for (i = 1; i < tr.length; i++) { // начинаем с 1, чтобы пропустить заголовок
        td = tr[i].getElementsByTagName("td")[1]; // поиск по второму столбцу (Ф.И.О.)
        if (td) {
            txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }       
    }
}
</script>

</body>
</html>
