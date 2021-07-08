<?php
include "path.php";
include_once '../Classes/RecipeClass.php';
include_once '../Classes/CategoryClass.php';
$recipe = new Recipe();
$kategorija = new Category();
$title='Izmena recepta';
session_start();
if(isset($_SESSION['Role'])){
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>World Of Recipes</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="icon" href="../Images/Logo 4.png">
    <link rel="stylesheet" type="text/css" href="../style/bootstrap.min.css"> 
  </head>
  <body>
    <!-- Ispisivanje greske -->
    <?php
          if(isset($_GET['message'])){
            $msg = $_GET['message'];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            '.$msg.'
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>';
          }
        ?>

    <?php
          $id=$_GET['id'];
          $result = $recipe->getRecipeById($id);
          while($red = mysqli_fetch_assoc($result)){
            $naslov_stari = $red['Title'];
            $sadrzaj_stari = $red['Content'];
            $id_kategorije_stari = $red['CategoryId'];
            $Image_stara = $red['Image'];
          }
        
        ?>

    <?php
      if(isset($_POST['update'])){
				
                $title = $_POST['title'];
                $content = $_POST['sadrzaj'];
                $categoryId = $_POST['categoryId'];
                $authorId = $_SESSION['id'];
                
				if(empty($title) OR empty($content) OR empty($categoryId)){
					header("Location: edit_recipe.php?id="."$id"."&message=Empty fields");
					exit();
        }
        if(is_uploaded_file($_FILES['file']['tmp_name'])) 
        {
            $file = $_FILES['file'];
            $fileName = $file['name'];
            $fileType = $file['type'];
            $fileTmp = $file['tmp_name'];
            $fileErr = $file['error'];
            $fileSize = $file['size'];
            $fileEXT = explode('.',$fileName);
            $fileExtension = strtolower(end($fileEXT));
            $allowedExt = array("jpg", "jpeg", "png", "gif");
            
            if(in_array($fileExtension, $allowedExt)){
              if($fileErr === 0){
                if($fileSize < 2000000){
                  $newFileName = uniqid('',true).'.'.$fileExtension;
                  $destination = "../Images/Recipes/$newFileName";
                  $dbdestination = "Images/Recipes/$newFileName";
                  

                  if($recipe->editRecipe($id,$title,$content,$categoryId,$dbdestination)){
                    move_uploaded_file($fileTmp, $destination);
                    unlink(ROOT ."/". $Image_stara);
                          header("Location: ".BASE_URL."/admin/my_recipes.php?message=Recipe successfully edited");
                            
                  }else{
                    header("Location: ".BASE_URL."/admin/my_recipes.php?message=Database error!");
                          
                  }
                } else {
                        header("Location: ".BASE_URL."/admin/edit_recipe.php?id="."$id"."&message=The image is larger than 3MB!");
                      
                  exit();
                }
              }else{
                  header("Location: ".BASE_URL."/admin/edit_recipe.php?id="."$id"."&message=Error with image!");
                exit();
              }
            }else{
              header("Location: ".BASE_URL."/admin/edit_recipe.php?id="."$id"."&message=Invalid image type!");
              exit();
                }
            
          } else 
            {
                if($recipe->editRecipeWithoutImage($id,$title,$content,$categoryId)){
                header("Location: ".BASE_URL."/admin/my_recipes.php?message=Recipe successfully edited");
                }else{
                  header("Location: ".BASE_URL."/admin/edit_recipe.php?id="."$id"."&message=Database error!");
              }
              
              }
  }
       ?> 
  <?php
  include '../includes/header.php';
  include '../includes/hero.php';
  ?>
  
    <main class="content bg-light container py-3">
      <div class="row justify-content-center">
        <form class="col-md-8" name="recipe" onsubmit="return validateEditPost()"   method="POST" enctype="multipart/form-data">
                <div class="form-group row justify-content-center">
                        <div class="col-md-5 col-form-label d-flex  embed-responsive embed-responsive-4by3">
                        <img class="img-fluid embed-responsive-item rounded" id="Image" src="<?php echo BASE_URL .'/'. $Image_stara?>" >
                        </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label ">Naziv</label>
                    <div class="col-md-10">
                         <input class="form-control" type="text" id="title" name="title" value="<?php echo $naslov_stari ?>">
                     </div>
                </div>   

                <div class="form-group row">
                
                    <label for="name" class="col-md-2 col-form-label " >Category</label>
                    <div class="col-md-10">
                        <select class="form-control " type="text" name="categoryId" id="kategorija" >
                        <?php
                            
                            $result = $kategorija->allCategories();
                            while($red=mysqli_fetch_assoc($result)){
                              $id = $red['Id'];
                              $naziv_kategorije = $red['CategoryName'];
                              if($id==$id_kategorije_stari){
                              ?>
                              <option selected value="<?php echo $id; ?>"><?php echo $naziv_kategorije; ?></option>
                            <?php
                            }else{
                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $naziv_kategorije; ?></option>
                            <?php }}?>
                        </select> 
                     </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label ">Content</label>
                    <div class="col-md-10">
                        <textarea class="form-control md-textarea" type="text" id="tinyeditor" name="sadrzaj" rows="5" ><?php echo $sadrzaj_stari ?></textarea>
                     </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label ">Image</label>
                    <div class="col-md-10  ">
                    <label class="btn btn-secondary" >
                        <i class="fa fa-fw fa-camera"></i>
                        Change the image <input type="file" name="file" id="imgInp" hidden >
                    </label> 
                     </div>
                </div>
                
                <div class="form-group row ">
                    <div class="col-md-12 d-flex justify-content-center">
                      <button type="update" name="update" class="btn btn-primary">Edit</button>
                    </div>
                  </div>

            
          </form>
          
      </div>

       

     
    </main>

    <?php include(ROOT . "/includes/footer.php"); ?> 

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
 

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea', height : 300});</script>
    <script src="../js/validate.js"></script>
    
  </body>
</html>
<?php
}else{
    header("Location: ".BASE_URL."/login.php?message=Please+Login");
}
?>  