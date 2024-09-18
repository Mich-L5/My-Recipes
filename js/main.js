/* --------------------------------------- */
/*      CONFIRM DELETE POPUP FUNCTION      */
/* --------------------------------------- */
function confirmDelete() {
    return confirm('Are you sure you want to delete this?');
}

/* --------------------------------------- */
/*     UNABLE TO DELETE POPUP FUNCTION     */
/* --------------------------------------- */

function unableToDelete() {
    alert('This recipe is a demo recipe and cannot be deleted. To try the delete functionality, please add a new recipe and try again.');
}

/* --------------------------------------- */
/*     UNABLE TO EDIT POPUP FUNCTION     */
/* --------------------------------------- */

function unableToEdit() {
    alert('This recipe is a demo recipe and cannot be edited. To try the edit functionality, please add a new recipe and try again.');
}

/* --------------------------------------- */
/*             DEMO MODE ALERT             */
/* --------------------------------------- */
function displayWelcomeAlert() {
    alert('Welcome to the Recipe Book app! You are currently in demo mode. Feel free to try the app by adding new recipes!');
}

document.addEventListener("DOMContentLoaded",(loaded) => {

    /* --------------------------------------- */
    /*    KEEP ACTIVE NAV TAB FROM MOVING      */
    /*               UPON HOVER                */
    /* --------------------------------------- */

    // Get all tab href links
    let pageLinks = document.links;

    // Variable to check if we are on the home tab (i.e. the "/recipe/" only href)
    var home = true;

    // Check to see if we are on a recipe page or an edit page (in that case, none of the nav tabs are active, and home is false since we are not on the home page either)
    // Change links based on hosting and URL paths when live
    if (window.location.href.includes("/recipe.php") || window.location.href.includes("/edit-recipe.php")) {
        home = false;
    }

    // Cycle through all the tab href links
    for (var i = 0; i < pageLinks.length; i++) {

        // If the tab's href matched the current (active) href, remove hover effects
        if (pageLinks[i].href == window.location.href) {

            // Remove moving tab and cursor pointer on hover, and bring tab to the front of the page
            pageLinks[i].parentElement.classList.add("current-tab");
            // Remove darker color on hover
            pageLinks[i].parentElement.classList.remove("hover-tab" + i);

            // If any of the if checks return true, then we are not on the "/recipe/" only href
            home = false;
        }
    }

    // If none of the if statement checks above return true, then we are on the "/recipe/" only href, and we must target the effects on the home tab
    // This is necessary because the for loop above is only checking for the "/recipe/index.php" as the home tab, so we need to perform an additional check for "/recipe/"
    if (home === true) {

        // Remove moving tab and cursor pointer on hover, and bring tab to the front of the page
        pageLinks[1].parentElement.classList.add("current-tab");
        // Remove darker color on hover
        pageLinks[1].parentElement.classList.remove("hover-tab" + 1);
    }

    /* --------------------------------------- */
    /*      REMOVE THE EXISTING RECIPE         */
    /*      THUMBNAIL WHEN NEW IMG IS          */
    /*              UPLOADED                   */
    /* --------------------------------------- */

    function fileUploaded() {
        existingImg.classList.add("img-uploaded");
    }

    if (document.getElementById("edit-recipe")) {

        // Get image input field
        var uploadInput = document.getElementById("uploadInput");

        // Get image to add the class that will make it "display:none"
        var existingImg = document.getElementById("upload-tn");

        // Listen for any change in input filed (i.e. a new file uploaded)
        uploadInput.addEventListener("change", fileUploaded);
    }   
});
