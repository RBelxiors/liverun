<?php
    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:login.php'); die();
    }

    echo"<h1>Página de Administrador </h1>";

    echo"<h2><a href='inserirTorneio.php'> Inserir Torneio</a></h2>";
    echo"<h2><a href='inserirProva.php'> Inserir Prova</a></h2>";
    echo"<h2><a href='editarTorneio.php'> Editar Torneio </a></h2>";
    echo"<h2><a href='editarProva.php'> Editar Prova </a></h2>";
    echo"<h2><a href='inserirResultados.php'> Inserir Resultados </a></h2>";
    echo"<h2><a href='apagarResultados.php'> Apagar Resultados </a></h2>";

    echo "<a href='logout.php'>Sair</a>";

 ?>
