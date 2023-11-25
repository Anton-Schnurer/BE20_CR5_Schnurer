<?php
    

    session_start();

    require_once '../includes/db_connect.php';
    require_once '../includes/fileUpload.php';


    if(!isset($_SESSION["adm"])){
        header("Location: ".ROOT."/home.php");
        die();
    }

    // define variables and set them to empty string
    $vaccinated = $name = $address = $breed = $description = ""; 
    $size = $age = 0;                                                    

    // define variables that will hold error messages later, for now empty string 
    $vaccinatedError = $nameError = $addressError = $breedError = $descriptionError = $sizeError = $ageError = ""; 
    
    if(isset($_GET["id"]) && !empty($_GET["id"])){

        $id = $_GET["id"];
        $sql = "SELECT * FROM `animals` WHERE `id` = $id";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
    }

    if(isset($_POST["update"])){
        $name = $_POST["name"];
        $vaccinated = $_POST["vaccinated"];
        $address = $_POST["address"];
        $breed = $_POST["breed"];
        $description = $_POST["description"];
        $size = $_POST["size"];
        $age = $_POST["age"];

        $error = false;

            // simple validation for the "name"
            if(empty($name)){
            $error = true;
            $nameError = "Please, enter a name";
        }elseif(strlen($name) < 3){
            $error = true;
            $nameError = "Name must have at least 3 characters.";
        }elseif(!preg_match("/^[a-zA-Z\s]+\d+$/", $name)){
            $error = true;
            $nameError = "Name must contain only letters, numbers and spaces.";
        }

        // simple validation for the "breed"
        if(empty($breed)){
            $error = true;
            $breedError = "Please, enter a breed";
        }elseif(strlen($breed) < 3){
            $error = true;
            $breedError = "Breed must have at least 3 characters.";
        }elseif(!preg_match("/^[a-zA-Z\s]+$/", $breed)){
            $error = true;
            $breedError = "Breed must contain only letters and spaces.";
        }

        // simple validation for the "description"
        if(empty($description)){
            $error = true;
            $descriptionError = "Please, enter a description";
        }elseif(strlen($description) < 3){
            $error = true;
            $descriptionError = "Description must have at least 3 characters.";
        }elseif(!preg_match("/^[a-zA-Z\s]+$/", $description)){
            $error = true;
            $descriptionError = "Description must contain only letters and spaces.";
        }

        // simple validation for the "address"
        if(empty($address)){
            $error = true;
            $addressError = "Please, enter your address";
        }elseif(strlen($address) < 3){
            $error = true;
            $addressError = "Address must have at least 3 characters.";
        }

        // simple validation for the "age"
        if ($age <= 0){
            $error = true;
            $ageError = "Please, enter an age greater than 0";
        }

        // simple validation for the "size"
        if ($size <= 0){
            $error = true;
            $sizeError = "Please, enter a size greater than 0";
        }

        // simple validation for "vaccinated"
        if (!(($vaccinated == "yes") || ($vaccinated == "no"))) {
            $error = true;
            $vaccinatedError = "Please, enter if vaccinated (yes or no)";
        }

        if($error === false){
            // do the picture last
            $picture = fileUpload($_FILES["picture"], "furry");
        }

        if ($error === false) {
            if ($_FILES["picture"]["error"] == 0){
                if ($row["picture"] !== "default.png"){
                    unlink("../pictures/furries/$row[picture]");
                }
                $sql = "UPDATE `animals` SET `status`='Available',
                                            `vaccinated`='$vaccinated',
                                            `name`='$name',
                                            `address`='$address',
                                            `size`= $size,
                                            `age`= $age,
                                            `breed`='$breed',
                                            `description`='$description',
                                            `picture`='$picture[0]' 
                        WHERE id = $id";
            }
            else {
                $sql = "UPDATE `animals` SET `status`='Available',
                                            `vaccinated`='$vaccinated',
                                            `name`='$name',
                                            `address`='$address',
                                            `size`= $size,
                                            `age`= $age,
                                            `breed`='$breed',
                                            `description`='$description'
                        WHERE id = $id";
            }

            if(mysqli_query($connect, $sql)){
                echo "
                <div class='alert alert-success' role='alert'>
                    Furry updated!
                </div>";
            }
            else {
                echo "
                <div class='alert alert-danger' role='alert'>
                    Something went wrong!
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
    <title>Update Furry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php require_once '../includes/navbar.php' ?>

    <div class="container">
    <h1 class="text-center">Update Furry</h1>
    <form method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $row["name"]??"" ?>">
                <span class="text-danger"><?= $nameError ?></span>
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" class="form-control" id="breed" name="breed" value="<?= $row["breed"]??"" ?>">
                <span class="text-danger"><?= $breedError ?></span>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= $row["address"]??"" ?>">
                <span class="text-danger"><?= $addressError ?></span>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?= $row["description"]??"" ?>">
                <span class="text-danger"><?= $descriptionError ?></span>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Size in cm</label>
                <input type="number" class="form-control" id="size" name="size" value="<?= $row["size"]??"" ?>">
                <span class="text-danger"><?= $sizeError ?></span>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age in years</label>
                <input type="number" class="form-control" id="age" name="age" value="<?= $row["age"]??"" ?>">
                <span class="text-danger"><?= $ageError ?></span>
            </div>
            <div class="mb-3">
                <label for="vaccinated" class="form-label">Vaccinated</label>
                <select name="vaccinated" class="form-control">
                    <option value="no">no</option>
                    <option value="yes">yes</option>
                </select>
                <span class="text-danger"><?= $vaccinatedError ?></span>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="picture" name="picture">
                <img style="width:50px;height:50px;" src="/pictures/furries/<?=$row["picture"] ?>" >
            </div>
            <button name="update" type="submit" class="btn btn-primary">Update furry</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>