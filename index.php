<!doctype html>
<html lang="en">

<head>
    <?php include './meta.php'; ?>
    <title>Home</title>
</head>

<body>

    <div class="mobile-container">
        <header><?php include './header.php'; ?></header>
        <main>
            <!-- recipe book -->
            <section class="recipe-book">
                <img src="img/gold-paperclip.png" class="gold-paperclip" alt="gold paperclip">
                <div class="title-container">
                    <img src="img/lemon-tape.png" class="lemon-tape" alt="lemon print washi tape">
                    <h1 class="home-title">My Recipes</h1>
                    <img src="img/lemon-tape.png" class="lemon-tape" alt="lemon print washi tape">
                </div>
            </section>
        </main>
    </div>
    <!-- welcome popup -->
    <div id="generic-popup-overlay" class="popup-overlay hidden">
        <div id="generic-popup" class="popup">
            <h2 id="popup-title">Title</h2>
            <p id="popup-message">Message</p>
            <button id="popup-ok-button" class="popup-button">OK</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" defer></script>
    <script src="js/main.js"></script>
    <script src="https://kit.fontawesome.com/36e897625c.js" crossorigin="anonymous"></script>
    <script>
        displayWelcomeAlert();
    </script>
</body>

</html>