<?php
    session_start();

    require_once '../includes/db_connect.php';
    require_once '../includes/clean.php';
    require_once '../includes/fileUpload.php';

    if(isset($_SESSION["user"]) || isset($_SESSION["adm"])){
        header("Location: ".ROOT."/home.php");
    }

    $first_name = $last_name = $phone_number = $address = $email = ""; // define variables and set them to empty string
    $fnameError = $lnameError = $emailError = $addressError = $phoneError = $passError = ""; // define variables that will hold error messages later, for now empty string 

    if(isset($_POST["register"])) {

        $email = clean($_POST["email"]);
        $password = clean($_POST["password"]);
        $first_name = clean($_POST["first_name"]);
        $last_name = clean($_POST["last_name"]);
        $phone_number = clean($_POST["phone_number"]);
        $address = clean($_POST["address"]);
         
        $error = false;

        // simple validation for the "first name"
        if(empty($first_name)){
            $error = true;
            $fnameError = "Please, enter your first name";
        }elseif(strlen($first_name) < 3){
            $error = true;
            $fnameError = "Name must have at least 3 characters.";
        }elseif(!preg_match("/^[a-zA-Z\s]+$/", $first_name)){
            $error = true;
            $fnameError = "Name must contain only letters and spaces.";
        }

        // simple validation for the "last name"
        if(empty($last_name)){
            $error = true;
            $lnameError = "Please, enter your last name";
        }elseif(strlen($last_name) < 3){
            $error = true;
            $lnameError = "Last name must have at least 3 characters.";
        }elseif(!preg_match("/^[a-zA-Z\s]+$/", $last_name)){
            $error = true;
            $lnameError = "Last name must contain only letters and spaces.";
        }

        // simple validation for the "address"
        if(empty($address)){
            $error = true;
            $addressError = "Please, enter your address";
        }elseif(strlen($address) < 3){
            $error = true;
            $addressError = "Address must have at least 3 characters.";
        }

        // simple validation for the "phone number"
        if(empty($phone_number)){
            $error = true;
            $phoneError = "Please, enter your phone number";
        }elseif(strlen($address) < 3){
            $error = true;
            $phoneError = "Phone number must have at least 3 characters.";
        }


        if(empty($email)){
            $error = true;
            $emailError = "Email cannot be empty.";
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = true;
            $emailError = "Email has the wrong format.";
        }
        else{
            $sql = "SELECT email FROM `users` WHERE email = '$email'";
            $result = mysqli_query($connect, $sql);
            if(mysqli_num_rows($result) !== 0){
                $error = true;
                $emailError = "Email already exists.";
            }
        }

        if(empty($password)){
            $error = true;
            $passError = "Password cannot be empty.";
        }
        elseif(strlen($password) < 6){
            $error = true;
            $passError = "Password must be at least 6 chars long.";
        }

        // do the picture last

        if($error === false){
            $picture = fileUpload($_FILES["picture"]);
        }

        if($error === false){
            // below version would be a more secure password using BCRYPT
            // $password = password_hash ($password, PASSWORD_DEFAULT);
            $password = hash("sha256", $password);

            $sql = "INSERT INTO `users`(`email`, `pass`, `first_name`, `last_name`, `phone_number`, `address`, `picture`) 
                    VALUES ('$email', '$password', '$first_name', '$last_name', '$phone_number', '$address', '$picture[0]')";

            $result = mysqli_query($connect, $sql);

            if($result){
                echo "
                <div class='alert alert-success' role='alert'>
                    <p>New user created! $picture[1]</p>
                </div>";
            }
            else{
                echo "
                <div class='alert alert-danger' role='alert'>
                    <p>Something went wrong!</p>
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
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php require_once '../includes/navbar.php' ?>

    <div class="container">
            <h1 class="text-center">Register</h1>
            <form method="post" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="fname" class="form-label">First name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="<?= $first_name ?>">
                    <span class="text-danger"><?= $fnameError ?></span>
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lname" name="last_name" placeholder="Last name" value="<?= $last_name ?>">
                    <span class="text-danger"><?= $lnameError ?></span>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?= $address ?>">
                    <span class="text-danger"><?= $addressError ?></span>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= $phone_number ?>">
                    <span class="text-danger"><?= $phoneError ?></span>
                </div>
                <div class="mb-3">
                    <label for="picture" class="form-label">Profile picture</label>
                    <input type="file" class="form-control" id="picture" name="picture">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>">
                    <span class="text-danger"><?= $emailError ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="text-danger"><?= $passError ?></span>
                </div>
                <button name="register" type="submit" class="btn btn-primary">Create account</button>
                
                <span>Do you have an account already? <a href="login.php">sign in here</a></span>
            </form>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>