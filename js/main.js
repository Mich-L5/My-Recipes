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
    /*       COMBINE INGREDIENT FIELDS         */
    /* --------------------------------------- */

    // add new ingredient field when "+" is clicked
    document.getElementById('add-ingredient-btn').addEventListener('click', function() {

        const container = document.getElementById('ingredient-container');

        // create a new ingredient input field and the "X" button
        const newIngredientField = document.createElement('div');

        // add input field and "X" button inside the new div
        newIngredientField.innerHTML = `
        <input type="text" name="ingredient[]" class="ingredient-input" />
        <button type="button" class="remove-ingredient-btn"><i class="fa-solid fa-x"></i></button>
    `;

        // add the new field to the container
        container.appendChild(newIngredientField);

        // add event listener to the "x" button to remove the field
        newIngredientField.querySelector('.remove-ingredient-btn').addEventListener('click', function() {
            container.removeChild(newIngredientField);
        });
    });

// event listener for form submission - combine ingredients into a single string
    document.getElementById('form').addEventListener('submit', function(event) {

        // get all ingredient inputs
        const ingredients = [];
        const ingredientInputs = document.querySelectorAll('.ingredient-input');

        // collect values from each input field and join them with semicolons
        ingredientInputs.forEach(input => {
            if (input.value.trim() !== '') {
                ingredients.push(input.value.trim());
            }
        });

        // convert the array to a semicolon-separated string
        const ingredientsString = ingredients.join(';');

        // set the hidden input field with the semicolon-separated string
        document.getElementById('ingredients').value = ingredientsString;
    });






















    /* --------------------------------------- */
    /*          FORM CHECK FOR ERRORS          */
    /* --------------------------------------- */

    const form = document.getElementById("form");

    if (form)
    {
        form.addEventListener("submit", validateForm);
    }
    function validateForm(event)
    {
        // Get form inputs
        const imgUpload = document.getElementById("image").files[0];
        const name = document.getElementById("name").value.trim();
        const categoryId = document.getElementById("categoryId").value.trim();
        const servings = document.getElementById("servings").value.trim();
        let prepTimeH = document.getElementById("prep-time-hours").value.trim();
        let prepTimeM = document.getElementById("prep-time-minutes").value.trim();
        let cookTimeH = document.getElementById("cook-time-hours").value.trim();
        let cookTimeM = document.getElementById("cook-time-minutes").value.trim();
        const rating = document.getElementById("rating").value.trim();
        const ingredients = document.getElementById("ingredients").value.trim();
        const directions = document.getElementById("directions").value.trim();

        // check file
        fileSizeTypeValidation(imgUpload, event);

        // check name
        emptyCheck(event, name, "emptyName");

        // check category
        emptyCheck(event, categoryId, "emptyCategory");

        // check servings
        emptyCheck(event, servings, "emptyServings");

        // check prep time
        emptyTimeCheck(event, prepTimeH, prepTimeM, "prep-time-hours", "prep-time-minutes", "emptyPrepTime");

        // check cook time
        emptyTimeCheck(event, cookTimeH, cookTimeM, "cook-time-hours", "cook-time-minutes", "emptyCookTime");

        // check rating
        emptyCheck(event, rating, "emptyRating");

        // check ingredients
        emptyCheck(event, ingredients, "emptyIngredients");

        // check directions
        emptyCheck(event, directions, "emptyDirections");
    }

    function emptyCheck(event, field, fieldID)
    {
        if (!field)
        {
            event.preventDefault();
            document.getElementById(fieldID).classList.add("form-error");
        }
        else
        {
            document.getElementById(fieldID).classList.remove("form-error");
        }
    }

    function emptyTimeCheck(event, hours, mins, hoursFieldID, minsFieldID, errorFieldID)
    {
        if (hours == "" && mins == "")
        {
            event.preventDefault();
            document.getElementById(errorFieldID).classList.add("form-error");
        }
        else if (hours == "")
        {
            document.getElementById(hoursFieldID).value = 0;
            document.getElementById(errorFieldID).classList.remove("form-error");
        }
        else if (mins == "")
        {
            document.getElementById(minsFieldID).value = 0;
            document.getElementById(errorFieldID).classList.remove("form-error");
        }
    }

    function fileSizeTypeValidation(imgUpload, event)
    {
        let error = false;

        if (imgUpload)
        {
            const allowedFormats = ["image/jpeg", "image/png"];

            if (!allowedFormats.includes(imgUpload.type))
            {
                if(event)
                {
                    event.preventDefault();
                }
                document.getElementById("invalidFormat").classList.add("form-error");
                error = true;
            }
            else
            {
                document.getElementById("invalidFormat").classList.remove("form-error");
            }

            // file size
            if (imgUpload.size > 2097152)
            {
                if(event)
                {
                    event.preventDefault();
                }
                document.getElementById("imgTooBig").classList.add("form-error");
                error = true;
            }
            else
            {
                document.getElementById("imgTooBig").classList.remove("form-error");
            }
        }

        return error === true ? false : true;
    }


    /* --------------------------------------- */
    /*    HANDLE IMAGE UPLOAD CLIENT-SIDE      */
    /* --------------------------------------- */

    const uploadField = document.getElementById('image');

    if (uploadField)
    {
        let uploadTn = document.getElementById('upload-tn');
        let clearButton;

        // event listener for a change in the file input
        uploadField.addEventListener('input', function (event) {

            uploadTn = document.getElementById('upload-tn');
            const file = event.target.files[0];

            if (file)
            {
                // validate - check for errors
                const errorFree = fileSizeTypeValidation(file, event = null);

               if (errorFree)
               {
                   // create file reader object and read the file as a data URL
                   const reader = new FileReader();
                   reader.readAsDataURL(file);

                   // when the file is read successfully, update the img src
                   reader.onload = function (e)
                   {
                       if (uploadTn)
                       {
                           uploadTn.src = e.target.result;
                       }
                       else
                       {
                           // create the img element if it doesn't exist
                           const newImg = document.createElement('img');
                           newImg.id = 'upload-tn';
                           newImg.src = e.target.result;
                           newImg.alt = 'recipe image';
                           uploadField.parentNode.parentNode.insertBefore(newImg, document.getElementById("button-container"));
                           uploadTn = document.getElementById('upload-tn');

                           // create clear file button
                           clearButton = document.createElement('a');
                           clearButton.innerHTML = '<i class="fa-solid fa-x"></i>';
                           clearButton.id = 'clearFileButton';
                           clearButton.classList.add('button-styles', 'clear-button');
                           uploadField.parentNode.appendChild(clearButton);

                           // event listener for the clear button
                           clearButton.addEventListener('click', function () {
                               uploadTn.remove();
                               clearButton.remove();
                               uploadField.value = "";
                           });
                       }
                   };
               }
               else
               {
                   // clear file
                   uploadField.value = "";

                   // clear thumbnail
                   if (uploadTn)
                   {
                        uploadTn.remove();
                        clearButton.remove();
                   }
               }
            }

            // this check is for when a user clicks to select a file and cancels
            if (!uploadField.files.length) {

                // if no file is selected, remove thumbnail
                if (uploadTn) {
                    uploadTn.remove();
                    clearButton.remove();
                }
            }
        });
    }

});
