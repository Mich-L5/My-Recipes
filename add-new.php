<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <title>Add New!</title>
    <link href="./css/styles.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400;700&family=Sue+Ellen+Francisco&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/36e897625c.js" crossorigin="anonymous"></script>
</head>
<body>
<nav>
    <ul>
        <li><a href="add-new.php">Add New!</a></li>
        <li><a href="index.php"><i class="fa-solid fa-house"></i></a></li>
        <li><a href="#">Apps</a></li>
        <li><a href="#">Mains</a></li>
        <li><a href="#">Sides</a></li>
        <li><a href="#">Desserts</a></li>
        <li><a href="#">Drinks</a></li>
        <li><a href="#">Sauces</a></li>
    </ul>
</nav>

<main>
    <section>
        <h1 class="add-new-title">Add New!</h1>
        <form class="add-new-form" action="save-recipe.php" method="POST">
           <!-- <fieldset>
                <div>
                    <label for="upload">Upload image:</label>
                </div>
                <input name="upload-image" id="upload-image" type="file" placeholder="Choose image"/>
            </fieldset> -->
            <fieldset>
                <div>
                    <label for="name">Name:</label>
                </div>
                <input name="name" id="name"/>
            </fieldset>
            <fieldset>
                <div>
                    <label for="category">Category:</label>
                </div>
                <select name="category" id="category">
                    <option value="" disabled selected>Categories</option>
                    <option value="app">Apps</option>
                    <option value="main">Mains</option>
                    <option value="side">Sides</option>
                    <option value="dessert">Desserts</option>
                    <option value="drink">Drinks</option>
                    <option value="sauce">Sauces</option>
                </select>
            </fieldset>
            <fieldset>
                <div>
                    <label for="servings">Servings:</label>
                </div>
                <input name="servings" id="servings" type="number"/>
            </fieldset>
            <fieldset>
                <div>
                    <label for="prep-time">Prep time (minutes):</label>
                </div>
                <input name="prep-time" id="prep-time" type="number"/>
            </fieldset>
            <fieldset>
                <div>
                    <label for="cook-time">Cook time (minutes):</label>
                </div>
                <input name="cook-time" id="cook-time" type="number"/>
            </fieldset>
            <fieldset>
                <div>
                    <label for="rating">Rating (0-5):</label>
                </div>
                <input name="rating" id="rating" type="number"/>
            </fieldset>
            <fieldset>
                <div>
                    <label for="ingredients">Ingredients:</label>
                </div>
                <textarea name="ingredients" id="ingredients"></textarea>
            </fieldset>
            <fieldset>
                <div>
                    <label for="directions">Directions:</label>
                </div>
                <textarea name="directions" id="directions"></textarea>
            </fieldset>
            <div>
                <button>Save</button>
            </div>
        </form>
    </section>
</main>

</body>
</html>
