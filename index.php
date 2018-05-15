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

        <link rel="stylesheet" href="css/main.css">

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

        <!-- <div class="logo">
          <img src="img/logo.jpg" alt="" width="125px">
        </div> -->

        <h2 class="subTitle"> Bem-vindo à LiveRun </h2>
          <div class="formSearch">
              <form method="post">
                <input type="text" style="height:18px" name="search" placeholder="Procurar">

                <select style="height:24px" name = "mes" class="date">
                    <option value="1"> Janeiro </option>
                    <option value="2"> Fevereiro</option>
                    <option value="3"> Março </option>
                    <option value="4"> Abril </option>
                    <option value="5"> Maio </option>
                    <option value="6"> Junho </option>
                    <option value="7"> Julho </option>
                    <option value="8"> Agosto </option>
                    <option value="9"> Setembro </option>
                    <option value="10"> Outubro </option>
                    <option value="11"> Novembro </option>
                    <option value="12"> Dezembro </option>
                </select>

                <select style="height:24px" name = "ano" class="date">
                    <option value="2018"> 2018 </option>
                    <option value="2019"> 2019</option>
                </select>

                    <input type="submit" style="height:24px" name="searchBtn" id="searchBtn" value="Procurar" /><br/>
                </form>
              </div>
                <br><br>

                <table class="zui-table zui-table-vertical">

                  <thead>
                 <tr>
                    <th>Prova</th>
                    <th>Torneio</th>
                    <th>Data</th>
                    <th>Local</th>
                 </tr>
               </thead>
                <tbody>

                <?php

                function show_default(){
                  $query = "call getEvents();";
                  $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
                  $result = mysqli_query($link, $query) or die("Bad Query: $query");


                  while($row = mysqli_fetch_assoc($result)){
                    if($row['torneio'] == "A"){
                      $row['torneio'] = "-";
                      echo "<tr><td><a href=\"eventPage.php?data={$row['idsubEvent']}\">{$row['prova']}</a></td><td> {$row['torneio']}</td><td>{$row['date']}</td><td>{$row['local']}</td></tr>";
                    } else
                      echo "<tr><td><a href=\"eventPage.php?data={$row['idsubEvent']}\">{$row['prova']}</a></td><td><a href=\"torneioPage.php\"> {$row['torneio']}</a></td><td>{$row['date']}</td><td>{$row['local']}</td></tr>";
                  }


                }

                function querie_events()
                {
                  $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
                  $date = $_POST['ano'];
                  $date .= "-";
                  $date .= $_POST['mes'];
                  $date .= "-";
                  $date .= "1";

                  if($_POST['search'] != ""){
                    $name = "'";
                    $name .= $_POST['search'];
                    $name .= "'";
                  } else
                    $name = "'#'";

                  $query = "call getEventsbydate('";
                  $query .= $date;
                  $query .= "', ";
                  $query .= $name;
                  $query .= ");";

                  $result = mysqli_query($link, $query) or die("Bad Query: $query");

                  while($row = mysqli_fetch_assoc($result)){
                    if($row['torneio'] == "A"){
                      $row['torneio'] = "-";
                      echo "<tr><td><a href=\"eventPage.php?data={$row['idsubEvent']}\">{$row['prova']}</a></td><td> {$row['torneio']}</td><td>{$row['date']}</td><td>{$row['local']}</td></tr>";
                    } else
                      echo "<tr><td><a href=\"eventPage.php?data={$row['idsubEvent']}\">{$row['prova']}</a></td><td><a href=\"torneioPage.php\"> {$row['torneio']}</a></td><td>{$row['date']}</td><td>{$row['local']}</td></tr>";
                  }


                }

                if(array_key_exists('searchBtn',$_POST)){
                    querie_events();
                } else {
                    show_default();
                }

                ?>
                 </tbody>
              </table>
    </body>
</html>
