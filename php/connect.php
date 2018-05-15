<?php

$link = mysqli_connect("localhost", "root", "atletismo", "mydb");

if(!$link) {
    echo "Error: Unable to conect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: A proper connection to MySQL was made! The mydb database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHO_EOL;

?>
