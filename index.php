<?php

    session_start();
    
    require_once './includes/db_connect.php';
    require_once './includes/navbar.php';

 
    if(isset($_SESSION["user"]) || isset($_SESSION["adm"])){
        header("Location: ".ROOT."/home.php");
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
       <title>Landing Page</title>
   </head>
   <body>

         <div class="container">
            <h2><u>Welcome to the animal adoption page</u></h2></br><br>
            <h3>Please register or login first</h3></br><br>
            <h5>...fancy background, company info, footer with legals goes here...</h5>
         </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   </body>
</html>