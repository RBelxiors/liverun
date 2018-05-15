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

  $globals['id']                =  "";
  $globals['name']              =  "";
  $globals['short']             =  "";
  $globals['local']             =  "";
  $globals['inicio']            =  "";
  $globals['info']              =  "";
  $globals['image']             =  "";
  $globals['regulamentoPath']   =  "";
  $globals['isTorneio']         =  "";
  $globals['event_idevent1']    =  "";


  if(array_key_exists('sProva',$_POST)){

    $query = "select * from subevent where idsubEvent = (select idsubEvent from subevent where name='";
    $query .= $_POST['prova_select'];
    $query .= "');";

    $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
    $result = mysqli_query($link, $query) or die("Bad Query: $query");

    $row = mysqli_fetch_assoc($result);
    $globals['id']                = $row['idsubEvent'];
    $globals['name']              = $row['name'];
    $globals['short']             = $row['shotname'];
    $globals['local']             = $row['local'];
    $globals['inicio']            = $row['date'];
    $globals['info']              = $row['info'];
    $globals['image']             = $row['image'];
    $globals['regulamentoPath']   = $row['regulamentoPath'];
    $globals['isTorneio']         = $row['isTorneio'];
    $globals['event_idevent1']    = $row['event_idevent1'];

  }

  if(array_key_exists('submit',$_POST)){

    $link = mysqli_connect("localhost", "root", "atletismo", "mydb");

    if($_POST['torneio_select'] != "0"){
      echo $_POST['torneio_select'];
      $query1 = "select idevent from event where name='";
      $query1 .= $_POST['torneio_select'];
      $query1 .= "';";

      $result = mysqli_query($link, $query1) or die("Bad Query: $query1");
      $row = mysqli_fetch_assoc($result);
      $id_event = $row['idevent'];
      //echo $query1;
      //echo $row['idevent'];
    } else
      $id_event = $_POST['idTorneio'];

    $query = "call updateProva(";
    $query .= $_POST['id'];
    $query .= ",'";
    $query .= $_POST['prova'];
    $query .= "','";
    $query .= $_POST['cProva'];
    $query .= "','";
    $query .= $_POST['local'];
    $query .= "','";
    $query .= $_POST['inicio'];
    $query .= "','";
    $query .= $_POST['info'];
    if(isset($_POST['istorneio']))
      $query .= "',1,";
    else
      $query .= "',0,";
    $query .= $id_event;
    $query .= ");";
    echo $id_event;
    $result = mysqli_query($link, $query) or die("Bad Query: $query");
    echo"$query";
    echo"$result";

  }

  if(array_key_exists('submitfile',$_POST)){
    insertFile();
    $filename=$_FILES['fileToUpload']['name'];
    $query = "call updatefile(";
    $query .= $_POST['id'];
    $query .= ",'";
    $query .= $filename;
    $query .= "');";

    $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
    $result = mysqli_query($link, $query) or die("Bad Query: $query");
    echo $result;
  }

  if(array_key_exists('submitIMG',$_POST)){
    insertImg();
    $imgname=$_FILES['imgToUpload']['name'];
    $query = "call updateIMG(";
    $query .= $_POST['id'];
    $query .= ",'";
    $query .= $imgname;
    $query .= "');";

    $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
    $result = mysqli_query($link, $query) or die("Bad Query: $query");
    echo $result;
  }

 ?>

 <!DOCTYPE html>
 <html>
    <head>
      <meta http-equiv='content-type' content='text/html;charset=utf-8' />
      <title>Editar Prova</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
 <body>
   <form method="post" enctype="multipart/form-data">

     <a href="admin.php"> back </a><br><br>

     <select id="prova_select" name="prova_select" >
      <?php

       $query = "select name from subevent;";

       $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
       $result = mysqli_query($link, $query) or die("Bad Query: $query");

       while($row = mysqli_fetch_assoc($result)){
         echo"<option>{$row['name']}</option>";
       }
       ?>
     </select>

     <input type="submit" name="sProva" id="sProva" value="Submit">

     <h2> Dados da Prova </h2>

     ID TORNEIO: <input type="text" name="idTorneio" value="<?php echo $globals['event_idevent1'] ?>"> <br>
     ID: <input type="text" name="id" value="<?php echo $globals['id'] ?>"> <br>
     Nome da Prova: <input type="text" name="prova" value="<?php echo $globals['name'] ?>"> <br>
     Nome curto Prova: <input type="text" name="cProva" value="<?php echo $globals['short'] ?>"><br>
     Local: <input type="text" name="local" value="<?php echo $globals['local'] ?>"><br>
     Data: <input type="datetime" name="inicio" value="<?php echo $globals['inicio'] ?>"><br>
     Mais Informação: <textarea name="info" cols="40" rows="5"><?php echo $globals['info'] ?></textarea> <br><br>

     Imagem: <input type="file" name="imgToUpload" id="imgToUpload">        <input type="submit" name="submitIMG" id="submitIMG" value="Submit"><br><br> <br><br>
     Regulamento: <input type="file" name="fileToUpload" id="fileToUpload"> <input type="submit" name="submitfile" id="submitfile" value="Submit"><br><br> <br><br>

     É Torneio?
     <?php
        if($globals['isTorneio'])
          echo'<input type="checkbox" name="istorneio" checked><br>';
        else
          echo'<input type="checkbox" name="istorneio"><br>';
      ?>

      Torneio:
      <select id="torneio_select" name="torneio_select" >
       <?php
        echo'<option value="0"> </option>';
        $query2 = "select name from event where idevent<>";
        $query2 .= $globals['event_idevent1'];

        $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
        $result = mysqli_query($link, $query2) or die("Bad Query: $query2");

        while($row = mysqli_fetch_assoc($result)){
          echo"<option>{$row['name']}</option>";
        }
        ?>
      </select><br><br>

     <input type="submit" name="submit" id="submit" value="Submit"><br><br>


   </form>
   <script src="js/main.js"></script>
 </body>
 </html>
