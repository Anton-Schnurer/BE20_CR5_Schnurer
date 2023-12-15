<?php

    session_start();
    
    require_once './includes/db_connect.php';
    require_once './includes/navbar.php';

    // control access by quering the session variable
    
    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: ".ROOT."/index.php");
        die();
    }
  
    $age=0;

    if(isset($_GET["age"]) && !empty($_GET["age"])){

        $show_age = $_GET["age"];
        if ($show_age === "old") {
            $age = 8;
        }
    }

    if (isset($_SESSION["user"])) {
        $sql = "SELECT * FROM `animals` WHERE status='Available' and age > $age";
    }
    elseif (isset($_SESSION["adm"])) {
        $sql = "SELECT * FROM `animals` WHERE age > $age";   
    }

    $result = mysqli_query($connect, $sql);

    $cards = "";

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $cards .= "
            <div class='p-2'>
                <div class='card'>
                    <img src='".ROOT."/pictures/furries/$row[picture]' class='card-img-top' style='height: 12rem' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>$row[name]</h5>
                        <p class='card-text'>Breed: $row[breed]</p>
                        <a href='".ROOT."/furries/details.php?id=$row[id]' class='btn btn-primary'>Details</a>";
            if (isset($_SESSION["user"])) {
                $cards .="
                        <a href='".ROOT."/furries/adopt.php?id=$row[id]' class='btn btn-warning'>Take me home</a>";
                        
            }
            if (isset($_SESSION["adm"])) {
                $cards .="
                        <p class='card-text'>Status: $row[status]</p>
                        <a href='".ROOT."/furries/update.php?id=$row[id]' class='btn btn-warning'>Update</a>
                        <a href='".ROOT."/furries/delete.php?id=$row[id]' class='btn btn-danger'>Delete</a>";
            }
            $cards .="
                    </div>
                </div>
            </div>
            ";
        }
    }
    else{
        $cards = "No data found.";
    }
    mysqli_close($connect);
?>



<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
       <script src="https://kit.fontawesome.com/553d5d3b41.js" crossorigin="anonymous"></script>
       <title>Animal Slaves</title>
   </head>
   <body>
         <a href='home.php?age=all' class='btn btn-warning'>Show all</a>
         <a href='home.php?age=old' class='btn btn-warning'>Show seniors</a>
         <div class="row row-cols-1 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2">
            <?= $cards ?>
         </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   </body>
</html>