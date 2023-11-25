<?php 

define("ROOT", ""); // if code is being put inside a subfolder(s) below php-root


$hostname = "localhost"; // this is the hostname 
$username = "root"; // be default the userName for the databases is root
$password = ""; // by default there is no password in the databases
$dbname = "be20_cr5_animal_adoption_schnurer"; // here we need to write the Database name

// create connection, you need to be aware of the order of the parameters
$connect = mysqli_connect($hostname, $username, $password, $dbname);

// check connection
if(!$connect) {
   die( "Connection failed: " . mysqli_connect_error() );
}
