<?php
require_once 'path.php';
include_once '../Classes/CategoryClass.php';
include_once '../Classes/RecipeClass.php';
include_once '../Classes/AuthorClass.php';
$recipe = new Recipe();
$kategorija = new Category();
$autor = new Author();
session_start();

if(isset($_POST["limit"], $_POST["start"],$_POST["session"]))
{
        $result = $recipe->allRecipesLimitByAuthorId($_POST["start"],$_POST["limit"],$_POST["session"]);
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
        
        $authresult = $autor->getAuthorById($authorId);
        while($authrow=mysqli_fetch_assoc($authresult)){
            $id_autora_name = $authrow['Name'];
        
        $catResult = $kategorija->getCategorieById($categoryId);
        while($catrow=mysqli_fetch_assoc($catResult)){
        $naziv_kategorije = $catrow['CategoryName'];
            
    ?>

        <article class="col-md-4  p-0">
          <a class="text-dark " href="<?php echo BASE_URL ."/recipe.php?id=" . $id; ?>">
            <div class="m-2 shadow">
              <!-- embed-responsive-4by3 je koristen da bi sve slike ubek bile iste visine -->
              <div class="embed-responsive embed-responsive-4by3">
                <img  class="img-fluid embed-responsive-item" src="<?php echo BASE_URL .'/'. $image?>" alt="<?php echo $title?>">
              </div>
              
              <div class="article-content px-2 py-1 ">
                <h2 class="fs-3 font-weight-bold mb-1 "><?php echo $title?></h2>
                </a>
                <p class="mb-0 text-decoration-none">Author: <?php echo $id_autora_name?></p>
                <div class="d-flex justify-content-between">
                <p><span class="font-italic">Date: </span><?php echo $dt->format('d.m.Y.'); ?></p>
                  <p><span class="badge badge-warning fs-5"><?php echo $naziv_kategorije?></span></p>
                </div>
                <div class="d-flex justify-content-start my-0">
                <a href="edit_recipe.php?id=<?php echo $id;?>"><button class="btn btn-primary btn-lg fs-5 mr-2">Edit</button></a>
                <a onclick="return confirm('Are You sure');" href="delete_recipe.php?id=<?php echo $id;?>"><button class="btn btn-danger btn-lg fs-5">Delete</button></a>
                </div>
              </div>
            </div>
        </article>
<?php } }}}}?>