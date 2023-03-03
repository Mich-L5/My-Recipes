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
<body>
<div class="mobile-container">
    <header><?php include './header.php' ?></header>
    <main>
        <!-- recipe book -->
        <section class="recipe-book">
            <img src="img/gold-paperclip.png" class="gold-paperclip" alt="gold paperclip">
            <div class="grid">
                <div class="title-container title-image">
                    <h1><?php echo $recipe['name'] ?></h1>
                    <img src="./img/yellow-tape.png" alt="a piece of yellow and white striped washi tape">
                    <?php echo '<img class="recipe-image" src="data:image;base64,' . $recipe['image'] . '" alt="recipe image">' ?>
                </div>
                <div class="recipe-info">
                    <?php
                        echo '<span class="recipe-info-piece"><h2>Servings: ' . $recipe['servings'] . '</h2></span>
                              <span class="recipe-info-piece"><h2>Prep time: ' . $recipe['prepTimeHours'] . ":" . $recipe['prepTimeMins']. '</h2></span>
                              <span class="recipe-info-piece"><h2>Cook time: ' . $recipe['cookTimeHours'] . ":" . $recipe['cookTimeMins']. '</h2></span>
                              <span class="recipe-info-piece"><h2>Rating: ' . $recipe['rating']. "/5" . '</h2></span>
                            ';
                    ?>
                </div>
                <div class="recipe-details">
                    <div class="ingredients">
                        <h2>Ingredients: </h2>
                        <?php
                            $ingredientsArray = explode(',', $recipe['ingredients']);
                            foreach ($ingredientsArray as $ingredient) {
                                echo '<span class="ingredient">' . $ingredient . '</span>';
                            }
                        ?>
                    </div>
                    <div class="directions">
                        <h2>Directions: </h2>
                        <?php
                        $directionsArray = explode(',', $recipe['directions']);
                        foreach ($directionsArray as $direction) {
                            echo '<span class="direction">' . $direction . '</span>';
                        }
                        ?>
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
