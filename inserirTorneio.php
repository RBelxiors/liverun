<?php
  session_start();
  if(!isset($_SESSION['login'])) {
      header('LOCATION:login.php'); die();
  }

  if(array_key_exists('submit',$_POST)){
    $query = "call inserirTorneio('";
    $query .= $_POST['torneio'];
    $query .= "','";
    $query .= $_POST['cTorneio'];
    $query .= "','";
    $query .= $_POST['local'];
    $query .= "','";
    $query .= $_POST['inicio'];
    $query .= "','";
    $query .= $_POST['fim'];
    $query .= "');";

    $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
    $result = mysqli_query($link, $query) or die("Bad Query: $query");

    echo"$result";
  }

 ?>

 <!DOCTYPE html>
 <html>
    <head>
      <meta http-equiv='content-type' content='text/html;charset=utf-8' />
      <title>Login</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
 <body>
   <form method="post">

     <h2> Dados do Torneio </h2>
     Nome do Torneio: <input type="text" name="torneio"> <br>
     Nome curto Torneio: <input type="text" name="cTorneio"><br>
     Local: <input type="text" name="local"><br>
     Data de Inicio: <input type="date" name="inicio"><br>
     Data de Fim: <input type="date" name="fim"><br>
     <input type="submit" name="submit" id="submit" value="Submit">
     <a href="admin.php"> back </a>

   </form>
 </body>
 </html>
