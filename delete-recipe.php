<?php

// Restricted IDs (demo recipes that shouldn't be deleted)
include 'restricted-ids.php';

// read the selected recipeId from the url param using $_GET
$recipeId = $_GET['recipeId'];

// Check if the recipe ID is in the restricted list
if (in_array($recipeId, $restrictedRecipeIds)) {
    exit("This recipe is a demo recipe and cannot be deleted.");
}

// connect to the database
include './db.php';

// set up the SQL DELETE
$sql = "DELETE FROM recipes WHERE recipeId = :recipeId";
$cmd = $db->prepare($sql);
$cmd->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);

// run the deletion
$cmd->execute();

// disconnect
$db = null;

// redirect to home page
header('location:home.php');
