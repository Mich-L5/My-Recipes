<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Update Recipe</title>

    <link href="./css/styles.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400;700&family=Sue+Ellen+Francisco&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/36e897625c.js" crossorigin="anonymous"></script>

</head>
<body>
<main>

    <?php

    // to display php errors
    ini_set ('display_errors', 1);
    ini_set ('display_startup_errors', 1);
    error_reporting (E_ALL);

    // capture form inputs to vars
    $name = $_POST['name'];
    $categoryId = $_POST['categoryId'];
    $servings = $_POST['servings'];
    $prepTimeH = $_POST['prep-time-hours'];
    $prepTimeM = $_POST['prep-time-minutes'];
    $cookTimeH = $_POST['cook-time-hours'];
    $cookTimeM = $_POST['cook-time-minutes'];
    $rating = $_POST['rating'];
    $ingredients = $_POST['ingredients'];
    $directions = $_POST['directions'];
    $recipeId = $_POST['recipeId'];

    // initialize a variable to keep track of our error checks
    $errorFree = true;

    // validation (1 field at a time)

    // 1. NAME - check that field is not empty
    if (empty($name)) {
        $errorMsg = "Recipe name is required.";
        $errorFree = false;
    }
    // check that input is no longer than 60 characters as per SQL column (VARCHAR(60))
    else if (strlen($name) > 60) {
        $errorMsg = "Recipe name must be under 60 characters.";
        $errorFree = false;
    }

    // 2. CATEGORY - check that field is not empty
    if (empty($categoryId)) {
        $errorMsg = "Category is required.";
        $errorFree = false;
    }
    // check that input is numeric
    else if (!is_numeric($categoryId)) {
        $errorMsg = "Category must be numeric.";
        $errorFree = false;
    }

    // 3. SERVINGS - check that field is not empty
    if (empty($servings)) {
        $errorMsg = "Servings is required.";
        $errorFree = false;
    }
    // check that input is numeric
    else if (!is_numeric($servings)) {
        $errorMsg = "Servings must be numeric.";
        $errorFree = false;
    }
    // check that input is between 1 and 1000
    else if ($servings < 1 || $servings > 1000) {
        $errorMsg = "Serving size must be between 1-1000.";
        $errorFree = false;
    }

    // 4. a) PREP TIME (HOURS) - check that field is not empty
    if (empty($prepTimeH) && $prepTimeH != 0) {
        $errorMsg = "Prep time hours is required.";
        $errorFree = false;
    }

    // check that input is numeric
    else if (!is_numeric($prepTimeH)) {
        $errorMsg = "Prep time hours must be numeric.";
        $errorFree = false;
    }
    // check that input is above 0
    else if ($prepTimeH < 0) {
        $errorMsg = "Prep time hours must be at least 0.";
        $errorFree = false;
    }

    // 4. b) PREP TIME (MINUTES) - check that field is not empty
    if (empty($prepTimeM) && $prepTimeM != 0) {
        $errorMsg = "Prep time minutes is required.";
        $errorFree = false;
    }
    // check that input is numeric
    else if (!is_numeric($prepTimeM)) {
        $errorMsg = "Prep time minutes must be numeric.";
        $errorFree = false;
    }
    // check that input is between 0 and 59
    else if ($prepTimeM > 59 || $prepTimeM < 0) {
        $errorMsg = "Prep time minutes must be between 0 and 59.";
        $errorFree = false;
    }

    // 5. a) COOK TIME (HOURS) - check that field is not empty
    if (empty($cookTimeH) && $cookTimeH != 0) {
        $errorMsg = "Cook time hours is required.";
        $errorFree = false;
    }
    // check that input is numeric
    else if (!is_numeric($cookTimeH)) {
        $errorMsg = "Cook time hours must be numeric.";
        $errorFree = false;
    }
    // check that input is above 0
    else if ($cookTimeH < 0) {
        $errorMsg = "Cook time hours must be at least 0.";
        $errorFree = false;
    }

    // 5. b) COOK TIME (MINUTES) - check that field is not empty
    if (empty($cookTimeM) && $cookTimeM != 0) {
        $errorMsg = "Cook time minutes is required.";
        $errorFree = false;
    }
    // check that input is numeric
    else if (!is_numeric($cookTimeM)) {
        $errorMsg = "Cook time minutes must be numeric.";
        $errorFree = false;
    }
    // check that input is between 0 and 59
    else if ($cookTimeM > 59 || $cookTimeM < 0) {
        $errorMsg = "Cook time minutes must be between 0 and 59.";
        $errorFree = false;
    }

    // 6. RATING - check that field is not empty
    if (empty($rating)) {
        $errorMsg = "Rating is required.";
        $errorFree = false;
    }
    // check that input is numeric
    else if (!is_numeric($rating)) {
        $errorMsg = "Rating must be numeric.";
        $errorFree = false;
    }
    // check that input is between 1 and 5
    else if ($rating > 5 || $rating < 1) {
        $errorMsg = "Rating must be between 1 and 5.";
        $errorFree = false;
    }

    // 7. INGREDIENTS - check that field is not empty
    if (empty($ingredients)) {
        $errorMsg = "Ingredients is required.";
        $errorFree = false;
    }
    // check that input is no longer than 2000 characters as per SQL column (TEXT(2000))
    else if (strlen($ingredients) > 2000) {
        $errorMsg = "Ingredients must be under 2000 characters.";
        $errorFree = false;
    }

    // 8. DIRECTIONS - check that field is not empty
    if (empty($directions)) {
        $errorMsg = "Directions is required.";
        $errorFree = false;
    }
    // check that input is no longer than 5000 characters as per SQL column (TEXT(5000))
    else if (strlen($directions) > 5000) {
        $errorMsg = "Directions must be under 5000 characters.";
        $errorFree = false;
    }

    // 9. IMAGE - if an image file has been uploaded
    if ($_FILES && $_FILES['image']['name'] != "") {

        // capture the image file
        // $_FILES['image'] returns an array with the image file information, $_FILES['image']['tmp_name'] captures the file's temp name
        $imgTmpLoc = $_FILES['image']['tmp_name'];
        // encode image file
        $image = base64_encode(file_get_contents($imgTmpLoc));

        // store the image file array in a variable for easier access when error-checking below
        $imgFile = $_FILES['image'];

        // file formats allowed
        $formatsAllowed = array('jpg', 'jpeg', 'png');

        // grab file extension and convert it to lowercase
        // explode() will return an array of strings seperated by our separator '.'
        $fileExtension = explode('.', $imgFile['name']);
        // grab the last item in our array (the file extension)
        $fileExtension = strtolower(end($fileExtension));

        // check if the image's file format is allowed
        $validExt = false;

        foreach ($formatsAllowed as $format) {
            if ($format == $fileExtension) {
                $validExt = true;
            }
        }

        // if the image extension is not valid (i.e. does not match any of the formats allowed), return error message
        if (!$validExt) {
            $errorMsg = "Image format is not allowed, please try again.";
            $errorFree = false;
        } // check that image size is no larger than 2MB
        else if ($imgFile['size'] > 2000000) {
            $errorMsg = "File size is too big, please try again.";
            $errorFree = false;
        } // check for any other image upload errors
        else if ($imgFile['error'] != 0) {
            $errorMsg = "There was an error when uploading your file, please try again.";
            $errorFree = false;
        }
    }


    // if any errors occured during error-checking, alert the user with custom error message, and re-direct them to the form page
    if (!$errorFree) {
        echo '<script>alert("' . $errorMsg . '")</script>';
        echo '<script>window.location.href = "edit-recipe.php?recipeId=' . $recipeId . '"</script>';
    }
    // if no errors came back and our errorFree variable still holds 'true', enter the new car entry in database
    else {

        // connect to the database
        $db = new PDO('mysql:host=172.31.22.43;dbname=Micha546528', 'Micha546528', '3POKCa61FA');

        // set up SQL query
        $sql = "UPDATE recipes SET name = :name, categoryId = :categoryId, servings = :servings, 
                   prepTimeHours = :prepTimeH, prepTimeMins = :prepTimeM, cookTimeHours = :cookTimeH, 
                   cookTimeMins = :cookTimeM, rating = :rating, ingredients = :ingredients, directions = :directions
                   WHERE recipeId= :recipeId";


        // create pdo command and populate variables into parameters
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':name', $name, PDO::PARAM_STR, 60);
        $cmd->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $cmd->bindParam(':servings', $servings, PDO::PARAM_INT);
        $cmd->bindParam(':prepTimeH', $prepTimeH, PDO::PARAM_INT);
        $cmd->bindParam(':prepTimeM', $prepTimeM, PDO::PARAM_INT);
        $cmd->bindParam(':cookTimeH', $cookTimeH, PDO::PARAM_INT);
        $cmd->bindParam(':cookTimeM', $cookTimeM, PDO::PARAM_INT);
        $cmd->bindParam(':rating', $rating, PDO::PARAM_INT);
        $cmd->bindParam(':ingredients', $ingredients, PDO::PARAM_STR, 2000);
        $cmd->bindParam(':directions', $directions, PDO::PARAM_STR, 5000);
        $cmd->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);


        // run the command
        $cmd->execute();


        // if an image has been uploaded:
        if($_FILES && $_FILES['image']['name'] != "") {

            // set up SQL query
            $sql = "UPDATE recipes SET image = :image WHERE recipeId= :recipeId";

            $cmd = $db->prepare($sql);
            $cmd->bindParam(':image', $image, PDO::PARAM_LOB);
            $cmd->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
            $cmd->execute();
        }


        // show confirmation to the user that the new recipe has been saved
        echo '<script>alert("Your recipe has been successfully saved!");</script>';

        // disconnect from database
        $db = null;

        echo '<script>window.location.href ="index.php"</script>';
    }


    ?>

</main>
</body>
</html>