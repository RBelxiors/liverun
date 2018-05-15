<?php
  session_start();
  if(!isset($_SESSION['login'])) {
      header('LOCATION:login.php'); die();
  }
?>

  <?php
    if(array_key_exists('submit',$_POST)){

      $query1 = "select idsubEvent from subevent where name='";
      $query1 .= $_POST['prova_select'];
      $query1 .= "';";

      $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
      $result = mysqli_query($link, $query1) or die("Bad Query: $query1");
      $row = mysqli_fetch_assoc($result);

       $query = "delete from results where subEvent_idsubEvent=";
       $query .= $row['idsubEvent'];
       $query .= " and escalao='";
       $query .= $_POST['escalao_select'];
       $query .= "';";

       $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
       $result = mysqli_query($link, $query) or die("Bad Query: $query");
       echo $result;

  }
 ?>


  <!DOCTYPE html>
  <html>
     <head>
       <meta http-equiv='content-type' content='text/html;charset=utf-8' />
       <title>Inserir Prova</title>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
     </head>
  <body>
    <form method="post" enctype="multipart/form-data">

      <a href="admin.php"> back </a>
      <h2> Resultados </h2>

      <select id="prova_select" name="prova_select" >
       <?php

        $query = "select name from subevent;";

        $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
        $result = mysqli_query($link, $query) or die("Bad Query: $query");

        while($row = mysqli_fetch_assoc($result)){
          echo"<option>{$row['name']}</option>";
        }
        ?>
      </select><br><br>
      <input type="submit" name="submitT" id="submitT" value="Submit"><br><br>

      <?php
      if(array_key_exists('submitT',$_POST)){

        echo "Escalão:";
        echo '<select id="escalao_select" name="escalao_select">';


             $query = "select idsubEvent from subevent where name='";
             $query .= $_POST['prova_select'];
             $query .= "';";

             $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
             $result = mysqli_query($link, $query) or die("Bad Query: $query");
             $row = mysqli_fetch_assoc($result);

              $query1 = "select escalao from results where subEvent_idsubEvent=";
              $query1 .= $row['idsubEvent'];

              $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
              $result = mysqli_query($link, $query1) or die("Bad Query: $query1");

              while($row = mysqli_fetch_assoc($result)){
                echo"<option>{$row['escalao']}</option>";
              }

              echo'</select><br><br>';
        }
       ?>

      <input type="submit" name="submit" id="submit" value="Submit"><br><br>

    </form>
  </body>
  </html>
