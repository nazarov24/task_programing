<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER</title>
    <link rel="stylesheet" href="/css/style_1.css">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">Suporish</span>
      </a>
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="#" class="nav-link" aria-current="page">Асосӣ</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Алоқа</a></li>
      </ul>
    </header>
  </div> 
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
    session_start();
    $uid = $_SESSION['uid'];
    $conn = mysqli_connect("localhost", "root", "", "zadachnik"); 
    if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
    }  
    // $sql = "SELECT `id` FROM users ";
    // $zapros = $conn->query($sql);
    // if($zapros->num_rows > 0){
    //   while($boom = $zapros->fetch_assoc());
    // }
    $s = "SELECT `id` , `name`, `date`, `comment` FROM tasks WHERE `user_id` = '$uid' ";
    $result = $conn->query($s);
    if ($result->num_rows > 0) { 
    $k=0;
    while($row = $result->fetch_assoc()) { 
      $k++;
      echo "<tr><td>" . $k
        . "</td><td>" . $row["name"]
        . "</td><td>" . $row["date"]
        . "</td><td>" . $row["comment"]
        . "</td><td>" ."<a href=# download>Боргирӣ</a>"
        . "</td><td>" ."<a href=send_user.php?id=".$row['id'].">Супоридан</a> "
        . "</td></tr>"; 
    } 
    echo "</tbody>";
  }
    $conn->close(); 
  ?>
</table>
    <footer class="bg-light text-center text-lg-start job">
  <div class="container p-4">
    <div class="row">
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2022:
    <a class="text-dark" href="admin.php">Хамаи хуқуқҳо ҳифз карда шудаанд</a>
  </div>
</footer>
</body>
</html>