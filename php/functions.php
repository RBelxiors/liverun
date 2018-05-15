<?php

function querie_events()
{
  $link = mysqli_connect("localhost", "root", "atletismo", "mydb");
  $date = $_POST['ano'];
  $date .= "-";
  $date .= $_POST['mes'];
  $date .= "-";
  $date .= "1";

  $query = "call getEventsbydate('";
  $query .= $date;
  $query .= "');";

  $result = mysqli_query($link, $query) or die("Bad Query: $query");

  echo"<table border='1'>";
  echo"<tr><td>Name</td><td>Date</td><td>Local</td><tr>";

  while($row = mysqli_fetch_assoc($result)){
   echo"<tr><td>{$row['name']}</td><td>{$row['date']}</td><td>{$row['local']}</td><tr>";
  }

  echo"</table>";
}

if(array_key_exists('test',$_POST)){
    querie_events();
}

?>
