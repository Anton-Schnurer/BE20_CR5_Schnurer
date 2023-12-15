<?php
    session_start();

    require_once '../includes/db_connect.php';
    require_once '../includes/clean.php';

    // access control if already logged in

    if(isset($_SESSION["user"]) || isset($_SESSION["adm"])){
        header("Location: ".ROOT."/home.php");
    }

    $emailError = $passError = "";

    if(isset($_POST["login"])){
        $email = clean($_POST["email"]);
        $password = clean($_POST["password"]);
        $error=false;

        if(empty($email)){
            $error = true;
            $emailError = "Email cannot be empty.";
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = true;
            $emailError = "Email has the wrong format.";
        }

        if(empty($password)){
            $error = true;
            $passError = "Password cannot be empty.";
        }

        if(!$error){
            //
            // using password_hash would be more secure and would require password_verify to be tested against the current hash saved in the database
            //
            $password = hash("sha256", $password);


            $sql = "SELECT * FROM `users` WHERE email = '$email' AND pass = '$password'";

            $result = mysqli_query($connect, $sql);

            if(mysqli_num_rows($result) === 1){
                $row = mysqli_fetch_assoc($result);
                if($row["status"] === "user"){
                    //
                    // create more entries to the SESSION to access the info in the navbars later
                    //
                    $_SESSION["user"] = $row["id"];
                    $_SESSION["picture"] = $row["picture"];
                    $user_name = $row["first_name"]. " ". $row["last_name"];
                    $_SESSION["user_name"] = $user_name;
                    header("Location: ".ROOT."/home.php");
                }
                elseif($row["status"] === "adm"){
                    $_SESSION["adm"] = $row["id"];
                    $_SESSION["picture"] = $row["picture"];
                    $user_name = $row["first_name"]. " ". $row["last_name"];
                    $_SESSION["user_name"] = $user_name;
                    header("Location: ".ROOT."/users/adm_user.php");
                }
            }
            else{
                echo "
                <div class='alert alert-danger' role='alert'>
                    Something went very wrong!
                </div>";
            }
        }
    }

    mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php require_once '../includes/navbar.php' ?>

    <div class="container"><u>LOGIN:</u><br>user: furry@furry.com 123456<br>admin: admin@admin.com 12345678<br>
        <form method="post">
            <label>
                Email:
                <input type="email" name="email" class="form-control" value="<?= $email??""; ?>">
                <span><?= $emailError; ?></span>
            </label>
            <label>
                Password:
                <input type="password" name="password" class="form-control">
                <span><?= $passError; ?></span>
            </label>
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>