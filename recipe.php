<?php

    // get recipeId from url param using $_GET

    $recipeId = $_GET['recipeId'];

    if(empty($recipeId) || !is_numeric($recipeId)) {
    header('location:400.php'); // bad request http 400 error
    exit();
    }

    // connect to the database
    $db = new PDO('mysql:host=172.31.22.43;dbname=Micha546528','Micha546528' ,'3POKCa61FA');

    // fetch the selected recipe record with this recipeId
    $sql = "SELECT * FROM recipes WHERE recipeId = :recipeId";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
    $cmd->execute();
    $recipe = $cmd->fetch();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <title>Home</title>
    <link href="./css/styles.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400;700&family=Sue+Ellen+Francisco&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/36e897625c.js" crossorigin="anonymous"></script>
</head>
<body class="recipe">
<div class="mobile-container">
    <header><?php include './header.php' ?></header>
    <main>
        <!-- recipe book -->
        <section class="recipe-book">
            <img src="img/gold-paperclip.png" class="gold-paperclip" alt="gold paperclip">
            <div class="action-container">

                <?php
               echo '<a href="edit-recipe.php?recipeId=' . $recipe['recipeId'] . '"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="delete-recipe.php?recipeId=' . $recipe['recipeId'] . '" title="delete" onclick="return confirmDelete();"><i class="fa-regular fa-trash-can"></i></a>';

                ?>

            </div>
            <div class="recipe-content">
                <div class="grid">
                    <div class="grid-col-1">
                        <div class="title-container title-image">
                            <h1><?php echo $recipe['name'] ?></h1>
                            <img src="./img/yellow-tape.png" alt="a piece of yellow and white striped washi tape">
                            <?php echo '<img src="data:image;base64,' . $recipe['image'] . '" alt="recipe image">' ?>
                        </div>
                        <div class="recipe-info">
                            <?php
                                echo '<h2>Servings: <span>' . $recipe['servings'] . '</span></h2>
                                      <h2>Prep time: <span>' . $recipe['prepTimeHours'] . ":" . $recipe['prepTimeMins']. '</span></h2>
                                      <h2>Cook time: <span>' . $recipe['cookTimeHours'] . ":" . $recipe['cookTimeMins']. '</span></h2>
                                      <h2>Rating: <span>' . $recipe['rating']. "/5" . '</span></h2>
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
                                            $ingredientsArray = explode(';', $recipe['ingredients']);
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
                                        $directionsArray = explode(';', $recipe['directions']);
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
<script src="js/main.js" defer></script>
</body>
</html>
