<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>See</title>
    <link rel="stylesheet" href="/css/style_1.css">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
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
            <th scope="col">Cтатус</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
      <?php 
          $id = $_GET['id'];
          $conn = mysqli_connect("localhost", "root", "", "zadachnik"); 
          if ($conn->connect_error) { 
          die("Connection failed: " . $conn->connect_error); 
          }  
          $s = "SELECT `name`, `date` FROM tasks WHERE `user_id` = '$id' ";
          $result = $conn->query($s); 
          if ($result->num_rows > 0) { 
          $k=0;
          while($row = $result->fetch_assoc()) { 
            $k++;
            $CRLF = chr(0x0d).chr(0x0a);
            echo "<tr><td>" . $k
              . "</td><td>" . $row["name"]
              ."</td><td>" ."<a href=status.php?>Дидан</a>"
              . "</td><td>" ."<a href=#>Иваз</a>"
              . "</td><td>" ."<select name=status>
              .<option  selected disabled>Интихоби статус</option>
              .<option value=qabul>Қабул шуд</option>
              .<option value=notqabul>Қабул нашуд</option>
              .<option value=nopura>Нопурра</option>
             </select>"
              . "</td></tr>";
          } 
          function tasdiq(){

            $r = "UPDATE tasks SET status = 1 ";
          }
          function notQabul(){
            $result = "UPDATE tasks SET status = 0";  
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
</footer> 
</body>
</html>