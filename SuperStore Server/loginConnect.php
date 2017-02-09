<?php

session_start();

$_SESSION["host"] = $_POST["host"];
$_SESSION["user"] = $_POST["user"];
$_SESSION["passw"] = $_POST["password"];

// build the connection ...
echo ".......connecting".$_SESSION["host"];
$conn = mysqli_connect($_SESSION["host"], $_SESSION["user"], 
		       $_SESSION["passw"], $_SESSION["user"]);

if (!$conn) {
	// die is a php function that terminates execution. 
	//   the . means string concatenation in php. 
	die("Could not connect:".mysqli_connect_error());
header('Location:index.html');
}
else
	echo "hello";
	//echo "hello world";

$_SESSION["login"]=true;

// try and create the table (if it does not exist) ...
// creating tables required to run the program

//creating the recipes table if it does not exist
$queryString = "create table if not exists recipes
                (recipeName char(100) NOT NULL, ingredient char(100) NOT NULL, 
		 quantity integer, PRIMARY KEY (recipeName, Ingredient))";
$status = mysqli_query($conn, $queryString);

if (!$status)
    die("Error creating table: " . mysqli_error($conn));

//creating the recipes table if it does not exist
$queryString = "create table if not exists inventory
                (ingredient char(100) NOT NULL, quantity integer, 
		 PRIMARY KEY (Ingredient))";
$status = mysqli_query($conn, $queryString);

if (!$status)
    die("Error creating table: " . mysqli_error($conn));
/*
// try and insert request
$queryString = "insert into brandNewTable".
               " values (\"bookname\", \"Donald\", 42)";
echo "query: $queryString<br>";
$status = mysqli_query($conn, $queryString);

if (!$status)
    die("Error performing insertion: " . mysqli_error($conn));
*/

// close the connection (to be safe)
mysqli_close($conn);
header('Location:mainMenu.php');

?>

