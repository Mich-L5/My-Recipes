<?php

// Restricted IDs (demo recipes that shouldn't be edited)
include 'restricted-ids.php';

// get recipeId from url param using $_GET
$recipeId = $_GET['recipeId'];

// Check if the recipe ID is in the restricted list
if (in_array($recipeId, $restrictedRecipeIds)) {
    exit("This recipe is a demo recipe and cannot be edited.");
}

if (empty($recipeId) || !is_numeric($recipeId)) {
    header('location:400.php'); // bad request http 400 error
    exit();
}

// connect to the database
include './db.php';

// fetch the selected recipe record with this recipeId. use fetch (not fetchAll) for single row queries
$sql = "SELECT * FROM recipes WHERE recipeId = :recipeId";
$cmd = $db->prepare($sql);
$cmd->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
$cmd->execute();
$recipe = $cmd->fetch();

if (empty($recipeId)) {
    header('location:404.php');
    exit(); // exit is like a return statement
}

// store variables in local vars
$name = $recipe['name'];
$currentCategory = $recipe['categoryId'];
$servings = $recipe['servings'];
$prepTimeH = $recipe['prepTimeHours'];
$prepTimeM = $recipe['prepTimeMins'];
$cookTimeH = $recipe['cookTimeHours'];
$cookTimeM = $recipe['cookTimeMins'];
$rating = $recipe['rating'];
$ingredients = $recipe['ingredients'];
$directions = $recipe['directions'];
$image = $recipe['image'];

?>

<!doctype html>
<html lang="en">

<head>
    <?php include './meta.php'; ?>
    <title>Edit Recipe</title>
</head>

<body id="add-new-page">
    <div class="mobile-container" id="edit-recipe">
        <header><?php include './header.php'; ?></header>
        <main id="edit-recipe">
            <!-- recipe book -->
            <section class="recipe-book">
                <img src="img/gold-paperclip.png" class="gold-paperclip" alt="gold paperclip">
                <div class="title-container">
                    <h1 class="add-new-title">Edit Recipe</h1>
                </div>
                <form class="add-new-form" action="update-recipe.php" method="POST" enctype="multipart/form-data">
                    <fieldset class="image-fieldset">
                        <div>
                            <label for="image">Upload image: <span class="file-format">Formats allowed: .jpg, .jpeg, .png <span>(max. size 2MB)</span></span></label>
                        </div>
                        <div class="upload-img-container">
                            <?php
                                if ($recipe['image'] !== "placeholder")
                                {
                                    echo '<img id="upload-tn" src="data:image;base64,' . $recipe['image'] . '" alt="recipe image">';
                                }
                             ?>
                            <input name="image" id="image" type="file" />
                        </div>
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="name">Recipe name:</label>
                        </div>
                        <input value="<?php echo $name; ?>" name="name" id="name" maxlength="60" />
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="category">Category:</label>
                        </div>
                        <select name="categoryId" id="categoryId">
                            <option value="" disabled selected>Categories</option>
                            <?php

                            // write SQL query to select all the recipe categories
                            $sql = "SELECT * FROM recipeCategories";

                            // create the command
                            $cmd = $db->prepare($sql);

                            // execute the query
                            $cmd->execute();

                            // store SQL query results in variable
                            $categories = $cmd->fetchAll();

                            // loop and display as <option></option> each category
                            foreach ($categories as $category) {

                                // if recipe category matches the category in loop, select it
                                if ($currentCategory == $category['categoryId']) {
                                    echo '<option selected value="' . $category['categoryId'] .
                                        '">' . $category['category'] . '</option>';
                                } else {

                                    echo '<option value="' . $category['categoryId'] .
                                        '">' . $category['category'] . '</option>';
                                }
                            }

                            ?>
                        </select>
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="servings">Servings:</label>
                        </div>
                        <input value="<?php echo $servings; ?>" min="1" name="servings" id="servings" type="number" />
                    </fieldset>
                    <fieldset>
                        <div>
                            <span>Prep time:</span>
                        </div>
                        <label hidden for="prep-time-hours">Prep time (hours)</label>
                        <input value="<?php echo $prepTimeH; ?>" min="0" name="prep-time-hours" id="prep-time-hours" type="number" />
                        <span class="form-time-label">hours &nbsp;</span>
                        <label hidden for="prep-time-minutes">Prep time (minutes)</label>
                        <input value="<?php echo $prepTimeM; ?>" min="0" max="59" name="prep-time-minutes" id="prep-time-minutes" type="number" />
                        <span class="form-time-label">mins</span>
                    </fieldset>
                    <fieldset>
                        <div>
                            <span>Cook time:</span>
                        </div>
                        <label hidden for="cook-time-hours">Cook time (hours)</label>
                        <input value="<?php echo $cookTimeH; ?>" min="0" name="cook-time-hours" id="cook-time-hours" type="number" />
                        <span class="form-time-label">hours &nbsp;</span>
                        <label hidden for="cook-time-minutes">Cook time (minutes)</label>
                        <input value="<?php echo $cookTimeM; ?>" min="0" max="59" name="cook-time-minutes" id="cook-time-minutes" type="number" />
                        <span class="form-time-label">mins</span>
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="rating">Rating (0-5):</label>
                        </div>
                        <input value="<?php echo $rating; ?>" min="1" max="5" name="rating" id="rating" type="number" />
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="ingredients">Ingredients:<span class="seperate"><mark>(Seperate with semicolons)</mark></span></label>
                        </div>
                        <textarea placeholder="1 sweet potato; 1 tsp salt.." maxlength="2000" name="ingredients" id="ingredients"><?php echo $ingredients; ?></textarea>
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="directions">Directions:<span class="seperate"><mark>(Seperate with semicolons)</mark></span></label>
                        </div>
                        <textarea placeholder="Wash the sweet potato.." maxlength="5000" name="directions" id="directions"><?php echo $directions; ?></textarea>
                    </fieldset>
                    <div>
                        <button>Save</button>
                        <!-- to pass our primary key value to update-recipe.php -->
                        <input name="recipeId" id="recipeId" value="<?php echo $recipeId; ?>" type="hidden" />
                    </div>
                </form>
            </section>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
    <script src="js/main.js" defer></script>
    <script src="https://kit.fontawesome.com/36e897625c.js" crossorigin="anonymous"></script>
</body>

</html>