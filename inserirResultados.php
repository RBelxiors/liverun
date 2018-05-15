<?php
  session_start();
  if(!isset($_SESSION['login'])) {
      header('LOCATION:login.php'); die();
  }

  function insertFile(){
    $target_dir = "results/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
  }

  if(array_key_exists('submit',$_POST)){

    insertFile();
    $filename=$_FILES['fileToUpload']['name'];

    $query = "select idsubEvent from subevent where name='";
    $query .= $_POST['prova_select'];
    $query .= "';";

    $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
    $result = mysqli_query($link, $query) or die("Bad Query: $query");
    $row = mysqli_fetch_assoc($result);

    $query1 = "call setResults(";
    $query1 .= $row['idsubEvent'];
    $query1 .= ");";

    $result = mysqli_query($link, $query1) or die("Bad Query: $query1");

    $query2 = "call inserirResultados(";
    $query2 .= $row['idsubEvent'];
    $query2 .= ",'";
    $query2 .= $_POST['escalao'];
    $query2 .= "','";
    $query2 .= $filename;
    $query2 .= "');";

    $result = mysqli_query($link, $query2) or die("Bad Query: $query2");
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

      Escalão: <input type="text" name="escalao"><br>
      Resultados: <input type="file" name="fileToUpload" id="fileToUpload"> <br><br>

      <input type="submit" name="submit" id="submit" value="Submit"><br><br>
      <a href="admin.php"> back </a>

    </form>
  </body>
  </html>
