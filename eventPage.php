<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>liveRun</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/mainEvent.css">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">liveRun</h1>
                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                      </li>
                    </ul>
                </nav>
            </header>
        </div>


        <section class="sImage">
          <?php
              if(isset($_GET["data"]) )
              {
                $data = $_GET["data"];

                $query = "select image from subevent where idsubEvent=";
                $query .= $data;

                $link = mysqli_connect("localhost", "root", "atletismo", "mydb");

                $result = mysqli_query($link, $query) or die("Bad Query: $query");
                $row = mysqli_fetch_assoc($result);
                if($row['image'] != "")
                  echo "<img src='img/".$row['image']."' alt='corrida' width='350' height='500'/>";
              }
          ?>

        </section>



        <section class="mInfo">

              <?php
                  if(isset($_GET["data"]) )
                  {
                      $data = $_GET["data"];

                      $query = "select A.* from (select  subevent.isTorneio, subevent.regulamentoPath, subevent.idsubEvent, event.name as torneio, subevent.name as prova, subevent.hasResults, subevent.local, subevent.date, subevent.info from subevent inner join event on event.idevent=subevent.event_idevent1) A where idsubEvent=";
                      $query .= $data;
                      $queryR = "select escalao, filePath from results where subEvent_idsubEvent =";
                      $queryR .= $data;

                      $link = mysqli_connect("localhost", "root", "atletismo", "mydb");

                      $result = mysqli_query($link, $query) or die("Bad Query: $query");
                      $row = mysqli_fetch_assoc($result);

                      $resultR = mysqli_query($link, $queryR) or die("Bad Query: $queryR");
                      $rowR = mysqli_fetch_assoc($result);

                      if($row['isTorneio'] == 1){
                        echo"<h1 >{$row['torneio']}</h1>";
                        echo"<h2 >{$row['prova']}</h2  >";
                      } else {
                        echo"<h1 >{$row['prova']}</h1>";
                      }

                      echo"<p >Data: <td>{$row['date']}</td> <span style='display:inline-block; width: 100px;'></span> Local: <td>{$row['local']}</td></p>";
                      echo"<p ><td>{$row['info']}</td> </p>";

                      if($row['regulamentoPath'] != "")
                        echo"<p >Regulamento: <a href='reg/".$row['regulamentoPath']."' target='_blank'>Aqui</a></p>";

                      if($row['hasResults'] != 0){
                        echo"<p ><b>Resultados:</b></p>";
                        while($rowR = mysqli_fetch_assoc($resultR)){
                         echo"<p >{$rowR['escalao']}: <a href='results/".$rowR['filePath']."' target='_blank'>Aqui</a></p> ";
                        }
                      }

                  }
              ?>
            </section>

        <div class="footer">
              LiveRun 2018
        </div>

    </body>
</html>
