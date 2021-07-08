<?php
include_once 'Classes/RecipeClass.php';
$recipe = new Recipe();
include_once 'Classes/CategoryClass.php';
$kategorija = new Category();
include_once 'Classes/AuthorClass.php';
$autor = new Author();

if(isset($_POST["limit"], $_POST["start"]))
{
 
        if($_POST["idKategorije"]==0){
          $result = $recipe->allRecipesLimit($_POST["start"],$_POST["limit"]);
        }else {
          $result = $recipe->allRecipesLimitByCategoryId($_POST["start"],$_POST["limit"],$_POST["idKategorije"]);
        }
        
        if($result){
        while($red=mysqli_fetch_assoc($result)){
        $id = $red['Id'];
        $title = $red['Title'];
        $authorId = $red['AuthorId'];
        $content = $red['Content'];
        $categoryId = $red['CategoryId'];

        $date = $red['Date'];
        $dt = new DateTime($date);
        $image = $red['Image'];
        
        $autorRezultat = $autor->getAuthorById($authorId);
        while($autorRed=mysqli_fetch_assoc($autorRezultat)){
            $autorName = $autorRed['Name'];
            
        $catResult = $kategorija->getCategorieById($categoryId);
        while($katRed=mysqli_fetch_assoc($catResult)){
        $naziv_kategorije = $katRed['CategoryName'];
            
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
                <p class="mb-0 text-decoration-none ">Author: <span class="font-italic"><?php echo $autorName?></span></p>
                <div class="d-flex justify-content-between">
                  <p class="text-decoration-none">Date: <?php echo $dt->format('d.m.Y.'); ?></p>
                  <p><span class="badge badge-warning fs-5"><?php echo $naziv_kategorije?></span></p>
                </div>
              </div>
            </div>
         
        </article>
<?php } }}}}?>
