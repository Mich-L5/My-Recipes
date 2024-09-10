<!doctype html>
<html lang="en">

<head>
    <?php include './meta.php'; ?>
    <title>Desserts</title>
</head>

<body class="category-page">
    <div class="mobile-container">
        <header><?php include './header.php'; ?></header>
        <main>
            <!-- recipe book -->
            <section class="recipe-book">
                <img src="img/gold-paperclip.png" class="gold-paperclip" alt="gold paperclip">
                <div class="title-container">
                    <h1>Desserts</h1>
                </div>
                <?php

                // connect to the database
                include './db.php';

                // SQL query that reads all table records and returns the recipes in the "apps" category
                $sql = "SELECT * FROM recipes WHERE categoryId = 4";

                // create the command
                $cmd = $db->prepare($sql);

                // execute the command
                $cmd->execute();

                // use the fetchAll() method to store the data into a variable called $recipes
                // fetchAll() returns a 2-dimentional array (rows and columns)
                // $recipes is a 2-dimentional array
                $recipes = $cmd->fetchAll();

                // if no recipes exist in this category yet, display "no recepies yet" message
                if (!$recipes) {
                    echo "<p class='no-recipes'>You don't have any recipes in this category!</p>";
                }

                // else, print the list of recipes
                else {

                    // start html table format
                    echo '<div class="category-table-container"><table class="sortable"><thead><th></th><th>Recipe</th><th>Total time</th><th>Rating</th></thead>';

                    // loop through each table row and display values in table
                    foreach ($recipes as $recipe) {
                        echo '<tr>';
                        echo '<td><a href="recipe.php?recipeId=' . $recipe['recipeId'] . '"><img class="recipe-tn" src="data:image;base64,' . $recipe['image'] . '" alt="recipe thumbnail image"></a></td>';
                        echo '<td><a href="recipe.php?recipeId=' . $recipe['recipeId'] . '"><mark>' . $recipe['name'] . '</mark></a></td>';

                        // calculate and format the total time (prep time + cook time)
                        $totalH = $recipe['prepTimeHours'] + $recipe['cookTimeHours'];
                        $totalM = $recipe['prepTimeMins'] + $recipe['cookTimeMins'];

                        if ($totalM > 59) {
                            $additionalH = floor($totalM / 60);
                            $totalH += $additionalH;
                            $totalM = $totalM - ($additionalH * 60);
                        }
                        if ($totalM < 10) {
                            $totalM = "0" . $totalM;
                        }

                        echo '<td><a href="recipe.php?recipeId=' . $recipe['recipeId'] . '"><span>' . $totalH . ":" . $totalM . '</span></a></td>';
                        echo '<td><a href="recipe.php?recipeId=' . $recipe['recipeId'] . '"><span>' . $recipe['rating'] . "/5" . '</span></a></td>';
                        echo '</tr>';
                    }

                    echo '</table></div>';
                }

                // disconnect from the database
                $db = null;

                ?>
            </section>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
    <script src="js/main.js" defer></script>
    <!-- https://www.kryogenix.org/code/browser/sorttable/ for column sorting-->
    <script src="js/sorttable.js" defer></script>
    <script src="https://kit.fontawesome.com/36e897625c.js" crossorigin="anonymous" defer></script>
</body>

</html>