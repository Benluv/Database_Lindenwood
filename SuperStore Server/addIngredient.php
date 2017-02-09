<?php
	session_start(); 
	
	// setup connection to send the table to mysql
	$conn = mysqli_connect($_SESSION["host"], $_SESSION["user"], 
		       	       $_SESSION["passw"], $_SESSION["user"]);
	
	if ($_SESSION["login"] == false) {
	header('Location:login.html');
	}
?>

<form action="addIngredient.php" method="post">
<h2>Ingredient's Page:</h2> <br>
<i>Name:     <input type=text name="inName"></input></i> <br>
<i>Quantity: <input type=number  min="1" name="inQuantity"></input></i> <br>
<input type=submit value="Submit"></input>
</form>

<!-- button to go back to the main menu -->
<form action="mainMenu.php">
    <input type="submit" value="Go to main Menu" />
</form>

<?php
$ingredientName = $_POST["inName"];
$ingredientQ = $_POST["inQuantity"];

$queryString = "INSERT INTO inventory".
               " values (\"$ingredientName\",$ingredientQ)";
	$status = mysqli_query($conn, $queryString);
	
	// if the recipe and the ingredient match update the table by adding the
	// ingredient quantity
	if (!$status)
		$queryString = "UPDATE inventory set quantity = quantity + "
				.$ingredientQ . " WHERE ingredient LIKE \"$ingredientName\"";
		$status = mysqli_query($conn, $queryString);
mysqli_close($conn);
?>
