<?php
	session_start(); 

	if ($_SESSION["login"] == false) {
	header('Location:login.html');
	}
?>
<h1> WELCOME TO THE SUPERSTORE </h1>

<a href=recipeMaker.php> Create a recipe or add ingredient to a recipe </a><br>
<br>
<a href=listRecipe.php> List a recipe's ingredients </a><br>
<br>
<a href=buyAll.php> Buy all recipe ingredients from the store </a><br>
<br>
<a href=addIngredient.php>Add ingredients to the store</a><br>

