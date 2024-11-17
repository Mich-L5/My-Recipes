<!doctype html>
<html lang="en">

<head>
    <?php include './meta.php'; ?>
    <title>Add New!</title>
</head>

<body id="add-new-page">
    <div class="mobile-container">
        <header><?php include './header.php'; ?></header>
        <main>
            <!-- recipe book -->
            <section class="recipe-book">
                <img src="img/gold-paperclip.png" class="gold-paperclip" alt="gold paperclip">
                <div class="title-container">
                    <h1 class="add-new-title">Add New!</h1>
                </div>
                <form id="form" class="add-new-form" action="save-recipe.php" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <div>
                            <label for="image">Upload image: <span class="file-format">Formats allowed: .jpg, .jpeg, .png <span>(max. size 2MB)</span></label>
                        </div>
                        <div class="upload-img-container">
                            <div id="button-container">
                                <input name="image" id="image" type="file" />
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
                            <input name="name" id="name" maxlength="60" />
                            <small id="emptyName" class="form-error-hide">Recipe name is required.</small>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <label for="category">*Category:</label>
                        </div>
                        <div>
                            <select name="categoryId" id="categoryId">
                                <option value="" disabled selected>Categories</option>
                                <?php

                                // connect to the database
                                include './db.php';

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
                                    echo '<option value="' . $category['categoryId'] .
                                        '">' . $category['category'] . '</option>';
                                }

                                // disconnect from the database
                                $db = null;

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
                            <input min="1" name="servings" id="servings" type="number" />
                            <small id="emptyServings" class="form-error-hide">Serving size is required.</small>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div>
                            <span>*Prep time:</span>
                        </div>
                        <div>
                            <label hidden for="prep-time-hours">Prep time (hours)</label>
                            <input min="0" name="prep-time-hours" id="prep-time-hours" type="number" />
                            <span class="form-time-label">hours &nbsp;</span>
                            <label hidden for="prep-time-minutes">Prep time (minutes)</label>
                            <input min="0" max="59" name="prep-time-minutes" id="prep-time-minutes" type="number" />
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
                            <input min="0" name="cook-time-hours" id="cook-time-hours" type="number" />
                            <span class="form-time-label">hours &nbsp;</span>
                            <label hidden for="cook-time-minutes">Cook time (minutes)</label>
                            <input min="0" max="59" name="cook-time-minutes" id="cook-time-minutes" type="number" />
                            <span class="form-time-label">mins</span>
                            <small id="emptyCookTime" class="form-error-hide">Cook time is required.</small>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="rating">*Rating (0-5):</label>
                        </div>
                        <div>
                            <input min="1" max="5" name="rating" id="rating" type="number" />
                            <small id="emptyRating" class="form-error-hide">Rating is required.</small>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="ingredients">*Ingredients:<span class="seperate"><mark>Seperate with semicolons</mark></span></label>
                        </div>
                        <div>
                            <textarea maxlength="2000" name="ingredients" id="ingredients"></textarea>
                            <small id="emptyIngredients" class="form-error-hide">At least one ingredient is required.</small>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div>
                            <label for="directions">*Directions:<span class="seperate"><mark>Seperate with semicolons</mark></span></label>
                        </div>
                        <div>
                            <textarea maxlength="5000" name="directions" id="directions"></textarea>
                            <small id="emptyDirections" class="form-error-hide">At least one direction is required.</small>
                        </div>
                    </fieldset>
                    <div>
                        <button>Save</button>
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