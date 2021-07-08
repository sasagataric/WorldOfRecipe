<?php
include_once '../Classes/RecipeClass.php';
$recipe = new Recipe();
session_start();
include_once "path.php";
if(!isset($_GET['id'])){
    header("Location: ".BASE_URL."/index.php");
    exit();
}else{
    if(!isset($_SESSION['Role'])){
        header("Location: ".BASE_URL."/login.php?message=Please+Login");
    }else
        $id=$_GET['id'];
        $result = $recipe->getRecipeById($id);
        $red=mysqli_fetch_assoc($result);
        $idAutoraRecepta=$red['AuthorId'];
        $image=$red['Image'];
     if($_SESSION['Role']=="admin" || $_SESSION['id']==$idAutoraRecepta){
             
            if(mysqli_num_rows($result)<=0){
                header("Location: my_recipes.php?message=NoFile");
                exit();
            }
            
            if($recipe->deleteRecipe($id)){
                unlink(realpath(ROOT ."/". $image));
                if(isset($_GET['lista'])){
                    header("Location: all_recipes_list.php?message=Successfully deleted+");
                    exit();
                }
                header("Location: my_recipes.php?message=Successfully deleted+"); 
                exit();
            }else{
                  header("Location: my_recipes.php?message=Could+not+delete+your+post"); 
            }
        }
        else{
            header("Location: ".BASE_URL."/index.php?message=You don't have permission to delete this recipe"); 
      }
}



?>