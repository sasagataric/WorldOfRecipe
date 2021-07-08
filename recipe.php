<?php
   $title='Explore a world full of recipes';
   include_once 'path.php';
   include_once 'Classes/CategoryClass.php';
   include_once 'Classes/AuthorClass.php';
   include_once 'Classes/RecipeClass.php';
   $recipe = new Recipe();
   $autor = new Author();
   $kategorija = new Category();
   session_start();
  if(!isset($_GET['id'])){
    header("Location: index.php");
}else{
    $id = $_GET['id'];
    if(!is_numeric($id)){
      header("Location: index.php");
        exit;
    }else if(is_numeric($id)){
        $result = $recipe->getRecipeById($id);
        if(mysqli_num_rows($result)<=0){
       header("Location: index.php"); 
        }else if(mysqli_num_rows($result)>0){
            while($red = mysqli_fetch_assoc($result)){
              $id = $red['Id'];
              $title = $red['Title'];
              $authorId = $red['AuthorId'];
              $content = $red['Content'];
              $categoryId = $red['CategoryId'];
              $date = $red['Date'];
              $dt = new DateTime($date);

              $image = $red['Image'];
              if(mysqli_num_rows($result) == 1){
                $setInTheCenter='d-flex justify-content-center';
              }else $setInTheCenter='';

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
  include 'includes/hero.php';
  ?>

    <main class="content bg-light container py-3">
      <div class="row <?php echo $setInTheCenter?>">
    <?php
        $autorRezultat = $autor->getAuthorById($authorId);
        while($authrow=mysqli_fetch_assoc($autorRezultat)){
          $authorName = $authrow['Name'];
          $authorBio = $authrow['Bio'];
          $authorImg = $authrow['Image'];
            
          $catResult = $kategorija->getCategorieById($categoryId);
          while($catrow=mysqli_fetch_assoc($catResult)){
          $categoryName = $catrow['CategoryName'];
            
    ?>
        <article class="col-md-8 px-4">
          <div class="m-2 shadow">
            <div class="embed-responsive embed-responsive-4by3">
              <img  class="img-fluid embed-responsive-item" src="<?php echo $image; ?>" alt="Biftek">
            </div>
            <div class="p-2 text-justify ">
              <div class="badges mb-1 d-flex justify-content-between">
              <h3><?php echo $title; ?></h3>
                <a href="<?php echo BASE_URL . "/index.php?category=". $categoryId ."#jump"?>" class="badge text-white badge-warning ml-0 mr-2 my-2 fs-5 p-1 "><?php echo $categoryName; ?></a>

              </div>
              
              <p class=" mb-0">Author: <span class="font-italic"><?php echo $authorName?></span></p>
              <p><span class="font-italic">Date: </span><?php echo $dt->format('d.m.Y.'); ?></p>

              <p><?php echo $content ?> </p>
            </div>
            
            <div class="p-3 bg-warning text-justify text-white rounded">
              <div class="row">
                <div class="col-md-3 text-center ">
                  <img class="img-fluid rounded-circle" src="<?php echo $authorImg; ?>" alt="Kosrisnik">
                </div>
                <div class="col-md-9 pl-0 ">
                  <h3 class="m-0 "><?php echo $authorName?></h3>
                  <p><?php echo $authorBio?></p>
                </div>
              </div>
            </div>
            
          </div>

        </article>
        <?php } }?>
        <aside class="col-md-4 px-0">
        <?php
        
        $rezultat_aside =$recipe->getRandomRecipes($id,3);
        if(mysqli_num_rows($rezultat_aside) != 0){
        while($red_aside=mysqli_fetch_assoc($rezultat_aside)){
        $id_aside = $red_aside['Id'];
        $title_aside = $red_aside['Title'];
        $authorId_aside = $red_aside['AuthorId'];
        $categoryId_aside = $red_aside['CategoryId'];
        $image_aside = $red_aside['Image'];
        
        $authorResult_aside = $autor->getAuthorById($authorId_aside);;
        while($red_aside=mysqli_fetch_assoc($authorResult_aside)){
        $nameAutora_aside = $red_aside['Name'];
            
        $catResult_aside = $kategorija->getCategorieById($categoryId_aside);  
        while($catrow_aside=mysqli_fetch_assoc($catResult_aside)){
        $categoriName_aside = $catrow_aside['CategoryName'];
            
    ?>

        <a class="text-dark" href="recipe.php?id=<?php echo $id_aside; ?>">
          <article class="w-100  p-0 my-2 mb-3">
            <div class="m-0 shadow">
              <div class="embed-responsive embed-responsive-4by3">
                <img  class="img-fluid embed-responsive-item" src="<?php echo $image_aside?>" alt="<?php echo $title_aside?>">
              </div>
           
              <div class="article-content px-2 py-1">
                <h2 class="fs-3 font-weight-bold mb-1"><?php echo $title_aside?></h2> </a>
                <div class="d-flex justify-content-between">
                <p class="mb-0">Author: <?php echo $nameAutora_aside?></p>
                  <p><span class="badge text-white badge-warning fs-5"><?php echo $categoriName_aside?></span></p>
                </div>
              </div>
            </div>
           
          </article>
          
          <?php } } } }?>
        </aside>

      </div>

      
    </main>

    <?php include 'includes/footer.php'; ?> 
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>

      <?php

       }
    }
  }
}

?>