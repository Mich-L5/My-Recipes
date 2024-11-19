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
                <form id="form" class="add-new-form" action="update-recipe.php" method="POST" enctype="multipart/form-data">

                    <fieldset>
                        <div>
                            <label for="image">Upload image: <span class="file-format">Formats allowed: .jpg, .jpeg, .png <span>(max. size 2MB)</span></label>
                        </div>
                        <div class="upload-img-container">
                            <?php
                            if ($image !== "placeholder")
                            {
                                echo '<img id="upload-tn" src="data:image;base64,' . $image . '" alt="recipe image">';
                            }
                            ?>
                            <div id="button-container">
                                <input name="image" id="image" type="file" />
                                <input type="hidden" name="previous-image" id="previous-image" value="<?php echo $image; ?>">
                                <?php
                                if ($image !== "placeholder")
                                {
                                    echo '<a id="clearFileButton" class="button-styles round-button clear-button"><i class="fa-solid fa-x" aria-hidden="true"></i></a>';
                                }
                                ?>
                            </div>
                            <small id="imgTooBig" class="form-error-hide">Image is too large.</small>
                            <small id="invalidFormat" class="form-error-hide">Image format not supported.</small>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <label for="name">*Recipe name:</label>
                        </div>
                        <div>
                            <input value="<?php echo $name; ?>" name="name" id="name" maxlength="60" />
                            <small id="emptyName" class="form-error-hide">Recipe name is required.</small>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <label for="categoryId">*Category:</label>
                        </div>
                        <div>
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
                            <small id="emptyCategory" class="form-error-hide">Category is required.</small>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <label for="servings">*Servings:</label>
                        </div>
                        <div>
                            <input value="<?php echo $servings; ?>" min="1" name="servings" id="servings" type="number" />
                            <small id="emptyServings" class="form-error-hide">Serving size is required.</small>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <span>*Prep time:</span>
                        </div>
                        <div>
                            <label hidden for="prep-time-hours">Prep time (hours)</label>
                            <input value="<?php echo $prepTimeH; ?>" min="0" name="prep-time-hours" id="prep-time-hours" type="number" />
                            <span class="form-time-label">hours &nbsp;</span>
                            <label hidden for="prep-time-minutes">Prep time (minutes)</label>
                            <input value="<?php echo $prepTimeM; ?>" min="0" max="59" name="prep-time-minutes" id="prep-time-minutes" type="number" />
                            <span class="form-time-label">mins</span>
                            <small id="emptyPrepTime" class="form-error-hide">Prep time is required.</small>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <span>*Cook time:</span>
                        </div>
                        <div>
                            <label hidden for="cook-time-hours">Cook time (hours)</label>
                            <input value="<?php echo $cookTimeH; ?>" min="0" name="cook-time-hours" id="cook-time-hours" type="number" />
                            <span class="form-time-label">hours &nbsp;</span>
                            <label hidden for="cook-time-minutes">Cook time (minutes)</label>
                            <input value="<?php echo $cookTimeM; ?>" min="0" max="59" name="cook-time-minutes" id="cook-time-minutes" type="number" />
                            <span class="form-time-label">mins</span>
                            <small id="emptyCookTime" class="form-error-hide">Cook time is required.</small>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <label for="rating">*Rating (0-5):</label>
                        </div>
                        <div>
                            <input value="<?php echo $rating; ?>" min="1" max="5" name="rating" id="rating" type="number" />
                            <small id="emptyRating" class="form-error-hide">Rating is required.</small>
                        </div>
                    </fieldset>

                    <fieldset>
                        <?php
                        // Split the ingredients string into an array
                        $ingredientList = explode('#**@$seperator^+><%', $ingredients);
                        ?>
                        <div>
                            <label for="ingredient-list">*Ingredients:</label>
                        </div>
                        <div>
                            <div id="ingredient-container">

                                <?php foreach ($ingredientList as $index => $ingredient): ?>
                                    <div class="ingredient-item">
                                        <?php if ($index === 0): ?>
                                            <input type="text" name="ingredient[]" class="ingredient-input" id="ingredient-list" value="<?php echo $ingredient ?>" />
                                        <?php endif; ?>
                                        <!-- only add the remove button for additional fields -->
                                        <?php if ($index > 0): ?>
                                            <input type="text" name="ingredient[]" class="ingredient-input" value="<?php echo $ingredient ?>" />
                                            <button type="button" class="remove-field-btn round-button button-styles inline-button" onclick="this.parentElement.remove();"><i class="fa-regular fa-trash-can"></i></button>
                                        <?php endif; ?>

                                    </div>
                                <?php endforeach; ?>

                            </div>
                            <small id="emptyIngredients" class="form-error-hide">Ingredients are required.</small>
                            <div class="plus-button-container">
                                <button class="round-button button-styles" type="button" id="add-ingredient-button"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <!-- hidden input field where ingredient string gets submitted -->
                            <input type="hidden" id="ingredients" name="ingredients" />
                        </div>
                    </fieldset>

                    <fieldset>
                        <?php
                        // Split the directions string into an array
                        $directionList = explode('#**@$seperator^+><%', $directions);
                        ?>
                        <div>
                            <label for="direction-list">*Directions:</label>
                        </div>
                        <div>
                            <div id="direction-container">

                                <?php foreach ($directionList as $index => $direction): ?>
                                    <div class="direction-item">
                                        <?php if ($index === 0): ?>
                                            <input type="text" name="direction[]" id="direction-list" class="direction-input" value="<?php echo $direction ?>" />
                                        <?php endif; ?>
                                        <!-- only add the remove button for additional fields -->
                                        <?php if ($index > 0): ?>
                                            <input type="text" name="direction[]" class="direction-input" value="<?php echo $direction ?>" />
                                            <button type="button" class="remove-field-btn round-button button-styles inline-button" onclick="this.parentElement.remove();"><i class="fa-regular fa-trash-can"></i></button>
                                        <?php endif; ?>

                                    </div>
                                <?php endforeach; ?>

                            </div>
                            <small id="emptyDirections" class="form-error-hide">Directions are required.</small>
                            <div class="plus-button-container">
                                <button class="round-button button-styles" type="button" id="add-direction-button"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <!-- hidden input field where ingredient string gets submitted -->
                            <input type="hidden" id="directions" name="directions" />
                        </div>
                    </fieldset>

                    <div>
                        <button class="button-styles save-button">Save</button>
                        <!-- to pass our primary key value to update-recipe.php -->
                        <input name="recipeId" id="recipeId" value="<?php echo $recipeId; ?>" type="hidden" />
                    </div>
                </form>
            </section>
        </main>
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