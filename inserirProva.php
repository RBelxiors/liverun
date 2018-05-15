<?php

  function insertFile(){
    $target_dir = "reg/";
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

  function insertImg(){
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["imgToUpload"]["name"]);
    $uploadOk = 1;

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["imgToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["imgToUpload"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
  }


  session_start();
  if(!isset($_SESSION['login'])) {
      header('LOCATION:login.php'); die();
  }



  if(array_key_exists('submit',$_POST)){

    insertFile();
    insertImg();

    $query = "select idevent from event where name='";
    $query .= $_POST['torneio_select'];
    $query .= "';";

    $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
    $result = mysqli_query($link, $query) or die("Bad Query: $query");
    $row = mysqli_fetch_assoc($result);

    $imgname=$_FILES['imgToUpload']['name'];
    $filename=$_FILES['fileToUpload']['name'];

    $query = "call inserirProva('";
    $query .= $_POST['prova'];
    $query .= "','";
    $query .= $_POST['cProva'];
    $query .= "','";
    $query .= $_POST['inicio'];
    $query .= "','0','";
    $query .= $_POST['info'];
    $query .= "','";
    $query .= $imgname;
    $query .= "','";
    $query .= $_POST['local'];
    $query .= "',";
    $query .= $row['idevent'];
    if(isset($_POST['istorneio']))
      $query .= ",1,'";
    else
      $query .= ",0,'";
    $query .= $filename;
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
      <title>Inserir Prova</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
 <body>
   <form method="post" enctype="multipart/form-data">

     <h2> Qual o torneio? </h2>
    <select name="torneio_select">
     <?php

      $query = "select name from event;";

      $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
      $result = mysqli_query($link, $query) or die("Bad Query: $query");

      while($row = mysqli_fetch_assoc($result)){
        echo"<option>{$row['name']}</option>";
      }
      ?>
    </select>
     <h2> Dados da Prova </h2>

     Nome da Prova: <input type="text" name="prova"> <br>
     Nome curto Prova: <input type="text" name="cProva"><br>
     Local: <input type="text" name="local"><br>
     Data: <input type="datetime-local" name="inicio"><br>
     Mais Informação: <textarea name="info" cols="40" rows="5"></textarea> <br><br>
     É Torneio? <input type="checkbox" name="istorneio" value="0"><br>
     Imagem: <input type="file" name="imgToUpload" id="imgToUpload"><br><br>
     Regulamento: <input type="file" name="fileToUpload" id="fileToUpload"> <br><br>

     <input type="submit" name="submit" id="submit" value="Submit"><br><br>
     <a href="admin.php"> back </a>

   </form>
 </body>
 </html>
