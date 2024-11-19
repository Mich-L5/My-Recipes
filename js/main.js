
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

/* --------------------------------------- */
/*         REMOVE LOADING SCREEN           */
/* --------------------------------------- */
window.addEventListener('load', function () {
    const loadingScreen = document.getElementById('loading-screen');

    if (loadingScreen) {
        loadingScreen.style.display = 'none';
    }
});


document.addEventListener("DOMContentLoaded",(loaded) => {

    /* --------------------------------------- */
    /*      CONFIRM DELETE POPUP FUNCTION      */
    /* --------------------------------------- */

    const recipeDeleteButton = document.getElementById("delete-button");

    if (recipeDeleteButton)
    {
        recipeDeleteButton.addEventListener('click', function () {

            const deletePopupOverlay = document.getElementById('delete-popup-overlay');

            // show the delete confirmation popup
            deletePopupOverlay.classList.remove('hidden');
            const deleteCancelButton = document.getElementById('delete-popup-cancel');

            deleteCancelButton.addEventListener('click', function() {
                deletePopupOverlay.classList.add('hidden');
            });

            deletePopupOverlay.addEventListener('click', function() {
                deletePopupOverlay.classList.add('hidden');
            });


        });
    }

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

            // Create a new input field with a trash button
            const newField = document.createElement('div');
            newField.innerHTML = `
            <input type="text" name="${nameAttribute}[]" class="${inputClass}" />
            <button type="button" class="remove-field-btn round-button button-styles inline-button">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#454545"><path d="M304.62-160q-26.66 0-45.64-18.98T240-224.62V-720h-20q-8.5 0-14.25-5.76T200-740.03q0-8.51 5.75-14.24T220-760h140q0-12.38 9.19-21.58 9.19-9.19 21.58-9.19h178.46q12.39 0 21.58 9.19Q600-772.38 600-760h140q8.5 0 14.25 5.76t5.75 14.27q0 8.51-5.75 14.24T740-720h-20v495.38q0 26.66-18.98 45.64T655.38-160H304.62ZM680-720H280v495.38q0 10.77 6.92 17.7 6.93 6.92 17.7 6.92h350.76q10.77 0 17.7-6.92 6.92-6.93 6.92-17.7V-720ZM412.33-280q8.52 0 14.25-5.75t5.73-14.25v-320q0-8.5-5.76-14.25T412.28-640q-8.51 0-14.24 5.75T392.31-620v320q0 8.5 5.76 14.25 5.75 5.75 14.26 5.75Zm135.39 0q8.51 0 14.24-5.75t5.73-14.25v-320q0-8.5-5.76-14.25-5.75-5.75-14.26-5.75-8.52 0-14.25 5.75T527.69-620v320q0 8.5 5.76 14.25t14.27 5.75ZM280-720v520-520Z"/></svg>
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
                           clearButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#454545"><path d="M480-451.69 270.15-241.85q-5.61 5.62-13.77 6-8.15.39-14.53-6-6.39-6.38-6.39-14.15 0-7.77 6.39-14.15L451.69-480 241.85-689.85q-5.62-5.61-6-13.77-.39-8.15 6-14.53 6.38-6.39 14.15-6.39 7.77 0 14.15 6.39L480-508.31l209.85-209.84q5.61-5.62 13.77-6 8.15-.39 14.53 6 6.39 6.38 6.39 14.15 0 7.77-6.39 14.15L508.31-480l209.84 209.85q5.62 5.61 6 13.77.39 8.15-6 14.53-6.38 6.39-14.15 6.39-7.77 0-14.15-6.39L480-451.69Z"/></svg>';
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

        // if the previous image in the hidden field exists, set the value as placeholder
        const prevImg = document.getElementById("previous-image");
        if (prevImg) {
            prevImg.value = "placeholder";
        }
    }

});
