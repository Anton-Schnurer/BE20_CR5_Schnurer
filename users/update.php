<?php
    session_start();

    require_once '../includes/db_connect.php';
    require_once '../includes/clean.php';

    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: ".ROOT."/index.php");
        die();
    }

    if(isset($_SESSION["adm"])){
        $id = $_GET["id"]??$_SESSION["adm"];
    }
    else{
        $id = $_SESSION["user"];
    }



    $emailError = "";
    $passError = "";

    $sql = "SELECT * FROM `users` WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);

    if(isset($_POST["update"])){

        $email = clean($_POST["email"]);
        $password = clean($_POST["password"]);
        $error = false;

        if(empty($email)){
            $error = true;
            $emailError = "Email cannot be empty.";
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = true;
            $emailError = "Email has the wrong format.";
        }

        // $sql = "SELECT * FROM `users` WHERE email = '$email'";
        // $result = mysqli_query($connect, $sql);
        // if(mysqli_num_rows($result) !== 0){
        //     $error = true;
        //     $emailError = "Email already exists.";
        // }
        
        if(empty($password)){
            $error = true;
            $passError = "Password cannot be empty.";
        }
        elseif(strlen($password) < 6){
            $error = true;
            $passError = "Password must be at least 6 chars long.";
        }


        if($error === false){
            $password = hash("sha256", $password);

            $sql = "UPDATE `users` SET `email`='$email',`pass`='$password' WHERE id = $id";
            $result = mysqli_query($connect, $sql);

            if($result){
                echo "
            <div class='alert alert-success' role='alert'>
                User updated!
            </div>";
            }
            else{
                echo "
                <div class='alert alert-danger' role='alert'>
                    Something went wrong!
                </div>";
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php require_once '../includes/navbar.php' ?>

    <div class="container">
        <form action="" method="post">
            <label>
                Email:
                <input type="email" name="email" class="form-control" value="<?= $row["email"]??""; ?>">
                <span><?= $emailError; ?></span>
            </label>
            <label>
                Password:
                <input type="password" name="password" class="form-control">
                <span><?= $passError; ?></span>
            </label>
            <input type="submit" value="update" name="update" class="btn btn-primary">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>