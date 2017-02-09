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
<form action="buyAll.php" method="post">
<h2>Buy All from recipe:</h2> <br>
<i>Name:       <input type=text name="buyRe"></input></i><br>
<br>

<!-- submit the values prompted by the user-->
<input type=submit value="Submit"></input>
</form>

<!-- button to go back to the main menu -->
<form action="mainMenu.php">
    <input type="submit" value="Go to main Menu" />
</form>

<?php
	// does not commit the queries that follow this line of code. Either the 
	// queries will commit and the ingredients from the inventory will be removed
	// or the order is not processed.
	mysqli_autocommit($conn, FALSE);
	//mysqli_query($conn, START TRANSACTION);

	// will commit at the end unless stated otherwise
	$commit = true;
	$message = "The transaction could not be made, please try buying another recipe ".
		   "or wait until more supplies arrive.";
	// assigns the user prompted data into variables
	$buyRecipe = $_POST["buyRe"];
	// start transaction to see if commit or rollback
	mysqli_query($conn, "START TRANSACTION");
	// take the items that want to be purchased from the inventory
	$queryString = "UPDATE inventory, recipes SET inventory.quantity = inventory.quantity - recipes.quantity ".
		       "WHERE recipes.recipeName = \"$buyRecipe\" AND recipes.ingredient = inventory.ingredient ";
	$status = mysqli_query($conn, $queryString);
	if (!$status)
	    die("Error running query: " . mysqli_error($conn));
	
	// selects the quantity of ingredients from the inventory given the recipe name and the ingredients it has
	$queryString = "SELECT inventory.quantity FROM inventory, recipes ".
		       "WHERE recipes.recipeName=\"$buyRecipe\" AND recipes.ingredient = inventory.ingredient";
	$status = mysqli_query($conn, $queryString);	
	if (!$status)
	    die("Error running query: " . mysqli_error($conn));

	// goes through each ingredient that is on the recipe and checks if it is in stock
	while($row = mysqli_fetch_assoc($status)) {
		// if there is no ingredients in the inventory, do not process transaction
		if ($row["quantity"] < 0 ) {
			// states that it will not commit
			$commit = false;
			// prints message indicating that there are not enough ingredients in the inventory
			echo "<script type='text/javascript'>alert('$message');</script>";
			break;
		}
	}
	// if there is enough the proceed with the transaction
	if ($commit) {
		// commit with the transaction
		mysqli_commit($conn);
		//mysqli_query($conn, "COMMIT");
	}		
	else if ($commit = false) {
		mysqli_rollback($conn	);
		//mysqli_query($conn, "ROLLBACK");
	}
	mysqli_close($conn);
?>
