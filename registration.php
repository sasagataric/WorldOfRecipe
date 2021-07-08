<?php
include_once 'path.php';
include_once 'Classes/AuthorClass.php';
$autor = new Author();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>World Of Recipes</title>
</head>
<body class="bg-white">

<?php 
                
        if(isset($_POST['signup'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $bio =$_POST['bio'];
            $password = $_POST['password'];
            $passwordR = $_POST['passwordR'];
            
            //checking for validity of email
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                header("Location: registration.php?message=Insert valid email");
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
                        $dbdestination = "Images/Authors/$newFileName";
                        
                        //If email exists
                        $result =$autor->getAuthorByEmail($email);
                        if(mysqli_num_rows($result)>0){
                            header("Location: registration.php?message=Email already exists");
                            exit();
                        } else {
                            //hashing password
                            $hash = password_hash($password, PASSWORD_DEFAULT);
                            
                            if($autor->insertAuthor($name,$email,$hash,$bio,$dbdestination)){
                                move_uploaded_file($fileTmp, $dbdestination);
                                header("Location: login.php?message=Successful registration!");
                                exit();
                            }else{
                                header("Location: registration.php?message=Registration error!");
                                exit();
                            }
                        }
                    }else {
                        header("Location: registration.php?message=The image is larger than 3MB!");
                        exit();
                    }
                }else{
                    header("Location: registration.php?message=Error with image!");
                    exit();
                }
            }else{
                header("Location: registration.php?message=Invalid image type!");
                exit();
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
?>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
            
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block "> <img  class="img-fluid embed-responsive-item" src="Images/registre-slika.jpeg" alt="Registre"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create profile!</h1>
                            </div>
                            <form  method="post" enctype="multipart/form-data" name="registration" onsubmit="return validateRegistration();" novalidate>
                                <div class="form-group ">          
                                        <input type="text" class="form-control form-control-user" name="name" id="inputName" placeholder="Name">                                  
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" id="inputEmail" placeholder="Email" >
                                    <span id="emailValidate" style="font-size: 12px; color: red;"></span>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"name="password" id="inputPassword" placeholder="Password">
                                        <span id="passwordcheck" style="font-size: 12px; color: red;"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="passwordR"id="inputRPassword" placeholder="Ponovi password">
                                        <span id="passwordcheckR" style="font-size: 12px; color: red;"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                <textarea class="form-control md-textarea" type="text" id="inputBio" name="bio" rows="4"placeholder="About you" ></textarea>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex ">
                                        <label  class=" col-form-label mr-4">Image</label>
                                        <label class="col-ml-3 btn btn-secondary" >
                                            <i class="fa fa-fw fa-camera"></i>
                                            Add image <input class="form-control-file " type="file" name="file"  id="exampleFormControlFile1"  hidden >
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" name="signup" class="btn btn-success btn-user btn-block">Registre</button>
                                
                                
                            </form>
                          
                            <hr>
                            <div class="text-center">
                                <a href="<?php echo BASE_URL .  "/index.php" ?>" class="btn btn-primary btn-block text-white btn-user">Home</a>
                            </div>
                            <hr>
                            <div class="text-center">
                            <a href="<?php echo BASE_URL .  "/login.php" ?>" class="btn btn-danger btn-block text-white btn-user">Already have an account? Login!</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <script>
    function validateRegistration() {
    let name = document.forms["registration"]["name"].value;
    let email = document.forms["registration"]["email"].value;
    let bio = document.forms["registration"]["bio"].value;
    let password = document.forms["registration"]["password"].value;
    let SifraPotvrdi = document.forms["registration"]["passwordR"].value;
    let file = document.forms["registration"]["file"].value;
    var mailformat = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    if (email === "" || email === null || name === "" || name === null || bio === "" || bio === null || file === "" || file === null || password === "" || password === null || SifraPotvrdi === "" || SifraPotvrdi === null) {
        alert("Fill in all the field");
        return false;
    }
    else if(password != SifraPotvrdi){
            document.getElementById('passwordcheck').innerHTML = 'The passwords do not match';
            document.getElementById('passwordcheckR').innerHTML = 'The passwords do not match';
            return false;
    }else {
            if (email.match(mailformat)) {
                return true;
            }else{
                document.getElementById('emailValidate').innerHTML = 'Invalid email';
                return false;
            } 
    }
}  

    </script>
</body>

</html>