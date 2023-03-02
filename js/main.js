/* --------------------------------------- */
/*    Keep active nav tab from moving      */
/*               upon hover                */
/* --------------------------------------- */



// get all tab href links
let pageLinks = document.links;

// variable to check if we are on the home tab (i.e. the "/recipe/" only href)
var home = true;

// cycle through all the tab href links
for (var i = 0; i < pageLinks.length; i++)
{
    // if the tab's href matched the current (active) href, remove hover effects
    if(pageLinks[i].href == window.location.href) {

        // remove moving tab and cursor pointer on hover, and bring tab to the front of the page
        pageLinks[i].parentElement.classList.add("current-tab");
        // remove darker color on hover
        pageLinks[i].parentElement.classList.remove("hover-tab" + i);

        // if any of the if checks return true, then we are not on the "/recipe/" only href
        home = false;
    }
}

// if none of the if checks above return true, then we are on the "/recipe/" only href, and we must target the effects on the home tab
// this is necessary because the for loop above is only checking for the "/recipe/index.php" as the home tab, so we need to perform an additional check for "/recipe/"
if (home === true) {
    // remove moving tab and cursor pointer on hover, and bring tab to the front of the page
    pageLinks[1].parentElement.classList.add("current-tab");
    // remove darker color on hover
    pageLinks[1].parentElement.classList.remove("hover-tab" + 1);
}



