<?php

session_start();

require_once '../includes/db_connect.php';

if(!isset($_SESSION["user"])){
    header("Location: ../home.php");
    die();
}

if(isset($_GET["id"]) && !empty($_GET["id"]) && isset($_SESSION["user"])) {

    $id = $_GET["id"];
    $user = $_SESSION["user"];
    $date = date("Y-m-d");

    $sql = "SELECT * FROM `animals` where id=$id and status='Available'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0){
        // 
        // fill out the pivot table pet_adoption for the many2many relationship in the db
        // 
        //
        $sql_update = "UPDATE `animals` SET status='Adopted' WHERE id=$id";
        $sql_insert = "INSERT INTO `pet_adoption` (`adoption_date`, `fk_userid`, `fk_animalid`) VALUES ('$date',$user,$id)";
        mysqli_query($connect, $sql_insert);
        mysqli_query($connect, $sql_update);

    }
    echo "<h2>Pet adopted</h2>";
    header("Refresh:3; url='../home.php'");
    die();
}

mysqli_close($connect);
header("Location: ../home.php");
die();