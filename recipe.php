<?php

// get recipeId from url param using $_GET
$recipeId = $_GET['recipeId'];

if (empty($recipeId) || !is_numeric($recipeId)) {
    header('location:400.php'); // bad request http 400 error
    exit();
}

// connect to the database
include './db.php';

// fetch the selected recipe record with this recipeId
$sql = "SELECT * FROM recipes WHERE recipeId = :recipeId";
$cmd = $db->prepare($sql);
$cmd->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
$cmd->execute();
$recipe = $cmd->fetch();

// Array of restricted recipe IDs to not delete (for the demo mode)
include 'restricted-ids.php';

// Check if the recipe ID is in the array of restricted IDs
$isRestrictedRecipe = in_array($recipe['recipeId'], $restrictedRecipeIds);

// Generate image src
$imgSrc = "";

if ($recipe['image'] === "placeholder")
{
    $imgSrc = "./img/placeholder.jpg";
}
else
{
    $imgSrc = "data:image;base64," . $recipe['image'];
}


?>

<!doctype html>
<html lang="en">

<head>
    <?php include './meta.php'; ?>
    <title><?php echo $recipe['name'] ?></title>
</head>

<body class="recipe">
    <div class="mobile-container">
        <header><?php include './header.php'; ?></header>
        <main>
            <!-- recipe book -->
            <section class="recipe-book">
                <img src="img/gold-paperclip.png" class="gold-paperclip" alt="gold paperclip">
                <div class="action-container">
                    <?php
                    // If the recipe is a demo recipe, restrict ability to edit and delete
                    if ($isRestrictedRecipe) {
                        echo '
                        <a href="#" title="delete" onclick="return unableToEdit();"><i class="fa-regular fa-pen-to-square"></i></a>

                        <a href="#" title="delete" onclick="return unableToDelete();"><i class="fa-regular fa-trash-can"></i></a>';
                    } else {
                        echo '
                        <a href="edit-recipe.php?recipeId=' . $recipe['recipeId'] . '"><i class="fa-regular fa-pen-to-square"></i></a>

                        <a href="delete-recipe.php?recipeId=' . $recipe['recipeId'] . '" title="delete" onclick="return confirmDelete();"><i class="fa-regular fa-trash-can"></i></a>';
                    }
                    ?>

                </div>
                <div class="recipe-content">
                    <div class="grid">
                        <div class="grid-col-1">
                            <div class="title-container title-image">
                                <h1><?php echo $recipe['name'] ?></h1>
                                <img src="./img/yellow-tape.png" alt="a piece of yellow and white striped washi tape">
                                <?php echo '<img src="' . $imgSrc . '" alt="recipe image">' ?>
                            </div>
                            <div class="recipe-info">
                                <?php

                                // format minutes
                                if ($recipe['prepTimeMins']) {
                                    $recipe['prepTimeMins'] = "0" . $recipe['prepTimeMins'];
                                }
                                if ($recipe['cookTimeMins']) {
                                    $recipe['cookTimeMins'] = "0" . $recipe['cookTimeMins'];
                                }

                                echo '<h2>Servings: <span>' . $recipe['servings'] . '</span></h2>
                                      <h2>Prep time: <span>' . $recipe['prepTimeHours'] . ":" . $recipe['prepTimeMins'] . '</span></h2>
                                      <h2>Cook time: <span>' . $recipe['cookTimeHours'] . ":" . $recipe['cookTimeMins'] . '</span></h2>
                                      <h2>Rating: <span>' . $recipe['rating'] . "/5" . '</span></h2>
                                    ';
                                ?>
                            </div>
                        </div>
                        <div class="grid-col-2">
                            <div class="recipe-details">
                                <div class="ingredients">
                                    <h2>Ingredients: </h2>
                                    <p>
                                    <ul>
                                        <?php

                                        $ingredientsArray = explode('#**@$seperator^+><%', $recipe['ingredients']);
                                        foreach ($ingredientsArray as $ingredient) {
                                            echo '<li><span class="ingredient">' . $ingredient . '</span></li>';
                                        }

                                        ?>
                                    </ul>
                                    </p>
                                </div>
                                <div class="directions">
                                    <h2>Directions: </h2>
                                    <p>
                                    <ol>
                                        <?php

                                        $directionsArray = explode('#**@$seperator^+><%', $recipe['directions']);
                                        foreach ($directionsArray as $direction) {
                                            echo '<li><span class="direction">' . $direction . '</li></span>';
                                        }

                                        ?>
                                    </ol>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <?php

    // disconnect from the database
    $db = null;

    ?>
    <!-- popup that is displayed when user tries to edit/delete a demo recipe -->
    <div id="generic-popup-overlay" class="popup-overlay hidden">
        <div id="generic-popup" class="popup">
            <h2 id="popup-title">Title</h2>
            <p id="popup-message">Message</p>
            <button id="popup-ok-button" class="popup-button">OK</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
    <script src="js/main.js" defer></script>
    <script src="https://kit.fontawesome.com/36e897625c.js" crossorigin="anonymous"></script>
</body>

</html>