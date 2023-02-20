/* --------------------------------------- */
/*    Keep active nav tab from moving      */
/*               upon hover                */
/* --------------------------------------- */

// get all tab href links
let pageLinks = document.links;

// cycle through all the tab href links
for (var i = 0; i < pageLinks.length; i++)
{
    // if the tab's href matched the current (active) href, remove hover effects
    if(pageLinks[i].href == window.location.href) {

        // remove moving tab and cursor pointer on hover, and bring tab to the front of the page
        pageLinks[i].parentElement.classList.add("current-tab");
        // remove darker color on hover
        pageLinks[i].parentElement.classList.remove("hover-tab" + i);

    }

}



