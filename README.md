# Recipe Book

<picture>
  <img alt="Developer badge" src="https://img.shields.io/badge/Developer-Mich--L5-9fdfdf?logo=github&logoColor=white">
</picture>
<picture>
  <img alt="Designer badge" src="https://img.shields.io/badge/Designer-Mich--L5-fdf45d?logo=github&logoColor=white">
</picture>

![recipe book preview](https://github.com/user-attachments/assets/95d22405-652c-4124-b1d9-26abb537cd0b)

<br>
<br>

## About

Recipe Book is a PHP web application that simulates a physical recipe book. Users can add, edit, delete, and view recipes organized by category.

## Live site

This live site can be accessed [here](https://mediumvioletred-caribou-677915.hostingersite.com/).

## Technologies

<picture>
  <img alt="HTML badge" src="https://img.shields.io/badge/HTML-fdf45d">
</picture>
<picture>
  <img alt="CSS badge" src="https://img.shields.io/badge/CSS-fdf45d">
</picture>
<picture>
  <img alt="JS badge" src="https://img.shields.io/badge/JavaScript-fdf45d">
</picture>
<picture>
  <img alt="PHP badge" src="https://img.shields.io/badge/PHP-fdf45d">
</picture>
<picture>
  <img alt="MySQL badge" src="https://img.shields.io/badge/MySQL-fdf45d">
</picture>

## How to use
### Open the app

Click [here](https://mediumvioletred-caribou-677915.hostingersite.com/) to open the app.

### Add a new recipe

Click on the <picture>
  <img alt="Add New! tab" src="https://img.shields.io/badge/Add_New!-8fddd1">
</picture> tab.

Fill out the recipe fields.

<img width="650" alt="Screenshot of the Add New Recipe page" src="https://github.com/user-attachments/assets/ae94ffcd-b118-42af-8b66-6ac622cc454d" />

<br>
<br>

Click
<picture>
  <img alt="Save button" src="https://img.shields.io/badge/Save-8fddd1">
</picture> .

### Find/browse recipes

Choose a category tab (<img alt="Apps tab" src="https://img.shields.io/badge/Apps-F5D4FA">, <img alt="Mains tab" src="https://img.shields.io/badge/Mains-93D6FB">, <img alt="Sides tab" src="https://img.shields.io/badge/Sides-CEFC92">, <img alt="Desserts tab" src="https://img.shields.io/badge/Desserts-F6FD70">, <img alt="Drinks tab" src="https://img.shields.io/badge/Drinks-F5BC8C">, <img alt="Sauces tab" src="https://img.shields.io/badge/Sauces-F4B8CE">)

<img width="650" alt="Screenshot of the category tabs" src="https://github.com/user-attachments/assets/dfbb74da-4eb9-4981-ab92-04e9030abfdc" />

<br>
<br>

Scroll to view all the recipes in the category. Additionally, you can click on any of the column headers (Recipe, Total time, Rating) to sort the recipes by column.

<img width="650" alt="Screenshot of the Mains page with three recipes" src="https://github.com/user-attachments/assets/45b4187c-03a2-4221-9d6b-4f2e9cfa840e" />

<br>
<br>

Click on a recipe to view the recipe details.

<img width="650" alt="Screenshot of a mac & cheese recipe" src="https://github.com/user-attachments/assets/799c5386-cbbc-4d38-9f36-c588e05143c8" />

<br>
<br>

### Edit a recipe

Once on the recipe page (see Find/browse recipes to view a recipe page), click the 
pencil in the top right of the recipe page. 

Make modifications to the recipe information.

Click
<picture>
  <img alt="Save button" src="https://img.shields.io/badge/Save-9fdfdf">
</picture> .

### Delete a recipe

Once on the recipe page (see Find/browse recipes to view a recipe page), click the 
trash can in the top right of the recipe page. 

## Features
### Desktop, tablet, and mobile responsive
The app is responsive across all three platforms (mobile, tablet, and desktop).
![Watermelon juice recipe page in three sizes: mobile, tablet, and desktop](https://github.com/user-attachments/assets/b8f20419-fd93-4d37-bade-c19111866053)

### Loading screen
A loading screen with a spinning lemon icon appears on the index page while the DOM is rendering.
<br>
<br>
<img width="650" alt="Screenshot of the loading screen" src="https://github.com/user-attachments/assets/a94732ec-c7ff-4268-94b0-1dc72f2e117c" />

### Formatting (ingredients and directions)
Recipe ingredients automatically get formatted in a bullet point list, and recipe directions automatically get formatted in a numbered list.

<img width="800" alt="Screenshot of recipe ingredients and directions in edit mode and read mode" src="https://github.com/user-attachments/assets/c1b00def-cafb-4e52-9104-8fa12d061360" />

### Confirm delete prompt
When the delete button on a recipe is clicked, a popup window appears to confirm the deletion.

<img width="400" alt="Screenshot of the confirm delete prompt" src="https://github.com/user-attachments/assets/4eba600f-96a5-4b36-bc02-375e4eb9d204" />

### Dynamic photo upload preview
When a recipe photo is uploaded/erased, the photo preview is dynamically updated.

<img width="400" alt="Screenshot of the upload photo section in the receipe form" src="https://github.com/user-attachments/assets/3e3b278a-328e-4c01-a6d5-7b917cf3094e" />

### Placeholder image
If no image is uploaded for a recipe, a placeholder image is used for the recipe.

<img width="650" alt="Screenshot of a cheese pizza recipe with a placeholder image" src="https://github.com/user-attachments/assets/8f7ce0ac-aced-42ce-9a45-efc5118c570c" />

### Form error feedback
If the form contains errors or is missing values, the user receives detailed feedback before the form is submitted. Error checking on the backend is also performed.

<img width="450" alt="Screenshot of a recipe form with errors" src="https://github.com/user-attachments/assets/97e0a3e3-10b5-41d5-86b6-035696e660a3" />

### Categorization
Recipes are categorized by type of dish (app, main, side, dessert, drink or sauce). When a new recipe is added, it gets added to its respective category page, and can easily be retrieved by accessing its category tab.

<img width="250" alt="Categories drop down select menu" src="https://github.com/user-attachments/assets/4b09cbf8-e0bd-444e-8219-b5716c1a0026" />

### Recipe sorting
In addition to recipe categorization, recipes can be further sorted by alphabetical order, total time, and rating score, by clicking on the respective column heading.

### Recipe total time calculation
The recipe total time is automatically calculated based on its prep time and cook time. The total time gets displayed in the recipe list, and can be used as a sorting parameter.


