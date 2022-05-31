<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style_1.css">
    <link rel="stylesheet" href="css/style_4.css">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">ADMIN</span>
      </a>
    </header>
  </div>
</div>
<div class=" d col-2">
<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" method="POST">
<input type="text" class="form-control"  id="myInput" onkeyup="myFunction()" placeholder="Ҷустуҷӯ..." >
        </form>
</div>
<div class="container col-8 ">
  <div class="row">
    <div class="col-12">
    <table id="myTable" class="table table-striped" cellspacing="0" width="100%" border="1px">
  <thead>
    <tr>
      <th class="th-sm">№</th>
      <th class="th-sm">Ф.И.О.</th>
    </tr>
  </thead>
  <tbody>
<?php 
    $conn = mysqli_connect("localhost", "root", "", "zadachnik"); 
    // Check connection 
    if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
    }  
    $sql = "SELECT `id`,`username` FROM users WHERE `user_status`=0"; 

    $result = $conn->query($sql); 
    if ($result->num_rows > 0) { 
$k=0;
    while($row = $result->fetch_assoc()) { 
      $k++;
      echo "<tr><td>" . $k
        . "</td><td>" . $row["username"]
        . "</td><td>" ."<button type=button class=btn btn-primary><i class=far fa-eye><a class=a href=adidan.php?id=".$row['id']." >Дидан</a></i></button>"
        . "</td><td>" ."<button type=button class=btn btn-succes><i class=fas fa-edit><a class=a href=send_admin.php?id=".$row['id'].">Супоридан</a></i></button>"
        . "</td></tr>"; 
    } 
    echo "</tbody>";
  }
    $conn->close(); 
  ?>
</table>
<footer class="bg-dark text-center text-white view">
  <div class="container p-4">
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2022:
    <a class="text-white" href="#">Ҳамаи ҳуқуқҳо ҳифз карда шудаанд</a>
  </div>
</footer>
<script>
function myFunction() {
  
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

 
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</body>
</html>



