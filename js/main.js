/* --------------------------------------- */
/*    Keep active nav tab from moving      */
/*               upon hover                */
/* --------------------------------------- */

// get all tab href links
let pageLinks = document.links;

// cycle through all the tab href links
for (var i = 0; i < pageLinks.length; i++)
{
    // if the tab's href matched the current (active) href, remove hover effect
    if(pageLinks[i].href == window.location.href) {

        pageLinks[i].parentElement.classList.add("current-tab");
    }

}



