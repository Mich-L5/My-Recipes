<?php

    // read the selected recipeId from the url param using $_GET
    $recipeId = $_GET['recipeId'];

    // connect to the database
    $db = new PDO('mysql:host=localhost;dbname=Micha546528', 'Micha546528', 'your_password_here');

    // set up the SQL DELETE
    $sql = "DELETE FROM recipes WHERE recipeId = :recipeId";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);

    // run the deletion
    $cmd->execute();

    // disconnect
    $db = null;

    // redirect to home page
    header('location:index.php');

?>