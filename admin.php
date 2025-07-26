<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        .search-bar {
            max-width: 300px;
        }
        .table-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .footer {
            background-color: #000;
            color: #fff;
            padding: 10px 0;
            margin-top: auto; /* прижимаем футер к низу */
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container d-flex justify-content-between align-items-center">
            <h2 class="text-dark fw-bold">Admin Panel</h2>
            <form class="search-bar" onsubmit="return false;" role="search">
                <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Поиск...">
            </form>
        </div>
    </header>

    <main class="container table-container flex-grow-1">
        <table id="myTable" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>№</th>
                    <th>Ф.И.О.</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $conn = new mysqli("localhost", "root", "", "zadachnik");
                    if ($conn->connect_error) { 
                        die("Connection failed: " . $conn->connect_error); 
                    }  
                    $sql = "SELECT `id`, `username` FROM users WHERE `user_status` = 0"; 
                    $result = $conn->query($sql); 
                    if ($result->num_rows > 0) { 
                        $k = 0;
                        while($row = $result->fetch_assoc()) { 
                            $k++;
                            echo "<tr>";
                            echo "<td>" . $k . "</td>";
                            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                            echo "<td>";
                            echo "<a class='btn btn-primary btn-sm me-2' href='adidan.php?id=" . $row['id'] . "'><i class='far fa-eye'></i> Просмотр</a>";
                            echo "<a class='btn btn-success btn-sm' href='send_admin.php?id=" . $row['id'] . "'><i class='fas fa-edit'></i> Назначить</a>";
                            echo "</td>";
                            echo "</tr>"; 
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>Пользователи не найдены.</td></tr>";
                    }
                    $conn->close(); 
                ?>
            </tbody>
        </table>
    </main>

    <footer class="footer text-center">
        <div class="container">
            <p>© 2025 Все права защищены</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) { 
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
                }       
            }
        }
    </script>
</body>
</html>
