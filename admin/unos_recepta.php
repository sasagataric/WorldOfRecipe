<?php
include "path.php";
include_once '../Classes/CategoryClass.php';
include_once '../Classes/RecipeClass.php';
$recipe = new Recipe();
$kategorija = new Category();
$title='Add recipe';
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
    <!-- Upisivanje u bazu -->
    <?php
      if(isset($_POST['submit'])){
				
				$title = $_POST['title'];
        $content =$_POST['sadrzaj'];
        $categoryId = $_POST['categoryId'];
        $authorId = $_SESSION['id'];
                
				if(empty($title) OR empty($content) OR empty($categoryId)){
					header("Location: unos_recepta.php?message=Empty field");
					exit();
        }else{
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
                    if($fileSize < 3000000){
                      $newFileName = uniqid('',true).'.'.$fileExtension;
                      $destination = "../Images/Recipes/$newFileName";
                      $dbdestination = "Images/Recipes/$newFileName";
                     
                      if($recipe->insertRecipes($title,$content,$categoryId,$authorId,$dbdestination)){
                        move_uploaded_file($fileTmp, $destination);
                        header("Location: ".BASE_URL."/index.php?message=Recipe successfully inserted");
                      }else{
                        header("Location: unos_recepta.php?message=Database error!");
                      }
                    } else {
                      header("Location: unos_recepta.php?message=The image is larger than 3MB!");
                      exit();
                    }
                  }else{
                    header("Location: unos_recepta.php?message=Error with image!");
                    exit();
                  }
                }else{
                  header("Location: unos_recepta.php?message=Invalid image type!");
                  exit();
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
        <form class="col-md-8" name="recipe" onsubmit="return validatePost()" novalidate  method="POST" enctype="multipart/form-data">
          <div class="  form-group row justify-content-center">
                  <div id="imageDiv" style="display: none !important;"class=" col-sm-5 col-form-label d-flex  embed-responsive embed-responsive-4by3">
                  <img class="img-fluid embed-responsive-item rounded" id="Image"  src="" alt="Prikaz recepta">
                  </div>
          </div>

          <div class="form-group row">
              <label for="name" class="col-md-2 col-form-label ">Naziv</label>
              <div class="col-md-10">
                    <input class="form-control" type="text" id="title" name="title" >
                </div>
          </div>   

          <div class="form-group row">
              <label for="name" class="col-md-2 col-form-label ">Category</label>
              <div class="col-md-10">
                  <select class="form-control " type="text" name="categoryId" id="kategorija">
                  <?php
                      $result = $kategorija->allCategories();
                      while($red=mysqli_fetch_assoc($result)){
                        $id = $red['Id'];
                        $naziv_kategorije = $red['CategoryName'];
                        ?>
                        <option value="<?php echo $id; ?>"><?php echo $naziv_kategorije; ?></option>
                      <?php
                      }
                      ?>
                  </select> 
                </div>
          </div>

          <div class="form-group row">
              <label for="name" class="col-md-2 col-form-label ">Content</label>
              <div class="col-md-10">
                  <textarea class="form-control md-textarea" type="text" id="tinyeditor" name="sadrzaj" rows="4" ></textarea>
                </div>
          </div>

          <div class="form-group row">
              <label for="name" class="col-2 col-form-label ">Image</label>
              <div>
              <label class="col ml-3 btn btn-secondary" >
                  <i class="fa fa-fw fa-camera"></i>
                  Add image <input type="file" name="file" id="imgInp" hidden >
              </label> 
              </div>
          </div>
          
          <div class="form-group row ">
            <div class="col-md-12 d-flex justify-content-center">
              <button type="submit" name="submit" class="btn btn-primary">Insert</button>
            </div>
          </div>
        </form>
      </div>     
    </main>
    <?php include(ROOT . "/includes/footer.php"); ?> 

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
 
    <script src="../js/validate.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea', height : 300});</script>

  </body>
</html>
<?php
}else{
    header("Location: ".BASE_URL."/login.php?message=Please+Login");
}
?>  