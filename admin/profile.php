<?php
include "path.php";
include '../Classes/AuthorClass.php';
$autor = new Author();
$title='Profil';
session_start();
// $pom se koristi da bi se znalo da li admin menja podatke 
//ili korisnik svoje nako cega treba da se menjaju i njugovi podaci u sesiji
$pom=0;
if(isset($_SESSION['Role'])){
      if($_SESSION['Role'] == "admin"){
          if(isset($_GET['id'])){
            //admin menja necije podatke
            $pom=1;
            $result = $autor->getAuthorById($_GET['id']);
            while($authrow=mysqli_fetch_assoc($result)){
                $id = $authrow['Id'];
                $name = $authrow['Name'];
                $email = $authrow['Email'];
                $biografija = $authrow['Bio'];
                $role=$authrow['Role'];
                $author_img=$authrow['Image'];
            }
          }else{
            $id = $_SESSION['id'];
            $name = $_SESSION['Name'];
            $email = $_SESSION['Email'];
            $biografija = $_SESSION['Bio'];
            $role=$_SESSION['Role'];
            $author_img=$_SESSION['Image'];
          }
        }else{
          $id = $_SESSION['id'];
          $name = $_SESSION['Name'];
          $email = $_SESSION['Email'];
          $biografija = $_SESSION['Bio'];
          $role=$_SESSION['Role'];
          $author_img=$_SESSION['Image'];
      }
    
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
  
  <?php
    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }
  
  if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
    $newPassword = $_POST['newPassword'];
    $newPasswordRepeat =  $_POST['newPasswordRepeat'];
    $sqlQueryWirhPassword='';
    if($newPassword !== '' OR $newPasswordRepeat !== ''){
      if($newPassword === $newPasswordRepeat){
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sqlQueryWirhPassword=" , Password ='".$hash."' ";
      } 
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
        if($fileSize < 3000000){
          $newFileName = uniqid('',true).'.'.$fileExtension;
          $destination = "../Images/Authors/$newFileName";
          $dbdestination = "Images/Authors/$newFileName";
          
          if($autor->editAuthor($id,$name,$email,$sqlQueryWirhPassword,$bio,$dbdestination)){
            move_uploaded_file($fileTmp, $destination);
            unlink(ROOT ."/". $author_img);
            if($pom==0){
              $_SESSION['Name']=$name;
              $_SESSION['Email']=$email;
              $_SESSION['Bio']=$bio;
              $_SESSION['Image']=$dbdestination;
              header("Location: ".BASE_URL."/admin/profile.php?message=Profile successfully edited");
            }else header("Location: ".BASE_URL."/admin/profile.php?message=Profile successfully edited&id="."$id"); 
          }else{
            header("Location: ".BASE_URL."/admin/profile.php?message=Database error!");
            exit();
          }
        } else {
                header("Location: ".BASE_URL."/admin/my_recipes.php?message=The image is larger than 3MB!");
              
          exit();
        }
      }else{
          header("Location: ".BASE_URL."/admin/my_recipes.php?message=Error with image!");
        exit();
      }
    }else{
      header("Location: ".BASE_URL."/admin/my_recipes.php?message=Invalid image type!");
      exit();
        }
      
    } else 
      {
        if($autor->editAuthorWithoutImage($id,$name,$email,$sqlQueryWirhPassword,$bio)){
          if($pom==0){
            $_SESSION['Name']=$name;
            $_SESSION['Email']=$email;
            $_SESSION['Bio']=$bio;
            header("Location: ".BASE_URL."/admin/profile.php?message=Profile successfully edited");
          }else header("Location: ".BASE_URL."/admin/profile.php?message=Profile successfully edited&id="."$id");
        }else{
          header("Location: ".BASE_URL."/admin/profile.php?message=Database error!");
          }
      }   
}
 ?> 

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
      include '../includes/header.php';
      include '../includes/hero.php';
    ?>

   
<div class="container">
<div class="mt-2 row d-flex justify-content-center">
  <div class="col-lg-10">
    <div class="row">
      <div class="col mb-3">
        <div class="card">
        <form class="form"  autocomplete="off" method="POST" name="profile" enctype="multipart/form-data" onsubmit="return validateProfile()" novalidate>
          <div class="card-body">
            <div class="e-profile">
              <div class="row">
                <div class="col-12 col-sm-auto mb-3">
                  <div class="mx-auto" style="width: 140px;">
                    <div class="d-flex justify-content-center align-items-center rounded embed-responsive embed-responsive-4by3" style="height: 140px; background-color: rgb(233, 236, 239);">
                        <img class="img-fluid embed-responsive-item rounded" id="Image" src="<?php echo BASE_URL .'/'. $author_img?>" >
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $name?></h4>
                    <div class="mt-2">
                    <label class="btn btn-primary" >
                        <i class="fa fa-fw fa-camera"></i>
                        Change the image <input type="file" name="file" id="imgInp" hidden >
                    </label>  
                    </div>
                  </div>
                  <div class="text-center text-sm-right" id="role">
                    <span class="badge badge-secondary fs-5"><?php echo $role?></span>
                  </div>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="" class="active nav-link">Profile</a></li>
              </ul>
              <div class="tab-content pt-3">
                <div class="tab-pane active">
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Name</label>
                              <input class="form-control" type="text" name="name" value='<?php echo $name?>'>
                              <span id="imeProvera" style="font-size: 12px; color: red;"></span>
                            </div>
                          </div>
                          
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Email</label>
                              <input  class="form-control" type="text" name="email" value='<?php echo $email?>'>
                              <span id="emailValidate" style="font-size: 12px; color: red;"></span>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label>About you</label>
                              <textarea  class="form-control" rows="5" name="bio" ><?php echo str_replace('\\', '', $biografija)?></textarea>
                              <span id="oVamaProvera" style="font-size: 12px; color: red;"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12  mb-3">
                        <div class="mb-2"><b>Change the password</b></div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>New password</label>
                              <input autocomplete="new-password" type="password" class="form-control" name="newPassword" >
                              <span id="novaSifraProvera" style="font-size: 12px; color: red;"></span>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Confirm <span class="d-none d-xl-inline">password</span></label>
                              <input autocomplete="new-password" type="password" class="form-control" name="newPasswordRepeat">
                              <span id="newPasswordErrorText" style="font-size: 12px; color: red;"></span>
                              </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col d-flex justify-content-center">
                        <button class="btn btn-primary" type="update" name="update" >Save changes</button>
                      </div>
                    </div>
                </div>
              </div>
             </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
    <?php include(ROOT . "/includes/footer.php"); ?> 
    
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
 
    <script src="../js/validate.js"></script>
  
  </body>
</html>
<?php
}else{
    header("Location: ".BASE_URL."/login.php?message=Please+Login");
}
?>  