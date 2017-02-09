<?php
	session_start(); 

// setup connection to send the table to mysql
	$conn = mysqli_connect($_SESSION["host"], $_SESSION["user"], 
			       $_SESSION["passw"], $_SESSION["user"]);

	if ($_SESSION["login"] == false) {
	header('Location:login.html');
	}
?>

<form action="listRecipe.php" method="post">
<h2>Recipe's Listing:</h2> <br>
<i> Recipe Name:       <input type=text name="liRecipe"></input></i> <br>
<br>
<input type=submit value="Submit"></input>
</form>

<!-- button to go back to the main menu -->
<form action="mainMenu.php">
    <input type="submit" value="Go to main Menu" />
</form>
<?php

	// assigns the user prompted data into variables
	$listing = $_POST["liRecipe"];

	// Select from all the columns in the recipe table in order to list them
	$queryString = "SELECT * FROM recipes ".
		       "WHERE recipeName=\"$listing\"";

	$status = mysqli_query($conn, $queryString);
	
	// check if any error in the sql syntax
	if (!$status)
	    die("Error running query: " . mysqli_error($conn));
	// set up the table border with its table headers
	echo "<table border=2>";
	echo "<tr> <th> Ingredient </th> <th> Quantity </th> </tr>";

	// while loop to scan through the selected recipe table in order to print
	// under the corresponding table headers
	while($row = mysqli_fetch_assoc($status))
	    {
		echo "<tr> <td>".$row["ingredient"]." </td>". 
		          "<td> ".$row["quantity"]."</td> </tr>";
	    }

	echo "</table>";


	mysqli_close($conn);
?>
