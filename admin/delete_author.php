<?php
include_once '../Classes/AuthorClass.php';
$autor = new Author();
session_start();
include_once "path.php";
if(!isset($_GET['id'])){
    header("Location: ".BASE_URL."/index.php");
    exit();
}else{
    if(!isset($_SESSION['Role'])){
        header("Location: ".BASE_URL."/login.php?message=Please+Login");
    }else
        

     if($_SESSION['Role']=="admin" || $_SESSION['id']==$_GET['id']){
             $id = $_GET['id'];
            $result = $autor->getAuthorById($id);
            $red=mysqli_fetch_assoc($result);
            $image=$red['Image'];
            if(mysqli_num_rows($result)<=0){
                header("Location: all_authors.php?message=There is no author with the given id");
                exit();
            }

            if($autor->deleteAuthor($id)){
                unlink(ROOT ."/". $image);
                if( $_SESSION['id']==$_GET['id']){
                    header("Location: ../logout.php"); 
                    exit();
                }
                header("Location: all_authors.php?message=Successfully deleted"); 
                exit();
            }else{
                  header("Location: all_authors.php?message=Unable to delete"); 
            }
        }else{
            header("Location: ".BASE_URL."/index.php?message=You don't have permission to delete this author"); 
        }
}

?>