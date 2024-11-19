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
                            <label for="categoryId">*Category:</label>
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
                            <label for="ingredient-list">*Ingredients:</label>
                        </div>
                        <div>
                            <div id="ingredient-container">
                                <div class="ingredient-item">
                                    <input type="text" name="ingredient[]" id="ingredient-list" class="ingredient-input" />
                                </div>
                            </div>
                            <small id="emptyIngredients" class="form-error-hide">Ingredients are required.</small>
                            <div class="plus-button-container">
                                <button class="round-button button-styles" type="button" id="add-ingredient-button"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#454545"><path d="M460-460H260q-8.5 0-14.25-5.76T240-480.03q0-8.51 5.75-14.24T260-500h200v-200q0-8.5 5.76-14.25t14.27-5.75q8.51 0 14.24 5.75T500-700v200h200q8.5 0 14.25 5.76t5.75 14.27q0 8.51-5.75 14.24T700-460H500v200q0 8.5-5.76 14.25T479.97-240q-8.51 0-14.24-5.75T460-260v-200Z"/></svg></button>
                            </div>
                            <!-- hidden input field where ingredient string gets submitted -->
                            <input type="hidden" id="ingredients" name="ingredients" />
                        </div>
                    </fieldset>

                    <fieldset>
                        <div>
                            <label for="direction-list">*Directions:</label>
                        </div>
                        <div>
                            <div id="direction-container">
                                <div class="direction-item">
                                    <input type="text" name="direction[]" id="direction-list" class="direction-input" />
                                </div>
                            </div>
                            <small id="emptyDirections" class="form-error-hide">Directions are required.</small>
                            <div class="plus-button-container">
                                <button class="round-button button-styles" type="button" id="add-direction-button"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#454545"><path d="M460-460H260q-8.5 0-14.25-5.76T240-480.03q0-8.51 5.75-14.24T260-500h200v-200q0-8.5 5.76-14.25t14.27-5.75q8.51 0 14.24 5.75T500-700v200h200q8.5 0 14.25 5.76t5.75 14.27q0 8.51-5.75 14.24T700-460H500v200q0 8.5-5.76 14.25T479.97-240q-8.51 0-14.24-5.75T460-260v-200Z"/></svg></button>
                            </div>
                            <!-- hidden input field where directions string gets submitted -->
                            <input type="hidden" id="directions" name="directions" />
                        </div>
                    </fieldset>

                    <div>
                        <button class="button-styles save-button">Save</button>
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