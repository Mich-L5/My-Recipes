<?php

// read the selected taskId from the url param using $_GET
$recipeId = $_GET['recipeId'];


// connect to the database
$db = new PDO('mysql:host=172.31.22.43;dbname=Micha546528','Micha546528' ,'3POKCa61FA');



// set up the SQL DELETE

$sql = "DELETE FROM recipes WHERE recipeId = :recipeId";
$cmd = $db->prepare($sql);
$cmd->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);

// run the delete

$cmd->execute();


// disconnect

$db = null;

// show confirmation / redirect

//temp (just to make sure delete works):
//echo '<p>Recipe deleted</p>';


// uncomment once delete function is fixed
header('location:index.php');

?>