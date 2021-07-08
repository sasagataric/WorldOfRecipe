<?php
 session_start();
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
        <title>World Of Recipes</title>
    </head>

    <body >
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
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block" ><img  class="img-fluid embed-responsive-item" src="Images/loginslika.jpeg" alt="Registre"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">User login</h1>
                                        </div>
                                        <form class="user" method="post" id="userform" name="userlogin" onsubmit="return validate();" novalidate>
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user" id="email" aria-describedby="emailHelp" name="email" placeholder="Insert email...">
                                                <span id="emailcheck" style="font-size: 12px; color: red;"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password" autocomplete="off">
                                                <span id="passwordcheck" style="font-size: 12px; color: red;"></span>
                                            </div>

                                            <button class="btn btn-success btn-block text-white btn-user" type="submit" name="login">Login
                                            </button>
                                            <hr>
                                        </form>
                                        
                                        <div class="text-center">
                                            <a href="<?php echo BASE_URL .  "/index.php" ?>" class="btn btn-primary btn-block text-white btn-user">Home</a>
                                        </div>
                                        
                                        <hr>
                                        <div class="text-center">
                                            <a href="<?php echo BASE_URL .  "/registration.php" ?>" class="btn btn-danger btn-block text-white btn-user">Do not have an account? Register</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <?php 
			if(isset($_POST['login'])){
				$email = $_POST['email'];
				$password =  $_POST['password'];
				
				//checking for validity of email
				if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
					header("Location: login.php?message=Invalid email");
					exit();
				}else{
					//If email exists
					$result =$autor->getAuthorByEmail($email);
					if(mysqli_num_rows($result)<=0){
						header("Location: login.php?message=Entered non-existent email");
						exit();
					} else { 
                      
                    while($red = mysqli_fetch_assoc($result))
                    {
                        if(!password_verify($password, $red['Password'])){
                        header("Location: login.php?message=Bad password");
                        exit();
                        } else if (password_verify($password, $red['Password'])){
                        $_SESSION['id'] = $red['Id'];
                        $_SESSION['Name'] = $red['Name'];
                        $_SESSION['Email'] = $red['Email'];
                        $_SESSION['Bio'] = $red['Bio'];
                        $_SESSION['Role'] = $red['Role'];
                        $_SESSION['Image'] = $red['Image'];
                        header("Location: index.php");
                            exit();
                        }
                    }   
                }
                }
            }
		?>



    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>   
    

    <script>
    function validate() {
    let email = document.forms["userlogin"]["email"].value;
    let pass = document.forms["userlogin"]["password"].value;

    if (email === "" || email === null && pass === "" || pass === null) {
        document.getElementById('emailcheck').innerHTML = 'Insert email';
        document.getElementById('passwordcheck').innerHTML = 'Insert password';
        return false;
    }
    if (email == "" || email == null) {
        document.getElementById('emailcheck').innerHTML = 'Insert email';
        document.userlogin.email.focus();
        return false;
    } else {
        var mailformat = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email.match(mailformat)) {
            if (pass === "" || pass === null) {
                document.getElementById('passwordcheck').innerHTML = 'Insert password';
                document.userlogin.password.focus();
                return false;
            }
            return true;
        } else {
            document.getElementById('emailcheck').innerHTML = 'Insert valid email';
            document.userlogin.email.focus();
            return false;
        }
    }
}
    </script>

    </body>

    </html>