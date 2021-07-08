<?php
$title='Explore a world full of recipes';
include_once 'path.php';

include 'Classes/CategoryClass.php';
include 'Classes/RecipeClass.php';
include 'Classes/AuthorClass.php';
$kategorija = new Category();
$recipe = new Recipe();
$autor = new Author();
session_start();
if(!isset($_GET['pretraga'])){
    header("Location: index.php");
    exit();
}else{
    $pretraga = $_GET['pretraga'];
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

        
   <main class="content bg-light container py-4">

    <section class="row">
    <?php
        $result = $recipe->searchRecipes($pretraga);
        if(mysqli_num_rows($result)<=0){
            echo '
            <div class=" col-md-12 my-5 "></div><div class=" col-md-12 my-5 "></div>
            <div class=" col-md-12 py-4 d-flex justify-content-center ">
            <div class="col-md-4 alert alert-warning alert-dismissible fade show text-center px-3 fs-3" role="alert">
                        Nema recepata iz pretrage
            </div> </div>
            <div class=" col-md-12 my-5 "></div>
            <div class=" col-md-12 my-5 "></div>'; 
        }else{
        while($red=mysqli_fetch_assoc($result)){
        $id = $red['Id'];
        $title = $red['Title'];
        $authorId = $red['AuthorId'];
        $content = $red['Content'];
        $categoryId = $red['CategoryId'];
        $date = $red['Date'];
        $dt = new DateTime($date);
        $image = $red['Image'];

        $authresult = $autor->getAuthorById($authorId);
        while($authrow=mysqli_fetch_assoc($authresult)){
        $name_autora = $authrow['Name'];
        
        $catResult = $kategorija->getCategorieById($categoryId);
        while($catrow=mysqli_fetch_assoc($catResult)){
        $naziv_kategorije = $catrow['CategoryName'];
          
      ?>

      <article name="article" class="col-md-4  p-0">
        <a class="text-dark " href="recipe.php?id=<?php echo $id; ?>">
          <div class="m-2 shadow">
            <!-- embed-responsive-4by3 je koristen da bi sve slike ubek bile iste visine -->
            <div class="embed-responsive embed-responsive-4by3">
              <img  class="img-fluid embed-responsive-item" src="<?php echo $image?>" alt="<?php echo $title?>">
            </div>
            
            <div class="article-content px-2 py-1 ">
              <h2 class="fs-3 font-weight-bold mb-1 "><?php echo $title?></h2>
              </a>
              <p class="mb-0 text-decoration-none ">Author: <span class="font-italic"><?php echo $name_autora?></span></p>
              <div class="d-flex justify-content-between">
                <p class="text-decoration-none">Date: <?php echo $dt->format('d.m.Y.'); ?></p>
                <p><span class="badge badge-warning fs-5"><?php echo $naziv_kategorije?></span></p>
              </div>
            </div>
          </div>
       
      </article>
      <?php } }}}?>
    </section>
    </main>

    <?php include 'includes/footer.php'; ?> 

	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
	</body>
</html>
<?php
}
?>