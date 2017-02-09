<?php
	session_start(); 

// setup connection to send the table to mysql
$conn = mysqli_connect($_SESSION["host"], $_SESSION["user"], 
		       $_SESSION["passw"], $_SESSION["user"]);

	if ($_SESSION["login"] == false) {
	header('Location:login.html');
	}
?>
<!-- create a form to submit to this same page to add ingredients  -->
<form action="recipeMaker.php" method="post">
<h2>Recipe's Page:</h2> <br>
<i>Name:       <input type=text name="reName"></input></i> <br>
<i>Ingredient: <input type=text name="reIngredient"></input></i> <br>
<i>Quantity:   <input type=number  min="1"name="reQuantity" ></input></i> <br>
<br>

<input type=submit value="Submit"></input>
</form>

<!-- button to go back to the main menu -->
<form action="mainMenu.php">
    <input type="submit" value="Go to main Menu" />
</form>

<?php
	// assigns the user prompted data into variables
	$recipeCook = $_POST["reName"];
	$recipeIng = $_POST["reIngredient"];
	$recipeQua = $_POST["reQuantity"];
	
	// if the recipe does not exist, create a recipe and add the ingredient
	// with its corresponding quantity
	$queryString = "INSERT INTO recipes".
		       " values (\"$recipeCook\",\"$recipeIng\",$recipeQua)";
	$status = mysqli_query($conn, $queryString);
	
	// if the recipe and the ingredient match update the table by adding the
	// ingredient quantity
	if (!$status)
		$queryString = "UPDATE recipes set quantity = quantity + "
				.$recipeQua . " WHERE ingredient LIKE \"$recipeIng\"";
		$status = mysqli_query($conn, $queryString);
	mysqli_close($conn);
?>
