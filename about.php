<?php
   $title='About us';
   include_once 'path.php';
   session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>World Of Recipes</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="Images/Logo 4.png">
    <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css"> 
  </head>
  <body>
  <?php
  include 'includes/header.php';
  ?>
  
  <?php include 'includes/hero.php'; ?> 

    <main class="content bg-light container py-3">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="m-3">
            <h2 class="text-warning">World Of Recipes</h2>
            <p>This is a site where you can find a variety of recipes that will introduce you to the magic world of cooking. You can also try yourself as an author and share your recipes with other users. Cooking is not only an obligation, cooking is also a pleasure!</p>
          </div>
        </div>
        
        <div class="col-lg-6 p-4">
          <img src="Images/Recepti.jpg" alt="" class="img-fluid">
        </div>
      </div>

      
    </main>

    <?php include 'includes/footer.php'; ?> 
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>
