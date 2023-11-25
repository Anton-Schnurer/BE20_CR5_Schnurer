
<?php

    session_start();
    
    require_once '../includes/db_connect.php';
    require_once '../includes/navbar.php';

    if(!isset($_SESSION["user"]) || !isset($_SESSION["adm"])){
        header("Location: ".ROOT."/home.php");
    }

    if(isset($_GET["id"]) && !empty($_GET["id"])) {
        $sql = "SELECT * FROM `animals` where id=$_GET[id]";
        $result = mysqli_query($connect, $sql);

        $cards = "";

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $cards .= "
            <div class='p-2'>
                <div class='card'>
                    <img src='".ROOT."/pictures/furries/{$row[0]["picture"]}' class='card-img-top' style='height: 50%; width:50%; object-fit:cover' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row[0]["name"]}</h5>
                        <p class='card-text'>Breed: {$row[0]["breed"]}</p>
                        <p class='card-text'>Vaccinated: {$row[0]["vaccinated"]}</p>
                        <p class='card-text'>Address: {$row[0]["address"]}</p>
                        <p class='card-text'>Size: {$row[0]["size"]} cm</p>
                        <p class='card-text'>Age: {$row[0]["age"]} years</p>
                        <p class='card-text'><details>
                        <summary>Details</summary>{$row[0]["description"]}</details></p>
                        <a href='".ROOT."/home.php' class='btn btn-primary'>back</a>
                    </div>
                </div>
            </div>
            ";
            }
        else{
            $cards = "No data found.";
        }
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
       <title>Details</title>
   </head>
   <body>

         <div class="container">
            <?= $cards ?>
         </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   </body>
</html>
