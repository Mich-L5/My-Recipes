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
                        <a href="#" title="edit" onclick="return unableToEdit();"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#454545"><path d="M218.46-160q-24.58 0-41.52-16.94Q160-193.88 160-218.46v-523.08q0-24.58 16.94-41.52Q193.88-800 218.46-800h309.51q8.47 0 12.7 5.35 4.23 5.34 4.23 11.45 0 6.11-4.52 11.58t-12.48 5.47H218.46q-9.23 0-16.92 7.69-7.69 7.69-7.69 16.92v523.08q0 9.23 7.69 16.92 7.69 7.69 16.92 7.69h523.08q9.23 0 16.92-7.69 7.69-7.69 7.69-16.92V-532.8q0-8.46 5.35-12.69 5.35-4.23 11.46-4.23 6.1 0 11.57 4.23 5.47 4.23 5.47 12.69v314.34q0 24.58-16.94 41.52Q766.12-160 741.54-160H218.46ZM480-480Zm-80 50.77v-50.8q0-12.09 4.82-23.16t13.05-19.3l344.77-344.77q5.13-5.13 11.31-7.1 6.18-1.97 13.13-1.97 6.25 0 12.41 2.05t11.15 6.92l52.72 51.41q5.82 5.61 8.51 12.51 2.69 6.9 2.69 13.87 0 6.98-2.12 13.26-2.12 6.28-7.54 11.8L518.64-417.44q-8.23 7.72-19.3 12.58T476.18-400h-46.95q-12.61 0-20.92-8.31-8.31-8.31-8.31-20.92Zm440.8-359.54-52.88-55.69 52.88 55.69ZM433.85-433.85h52.77l272.92-272.92-26.21-26.56-29.1-27.59-270.38 270.23v56.84Zm299.48-299.48-29.1-27.59 29.1 27.59 26.21 26.56-26.21-26.56Z"/></svg></a>

                        <a href="#" title="delete" onclick="return unableToDelete();"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#454545"><path d="M304.62-160q-26.66 0-45.64-18.98T240-224.62V-720h-20q-8.5 0-14.25-5.76T200-740.03q0-8.51 5.75-14.24T220-760h140q0-12.38 9.19-21.58 9.19-9.19 21.58-9.19h178.46q12.39 0 21.58 9.19Q600-772.38 600-760h140q8.5 0 14.25 5.76t5.75 14.27q0 8.51-5.75 14.24T740-720h-20v495.38q0 26.66-18.98 45.64T655.38-160H304.62ZM680-720H280v495.38q0 10.77 6.92 17.7 6.93 6.92 17.7 6.92h350.76q10.77 0 17.7-6.92 6.92-6.93 6.92-17.7V-720ZM412.33-280q8.52 0 14.25-5.75t5.73-14.25v-320q0-8.5-5.76-14.25T412.28-640q-8.51 0-14.24 5.75T392.31-620v320q0 8.5 5.76 14.25 5.75 5.75 14.26 5.75Zm135.39 0q8.51 0 14.24-5.75t5.73-14.25v-320q0-8.5-5.76-14.25-5.75-5.75-14.26-5.75-8.52 0-14.25 5.75T527.69-620v320q0 8.5 5.76 14.25t14.27 5.75ZM280-720v520-520Z"/></svg></a>';
                    } else {
                        echo '
                        <a href="edit-recipe.php?recipeId=' . $recipe['recipeId'] . '"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#454545"><path d="M218.46-160q-24.58 0-41.52-16.94Q160-193.88 160-218.46v-523.08q0-24.58 16.94-41.52Q193.88-800 218.46-800h309.51q8.47 0 12.7 5.35 4.23 5.34 4.23 11.45 0 6.11-4.52 11.58t-12.48 5.47H218.46q-9.23 0-16.92 7.69-7.69 7.69-7.69 16.92v523.08q0 9.23 7.69 16.92 7.69 7.69 16.92 7.69h523.08q9.23 0 16.92-7.69 7.69-7.69 7.69-16.92V-532.8q0-8.46 5.35-12.69 5.35-4.23 11.46-4.23 6.1 0 11.57 4.23 5.47 4.23 5.47 12.69v314.34q0 24.58-16.94 41.52Q766.12-160 741.54-160H218.46ZM480-480Zm-80 50.77v-50.8q0-12.09 4.82-23.16t13.05-19.3l344.77-344.77q5.13-5.13 11.31-7.1 6.18-1.97 13.13-1.97 6.25 0 12.41 2.05t11.15 6.92l52.72 51.41q5.82 5.61 8.51 12.51 2.69 6.9 2.69 13.87 0 6.98-2.12 13.26-2.12 6.28-7.54 11.8L518.64-417.44q-8.23 7.72-19.3 12.58T476.18-400h-46.95q-12.61 0-20.92-8.31-8.31-8.31-8.31-20.92Zm440.8-359.54-52.88-55.69 52.88 55.69ZM433.85-433.85h52.77l272.92-272.92-26.21-26.56-29.1-27.59-270.38 270.23v56.84Zm299.48-299.48-29.1-27.59 29.1 27.59 26.21 26.56-26.21-26.56Z"/></svg></a>

                        <div id="delete-button" title="delete""><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#454545"><path d="M304.62-160q-26.66 0-45.64-18.98T240-224.62V-720h-20q-8.5 0-14.25-5.76T200-740.03q0-8.51 5.75-14.24T220-760h140q0-12.38 9.19-21.58 9.19-9.19 21.58-9.19h178.46q12.39 0 21.58 9.19Q600-772.38 600-760h140q8.5 0 14.25 5.76t5.75 14.27q0 8.51-5.75 14.24T740-720h-20v495.38q0 26.66-18.98 45.64T655.38-160H304.62ZM680-720H280v495.38q0 10.77 6.92 17.7 6.93 6.92 17.7 6.92h350.76q10.77 0 17.7-6.92 6.92-6.93 6.92-17.7V-720ZM412.33-280q8.52 0 14.25-5.75t5.73-14.25v-320q0-8.5-5.76-14.25T412.28-640q-8.51 0-14.24 5.75T392.31-620v320q0 8.5 5.76 14.25 5.75 5.75 14.26 5.75Zm135.39 0q8.51 0 14.24-5.75t5.73-14.25v-320q0-8.5-5.76-14.25-5.75-5.75-14.26-5.75-8.52 0-14.25 5.75T527.69-620v320q0 8.5 5.76 14.25t14.27 5.75ZM280-720v520-520Z"/></svg></div>';
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
                                if ($recipe['prepTimeMins'] < 10 ) {
                                    $recipe['prepTimeMins'] = "0" . $recipe['prepTimeMins'];
                                }
                                if ($recipe['cookTimeMins'] < 10) {
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

    <!-- popup that is displayed when user tries to edit a demo recipe -->
    <div id="generic-popup-overlay" class="popup-overlay hidden">
        <div id="generic-popup" class="popup">
            <h2 id="popup-title">Title</h2>
            <p id="popup-message">Message</p>
            <button id="popup-ok-button" class="popup-button">OK</button>
        </div>
    </div>

    <!-- popup that is displayed to confirm delete a recipe -->
    <div id="delete-popup-overlay" class="popup-overlay hidden">
        <div id="delete-popup" class="popup">
            <h2 id="delete-popup-title">WARNING!</h2>
            <p id="delete-popup-message">Are you sure you want to delete this recipe?</p>
            <div class="popup-buttons">
                <?php
                    echo '<a href="delete-recipe.php?recipeId=' . $recipe['recipeId'] . '" id="delete-popup-confirm" class="popup-button">YES</a>';
                ?>
                <button id="delete-popup-cancel" class="popup-button">NO</button>
            </div>
        </div>
    </div>

    <?php

    // disconnect from the database
    $db = null;

    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
    <script src="js/main.js" defer></script>
    <script src="https://kit.fontawesome.com/36e897625c.js" crossorigin="anonymous"></script>
</body>

</html>