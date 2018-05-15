<?php
  session_start();
  if(!isset($_SESSION['login'])) {
      header('LOCATION:login.php'); die();
  }
  $globals['id'] = "";
  $globals['name'] = "";
  $globals['short'] = "";
  $globals['local'] = "";
  $globals['inicio'] = "";
  $globals['fim'] = "";

  if(array_key_exists('sTorneio',$_POST)){

    $query = "select * from event where idevent = (select idevent from event where name='";
    $query .= $_POST['torneio_select'];
    $query .= "');";

    $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
    $result = mysqli_query($link, $query) or die("Bad Query: $query");

    $row = mysqli_fetch_assoc($result);
    $globals['id']     = $row['idevent'];
    $globals['name']   = $row['Name'];
    $globals['short']  = $row['shortName'];
    $globals['local']  = $row['local'];
    $globals['inicio'] = $row['date_inicio'];
    $globals['fim']    = $row['date_fim'];

  }

  if(array_key_exists('submit',$_POST)){

    $query = "call updateTorneio(";
    $query .= $_POST['id'];
    $query .= ",'";
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
    echo"$query";
    echo"$result";

  }

 ?>

 <!DOCTYPE html>
 <html>
    <head>
      <meta http-equiv='content-type' content='text/html;charset=utf-8' />
      <title>Editar Torneio</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
 <body>
   <form method="post">

     <select id="torneio_select" name="torneio_select" onchange="saveTheme(this.value)" >
      <?php

       $query = "select name from event;";

       $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
       $result = mysqli_query($link, $query) or die("Bad Query: $query");

       while($row = mysqli_fetch_assoc($result)){
         echo"<option>{$row['name']}</option>";
       }
       ?>
     </select>

     <input type="submit" name="sTorneio" id="sTorneio" value="Submit">

     <h2> Dados do Torneio </h2>
     ID: <input type="text" name="id" value="<?php echo $globals['id'] ?>"> <br>
     Nome do Torneio: <input type="text" name="torneio" value="<?php echo $globals['name'] ?>"> <br>
     Nome curto Torneio: <input type="text" name="cTorneio" value="<?php echo $globals['short'] ?>"><br>
     Local: <input type="text" name="local" value="<?php echo $globals['local'] ?>"><br>
     Data de Inicio: <input type="date" name="inicio" value="<?php echo $globals['inicio'] ?>"><br>
     Data de Fim: <input type="date" name="fim" value="<?php echo $globals['fim'] ?>"><br>
     <input type="submit" name="submit" id="submit" value="Submit"><br>
     <a href="admin.php"> back </a>

   </form>
   <script src="js/main.js"></script>
 </body>
 </html>
