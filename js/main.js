
/* --------------------------------------- */
/*           POPUP FUNCTIONALITY           */
/* --------------------------------------- */
function displayPopup({ title, message, onClose }) {
    const popupOverlay = document.getElementById('generic-popup-overlay');
    const popupTitle = document.getElementById('popup-title');
    const popupMessage = document.getElementById('popup-message');
    const okButton = document.getElementById('popup-ok-button');

    // set content
    popupTitle.textContent = title;
    popupMessage.textContent = message;

    // show the popup
    popupOverlay.classList.remove('hidden');

    // close the popup
    function closePopup() {
        popupOverlay.classList.add('hidden');
    }

    // attach event listeners to button and overlay to close the popup upon click
    okButton.addEventListener('click', closePopup);
    popupOverlay.addEventListener('click', (e) => {
        if (e.target === popupOverlay) {
            closePopup();
        }
    });

    // remove listeners after the popup is closed to avoid duplication
    popupOverlay.addEventListener('transitionend', () => {
        okButton.removeEventListener('click', closePopup);
        popupOverlay.removeEventListener('click', closePopup);
    });
}

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
    displayPopup({
        title: "NOTE:",
        message: "This recipe is a demo recipe and cannot be deleted. To try the delete functionality, please add a new recipe and try again.",
        onClose: () => console.log("Popup closed")
    });
}

/* --------------------------------------- */
/*     UNABLE TO EDIT POPUP FUNCTION       */
/* --------------------------------------- */

function unableToEdit() {
    displayPopup({
        title: "NOTE:",
        message: "This recipe is a demo recipe and cannot be edited. To try the edit functionality, please add a new recipe and try again.",
        onClose: () => console.log("Popup closed")
    });
}

/* --------------------------------------- */
/*             DEMO MODE POPUP             */
/* --------------------------------------- */
function displayWelcomeAlert() {
    displayPopup({
        title: "WELCOME!",
        message: "Welcome to the Recipe Book app! You are currently in demo mode. Feel free to try the app by adding new recipes!",
        onClose: () => console.log("Popup closed")
    });
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
    /*        ADD FIELDS FUNCTIONALITY         */
    /* --------------------------------------- */

    function addFields(addButtonId, containerId, inputClass, nameAttribute) {

        document.getElementById(addButtonId).addEventListener('click', function () {
            const container = document.getElementById(containerId);

            // Create a new input field with an "X" button
            const newField = document.createElement('div');
            newField.innerHTML = `
            <input type="text" name="${nameAttribute}[]" class="${inputClass}" />
            <button type="button" class="remove-field-btn round-button button-styles inline-button">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        `;

            // Add the new field to the container
            container.appendChild(newField);

            // Attach event listener to the "X" button to remove the field
            newField.querySelector('.remove-field-btn').addEventListener('click', function () {
                container.removeChild(newField);
            });
        });
    }

    if (document.getElementById("add-ingredient-button"))
    {
        addFields('add-ingredient-button', 'ingredient-container', 'ingredient-input', 'ingredient');
        addFields('add-direction-button', 'direction-container', 'direction-input', 'direction');
    }

    /* --------------------------------------- */
    /*  COMBINE FIELDS INTO A SINGLE STRING    */
    /* --------------------------------------- */

    function combineFields(formId, inputClass, hiddenInputId) {
        document.getElementById(formId).addEventListener('submit', function () {
            const values = [];
            const inputs = document.querySelectorAll(`.${inputClass}`);

            // Collect values from each input field and ignore empty ones
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    values.push(input.value.trim());
                }
            });

            // Convert the array to a string with delimiter
            const combinedString = values.join('#**@$seperator^+><%');

            // Set the hidden input field with the combined string
            document.getElementById(hiddenInputId).value = combinedString;
        });
    }

    if (document.getElementById("add-ingredient-button"))
    {
        combineFields('form', 'ingredient-input', 'ingredients');
        combineFields('form', 'direction-input', 'directions');
    }

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

        // assign event listener to clear button if it already exists on the page
        if (document.getElementById("clearFileButton"))
        {
            clearButton = document.getElementById("clearFileButton");

            clearButton.addEventListener('click', function() {
                clearFile(uploadTn, clearButton);
            });
        }

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
                           clearButton.classList.add('button-styles', 'round-button', 'clear-button');
                           uploadField.parentNode.appendChild(clearButton);

                           // event listener for the clear button
                           clearButton.addEventListener('click', function() {
                               clearFile(uploadTn, clearButton);
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

    function clearFile(uploadThumbnail, clearBtn)
    {
        uploadThumbnail.remove();
        clearBtn.remove();
        uploadField.value = "";
    }

});
