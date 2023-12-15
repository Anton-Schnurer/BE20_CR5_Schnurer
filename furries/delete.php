<?php

    session_start();

    require_once '../includes/db_connect.php';

    if(!isset($_SESSION["adm"])){
        header("Location: ".ROOT."/index.php");
        die();
    }
    
    if(isset($_GET["id"]) && !empty($_GET["id"])){
        $id = $_GET["id"];

        // unlink picture and delete record in animals

        $sql = "SELECT * FROM `animals` WHERE `id` = $id";
        $result = mysqli_query($connect, $sql);

        $row = mysqli_fetch_assoc($result);
        if ($row["picture"] !== "default.png"){
            unlink("../pictures/furries/$row[picture]");
        }

        $sql = "DELETE FROM `animals` WHERE `id` = $id";
        mysqli_query($connect, $sql);

        // delete possible records in pivot table pet_adoption

        $sql = "SELECT * FROM `pet_adoption` WHERE `fk_animalid` = $id";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            $sql = "DELETE FROM `pet_adoption` WHERE `fk_animalid` = $id";
            mysqli_query($connect, $sql);
        }

    }

    mysqli_close($connect);
    header("Location: ".ROOT."/home.php");
    